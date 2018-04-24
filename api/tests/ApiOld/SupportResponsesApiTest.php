<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse;
use Tests\TestCases\ApiTestCase;

class SupportResponsesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SupportResponse::class;
    }

    protected function getRoute()
    {
        return '/support-responses';
    }

    protected function getStoreData()
    {
        return [
            "ticket_id" => 100,
            "responder_id" => 8,
            "body" => "Quam hic exercitationem eligendi et animi.",
            "response_type" => 1,
            "viewed" => true,
            "attachment" => "1ckgdi9z_r-ot39.bmp",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'responder_id' => 132,
            'body'         => 'support response body',
        ];
    }
}
