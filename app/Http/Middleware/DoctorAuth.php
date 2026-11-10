<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('doctor')->check()) {
            return redirect()->route('doctor.login');
        }

        return $next($request);
    }
}
