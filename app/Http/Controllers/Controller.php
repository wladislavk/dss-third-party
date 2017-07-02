<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Logged-in admin
     *
     * @var \DentalSleepSolutions\Eloquent\User|bool
     */
    protected $currentAdmin;

    /**
     * Logged-in user
     *
     * @var \DentalSleepSolutions\Eloquent\User|bool
     */
    protected $currentUser;

    /** @var JWTAuth */
    protected $auth;

    /** @var Config */
    protected $config;

    /**
     * Controller constructor
     *
     * @param JWTAuth    $auth
     * @param Config     $config
     * @param AuthTokenParser $authToken
     */
    public function __construct(
        JWTAuth $auth,
        Config $config,
        AuthTokenParser $authToken
    ) {
        $this->config = $config;

        /** @todo: generate tokens with $auth->fromUser($userModel) */
        if ($this->config->get('app.env') === 'testing') {
            return;
        }

        $this->auth = $auth;
        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
