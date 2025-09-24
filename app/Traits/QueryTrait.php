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
            }

            // Normal role ke liye jo assign kiya gaya hai wahi permission milega
            return DB::select("SELECT rp.route_url 
                FROM users us 
                JOIN role_permission rp ON rp.role_id = us.role_id 
                WHERE us.id = ?
            ", [$user->id]);

        } catch(\Throwable $th) {
            Log::error($th->getMessage());
            return [];
        }
    }
}