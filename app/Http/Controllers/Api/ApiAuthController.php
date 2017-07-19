<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Eloquent\User as UserView;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class ApiAuthController extends Controller
{
    /** @var JWTAuth */
    private $auth;

    /** @var UserView */
    private $resources;

    public function __construct(
        Config $config,
        AuthTokenParser $authToken,
        JWTAuth $auth,
        UserView $resources
    )
    {
        parent::__construct($config, $authToken);
        $this->auth = $auth;
        $this->resources = $resources;
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
        } catch (\Exception $e) { /* Several errors, invalid fields, empty POST payload */ }

        if (!$token) {
            return ApiResponse::responseError('Invalid credentials', 422);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }

    /**
     * @return array|JsonResponse
     */
    public function authHealth ()
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

        /**
         * DSS can log a single user (FO/BO) or two users (BO "logged in as" FO).
         * This method can return more than one result, if the given ID has a separator "|"
         */
        $resource = $this->resources->where('username', $request->input('username'))->where('admin', 0)->first();

        if (!$resource) {
            return ApiResponse::responseError('Invalid credentials', 422);
        }

        /**
         * JWTAuth relies on user ID (with the default configuration) but it is not possible to generate a payload
         * with a combined approach. As a workaround, the ID of a single model will be altered to pass along the
         * list of IDs needed for "logged in as".
         */
        $resource->id = "a_{$this->currentAdmin->id}|{$resource->id}";
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