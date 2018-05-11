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
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class AbstractJwtAuthMiddleware
{
    const AUTH_HEADER = 'Authorization';
    const AUTH_HEADER_START = 'Bearer ';
    const USER_SUDO_ID = 'sudo_id';
    const PATIENT_SUDO_ID = 'patient_id';
    const USER_MODEL_ID = 'userid';
    const PATIENT_MODEL_ID = 'patientid';

    /** @var string */
    protected $role = '';

    /** @var string */
    protected $sudoField = '';

    /** @var string */
    protected $sudoReference = '';

    /** @var bool */
    protected $fallsThrough = false;

    /** @var JwtAuth */
    protected $auth;

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
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->getAuthToken($request);
        } catch (HttpMalformedHeaderException $e) {
            if ($this->fallsThrough) {
                return $next($request);
            }

            return $this->responseError(MiddlewareErrors::TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        }

        if ($this->mustHandleSudo($request)) {
            $request = $this->handleSudo($request);
            return $next($request);
        }

        try {
            $this->auth->toRole($this->role, $token);
        } catch (InvalidTokenException $e) {
            return $this->responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_BAD_REQUEST);
        } catch (InactiveTokenException $e) {
            return $this->responseError(MiddlewareErrors::TOKEN_INACTIVE, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ExpiredTokenException $e) {
            return $this->responseError(MiddlewareErrors::TOKEN_EXPIRED, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidPayloadException $e) {
            if ($this->fallsThrough) {
                return $next($request);
            }
            if (!is_object($request->admin()) && !is_object($request->admin()) && !is_object($request->admin())) {
                return $this->responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (AuthenticatableNotFoundException $e) {
            return $this->responseError(MiddlewareErrors::USER_NOT_FOUND, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->setResolver($request);
        return $next($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function mustHandleSudo(Request $request)
    {
        return false;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function handleSudo(Request $request)
    {
        $sudoId = $request->query($this->sudoField, '');

        $user = $this->auth
            ->guard($this->role)
            ->once([
                $this->sudoReference => $sudoId
            ])
        ;

        if (!$user) {
            return $request;
        }

        $this->setResolver($request);
        return $request;
    }

    /**
     * @param Request $request
     * @return string
     * @throws HttpMalformedHeaderException
     */
    protected function getAuthToken(Request $request)
    {
        $authHeader = $request->header(self::AUTH_HEADER, '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);

        if (substr($authHeader, 0, $authHeaderStart) !== self::AUTH_HEADER_START) {
            throw new HttpMalformedHeaderException();
        }

        $token = substr($authHeader, $authHeaderStart);
        return $token;
    }

    /**
     * @param string $errorMessage
     * @param int    $httpStatus
     */
    protected function responseError($errorMessage, $httpStatus)
    {
        return ApiResponse::responseError($errorMessage, $httpStatus);
    }

    /**
     * @param Request $request
     */
    protected function setResolver(Request $request)
    {
        // noop
    }
}
