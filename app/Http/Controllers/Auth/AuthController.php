<?php

namespace DentalSleepSolutions\Http\Controllers\Auth;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Auth\LegacyAuth;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Exceptions\JwtException;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    const ADMIN_FLAG_INDEX = 'admin';

    /** @var LegacyAuth */
    private $legacyAuth;

    /** @var JwtAuth */
    private $jwtAuth;

    public function __construct(
        Config $config,
        LegacyAuth $legacyAuth,
        JwtAuth $jwtAuth,
        Request $request
    )
    {
        parent::__construct($config, $request);
        $this->legacyAuth = $legacyAuth;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Authenticate a user.
     * If authentication is successful, then a token will be returned
     *
     * @return array|JsonResponse
     */
    public function auth()
    {
        $credentials = $this->request->all();
        $authenticated = $this->legacyAuth
            ->byCredentials($credentials)
        ;

        if (!$authenticated) {
            return ApiResponse::responseError('Invalid credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->legacyAuth->user();
        $adminFlag = $user->getAttribute(self::ADMIN_FLAG_INDEX);
        $role = JwtAuth::ROLE_USER;

        if ($adminFlag) {
            $role = JwtAuth::ROLE_ADMIN;
        }

        $this->jwtAuth
            ->guard($role)
            ->login($user)
        ;

        try {
            $token = $this->jwtAuth->toToken($role);
        } catch (JwtException $e) {
            return ApiResponse::responseError('Invalid credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthException $e) {
            return ApiResponse::responseError('Invalid credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }

    /**
     * @return array|JsonResponse
     */
    public function authHealth()
    {
        if (!$this->config->get('app.debug') || $this->config->get('app.env') === 'production') {
            return ApiResponse::responseError('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return [
            'status' => 'Health',
            'data' => [
                'admin' => $this->request->admin(),
                'user' => $this->request->user(),
            ]
        ];
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken()
    {
        return ApiResponse::responseOk('');
    }
}
