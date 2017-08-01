<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\Admin;

class LegacyAuthApiTest extends ApiTestCase
{
    use DatabaseTransactions;

    public function testByUserCredentials()
    {
        $password = 'secret';

        $record = factory(User::class)->create();
        $record->password = hash('sha256', $password . $record->salt);
        $record->save();

        $data = ['username' => $record->username, 'password' => $password];

        $this->json('post', '/auth', $data)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testByAdminCredentials()
    {
        $password = 'secret';

        $record = factory(Admin::class)->create();
        $record->password = hash('sha256', $password . $record->salt);
        $record->save();

        $data = ['username' => $record->username, 'password' => $password, 'admin' => 1];

        $this->json('post', '/auth', $data)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }
}
