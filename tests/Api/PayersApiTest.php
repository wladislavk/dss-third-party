<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Payer;
use Tests\TestCases\ApiTestCase;

class PayersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Payer::class;
    }

    protected function getRoute()
    {
        return '/payers';
    }

    protected function getStoreData()
    {
        return [
            "names" => json_encode(['foo','bar']),
        ];
    }

    protected function getUpdateData()
    {
        return [
            "names" => json_encode(['bar','baz']),
        ];
    }

    public function testShow()
    {
        $this->markTestSkipped('Model is incorrectly transformed to array');
    }

    public function testStore()
    {
        $this->markTestSkipped('Model is incorrectly transformed to array');
    }

    public function testUpdate()
    {
        $this->markTestSkipped('Model is incorrectly transformed to array');
    }

    public function testRequiredFieldsForSingleEndpoint()
    {
        $this->markTestSkipped('Model is incorrectly transformed to array');
        return;

        factory(Payer::class, 5)->create();

        Payer::create($this->getPayerData());

        $this->get('api/v1/payers/RIBLS/required-fields?endpoint=coverage');
        $this->assertResponseOk();
        $this->seeJson(['data' => ['npi']]);
    }

    private function getPayerData()
    {
        return [
            "payer_id" => "RIBLS",
            "supported_endpoints" => [
                [
                    "endpoint" => "coverage",
                    "pass_through_fee" => 0,
                    "enrollment_required" => true,
                    "average_enrollment_process_time" => null,
                    "enrollment_mandatory_fields" => [
                        "npi",
                    ],
                    "signature_required" => false,
                    "blue_ink_required" => false,
                    "message" => null,
                    "status" => "available",
                    "status_details" => "Payer is working fine.",
                    "status_updated_at" => "2014-05-14T23:45:57Z",
                ],
                [
                    "endpoint" => "payment reports",
                    "pass_through_fee" => 0,
                    "enrollment_required" => true,
                    "average_enrollment_process_time" => null,
                    "enrollment_mandatory_fields" => [
                        "provider_name",
                        "address",
                        "city",
                        "state",
                        "zip",
                    ],
                    "signature_required" => true,
                    "blue_ink_required" => false,
                    "message" => null,
                    "status" => "available",
                    "status_details" => "Payer is working fine.",
                    "status_updated_at" => "2014-05-14T23:45:57Z",
                ],
            ],
        ];
    }
}
