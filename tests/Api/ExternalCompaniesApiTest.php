<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Tests\TestCases\ApiTestCase;
use Faker\Factory as Faker;

class ExternalCompaniesApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-companies';

    use WithoutMiddleware, DatabaseTransactions;

    public function testListExternalCompanies()
    {
        $this->get(self::ENDPOINT);
        $this->assertResponseOk();
    }

    public function testShowExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $this->get(self::ENDPOINT . '/' . $record->getKey());
        $this->assertResponseOk();
    }

    public function testStoreExternalCompany()
    {
        $record = factory(ExternalCompany::class)->make();
        $data = $record->toArray();

        $this->json('post', self::ENDPOINT, $data);
        $this->assertResponseOk();
        $this->seeInDatabase($record->getTable(), [
            'software' => $record->software,
            'api_key' => $record->api_key,
        ]);
    }

    public function testUpdateExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $faker = Faker::create();
        $record->api_key = $faker->sha1;
        $data = $record->toArray();

        $this->json('put', self::ENDPOINT . '/' . $record->getKey(), $data);
        $this->assertResponseOk();
        $this->seeInDatabase($record->getTable(), [
            'software' => $record->software,
            'api_key' => $record->api_key,
        ]);
    }

    public function testDestroyExternalCompany()
    {
        $record = factory(ExternalCompany::class)->create();
        $this->delete(self::ENDPOINT . '/' . $record->getKey());
        $this->assertResponseOk();
        $this->notSeeInDatabase($record->getTable(), [
            $record->getKeyName() => $record->getKey()
        ]);
    }
}
