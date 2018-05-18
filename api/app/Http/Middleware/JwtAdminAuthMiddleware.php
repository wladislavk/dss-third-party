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
    /** @var string */
    protected $role = JwtAuth::ROLE_ADMIN;

    /** @var bool */
    protected $fallsThrough = false;

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return parent::handle($request, $next);
    }

    /**
     * @param Request $request
     */
    protected function setResolver(Request $request)
    {
        $request->setAdminResolver(function () {
            $user = $this->auth
                ->guard($this->role)
                ->user()
            ;
            return $user;
        });
    }
}
