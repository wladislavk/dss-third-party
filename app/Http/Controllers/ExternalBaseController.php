<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;

abstract class ExternalBaseController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function __construct(
        ExternalAuthTokenParser $tokenParser,
        Request $request
    )
    {
        $this->currentUser = $tokenParser->getUserData(
            $request->input('api_key_company', ''),
            $request->input('api_key_user', '')
        );
    }
}
