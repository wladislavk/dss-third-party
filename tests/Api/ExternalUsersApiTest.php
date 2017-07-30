<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use Tests\TestCases\ApiTestCase;

class ExternalUsersApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-user';

    use WithoutMiddleware, DatabaseTransactions;

    public function testListExternalCompanies()
    {
        $this->get(self::ENDPOINT)
            ->assertResponseOk();
    }

    public function testShowExternalUser()
    {
        $record = factory(ExternalUser::class)->create();
        $this->get(self::ENDPOINT . '/' . $record->user_id)
            ->assertResponseOk();
    }

    public function testStoreExternalUser()
    {
        $record = factory(ExternalUser::class)->make();
        $data = $record->toArray();

        $this->json('post', self::ENDPOINT, $data)
            ->seeInDatabase($record->getTable(), ['api_key' => $record->api_key])
            ->assertResponseOk()
        ;
    }

    public function testUpdateExternalUser()
    {
        $record = factory(ExternalUser::class)->create();
        $data = $record->toArray();
        $data['api_key'] = 'test';

        $this->json('put', self::ENDPOINT . '/' . $record->user_id, $data)
            ->seeInDatabase($record->getTable(), ['api_key' => 'test'])
            ->assertResponseOk()
        ;
    }

    public function testDestroyExternalUser()
    {
        $record = factory(ExternalUser::class)->create();
        $this->delete(self::ENDPOINT . '/' . $record->user_id)
            ->notSeeInDatabase($record->getTable(), ['id' => $record->id])
            ->assertResponseOk()
        ;
    }
}
