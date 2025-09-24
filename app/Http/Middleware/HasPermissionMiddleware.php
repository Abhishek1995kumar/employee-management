<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMiddleware {
    public function handle(Request $request, Closure $next): Response {
        // $router = DB::table('permissions')->where('app_url', $request->route()->uri())->value('app_url');
        $currentRoute = $request->route()->getName();
        $router = DB::table('role_permission')->where('route_url', $currentRoute)->value('route_url');
        $user = auth()->user()->id;
        $permissions = DB::select("SELECT us.name, us.role_id, rp.role_id, rp.permission_name, rp.route_url FROM `users` us join role_permission rp ON rp.role_id = us.role_id where us.id= ?", [$user]);
        if(auth()->user()->role_id === 1) {
            return $next($request);

        } else {
            if($currentRoute === $router && $permissions) {
                return $next($request);
            }
        }
        return abort(404, "Something went wrong");
    }
}
