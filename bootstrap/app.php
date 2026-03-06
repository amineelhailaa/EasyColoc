<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MembershipRole;
use App\Http\Middleware\NoActiveMembership;
use App\Http\Middleware\NotBannedMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'membership.role' => MembershipRole::class,
            'admin' => AdminMiddleware::class,
            'notMember'=> NoActiveMembership::class,
            'not.banned'=> NotBannedMiddleware::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
