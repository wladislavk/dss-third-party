<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use DentalSleepSolutions\Helpers\ApiResponse;

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
