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
        return [
            'user_id' => 100,
            'api_key' => 'test api key',
            'valid_from' => 'test valid from',
            'valid_to' => 'test valid to',
            'created_by' => 0,
            'updated_by' => 1,
            'enabled' => true,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'api_key' => 'updated api key',
        ];
    }

    public function testListExternalUsers()
    {
        $this->get(self::ENDPOINT);
        $this->assertResponseOk();
    }

    public function testShowExternalUser()
    {
        $record = $this->createExternalUser();
        $this->get(self::ENDPOINT . '/' . $record->user_id);
        $this->assertResponseOk();
    }

    public function testStoreExternalUser()
    {
        $record = $this->createExternalUser(false);
        $data = $record->toArray();

        $this->json('post', self::ENDPOINT, $data);
        $this->assertResponseOk();
        $this->seeInDatabase($record->getTable(), [
            'user_id' => $record->user_id,
            'api_key' => $record->api_key,
        ]);
    }

    public function testUpdateExternalUser()
    {
        $record = $this->createExternalUser();
        $faker = Faker::create();
        $record->api_key = $faker->sha1;
        $data = $record->toArray();

        $this->json('put', self::ENDPOINT . '/' . $record->user_id, $data);
        $this->assertResponseOk();
        $this->seeInDatabase($record->getTable(), [
            'user_id' => $record->user_id,
            'api_key' => $record->api_key,
        ]);
    }

    public function testDestroyExternalUser()
    {
        $record = $this->createExternalUser();
        $this->delete(self::ENDPOINT . '/' . $record->user_id);
        $this->assertResponseOk();
        $this->notSeeInDatabase($record->getTable(), [
            'user_id' => $record->user_id
        ]);
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
