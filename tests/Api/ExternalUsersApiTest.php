<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Faker\Factory as Faker;
use Tests\TestCases\ApiTestCase;

class ExternalUsersApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-user';

    protected function getModel()
    {
        return ExternalUser::class;
    }

    protected function getRoute()
    {
        return '/external-user';
    }

    protected function getStoreData()
    {
        $record = $this->createExternalUser(false);
        unset($record['created_by']);
        unset($record['updated_by']);

        return $record->toArray();
    }

    protected function getUpdateData()
    {
        $faker = Faker::create();

        return [
            'api_key' => $faker->sha1,
        ];
    }

    public function testIndex()
    {
        $this->createExternalUser();

        $this->get(self::ROUTE_PREFIX . $this->getRoute(), $this->getStoreData());
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($this->getResponseData()));
    }

    public function testShow()
    {
        $testRecord = $this->createExternalUser();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->user_id;

        $this->get($endpoint);
        $this->assertResponseOk();
        $data = $this->getResponseData();
        $this->assertEquals($testRecord->$primaryKey, $data[$primaryKey]);
    }

    public function testStore()
    {
        $storeData = $this->getStoreData();

        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $storeData);
    }

    public function testUpdate()
    {
        $testRecord = $this->createExternalUser();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->user_id;
        $updateData = $this->getUpdateData();

        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeInDatabase(
            $this->model->getTable(), array_merge($updateData, [$primaryKey => $testRecord->$primaryKey])
        );
    }

    public function testDestroy()
    {
        $testRecord = $this->createExternalUser();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->user_id;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $testRecord->$primaryKey]);
    }

    private function createExternalUser($save = true)
    {
        $user = factory(User::class)->create();
        $externalUser = factory(ExternalUser::class)->make([
            'user_id' => $user->userid,
        ]);

        if ($save) {
            $externalUser->save();
        }

        return $externalUser;
    }
}
