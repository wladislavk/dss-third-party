<?php
namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class LegacyAuthApiTest extends BaseApiTestCase
{
    /** @test */
    public function testLegacyHashingAlgorithm()
    {
        // @todo - replace with factory after merging admin model
        \DB::table('admin')->insert([
            'email'    => 'test@me.com',
            'username' => 'johndoe',
            'salt'     => 'abcd1234',
            'password' => hash('sha256', 'secret' . 'abcd1234'),
        ]);

        $this->post('auth', ['email' => 'test@me.com', 'password' => 'secret']);
        $this
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }
}
