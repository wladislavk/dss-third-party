<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;

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
     * @throws \DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->admin()) {
            return $this->refreshToken($response, $request->admin(), JwtAuth::ROLE_ADMIN);
        }

        if ($request->user()) {
            return $this->refreshToken($response, $request->user(), JwtAuth::ROLE_USER);
        }

        if ($request->patient()) {
            return $this->refreshToken($response, $request->patient(), JwtAuth::ROLE_PATIENT);
        }

        return $response;
    }

    protected function refreshToken(Response $response, Authenticatable $model, $role)
    {
        $token = $this->jwtHelper
            ->createToken([
                JwtAuth::CLAIM_ROLE_INDEX => $role,
                JwtAuth::CLAIM_ID_INDEX  => $model->getAuthIdentifier(),
            ])
        ;
        $response->headers->set(self::AUTH_HEADER, self::AUTH_HEADER_START . $token);
        return $response;
    }
}
