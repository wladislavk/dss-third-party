<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

class JwtPatientAuthMiddleware extends AbstractJwtAuthMiddleware
{
    /** @var string */
    protected $role = JwtAuth::ROLE_PATIENT;

    /** @var string */
    protected $sudoField = self::PATIENT_SUDO_ID;

    /** @var string */
    protected $sudoReference = self::PATIENT_MODEL_ID;

    /** @var bool */
    protected $fallsThrough = false;

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return parent::handle($request, $next);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function mustHandleSudo(Request $request)
    {
        return is_object($request->user());
    }

    /**
     * @param Request $request
     */
    protected function setResolver(Request $request)
    {
        $request->setPatientResolver(function () {
            $user = $this->auth
                ->guard($this->role)
                ->user()
            ;
            return $user;
        });
    }
}
