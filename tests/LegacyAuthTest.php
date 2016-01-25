<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegacyAuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_legacy_hashing_algo()
    {
        // @todo - replace with factory after mergin admin model
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
