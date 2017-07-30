<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Tests\TestCases\ApiTestCase;

class ExternalCompaniesApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-companies';

    use WithoutMiddleware, DatabaseTransactions;

    public function testListExternalCompanies()
    {
        $this->get(self::ENDPOINT)
            ->assertResponseOk();
    }

    public function testShowExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $this->get(self::ENDPOINT . '/' . $record->id)
            ->assertResponseOk();
    }

    public function testStoreExternalCompany()
    {
        $record = factory(ExternalCompany::class)->make();
        $data = $record->toArray();

        $this->json('post', self::ENDPOINT, $data)
            ->seeInDatabase($record->getTable(), ['api_key' => $record->api_key])
            ->assertResponseOk()
        ;
    }

    public function testUpdateExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $data = $record->toArray();
        $data['api_key'] = 'api_key';

        $this->json('put', self::ENDPOINT . '/' . $record->id, $data)
            ->seeInDatabase($record->getTable(), ['name' => 'test'])
            ->assertResponseOk()
        ;
    }

    public function testDestroyExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $this->delete(self::ENDPOINT . '/' . $record->id)
            ->notSeeInDatabase($record->getTable(), ['id' => $record->id])
            ->assertResponseOk()
        ;
    }
}
