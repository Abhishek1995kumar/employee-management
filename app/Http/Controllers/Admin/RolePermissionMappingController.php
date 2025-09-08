<?php

namespace App\Http\Controllers\Admin;


use Exception;
use Carbon\Carbon;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\RolePermission;

class RolePermissionMappingController extends Controller {
    use ValidationTrait, CommanFunctionTrait;
    public function __construct() {
        $this->middleware('isAdmin');
    }

    public function index() {
        $permissionWithRoles = DB::select("SELECT rp.id, r.name AS role_name, GROUP_CONCAT(p.name ORDER BY p.name SEPARATOR ', ') AS permission_names
                                                FROM role_permission rp
                                                JOIN roles r ON rp.role_id = r.id
                                                JOIN permissions p ON FIND_IN_SET(p.id, rp.permission_id)
                                                GROUP BY rp.id, r.id
                                                ORDER BY r.name;
                                ");
        $permissions = Permission::all();
        $roles = Role::where('status', 1)->whereNot('slug', 'super_admin')->get();
        return view('admin..user-management.role-permission.index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionWithRoles' => $permissionWithRoles
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->rolePermissionMappingValidation($data);
            if ($validator) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator
                ]);
            }
            
            // Check if any of the selected permissions are already assigned to the given role
            // $d = DB::select("SELECT * FROM role_permission 
            //             WHERE role_id = ? 
            //             AND (
            //                 " . implode(' OR ', array_fill(0, count($data['permission_id']), 'FIND_IN_SET(?, permission_id)')) . "
            //             )", 
            //             array_merge([$data['role_id']], $data['permission_id'])
            // );
            $isAssignedRole = RolePermission::where('role_id', $data['role_id'])
                                ->where(function($query) use($data) {
                                    foreach($data['permission_id'] as $permission) {
                                        $query->orWhereRaw('FIND_IN_SET(?, permission_id)', [$permission]);
                                    }
                                })->first();

            if($isAssignedRole) {
                return response()->json([
                    'status' => 'error',
                    'message' => "{$isAssignedRole['permission_id'] } Permission is already assigned to selected role"
                ]);
            }

            $rolePermissionMapping = new RolePermission();
            $rolePermissionMapping->role_id = $data['role_id'];
            $rolePermissionMapping->permission_id = implode(',', $data['permission_id']);
            $rolePermissionMapping->created_by = Auth::id();
            $rolePermissionMapping->updated_by = Auth::id();
            $rolePermissionMapping->created_at = Carbon::now();
            $rolePermissionMapping->updated_at = Carbon::now();
            $rolePermissionMapping->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Role permission mapping saved successfully.'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id) {
        
    }

    public function destroy(Request $request) {
        
    }

    public function show(Request $request) {
        
    }
}
