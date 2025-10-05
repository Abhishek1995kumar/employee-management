<?php

namespace App\Traits;

use Exception;
use Throwable;
use Pusher\Pusher;
use App\Models\Logs;
use App\Models\User;
use App\Mail\OtpVerified;
use App\Models\Admin\LoginOtp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait QueryTrait {
    public function routePermission() {
        try {
            $user = Auth::user();
            // Super Admin ko by default sabhi permission dena
            $role = DB::table('roles')->where('id', $user->role_id)->first();
            if ($role && $role->slug === 'super_admin') {
                return DB::select('SELECT app_url AS route_url FROM permissions');
                
            } else {
                // Normal role ke liye jo assign kiya gaya hai wahi permission milega
                return DB::select("SELECT rp.route_url 
                    FROM users us 
                    JOIN role_permission rp ON rp.role_id = us.role_id 
                    WHERE us.id = ?
                ", [$user->id]);

            }


        } catch(\Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }


    public function allAssignedPermission() {
        try {
            return DB::select("SELECT id, role_id, role_name, 
                            GROUP_CONCAT(route_url SEPARATOR ',') AS route_url, 
                            GROUP_CONCAT(permission_name SEPARATOR ',') AS permission_name
                            FROM role_permission
                            GROUP BY role_id, role_name
                            ORDER BY permission_name ASC
                ");

        } catch(\Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }


    public function allPermission() {
        try {
            return DB::select("SELECT id, 
                            module_id, 
                            module_name, 
                            GROUP_CONCAT(name SEPARATOR ',') AS permission_names, 
                            GROUP_CONCAT(id SEPARATOR ',') AS permission_ids,
                            GROUP_CONCAT(app_url SEPARATOR ',') AS route_url
                        FROM permissions 
                        GROUP BY module_id, module_name
                    ");

        } catch(\Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }
    

    public function allRoutePermissionModuleTrait() {
        try {
            return DB::select("SELECT rp.id, rp.permission_id, p.name permission_name, rp.route_name, u.name user_name 
                                        FROM route_permission rp LEFT JOIN permissions p ON p.id = rp.permission_id 
                                        LEFT JOIN users u ON u.id = rp.created_by
                                    ");
        

        } catch(\Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }

    public function getRoleNames() {
        try {
            return DB::select("SELECT id, role_id, role_name FROM role_permission rp
                            GROUP BY role_name
                            ORDER BY rp.id DESC");
        } catch(Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }
}