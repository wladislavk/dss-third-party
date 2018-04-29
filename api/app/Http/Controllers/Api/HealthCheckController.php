<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use DentalSleepSolutions\Facades\ApiResponse;

/**
 * @todo: restore API tests if needed or delete the controller
 */
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
