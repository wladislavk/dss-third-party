<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCases\ApiTestCase;

class ExternalUsersApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-user';

    use WithoutMiddleware, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
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
