<?php

namespace DentalSleepSolutions\Http\Controllers\Auth;

use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthController extends Controller
{
    const ADMIN_FLAG_INDEX = 'admin';
    const PATIENT_FLAG_INDEX = 'patient';

    /** @var Auth */
    protected $auth;

    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param Auth $auth
     * @param Config $config
     * @param JwtHelper $jwtHelper
     * @param Request $request
     */
    public function __construct(
        Auth $auth,
        Config $config,
        JwtHelper $jwtHelper,
        Request $request
    )
    {
        parent::__construct($auth, $config, $request);
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * Authenticate a user.
     * If authentication is successful, then a token will be returned
     *
     * @return array|JsonResponse
     */
    public function auth()
    {
        $role = JwtHelper::ROLE_USER;
        $credentials = [
            'username' => $this->request->get('username'),
            'password' => $this->request->get('password'),
        ];
        if (!empty($this->request->get(JwtHelper::ROLE_ADMIN))) {
            $role = JwtHelper::ROLE_ADMIN;
        }
        if (!empty($this->request->get(JwtHelper::ROLE_PATIENT))) {
            $role = JwtHelper::ROLE_PATIENT;
            $credentials = [
                'email' => $this->request->get('email'),
                'password' => $this->request->get('password'),
            ];
        }
        /** @var Guard $guard */
        $guard = $this->auth->guard($role);
        if (!$guard) {
            return ApiResponse::responseError('Invalid credentials', Response::HTTP_FORBIDDEN);
        }
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->validate($credentials);
        if (!$authenticatable) {
            return ApiResponse::responseError('Invalid credentials', Response::HTTP_FORBIDDEN);
        }
        $token = $this->jwtHelper->createToken([
            JwtHelper::CLAIM_ROLE_INDEX => $role,
            JwtHelper::CLAIM_ID_INDEX => $authenticatable->getAuthIdentifier(),
        ]);
        return ['status' => 'Authenticated', 'token' => $token];
    }

    /**
     * @return array|JsonResponse
     */
    public function authHealth()
    {
        if (!$this->config->get('app.debug') || $this->config->get('app.env') === 'production') {
            //return ApiResponse::responseError('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return [
            'status' => 'Health',
            'data' => [
                'admin' => $this->admin(),
                'user' => $this->user(),
                'patient' => $this->patient(),
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
