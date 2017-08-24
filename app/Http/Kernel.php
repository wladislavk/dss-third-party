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
        \DentalSleepSolutions\Http\Middleware\CorsMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'jwt.auth.admin' => \DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware::class,
        'jwt.auth.user' => \DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware::class,
        'auth' => \DentalSleepSolutions\Http\Middleware\Authenticate::class,
        'dentrix.auth' => \DentalSleepSolutions\Http\Middleware\DentrixAuthMiddleware::class,
        'api.log' => \DentalSleepSolutions\Http\Middleware\ApiLogMiddleware::class,
    ];
}
