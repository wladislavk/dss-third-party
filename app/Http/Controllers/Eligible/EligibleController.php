<?php

namespace DentalSleepSolutions\Http\Controllers\Eligible;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Controllers\Controller;
use GuzzleHttp\Client;

class EligibleController extends Controller
{
    const DSS_DEFAULT_ELIGIBLE_API_KEY = '33b2e3a5-8642-1285-d573-07a22f8a15b4';

    public function getPayers()
    {
        $client = new Client();
        $path = 'https://gds.eligibleapi.com/v1.5/payers.json?api_key=' . self::DSS_DEFAULT_ELIGIBLE_API_KEY;
        $headers = ['content-type' => 'application/json'];

        $response = $client->request('GET', $path, $headers);
        $stream = $response->getBody();
        $data = json_decode($stream->getContents());

        return ApiResponse::responseOk('', $data);
    }
}
