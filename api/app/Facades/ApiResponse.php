<?php

namespace DentalSleepSolutions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Response helper class providing consistent structure of the json content
 * that is sent by the application. It tries to transform the resources
 * using dedicated transformer if there is one in default namespace.
 */
class ApiResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apiresponse';
    }
}
