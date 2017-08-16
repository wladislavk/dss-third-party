<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // TODO: this class should include common REST methods for all its children
    use DispatchesJobs, ValidatesRequests;

    /** @var Config */
    protected $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }
}
