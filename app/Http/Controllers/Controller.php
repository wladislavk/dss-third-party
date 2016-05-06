<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function __construct(JWTAuth $auth)
    {
        $this->currentUser = $auth->toUser();
    }
}
