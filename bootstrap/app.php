<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust all upstream proxies (Cloudflare, load balancers, cPanel
        // shared hosting reverse proxies, etc.) so that $request->ip()
        // returns the real visitor IP from X-Forwarded-For.
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\DetectCountrySubdomain::class,
        ]);

        // Stripe sends its own signature header — exempt the webhook URL
        // from Laravel's CSRF check.
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'employer' => \App\Http\Middleware\CheckEmployer::class,
            'seeker' => \App\Http\Middleware\CheckSeeker::class,
            'admin' => \App\Http\Middleware\CheckAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
