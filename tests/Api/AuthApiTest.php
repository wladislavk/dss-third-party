<?php

namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class AuthApiTest extends BaseApiTestCase
{
    public function testBadAttempt()
    {
        $this->post('/auth');
        $this->assertResponseStatus(422);
    }
}
