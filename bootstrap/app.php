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
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware kan hier globaal of per groep worden toegevoegd.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception rendering kan hier later worden toegevoegd.
    })
    ->create();
