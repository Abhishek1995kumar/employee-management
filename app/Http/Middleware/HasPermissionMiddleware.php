<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMiddleware {
    public function handle(Request $request, Closure $next): Response {
        $user = Auth::user();
        if (!$user) {
            return abort(401, 'You are not authenticated user to access this route');
        }

        $role = DB::table('roles')->where('id', $user->role_id)->first();
        if ($role && $role->slug === 'super_admin') {
            // Super Admin ko by default sabhi permission dena
            return $next($request);
        } 
        
        // Normal role ke liye jo assign kiya gaya hai wahi permission milega
        $currentRoute = $request->route()->getName();
        $allowedRoutes = DB::table('role_permission')
                            ->where('role_id', $user->role_id)
                            ->pluck('route_url')
                            ->toArray(); // Allowed routes for the user's role based

        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized Access');
    }
}
