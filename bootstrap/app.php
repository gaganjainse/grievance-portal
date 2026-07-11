<?php

return Illuminate\Foundation\Application::configure(dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'officer' => \App\Http\Middleware\OfficerMiddleware::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (\Illuminate\Foundation\Configuration\Exceptions $exceptions) {
        //
    })->create();
