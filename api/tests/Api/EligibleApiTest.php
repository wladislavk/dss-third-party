<?php

namespace Tests\Api;

use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\MockCaller;
use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\ThirdPartyCallerInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCases\BaseApiTestCase;

class EligibleApiTest extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testGetPayers()
    {
        /** @var MockCaller $mockCaller */
        $mockCaller = $this->app->make(ThirdPartyCallerInterface::class);
        $response = [
            [
                'payer_id' => '00014',
                'names' => ['SelectCare'],
                'created_at' => '2014-07-20T07:17:25Z',
                'updated_at' => '2015-06-12T13:19:53Z',
                'supported_endpoints' => [
                    [
                        'endpoint' => 'professional claims',
                        'pass_through_fee' => 0,
                        'enrollment_required' => false,
                        'signature_required' => false,
                        'average_enrollment_process_time' => null,
                        'blue_ink_required' => false,
                        'message' => null,
                        'enrollment_mandatory_fields' => [],
                        'credentials_required' => false,
                        'status' => 'available',
                        'status_details' => 'Payer is working fine.',
                        'status_updated_at' => '2017-05-10T15:32:11Z',
                        'original_signature_pdf' => null,
                    ],
                    [
                        'endpoint' => 'institutional claims',
                        'pass_through_fee' => 0,
                        'enrollment_required' => false,
                        'signature_required' => false,
                        'average_enrollment_process_time' => null,
                        'blue_ink_required' => false,
                        'message' => null,
                        'enrollment_mandatory_fields' => [],
                        'credentials_required' => false,
                        'status' => 'available',
                        'status_details' => 'Payer is working fine',
                        'status_updated_at' => '2015-06-12T13:19:53Z',
                        'original_signature_pdf' => null,
                    ],
                ],
            ],
            [
                'foo' => 'bar',
            ],
        ];
        $mockCaller->setExpectedResponse(json_encode($response));

        $this->get(self::ROUTE_PREFIX . '/eligible/payers');
        $this->assertResponseOk();
        $this->assertEquals(2, sizeof($this->getResponseData()));
        $first = $this->getResponseData()[0];
        $this->assertEquals($response[0], $first);
    }
}
