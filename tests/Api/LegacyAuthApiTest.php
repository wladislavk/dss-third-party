<?php
namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class LegacyAuthApiTest extends BaseApiTestCase
{
    /** @test */
    public function testLegacyHashingAlgorithm()
    {
        $reason = <<<TEXT
Invalid authorization specification: 1045 Access denied 
in query "select * from `v_users` where (`email` = ?) limit 1".
Need to check Docker DB settings and migrations
TEXT;

        $this->markTestSkipped($reason);
        return;
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
