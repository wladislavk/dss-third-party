<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Exceptions\JwtException;

class JwtAdminAuthMiddleware
{
    const AUTH_HEADER_START = 'Bearer ';

    /** @var JwtAuth */
    private $auth;

    /**
     * @param JwtAuth $auth
     */
    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization', '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);

        if (!substr($authHeader, 0, $authHeaderStart) !== 'Bearer ') {
            return $next($request);
        }

        $token = substr($authHeader, $authHeaderStart);

        try {
            $this->auth->toRole('Admin', $token);
        } catch (JwtException $e) {
            // Fall through
        } catch (AuthException $e) {
            // Fall through
        }

        $request->setAdminResolver(function () {
            $user = $this->auth
                ->guard('Admin')
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }
}
