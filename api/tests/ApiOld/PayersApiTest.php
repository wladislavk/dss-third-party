<?php
namespace Tests\ApiOld;

use Illuminate\Support\Arr;
use DentalSleepSolutions\Eloquent\Models\Payer;
use DentalSleepSolutions\Eloquent\Repositories\PayerRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

    /** @var PayerRepository */
    private $payerRepository;

    public function setUp()
    {
        parent::setUp();
        $this->payerRepository = $this->app->make(PayerRepository::class);
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

    public function testIndex()
    {
        $this->markTestSkipped('Model is incorrectly transformed to array');
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
