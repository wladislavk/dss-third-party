<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // TODO: this class should include common REST methods for all its children

    use DispatchesJobs, ValidatesRequests;

    /** @var User|null */
    protected $currentAdmin;

    /** @var User|null */
    protected $currentUser;

    /** @var Config */
    protected $config;

    /**
     * @param Config          $config
     * @param AuthTokenParser $authTokenParser
     */
    public function __construct(
        Config $config,
        AuthTokenParser $authTokenParser
    ) {
        $this->config = $config;

        /**
         * @todo Generate tokens with $auth->fromUser($userModel)
         * @todo Select user/admin data to inject in tests
         */
        if ($config->get('app.env') === 'testing') {
            $this->currentUser = new User();
            $this->currentAdmin = new User();
            $this->currentUser->id = 0;
            $this->currentAdmin->id = 0;

            return;
        }

        $this->currentAdmin = $authTokenParser->getAdminData();
        $this->currentUser = $authTokenParser->getUserData();
    }
}
