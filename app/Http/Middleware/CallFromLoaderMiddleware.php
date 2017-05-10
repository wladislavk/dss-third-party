<?php

namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class CallFromLoaderMiddleware
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
        $loaderDomain = parse_url(env('LOADER_HOST'), PHP_URL_HOST);
        $loaderIp = gethostbyname($loaderDomain);

        if ($loaderIp !== $request->ip()) {
            return Response::json(['status' => 'Not found'], 404);
        }

        $sharedSecret = env('SHARED_SECRET');

        if (!strlen($sharedSecret) || $sharedSecret !== $request->input('secret')) {
            return Response::json(['status' => 'Invalid credentials'], 422);
        }

        return $next($request);
    }
}
