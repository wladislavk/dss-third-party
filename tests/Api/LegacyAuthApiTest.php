<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Admin;

class LegacyAuthApiTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testLegacyHashingAlgorithm()
    {
        $password = 'secret';

        $record = factory(Admin::class)->make();
        $record->password = hash('sha256', $password . $record->salt);
        $record->save();

        $data = ['email' => $record->email, 'password' => $password];

        $this->post('auth', $data)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }
}
