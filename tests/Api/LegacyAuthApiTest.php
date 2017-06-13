<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;

class LegacyAuthApiTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_legacy_hashing_algo()
    {
        // @todo - replace with factory after merging admin model
        \DB::table('admin')->insert([
            'email'    => 'test@me.com',
            'username' => 'johndoe',
            'salt'     => 'abcd1234',
            'password' => hash('sha256', 'secret' . 'abcd1234'),
        ]);

        $this->post('auth', ['email' => 'test@me.com', 'password' => 'secret'])
             ->seeJson(['status' => 'Authenticated'])
             ->assertResponseOk();
    }
}
