<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

class ApiAuthController extends ApiBaseController
{

    public function __construct()
    {
    }

    /**
     * Authenticate a user.
     *
     * If authentication is successful, then a token will be returned
     *
     * @return mixed
     */
    public function auth()
    {
        //if all is good
        /*
         * return ['status' => true ];
         * else
         * return $this->createErrorResponse('whatever the error is');
         */
        //$this->createErrorResponse()
    }

    /**
     * Register a new user
     *
     * @todo add a site wide token here?
     * @return array
     */
    public function register()
    {
        //if all is good
        /*
         * return ['status' => true ];
         * else
         * return $this->createErrorResponse('whatever the error is');
         */
        //$this->createErrorResponse()
    }

    /**
     * Return the user's current profile
     *
     * @return array
     */
    public function profile()
    {
        //if all is good
        /*
         * return ['status' => true ];
         * else
         * return $this->createErrorResponse('whatever the error is');
         */
        //$this->createErrorResponse()
    }

    /**
     * Allow a user to update their own profile
     *
     * @return array
     */
    public function updateProfile()
    {


    }

    /**
     * Send forgot password email with reset code
     *
     * @return array
     */
    public function forgotPassword()
    {

    }

    /**
     * Reset user password
     *
     * @param string $code
     * @return array
     */
    public function resetPassword($code)
    {

    }


}