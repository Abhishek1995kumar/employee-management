<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpIsVerified {
    public function handle(Request $request, Closure $next): Response {
        if(Auth::check() && Auth::user()->is_otp_verified === false) {
            return redirect('/admin/verify-otp');
        }
        return $next($request);
    }
}
