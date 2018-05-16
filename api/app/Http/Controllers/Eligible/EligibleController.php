<?php

namespace DentalSleepSolutions\Http\Controllers\Eligible;

use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\ThirdPartyCallerInterface;

class EligibleController extends Controller
{
    private const ELIGIBLE_PATH = 'https://gds.eligibleapi.com/v1.5/payers.json';
    private const DSS_DEFAULT_ELIGIBLE_API_KEY = '33b2e3a5-8642-1285-d573-07a22f8a15b4';

    /**
     * @SWG\Get(
     *     path="/eligible/payers",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param ThirdPartyCallerInterface $thirdPartyCaller
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPayers(ThirdPartyCallerInterface $thirdPartyCaller)
    {
        $path = self::ELIGIBLE_PATH . '?api_key=' . self::DSS_DEFAULT_ELIGIBLE_API_KEY;
        $headers = ['content-type' => 'application/json'];

        $response = $thirdPartyCaller->callApi('GET', $path, $headers);
        $data = json_decode($response);

        return ApiResponse::responseOk('', $data);
    }
}
