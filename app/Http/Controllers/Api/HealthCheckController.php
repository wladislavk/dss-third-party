<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class HealthCheckController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/health-check",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::responseOk('OK');
    }
}
