<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::get();

        if ($setting->maintenance_mode && ! $request->is('admin*')) {
            return response()->view('maintenance', [
                'message' => $setting->maintenance_message ?: 'আমরা বর্তমানে সাইট আপডেট করছি। শীঘ্রই ফিরে আসবো।',
            ], 503);
        }

        return $next($request);
    }
}
