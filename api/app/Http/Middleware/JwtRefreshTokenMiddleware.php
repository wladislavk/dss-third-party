<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Http\Requests\Request;

class JwtRefreshTokenMiddleware extends AbstractJwtAuthMiddleware
{
    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param JwtAuth $jwtAuth
     * @param JwtHelper $jwtHelper
     */
    public function __construct(
        JwtAuth $jwtAuth,
        JwtHelper $jwtHelper
    )
    {
        parent::__construct($jwtAuth);
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $token = '';

        if ($request->user()) {
            $token = $this->jwtHelper
                ->createToken([
                    JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_USER,
                    JwtAuth::CLAIM_ID_INDEX  => $request->user()->getAuthIdentifier(),
                ])
            ;
        }

        if ($request->admin()) {
            $token = $this->jwtHelper
                ->createToken([
                    JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
                    JwtAuth::CLAIM_ID_INDEX  => $request->admin()->getAuthIdentifier(),
                ])
            ;
        }

        $response->headers->set(self::AUTH_HEADER, self::AUTH_HEADER_START . $token);
        return $response;
    }
}
