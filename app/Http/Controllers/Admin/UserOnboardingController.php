<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserOnboardingController extends Controller {
    use ValidationTrait;

    public function index() {
        $id = Auth::user()->id;
        $users = DB::select("SELECT u.id, u.name username, u.email, u.phone, r.name AS role_name 
                            FROM users u
                            JOIN roles r ON r.id = u.role_id
                            WHERE u.id != 1
                            -- AND u.id != $id
                            ORDER BY u.id DESC");
        return view('admin.user-management.users.index', [
            'users' => $users,
        ]);
    }

    public function create() {
        $roles = DB::select("SELECT rp.id, r.name AS role_name FROM role_permission rp
                            JOIN roles r ON rp.role_id = r.id
                            ORDER BY rp.id DESC");
        return view('admin.user-management.users.create', [
            'roles' => $roles,
        ]);
    }


    public function save(Request $request) {
        try {
            $validator = $this->validateUser($request);
            if($validator) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator
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
                'status' => 'success',
                'message' => 'Role permission mapping saved successfully.'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }


    public function update(Request $request) {
        try {
            $validator = $this->validateUser($request, 'update');
            if($validator) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator
                ]);
            }

            $user = User::find($request->user_id);
            if(!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
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
                'status' => 'success',
                'message' => 'User updated successfully.'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }


    public function delete(Request $request) {
        try {
            $user = User::find($request->user_id);
            if(!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
            }
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }
}
