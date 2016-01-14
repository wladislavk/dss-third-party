<?php

use DentalSleepSolutions\Eloquent\Payer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PayersTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /** @test */
    public function required_fields()
    {
        factory(Payer::class, 5)->create();

        factory(Payer::class)->create(

            );

        Payer::create([
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
                    "endpoint" => "cost estimate",
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
                    "endpoint" => "fetch and append",
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
        ]);

        $this->get('api/v1/payers/RIBLS/required-fields')
             ->seeJson(['data' => ['provider_name', 'address', 'city', 'state', 'zip', 'npi']])
             ->assertResponseOk();
    }
}
