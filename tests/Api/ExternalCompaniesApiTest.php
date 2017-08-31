<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Tests\TestCases\ApiTestCase;
use Faker\Factory as Faker;

class ExternalCompaniesApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-companies';

    protected function getModel()
    {
        return ExternalCompany::class;
    }

    protected function getRoute()
    {
        return '/external-companies';
    }

    protected function getStoreData()
    {
        return [
            'software' => 'test software',
            'name' => 'test name',
            'short_name' => 'test short name',
            'api_key' => 'test api key',
            'valid_from' => 'test valid from',
            'valid_to' => 'test valid to',
            'url' => 'test url',
            'description' => 'test description',
            'status' => 1,
            'created_by' => 0,
            'updated_by' => 2,
            'reason' => 'test reason',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'software' => 'updated software',
            'name' => 'updated name',
        ];
    }

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
