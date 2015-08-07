<?php

namespace DentalSleepSolutions\Http\Middleware;

use Closure;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $http_origin = $_SERVER['HTTP_ORIGIN'];
        $allow_origins = null;

        if (strpos($http_origin,'ds3soft.net') !== false || strpos($http_origin,'ds3soft.local') !== false) {
            $allow_origin = $http_origin;
        }

        return $next($request)->header('Access-Control-Allow-Origin' , $http_origin)
               ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
               ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');
    }
}
