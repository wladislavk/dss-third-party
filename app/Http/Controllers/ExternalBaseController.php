<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DentalSleepSolutions\Http\Requests\Request;

abstract class ExternalBaseController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function __construct(Request $request)
    {
        $this->currentUser = $request->attributes->get('currentUser');
    }
}
