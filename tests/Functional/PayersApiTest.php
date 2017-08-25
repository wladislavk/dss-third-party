<?php
namespace Tests\Functional;

use DentalSleepSolutions\Eloquent\Repositories\PayerRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;

// TODO: check if this test is needed
class PayersApiTest extends ApiTestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /** @test */
    public function required_fields_for_all_endpoints()
    {
        factory(PayerRepository::class, 5)->create();

        PayerRepository::create($this->getPayerData());

        $this->get('api/v1/payers/RIBLS/required-fields')
             ->seeJson(['data' => ['provider_name', 'address', 'city', 'state', 'zip', 'npi']])
             ->assertResponseOk();
    }

    /** @test */
    public function required_fields_for_single_endpoint()
    {
        factory(PayerRepository::class, 5)->create();

        PayerRepository::create($this->getPayerData());

        $this->get('api/v1/payers/RIBLS/required-fields?endpoint=coverage')
             ->seeJson(['data' => ['npi']])
             ->assertResponseOk();
    }

    protected function getPayerData()
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
