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
}
