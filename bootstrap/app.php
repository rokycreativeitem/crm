<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;
use App\Http\Middleware\CheckRolePermissionMiddleware;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Middleware\RedirectIfMiddleware;
use App\Http\Middleware\StaffMiddleware;
use Illuminate\Foundation\Application;
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
            'admin'            => AdminMiddleware::class,
            'client'           => ClientMiddleware::class,
            'staff'            => StaffMiddleware::class,
            'redirect'         => RedirectIfMiddleware::class,
            'check.permission' => CheckPermissionMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();