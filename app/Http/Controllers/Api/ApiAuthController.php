<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Exception;

class ApiAuthController extends Controller
{
    /** @var JWTAuth */
    private $auth;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        Config $config,
        AuthTokenParser $authTokenParser,
        JWTAuth $auth,
        UserRepository $userRepository
    )
    {
        parent::__construct($config, $authTokenParser);
        $this->auth = $auth;
        $this->userRepository = $userRepository;
    }

    /**
     * Authenticate a user.
     * If authentication is successful, then a token will be returned
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function auth(Request $request)
    {
        $token = false;
        $credentials = $request->all();

        $credentials = Arr::only($credentials, ['username', 'password', 'admin']);
        $credentials['admin'] = Arr::get($credentials, 'admin', 0);

        try {
            $token = $this->auth->attempt($credentials);
        } catch (Exception $e) {
            return ApiResponse::responseError('Invalid credentials', 422);
        }

        if (!$token) {
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

        return ['status' => 'Health', 'data' => ['user' => $this->currentUser, 'admin' => $this->currentAdmin]];
    }

    /**
     * @param Request $request
     * @return array|JsonResponse
     */
    public function authAs(Request $request)
    {
        /**
         * Only admins can access this endpoint. This needs to be a middleware somehow
         */
        if (!$this->currentAdmin) {
            return ApiResponse::responseError('Unauthorized', 401);
        }

        $resource = $this->userRepository->findByCredentials([
            'username' => $request->input('username'),
            'admin' => 0
        ]);

        if (!$resource) {
            return ApiResponse::responseError('Invalid credentials', 422);
        }

        $resource->id = $this->userRepository->sudoId($this->currentAdmin->id, $resource->id);
        return ['status' => 'Authenticated', 'token' => $this->auth->fromUser($resource)];
    }

    /**
     * @return array|JsonResponse
     */
    public function refreshToken()
    {
        $token = $this->auth->getToken();

        if (!$token) {
            return ApiResponse::responseError('Token not provided', 422);
        }

        try {
            $token = $this->auth->refresh($token);
        } catch (TokenExpiredException $e) {
            return ApiResponse::responseError('Expired token', 422);
        } catch (TokenInvalidException $e) {
            return ApiResponse::responseError('Invalid token', 422);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }
}
