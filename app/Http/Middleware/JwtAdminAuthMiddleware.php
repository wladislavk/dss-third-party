<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Exceptions\JwtException;

class JwtAdminAuthMiddleware
{
    /** @var JwtAuth */
    private $auth;

    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->auth->setRequest($request);

        try {
            $this->auth->toAdmin();
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
