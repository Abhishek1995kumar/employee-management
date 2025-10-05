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
            $holidayMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $holidayYear = ['2021', '2022', '2023', '2024', '2025', '2026', '2027'];
            $colorCode = ['#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1', '#955251', '#B565A7', '#009B77', '#DD4124', '#D65076', '#45B8AC', '#EFC050', '#5B5EA6', '#9B2335', '#BC243C', '#C3447A', '#98B4D4', '#DEEAEE', '#7BC4C4', '#E15D44', '#53B0AE', '#EFC7C2', '#FFD662', '#6A5ACD', '#20B2AA'];
            $columns = [
                'Branch ID','Holiday Name','Holiday Image','Holiday Category',
                'Holiday Day','Holiday Month','Holiday Year','Holiday Color',
                'Start Date','End Date','Description',''
            ];

            $dropdownDetails = [
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

            return response()->json([
                'success' => true,
                'message' => 'Sample excel generated successfully.',
                'code' => 0,
                'download_url' => $downloadUrl
            ]);

    }


    public function userBlukUpload(Request $request) {
        try {
            
        } catch(Throwable $th) {

        }
    }


}
