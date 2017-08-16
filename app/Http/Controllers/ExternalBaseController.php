<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Routing\Controller as IlluminateBaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\Models\User;

abstract class ExternalBaseController extends IlluminateBaseController
{
    use DispatchesJobs, ValidatesRequests;

    /** @var User|null */
    protected $currentUser;

    /** @var Config */
    protected $config;

    public function __construct(
        Config $config,
        Request $request
    ) {
        $this->config = $config;
    }
}
