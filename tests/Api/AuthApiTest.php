<?php

namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class AuthApiTest extends BaseApiTestCase
{
    public function testBadAttempt()
    {
        $this->markTestSkipped('Invalid authorization specification: 1045 Access denied for user "homestead"');
        return;
        $this->post('/auth');
        $this->assertResponseStatus(422);
    }
}
