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
        'jwt.authentication' => \DentalSleepSolutions\Http\Middleware\JwtAuthenticationMiddleware::class,
        'sudo.authentication' => \DentalSleepSolutions\Http\Middleware\SudoAuthenticationMiddleware::class,
        'authorization' => \DentalSleepSolutions\Http\Middleware\AuthorizationMiddleware::class,
        'dentrix.auth' => \DentalSleepSolutions\Http\Middleware\DentrixAuthenticationMiddleware::class,
        'api.log' => \DentalSleepSolutions\Http\Middleware\ApiLogMiddleware::class,
        'api.permissions' => \DentalSleepSolutions\Http\Middleware\ApiPermissionsLookupMiddleware::class,
    ];
}
