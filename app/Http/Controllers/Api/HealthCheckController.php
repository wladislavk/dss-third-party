<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class HealthCheckController extends Controller
{
    /**
     * OK
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::responseOk('OK');
    }
}
