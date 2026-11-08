<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\EnsureAdminRole;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use App\Http\Middleware\PatientAuth;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.auth' => AdminAuth::class,
            'admin.role' => EnsureAdminRole::class,
            'patient.auth' => PatientAuth::class,
        ]);

        $middleware->web(append: [
            SetLocale::class,
            CheckMaintenanceMode::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'payment/success',
            'payment/fail',
            'payment/cancel',
            'payment/ipn',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
