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

    /** @var User */
    protected $currentAdmin;

    /** @var User */
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

        /** @todo: generate tokens with $auth->fromUser($userModel) */
        if ($this->config->get('app.env') === 'testing') {
            return;
        }

        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
