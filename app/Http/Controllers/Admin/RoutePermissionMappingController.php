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
use App\Models\Admin\RoutePermission;

class RoutePermissionMappingController extends Controller {
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
        return view('admin..user-management.route-permission.index', [
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
            
            $routePermissionMapping = new RoutePermission();
            $routePermissionMapping->role_id = $data['role_id'];
            $routePermissionMapping->permission_id = implode(',', $data['permission_id']);
            $routePermissionMapping->created_by = Auth::id();
            $routePermissionMapping->updated_by = Auth::id();
            $routePermissionMapping->created_at = Carbon::now();
            $routePermissionMapping->updated_at = Carbon::now();
            $routePermissionMapping->save();

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
