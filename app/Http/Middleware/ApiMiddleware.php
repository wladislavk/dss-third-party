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
        //Todo - Refactor this entire function to support JWT instead of CORS

        $origin = $request->server('HTTP_ORIGIN', $request->server('HTTP_HOST'));

        return $next($request)->header('Access-Control-Allow-Origin', $origin)
               ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
               ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');
    }
}
