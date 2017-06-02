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
        $credentials['admin'] = 0;

        if (!empty($credentials['admin'])) {
            $credentials['admin'] = 1;
        }

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

    public function authAs(Request $request)
    {
        /**
         * Only admins can access this endpoint. This needs to be a middleware somehow
         */
        if (!$this->currentAdmin) {
            return Response::json(['status' => 'Unauthorized'], 401);
        }

        /**
         * DSS can log a single user (FO/BO) or two users (BO "logged in as" FO).
         * This method can return more than one result, if the given ID has a separator "|"
         */
        $userModel = User::where('username', $request->input('username'))->where('admin', 0)->first();

        if (!$userModel) {
            return Response::json(['status' => 'Invalid credentials'], 422);
        }

        /**
         * JWTAuth relies on user ID (with the default configuration) but it is not possible to generate a payload
         * with a combined approach. As a workaround, the ID of a single model will be altered to pass along the
         * list of IDs needed for "logged in as".
         */
        $userModel->id = "a_{$this->currentAdmin->id}|{$userModel->id}";

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
}