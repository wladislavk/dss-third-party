<?php

namespace Tests\Dummies\Http;

use DentalSleepSolutions\Http\Kernel;

class NoMiddlewareKernel extends Kernel
{
    /** @var array */
    protected $middleware = [];

    /** @var array */
    protected $routeMiddleware = [];
}
