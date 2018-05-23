<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Services\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Auth\Factory as Auth;

class JwtRefreshTokenMiddleware
{
    /** @var Auth */
    private $auth;

    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param Auth $auth
     * @param JwtHelper $jwtHelper
     */
    public function __construct(Auth $auth, JwtHelper $jwtHelper)
    {
        $this->auth = $auth;
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $response = $next($request);
        foreach (JwtHelper::ROLES as $role) {
            $authenticatable = $this->userGuard($role);
            if ($authenticatable) {
                return $this->refreshToken($response, $authenticatable, $role);
            }
        }
        return $response;
    }

    /**
     * @param JsonResponse $response
     * @param Authenticatable $authenticatable
     * @param string $role
     * @return JsonResponse
     */
    private function refreshToken(JsonResponse $response, Authenticatable $authenticatable, string $role): JsonResponse
    {
        $token = $this->jwtHelper->createToken([
            JwtHelper::CLAIM_ROLE_INDEX => $role,
            JwtHelper::CLAIM_ID_INDEX  => $authenticatable->getAuthIdentifier(),
        ]);
        $response->headers->set(
            JwtAuthenticationMiddleware::AUTH_HEADER, JwtAuthenticationMiddleware::AUTH_HEADER_START . $token
        );
        return $response;
    }

    /**
     * @param string $role
     * @return Authenticatable|null
     * @throws \InvalidArgumentException
     */
    private function userGuard(string $role):? Authenticatable
    {
        /** @var Guard $guard */
        $guard = $this->auth->guard($role);
        return $guard->user();
    }
}
