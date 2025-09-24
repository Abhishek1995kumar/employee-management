<?php

namespace App\Http\Controllers\Admin;


use Exception;
use Carbon\Carbon;
use App\Models\Admin\Role;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\RolePermission;
use Illuminate\Support\Facades\Route;

class RolePermissionMappingController extends Controller {
    // agar group by ka error aaye to ye use karna hai
    // DB::statement(DB::raw('SET sql_mode=(SELECT REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY", ""))')); 
    // ya phir config\database.php mein mysql ke andar 'strict' => false kar dena hai
    use ValidationTrait, CommanFunctionTrait, QueryTrait;
    public function __construct() {
        $this->middleware('isAdmin');
    }

    public function index(Request $request) {
        $routeDetails = $this->routePermission();
        $permissionWithRoles = DB::select("SELECT rp.id, role_name, route_url, permission_name
                                            FROM role_permission rp
                                            WHERE deleted_at IS NULL
                                            ORDER BY permission_name ASC
                                ");
        $permissions = DB::select("SELECT module_id, 
                                    module_name, 
                                    GROUP_CONCAT(name SEPARATOR ',') AS permission_names, 
                                    GROUP_CONCAT(id SEPARATOR ',') AS permission_ids,
                                    GROUP_CONCAT(app_url SEPARATOR ',') AS route_url
                                FROM permissions 
                                GROUP BY module_id, module_name
                            ");
        $result = [];
        foreach($permissions as $permission) {
            $ids = explode(',', $permission->permission_ids);
            $names = explode(',', $permission->permission_names);
            $route = explode(',', $permission->route_url);
            $permArr = [];
            for($i = 0; $i < count($ids); $i++) {
                $permArr[] = [
                    'id' => $ids[$i],
                    'name' => $names[$i],
                    'route_url' => $route[$i] // ye bhi add karna hai
                ];
            }
            $result[] = [
                'module_id' => $permission->module_id,
                'module_name' => $permission->module_name,
                'permissions' => $permArr
            ];
        }
        

        $roles = Role::where('status', 1)->whereNot('slug', 'super_admin')->get();
        return view('admin..user-management.role-permission.index', [
            'roles' => $roles,
            'permissions' => $result,
            'permissionWithRoles' => $permissionWithRoles,
            'routeDetails' => $routeDetails
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->rolePermissionMappingValidation($data);
            if ($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'error' => 1
                ]);
            }

            $roles = Role::find($data['role_id']);
            if (!$roles) {
                return response()->json([
                    'success' => false,
                    'message' => "Selected role does not exist.",
                    'error' => 2
                ]);
            }

            foreach ($data['permission_id'] as $index => $perId) {
                // check duplicate
                $isAssignedRole = RolePermission::where('role_id', $data['role_id'])
                    ->where('permission_id', $perId)
                    ->where('route_url', $data['route_url'][$index])
                    ->first();
                
                if ($isAssignedRole) {
                    return response()->json([
                        'success' => false,
                        'message' => "Permission ID {$perId} is already assigned to selected role",
                        'error' => 3
                    ]);
                }

                if ($data['route_url'][$index] == null) {
                    return response()->json([
                        'success' => false,
                        'message' => "Route url {$data['route_url'][$index]} is already assigned to selected role",
                        'error' => 3
                    ]);
                }

                $permissions = Permission::find($perId);
                if ($permissions) {
                    $rolePermissionMapping = new RolePermission();
                    $rolePermissionMapping->role_id = $data['role_id'];
                    $rolePermissionMapping->route_url = $data['route_url'][$index];
                    $rolePermissionMapping->permission_id = $perId;
                    $rolePermissionMapping->permission_name = $permissions->name;
                    $rolePermissionMapping->role_name = $roles->name;
                    $rolePermissionMapping->created_by = Auth::id();
                    $rolePermissionMapping->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Role permission mapping saved successfully.',
                'error' => 0
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 4
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        
    }

    public function destroy(Request $request) {
        
    }

    public function show(Request $request) {
        
    }
}
