<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Exceptions\JwtException;

class ApiAuthController extends Controller
{
    /** @var JWTAuth */
    private $auth;

    /** @var Request */
    private $request;

    public function __construct(
        Config $config,
        JwtAuth $auth,
        Request $request
    )
    {
        parent::__construct($config);
        $this->auth = $auth;
        $this->request = $request;
    }

    /**
     * Authenticate a user.
     * If authentication is successful, then a token will be returned
     *
     * @return array|JsonResponse
     */
    public function auth()
    {
        $token = '';
        $credentials = $this->request->all();

        $credentials = Arr::only($credentials, ['username', 'password', 'admin']);
        $credentials['admin'] = Arr::get($credentials, 'admin', 0);

        $role = 'User';

        if ($credentials['admin']) {
            $role = 'Admin';
        }

        $this->auth
            ->guard($role)
            ->attempt($credentials)
        ;

        try {
            $token = $this->auth->toToken($role);
        } catch (JwtException $e) {
            return ApiResponse::responseError('Invalid credentials', 422);
        } catch (AuthException $e) {
            return ApiResponse::responseError('Invalid credentials', 422);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }

    /**
     * @return array|JsonResponse
     */
    public function authHealth()
    {
        if (!$this->config->get('app.debug') || $this->config->get('app.env') === 'production') {
            return ApiResponse::responseError('Not Found', 404);
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
