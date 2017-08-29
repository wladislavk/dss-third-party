<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Exceptions\HttpMalformedHeaderException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Exceptions\JwtException;

class JwtAdminAuthMiddleware extends AbstractJwtAuthMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->getAuthToken($request);
        } catch (HttpMalformedHeaderException $e) {
            return $next($request);
        }

        try {
            $this->auth->toRole(JwtAuth::ROLE_ADMIN, $token);
        } catch (JwtException $e) {
            // Fall through
        } catch (AuthException $e) {
            // Fall through
        }

        $request->setAdminResolver(function () {
            $user = $this->auth
                ->guard(JwtAuth::ROLE_ADMIN)
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }
}
