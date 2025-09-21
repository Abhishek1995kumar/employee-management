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
use Illuminate\Support\Facades\Route;

class RoutePermissionMappingController extends Controller {
    use ValidationTrait, CommanFunctionTrait;
    public function __construct() {
        $this->middleware('isAdmin');
    }

    public function index() {
        $roles = Role::where('status', 1)->where('slug', '!=', 'super_admin')->get();
        $routePermissionMappingList = DB::select("SELECT rp.id, rp.permission_id, p.name permission_name, rp.route_name, u.name user_name 
                                        FROM route_permission rp LEFT JOIN permissions p ON p.id = rp.permission_id 
                                        LEFT JOIN users u ON u.id = rp.created_by
                                    ");
        
        $routes = Route::getRoutes();
        $middlewareGroup = 'isAdmin';
        $authenticatedRoutes = [];
        foreach ($routes as $route) {
            $allRoutes = $route->gatherMiddleware();
            if(in_array($middlewareGroup, $route->gatherMiddleware())) {
                $url = $route->uri();
                if($url !== 'admin/dashboard' && $url !== 'admin/logout') {
                    $authenticatedRoutes[] = [
                        'url' => $url,
                    ];
                }
            }
        }
        return view('admin..user-management.route-permission.index', [
            'roles' => $roles,
            'authenticatedRoutes' => $authenticatedRoutes,
            'routePermissionMappingList' => $routePermissionMappingList
        ]);
    }

    public function getPermissionsByRole(Request $request) {
        $roleId = $request->input('role_id');
        if (!$roleId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role ID is required.'
            ], 400);
        }
        $permissions = DB::select("SELECT p.id, p.name, p.route_pattern
                                FROM role_permission rp
                                JOIN permissions p ON FIND_IN_SET(p.id, rp.permission_id) > 0
                                WHERE rp.role_id = ?
                            ", [$roleId]
                        );

        $mapped = collect($permissions)->mapWithKeys(function($item) {
            return [
                $item->id => [
                    'name' => $item->name,
                    'route_pattern' => $item->route_pattern
                ]
            ];
        });
        
        return response()->json([
            'status' => 'success',
            'permissions' => $mapped
        ]);
    }

    public function getRouteByPermissions(Request $request) {
        $permissionId = $request->input('permission_id');
        if (!$permissionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission ID is required.'
            ], 400);
        }

        $routes = Route::getRoutes();
        $middlewareGroup = 'isAdmin';
        $authenticatedRoutes = [];
        foreach ($routes as $route) {
            $allRoutes = $route->gatherMiddleware();
            if(in_array($middlewareGroup, $route->gatherMiddleware())) {
                $url = $route->uri();
                if($url !== 'admin/dashboard' && $url !== 'admin/logout') {
                    $authenticatedRoutes[] = [
                        'url' => $url,
                    ];
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'authenticatedRoutes' => $authenticatedRoutes ?? []
        ]);
    }


    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->routePermissionMappingValidation($data);

            if ($validator) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator
                ]);
            }

            $routePermissionMapping = new RoutePermission();
            $routePermissionMapping->permission_id = $data['permission_id'];
            $routePermissionMapping->route_name = implode(',', $data['route_name']);
            $routePermissionMapping->created_by = Auth::id();
            $routePermissionMapping->updated_by = null;
            $routePermissionMapping->created_at = Carbon::now();
            $routePermissionMapping->updated_at = null;
            $routePermissionMapping->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Route permission mapping saved successfully.'
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

    public function delete(Request $request) {
        
    }

    public function show(Request $request) {
        
    }
}
