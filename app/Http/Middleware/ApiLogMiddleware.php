<?php

namespace DentalSleepSolutions\Http\Middleware;

use Carbon\Carbon;
use Closure;
use DB;

class ApiLogMiddleware
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
        /**
         * @ToDo: refactor this
         */
        DB::table('dental_api_logs')->insert([
            'method' => $request->method(),
            'route' => $request->path(),
            'payload' => json_encode($request->all()),
            'created_at' => Carbon::now(),
        ]);

        return $next($request);
    }
}
