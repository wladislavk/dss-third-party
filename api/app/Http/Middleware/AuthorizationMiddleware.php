<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorizationMiddleware
{
    /** @var Auth */
    private $auth;

    /**
     * @param Auth $auth
     */
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param string  $concatenatedRoles
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next, string $concatenatedRoles): JsonResponse
    {
        $roles = explode('|', $concatenatedRoles);
        foreach ($roles as $role) {
            if ($this->roleAuthenticated($role)) {
                return $next($request);
            }
        }
        $code = Response::HTTP_UNAUTHORIZED;
        $status = Response::$statusTexts[$code];
        return ApiResponse::responseError($status, $code);
    }

    /**
     * @param string $role
     * @return bool
     */
    private function roleAuthenticated(string $role): bool
    {
        /** @var Guard $adminGuard */
        $guard = $this->auth->guard($role);
        if (!$guard) {
            return false;
        }
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->user();
        if ($authenticatable) {
            return true;
        }
        return false;
    }
}
