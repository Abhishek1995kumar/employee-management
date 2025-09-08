<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMiddleware {
    public function handle(Request $request, Closure $next): Response {
        $router = $request->route()->uri();
        if(auth()->user()->hasPermissionToRoute($router)) {
            return $next($request);
        }
        return abort(404, "Something went wrong");
    }
}
