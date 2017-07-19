<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as IlluminateBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DentalSleepSolutions\Http\Requests\Request;

abstract class ExternalBaseController extends IlluminateBaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function __construct(Request $request)
    {
        $this->currentUser = $request->attributes->get('currentUser');
    }
}
