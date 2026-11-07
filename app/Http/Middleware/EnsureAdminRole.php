<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    /**
     * Usage: ->middleware('admin.role:super_admin')
     * অথবা একাধিক role: ->middleware('admin.role:super_admin,branch_admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = auth('admin')->user();

        if (! $admin || ! in_array($admin->role, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
