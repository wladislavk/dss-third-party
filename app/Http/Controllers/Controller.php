<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /** @var User|null */
    protected $currentAdmin;

    /** @var User|null */
    protected $currentUser;

    /** @var Config */
    protected $config;

    /**
     * @param Config          $config
     * @param AuthTokenParser $authToken
     */
    public function __construct(
        Config $config,
        AuthTokenParser $authToken
    ) {
        $this->config = $config;

        /**
         * @todo Generate tokens with $auth->fromUser($userModel)
         * @todo Select user/admin data to inject in tests
         */
        if ($this->config->get('app.env') === 'testing') {
            $this->currentUser = new User();
            return;
        }

        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
