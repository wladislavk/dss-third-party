<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\HttpMalformedHeaderException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JwtUserAuthMiddleware extends AbstractJwtAuthMiddleware
{
    /** @var string */
    protected $role = JwtAuth::ROLE_USER;

    /** @var string */
    protected $sudoField = self::USER_SUDO_ID;

    /** @var string */
    protected $sudoReference = self::USER_MODEL_ID;

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
     */
    protected function setResolver(Request $request)
    {
        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard($this->role)
                ->user()
            ;
            return $user;
        });
    }
}
