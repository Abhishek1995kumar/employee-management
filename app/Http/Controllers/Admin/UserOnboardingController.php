<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
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
            $fileToBeName = 'holiday-sample-' . time() . '.xlsx';
            $savePath = public_path('Employee/Sample/' . $fileToBeName);

            // agar folder exist nahi hai to bana do
            if (!File::isDirectory(public_path('Holiday/Sample'))) {
                File::makeDirectory(public_path('Holiday/Sample'), 0777, true, true);
            }
            $roles = User::selectRaw("CONCAT(id, '|', name) as role_option")->pluck('role_option')->toArray();
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
                'Ooutside Punch Applicable','Wwork Type','Overtime Applicable',
                'Sandwich Leave Applicable', 'Eemployee Firm Location', 'Late Applicable', 'Late Day',
                'Late Hours', 'Leave Period', 'Leave Should Be Accured From',
                'Aasset Name', 'Sub Asset Name', 'Document Type'
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
                'late_lpplicable_index' => 13,
                'late_lpplicable_option' => $lateApplicable,
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
            $downloadUrl = '';
            return response()->json([
                'success' => true,
                'message' => 'Sample excel generated successfully.',
                'code' => 0,
                'download_url' => $downloadUrl
            ]);

        } catch(Throwable $th) {

        }

    }


    public function userBlukUpload(Request $request) {
        try {
            
        } catch(Throwable $th) {

        }
    }


}
