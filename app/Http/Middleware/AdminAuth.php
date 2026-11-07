<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = auth('admin')->user();

        if (! $admin->is_active) {
            auth('admin')->logout();
            $request->session()->invalidate();

            return redirect()->route('admin.login')->withErrors(['email' => 'Your account has been deactivated. Contact Super Admin.']);
        }

        return $next($request);
    }
}
