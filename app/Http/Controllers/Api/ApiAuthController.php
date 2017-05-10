<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\User;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Response;
use DentalSleepSolutions\Http\Controllers\Controller as ApiBaseController;

class ApiAuthController extends ApiBaseController
{
    /**
     * Authenticate a user.
     *
     * If authentication is successful, then a token will be returned
     *
     * @return mixed
     */
    public function auth(Request $request)
    {
        $token = false;
        $credentials = $request->all();

        $credentials = array_only($credentials, ['username', 'password', 'admin']);
        $credentials['admin'] = empty($credentials['admin']) ? 0 : 1;

        try {
            $token = $this->auth->attempt($credentials);
        } catch (\Exception $e) { /* Several errors, invalid fields, empty POST payload */ }

        if (!$token) {
            return Response::json(['status' => 'Invalid credentials'], 422);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }

    public function authHealth ()
    {
        return ['status' => 'Health', 'data' => ['user' => $this->currentUser, 'admin' => $this->currentAdmin]];
    }

    public function generateToken(Request $request)
    {
        /**
         * DSS can log a single user (FO/BO) or two users (BO "logged in as" FO).
         * This method can return more than one result, if the given ID has a separator "|"
         */
        $userData = User::findByIdOrEmail($request->input('id'));

        if (!$userData) {
            return Response::json(['status' => 'Invalid credentials'], 422);
        }

        /**
         * JWTAuth relies on user ID (with the default configuration) but it is not possible to generate a payload
         * with a combined approach. As a workaround, the ID of a single model will be altered to pass along the
         * list of IDs needed for "logged in as".
         */
        $userModel = $userData[0];

        if (isset($userData[1])) {
            /**
             * Ensure only admins can access "Login As" functionality
             */
            if (!$this->currentAdmin) {
                return Response::json(['status' => 'Unauthorized'], 401);
            }

            $userModel->id = "{$userData[0]->id}|{$userData[1]->id}";
        }

        return ['status' => 'Authenticated', 'token' => $this->auth->fromUser($userModel)];
    }

    public function refreshToken(Request $request)
    {
        $token = $this->auth->getToken();

        if (!$token) {
            return Response::json(['status' => 'Token not provided'], 422);
        }

        try {
            $token = $this->auth->refresh($token);
        } catch (TokenExpiredException $e) {
            return Response::json(['status' => 'Expired token'], 422);
        } catch (TokenInvalidException $e) {
            return Response::json(['status' => 'Invalid token'], 422);
        }

        return ['status' => 'Authenticated', 'token' => $token];
    }

    public function lanGenerateToken(Request $request)
    {
        $errorResponse = $this->processRequestFromLoader($request);

        if ($errorResponse !== false) {
            return $errorResponse;
        }

        return $this->generateToken($request);
    }

    public function lanRefreshToken(Request $request)
    {
        $errorResponse = $this->processRequestFromLoader($request);

        if ($errorResponse !== false) {
            return $errorResponse;
        }

        return $this->refreshToken($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Response|bool
     */
    protected function processRequestFromLoader($request)
    {
        $loaderDomain = parse_url(env('LOADER_HOST'), PHP_URL_HOST);
        $loaderIp = gethostbyname($loaderDomain);

        if ($loaderIp !== $request->ip()) {
            return Response::json(['status' => 'Not found'], 404);
        }

        $sharedSecret = env('SHARED_SECRET');

        if (!strlen($sharedSecret) || $sharedSecret !== $request->input('secret')) {
            return Response::json(['status' => 'Invalid credentials'], 422);
        }

        return false;
    }
}