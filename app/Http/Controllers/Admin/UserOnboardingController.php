<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Jobs\EmployeeOnboardingJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\ExcelErrorReport;
use App\Jobs\DumpEmployeeOnboardingJob;
use App\Exports\EmployeeOnboardingExport;
use App\Imports\EmployeeOnboardingImport;
use App\Models\Admin\Role;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserOnboardingController extends Controller {
    use ValidationTrait, QueryTrait;

    public function index() {
        $id = Auth::user()->id;
        $permissions = $this->routePermission();
        $users = DB::select("SELECT 
            u.id, 
            u.name AS username, 
            u.email, 
            u.phone, 
            r.name AS role_name,
            (SELECT COUNT(*) FROM users WHERE created_by = u.id) AS total_users
            FROM users u
            JOIN roles r ON r.id = u.role_id
            WHERE u.id != 1
            ORDER BY u.id DESC
        ");
        
        return view('admin.user-management.users.index', [
            'users' => $users,
            'permissions' => $permissions
        ]);
    }

    public function create() {
        $roles = $this->getRoleNames();
        return view('admin.user-management.users.create', [
            'roles' => $roles,
        ]);
    }


    public function save(Request $request) {
        try {
            $validator = $this->validateUser($request);
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'code' => 1
                ]);
            }

            $user = new User();
            $user->role_id = $request->role_id;
            $user->username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', trim($request->username)));
            $user->name = trim($request->name);
            $user->phone = strtolower(trim($request->phone));
            $user->email = strtolower(trim($request->email));
            $domain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', trim($request->username))) .'@'. $request->role_id;
            $user->password = Hash::make($domain);
            $user->default_password = $domain;
            $user->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            $user->created_by = Auth::user()->id;
            $user->created_at = Carbon::now();
            $user->updated_at = null;
            $user->address = trim($request->address);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Role permission mapping saved successfully.',
                'code' => 0
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 500);
        }
    }


    public function update(Request $request) {
        try {
            $validator = $this->validateUser($request, 'update');
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'code' => 1
                ], 422);
            }

            $user = User::find($request->user_id);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                    'code' => 2
                ], 404);
            }
            $user->role_id = $request->role_id;
            $user->username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', trim($request->username)));
            $user->name = trim($request->name);
            $user->phone = strtolower(trim($request->phone));
            $user->email = strtolower(trim($request->email));
            $user->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            $user->updated_at = Carbon::now();
            $user->address = trim($request->address);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 500);
        }
        
    }


    public function delete(Request $request) {
        try {
            $user = User::find($request->user_id);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                    'code' => 1
                ]);
            }
            $user->delete();
            return response()->json([
                'success' => false,
                'message' => 'User deleted successfully.',
                'code' => 0
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 500);
        }
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }


    public function userExcelSampleDownload(Request $request) {
        try {
            $employeeSheetRow = env('FORMATTED_ROWS', 100);
            $fileToBeName = 'onboarding-sample-' . time() . '.xlsx';
            $savePath = public_path('Onboarding/Sample/' . $fileToBeName);

            // agar folder exist nahi hai to bana do
            if (!File::isDirectory(public_path('Onboarding/Sample'))) {
                File::makeDirectory(public_path('Onboarding/Sample'), 0777, true, true);
            }
            $roles = Role::selectRaw("CONCAT(id, '|', name) as role_option")->pluck('role_option')->toArray();
            $gender = ['Male', 'Female', 'Other'];
            $employeePerformanceLabel = ['30%', '40%', '50%', '60%', '70%','80%', '90%', '100%'];
            $startMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $financialYear = ['2021', '2022', '2023', '2024', '2025', '2026', '2027'];
            $salaryTypeDetails = [
                'Fixed Remenuration', 'ESOPS', 'Basic', 'Medical Allowance', 'House Rent Allowance(HRA)', 'Leave Travel Allowance (LTA)', 'Other Allowance', 'Conveyance', 'Children Education', 'Special Allowance', 'Travelling Allowance',
            ];

            $salaryDeductionType = ['Professional Tax', 'Provident Fund', 'TDS', 'Other Deductions'];

            $shiftApplicable = ['Day Shift', 'Night Shift'];
            $outsidePunchApplicable = ['Yes', 'No'];
            $workType = ['Full Time', 'Part Time','Contract'];
            $overtimeApplicable = ['Yes', 'No'];
            $sandwichLeaveApplicable = ['Yes', 'No'];
            $employeeFirmLocation = ['Lucknow', 'Delhi', 'Mumbai', 'Gurugram', 'Noida', 'Chennai'];

            $lateApplicable = ['Yes', 'No'];
            $lateDay = ['Half Day', 'Quater'];
            $lateHours = [ '1 hour', '2 hour', '3 hour', '4 hour', '5 hour', '6 hour', '7 hour', '8 hour', '9 hour' ];
            $leavePeriod = ['Weekly', 'Monthly'];
            $leaveshouldBeAccuredFrom = [
                'Professional Leave', 'Emergency Leave', 'Sick Leave', 'Earned Leave', 'Maternity Leave', 'Paternity Leave', 'Casual Leave', 'Compensatory Leave', 'Unpaid Leave'
            ];

            $assetName = ['Software', 'Hardware'];
            $subAssetName = [
                'Operation Syatem', 'Productivity Tool', 'Antivirus Tool', 'Database System'
            ];

            $documentType = [
                'Marksheet', 'Pan Card', 'Aadhar Card', 'Room Rent Agreement'
            ];

            $columns = [
                'Role Name','Gender Name','Employee Performance Label','Start Month',
                'Financial Year','Salary Type Details','Salary Deduction Type','Shift Applicable',
                'Ooutside Punch Applicable','Work Type','Overtime Applicable',
                'Sandwich Leave Applicable', 'Eemployee Firm Location', 'Late Applicable', 'Late Day',
                'Late Hours', 'Leave Period', 'Leave Should Be Accured From',
                'Aasset Name', 'Sub Asset Name', 'Document Type', 'Username', 'Name', 'Phone', 'Email', 'Address',
                'Previous Company Name', 'Previous Role', 'Previous Employee Experience (in years)', 'Previous Employee ID', 'Previous Official Email', 'Previous Probation Period (in months)', 'Previous Salary (in INR)', 'Previous HR Number',
                'Bank Name', 'Bank Account Number', 'IFSC Code', 'Branch Name', 'Account Holder Name', 'Beneficiary Name', 
                'Performance Bonus Amount', 'Loan Details', 'Loan Amount', 'Loan EMI (in INR)', 'Reason for Loan', 'Total Month', 'Salary Amount (in INR)', 'Fixed Amount', 'Percentage Amount',
                'Asset Name', 'Asset Sub Name', 'Asset Brand Name', 'Asset Model Number', 'Asset Serial Number', 'Asset Specification', 'Asset Warranty (in years)', 'Asset Condition', 'Asset Assigned By', 'Asset Assigned To','Asset Descrption',
                'Document Type', 'Document File URL',
                'Set the minutes for daily late', 'Total Leaves in a year', 'Total Leaves Allowed at a time', 'Balance Leave', 'Maximum Carry Forward Leaves', 'Maximum Leave Encashment in a year', 'Leave Encashment per Leave (in INR)', 'Notice Period (in days)', 'Probation Period (in months)', 'Standard Working Hours (in hours)', 'Overtime Rate (in INR)', 'PF Percentage (%)', 'ESI Percentage (%)', 'Professional Tax (in INR)', 'Gratuity Percentage (%)', 'TDS Percentage (%)',
                'Date of Birth', 'Previous Date of Joining', 'Previous Date of Relieving', 'Previous Confirmation Date (dd-mm-yyyy)', 'Asset Return Date', 'Asset Purchase Date', 'Assigned Date', 'Loan Start Date', 'Loan End Date', 'Sanction Date', 'Date Of Bonus'
                
            ];

            $dropdownDetails = [
                'roles_index' => 0,
                'roles_option' => $roles,
                'gender_index' => 1,
                'gender_option' => $gender,
                'employee_performance_label_index' => 2,
                'employee_performance_label_option' => $employeePerformanceLabel,
                'start_month_index' => 3,
                'start_month_option' => $startMonth,
                'financial_year_index' => 4,
                'financial_year_option' => $financialYear,
                'salary_type_details_index' => 5,
                'salary_type_details_option' => $salaryTypeDetails,
                'salary_deduction_type_index' => 6,
                'salary_deduction_type_option' => $salaryDeductionType,
                'shift_applicable_index' => 7,
                'shift_applicable_option' => $shiftApplicable,
                'outside_punch_applicable_index' => 8,
                'outside_punch_applicable_option' => $outsidePunchApplicable,
                'work_type_index' => 9,
                'work_type_option' => $workType,
                'overtime_applicable_index' => 10,
                'overtime_applicable_option' => $overtimeApplicable,
                'sandwich_leave_applicable_index' => 11,
                'sandwich_leave_applicable_option' => $sandwichLeaveApplicable,
                'employee_firm_location_index' => 12,
                'employee_firm_location_option' => $employeeFirmLocation,
                'late_applicable_index' => 13,
                'late_applicable_option' => $lateApplicable,
                'late_day_index' => 14,
                'late_day_option' => $lateDay,
                'late_hours_index' => 15,
                'late_hours_option' => $lateHours,
                'leave_period_index' => 16,
                'leave_period_option' => $leavePeriod,
                'leave_should_be_accured_from_index' => 17,
                'leave_should_be_accured_from_option' => $leaveshouldBeAccuredFrom,
                'asset_name_index' => 18,
                'asset_name_option' => $assetName,
                'sub_asset_name_index' => 19,
                'sub_asset_name_option' => $subAssetName,
                'document_type_index' => 20,
                'document_type_option' => $documentType
            ];

            // Excel file ko binary me le aao
            $excelBinary = Excel::raw(
                new EmployeeOnboardingExport($columns, $employeeSheetRow, $dropdownDetails),
                \Maatwebsite\Excel\Excel::XLSX
            );

            // Binary ko public folder me save karo
            File::put($savePath, $excelBinary);

            // public URL banake bhejo
            $downloadUrl = url('Onboarding/Sample/' . $fileToBeName);

            return response()->json([
                'success' => true,
                'message' => 'Sample excel generated successfully.',
                'code' => 0,
                'download_url' => $downloadUrl
            ]);

        } catch(Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getTraceAsString(),
                'code' => 0,
            ]);
        }

    }


    public function userBlukUpload(Request $request) {
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

            $file = $request->file('file');
            $errorReportId = 0;
            $fileToBeName = 'onboarding-import-' . time() . '.xlsx';
            $destinationPath = public_path('Onboarding/Import');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->file('file')->move($destinationPath, $fileToBeName);
            $savePath = $destinationPath . '/' . $fileToBeName;
            $publicUrl = asset('Onboarding/Import', $fileToBeName);

            $errorReport = new ExcelErrorReport();
            $errorReport->document_type_id = ExcelErrorReport::SUCCESS;
            $errorReport->original_document_url = $publicUrl;
            $errorReport->status = ExcelErrorReport::PROCESSING;
            $errorReport->save();
            $errorReportId = $errorReport->id;

            $excelData = \Maatwebsite\Excel\Facades\Excel::toArray(new EmployeeOnboardingImport($errorReportId), $savePath);
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
                foreach($excelData as $onboard) {
                    DumpEmployeeOnboardingJob::dispatch($onboard, $errorReportId);
                }
                if($errorReportId) {
                    EmployeeOnboardingJob::dispatch($errorReportId);
                }

            }
            dd($file->getClientOriginalName()); // check file name
            
        } catch(Throwable $th) {
            return response()->json([
                'success' => true,
                'message' => $th->getMessage(),
                'code' => 0,
            ]);
        }
    }


}
