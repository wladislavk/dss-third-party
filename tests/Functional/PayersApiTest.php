<?php
namespace Tests\Functional;

use Illuminate\Support\Arr;
use DentalSleepSolutions\Eloquent\Models\Payer;
use DentalSleepSolutions\Eloquent\Repositories\PayerRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;

// TODO: check if this test is needed
class PayersApiTest extends ApiTestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /** @var PayerRepository */
    private $payerRepository;

    public function setUp()
    {
        parent::setUp();
        $this->payerRepository = $this->app->make(PayerRepository::class);
    }

    public function testRequiredFieldsForAllEndpoints()
    {
        $payer = factory(Payer::class)->create();
        $mandatoryFields = $payer->requiredFields();

        $this->get("api/v1/payers/{$payer->payer_id}/required-fields");
        $this->assertResponseOk();
        $this->seeJson([
            'data' => $mandatoryFields
        ]);
    }

    /** @test */
    public function testRequiredFieldsForSingleEndpoint()
    {
        $payer = factory(Payer::class)->create();
        $supportedEndpoints = $payer->supported_endpoints;
        $firstEndpoint = $supportedEndpoints[0];
        $mandatoryFields = $payer->requiredFields($firstEndpoint['endpoint']);

        $this->get("api/v1/payers/{$payer->payer_id}/required-fields?endpoint=" . urlencode($firstEndpoint['endpoint']));
        $this->assertResponseOk();
        $this->seeJson([
            'data' => $mandatoryFields
        ]);
    }
}
