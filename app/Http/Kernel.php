<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class Kernel extends HttpKernel
{

    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // wajib uncomment saat di server
        \Guardian::class,
        \Agent::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Barryvdh\Cors\HandleCors::class,
        ],

        'api' => [
            // 'throttle:60,1' = max attempt 60 tried simultaneously will be locked for 1 minute
            'throttle:60,0.3', 
            'bindings',
            \Barryvdh\Cors\HandleCors::class,
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],
    ];

    protected $routeMiddleware = [
        'buster' => \Buster::class,        
        'sentry' => \Sentry::class,
        'guardian' => \Guardian::class,

        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'client' => CheckClientCredentials::class,
        'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
        'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
        'password-grant' => \App\Http\Middleware\InjectPasswordGrantCredentials::class,
        'claim' => \App\Http\Middleware\CheckClaims::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,		
    ];
}
