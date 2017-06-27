<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;

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

    /** @var Model|Repository */
    protected $resources;

    /** @var Request */
    protected $request;

    /** @var JWTAuth */
    protected $auth;

    /** @var Config */
    protected $config;

    /**
     * Controller constructor
     *
     * @param Repository $resources
     * @param Request    $request
     * @param JWTAuth    $auth
     * @param Config     $config
     * @param AuthTokenParser $authToken
     */
    public function __construct(
        Repository $resources,
        Request $request,
        JWTAuth $auth,
        Config $config,
        AuthTokenParser $authToken
    ) {
        $this->resources = $resources;
        $this->request = $request;
        $this->config = $config;

        /** @todo: generate tokens with $auth->fromUser($userModel) */
        if (env('APP_ENV') === 'testing') {
            return;
        }

        $this->auth = $auth;
        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
