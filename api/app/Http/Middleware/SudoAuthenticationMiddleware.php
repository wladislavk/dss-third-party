<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

class SudoAuthenticationMiddleware
{
    public const USER_SUDO_ID = 'sudo_id';
    public const PATIENT_SUDO_ID = 'patient_id';
    public const USER_MODEL_ID = 'userid';
    public const PATIENT_MODEL_ID = 'patientid';

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
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        /** @var Guard $adminGuard */
        $adminGuard = $this->auth->guard(JwtHelper::ROLE_ADMIN);
        /** @var Guard $userGuard */
        $userGuard = $this->auth->guard(JwtHelper::ROLE_USER);
        /** @var Authenticatable $admin */
        $admin = $adminGuard->user();
        /** @var Authenticatable $user */
        $user = $userGuard->user();
        $userSudoId = $request->get(self::USER_SUDO_ID);
        $patientSudoId = $request->get(self::PATIENT_SUDO_ID);
        if ($admin && $userSudoId) {
            $user = $userGuard->loginUsingId($userSudoId);
        }
        if (($admin || $user) && $patientSudoId) {
            /** @var Guard $patientGuard */
            $patientGuard = $this->auth->guard(JwtHelper::ROLE_PATIENT);
            $patientGuard->loginUsingId($patientSudoId);
        }
        return $next($request);
    }
}
