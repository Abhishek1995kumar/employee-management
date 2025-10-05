<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use Carbon\Carbon;
use \App\Models\User;
use App\Jobs\HolidayJob;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Jobs\DumpHolidayJob;
use \App\Models\Admin\Holiday;
use App\Exports\HolidayExport;
use App\Imports\HolidayImport;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin\CustomerBranch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\ExcelErrorReport;
use Illuminate\Support\Facades\Storage;


class HolidayController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function index() {
        $id = Auth::user()->id;
        $permissions = $this->routePermission();
        return view('admin.holidays.index', [
            'permissions' => $permissions
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validation = $this->holidayValidationTrait($data);
            if($validation) {
                return response()->json([
                    'success' => false, 
                    'message' => $validation,
                    'code' => 1
                ], 422);
            }

            $holiday = new Holiday();
            $holiday->firm_id = trim($data['firm_id']);
            $holiday->holiday_name = strtolower(trim($data['holiday_name']));
            $holiday->holiday_day = strtolower(trim($data['day_of_holiday']));
            $holiday->holiday_month = strtolower(trim($data['month_of_holiday']));
            $holiday->holiday_year = strtolower(trim($data['year_of_holiday']));
            $holiday->holiday_color = strtolower(trim($data['color']));
            $holiday->description = strtolower(trim($data['description'])) ?? NULL;
            $holiday->holiday_category = (int) trim($data['category']) ?? 1;
            $holiday->start_date = date('Y-m-d', strtotime(trim($data['holiday_start_date'])));
            $holiday->end_date = date('Y-m-d', strtotime(trim($data['holiday_end_date'])));
            $holiday->created_by = Auth::id();
            $holiday->created_name = User::where('id', Auth::id())->first()->name;
            $holiday->save();
            $this->storeLog('Holiday', 'save', 'Holiday');
            return response()->json([
                'success' => true,
                'message' => 'New holiday created successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 200);
        }
    }

    public function holidayExcelDownload(Request $request) {
        try {
            $holidaySheetRow = env('FORMATTED_ROWS', 100);
            $fileToBeName = 'holiday-sample-' . time() . '.xlsx';
            $savePath = public_path('Holiday/Sample/' . $fileToBeName);

            // agar folder exist nahi hai to bana do
            if (!File::isDirectory(public_path('Holiday/Sample'))) {
                File::makeDirectory(public_path('Holiday/Sample'), 0777, true, true);
            }

            $branches = CustomerBranch::selectRaw("CONCAT(branch_id, '|', branch_name) as branch_option")->pluck('branch_option')->toArray();
            // $branches = CustomerBranch::where("status", 1)->pluck('branch_name')->toArray();

            $dayOfHoliday = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $holidayCategory = ['National Holiday', 'Regional Holiday', 'Local Holiday'];
            $holidayMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $holidayYear = ['2021', '2022', '2023', '2024', '2025', '2026', '2027'];
            $colorCode = ['#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1', '#955251', '#B565A7', '#009B77', '#DD4124', '#D65076', '#45B8AC', '#EFC050', '#5B5EA6', '#9B2335', '#BC243C', '#C3447A', '#98B4D4', '#DEEAEE', '#7BC4C4', '#E15D44', '#53B0AE', '#EFC7C2', '#FFD662', '#6A5ACD', '#20B2AA'];
            $columns = [
                'Branch ID','Holiday Name','Holiday Image','Holiday Category',
                'Holiday Day','Holiday Month','Holiday Year','Holiday Color',
                'Start Date','End Date','Description',''
            ];

            $dropdownDetails = [
                'branch_id_index' => 0,
                'branch_id_option' => $branches,
                'holiday_category_index' => 3,
                'holiday_category_option' => $holidayCategory,
                'holiday_day_index' => 4,
                'holiday_day_option' => $dayOfHoliday,
                'holiday_month_index' => 5,
                'holiday_month_option' => $holidayMonth,
                'holiday_year_index' => 6,
                'holiday_year_option' => $holidayYear,
                'holiday_color_code_index' => 7,
                'holiday_color_code_option' => $colorCode,
            ];

            // Excel file ko binary me le aao
            $excelBinary = Excel::raw(
                new HolidayExport($columns, $holidaySheetRow, $dropdownDetails),
                \Maatwebsite\Excel\Excel::XLSX
            );

            // Binary ko public folder me save karo
            File::put($savePath, $excelBinary);

            // public URL banake bhejo
            $downloadUrl = url('Holiday/Sample/' . $fileToBeName);

            return response()->json([
                'success' => true,
                'message' => 'Sample excel generated successfully.',
                'code' => 0,
                'download_url' => $downloadUrl
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 1
            ]);
        }
    }

    public function holidayExcelImport(Request $request) {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time',0);
            set_time_limit(0);

            if (!$request->hasFile('file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded.',
                    'code' => 1
                ], 400);
            }

            $errorReportId = 0;
            $fileToBeName = 'holiday-import-' . time() . '.xlsx';

            $destinationPath = public_path('Holiday/Import');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->file('file')->move($destinationPath, $fileToBeName);
            $savePath = $destinationPath . '/' . $fileToBeName;
            $publicUrl = asset('Holiday/Import/' . $fileToBeName);

            $errorReport = new ExcelErrorReport();
            $errorReport->document_type_id = ExcelErrorReport::SUCCESS;
            $errorReport->original_document_url = $publicUrl;
            $errorReport->status = ExcelErrorReport::PROCESSING;
            $errorReport->save();
            $errorReportId = $errorReport->id;

            $excelData = \Maatwebsite\Excel\Facades\Excel::toArray(new HolidayImport($errorReportId), $savePath);
            if(!isset($excelData)) {
                $deleteExcel = ExcelErrorReport::find($errorReportId);
                if(!empty($deleteExcel)) {
                    $deleteExcel->delete();
                    return response()->json([
                        'success' => false,
                        'message' => 'Uploaded Excel is empty.',
                        'code' => 2
                    ]);
                }
            } else {
                foreach($excelData as $holiday) {
                    DumpHolidayJob::dispatch($holiday, $errorReportId);
                }
                if($errorReportId) {
                    HolidayJob::dispatch($errorReportId);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Holiday data imported successfully.',
                'code' => 0
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 3
            ], 500);
        }
    }
    
}
