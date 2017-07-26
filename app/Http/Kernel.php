<?php

namespace DentalSleepSolutions\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        // \DentalSleepSolutions\Http\Middleware\EncryptCookies::class,
        // \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        // \Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \DentalSleepSolutions\Http\Middleware\ApiMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'auth' => \DentalSleepSolutions\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \DentalSleepSolutions\Http\Middleware\RedirectIfAuthenticated::class,
        'external.validate' => \DentalSleepSolutions\Http\Middleware\ExternalCompanyMiddleware::class,
        'api.log' => \DentalSleepSolutions\Http\Middleware\ApiLogMiddleware::class,
    ];
}
