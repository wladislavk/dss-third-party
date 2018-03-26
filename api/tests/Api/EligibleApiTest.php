<?php

namespace Tests\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCases\BaseApiTestCase;

class EligibleApiTest extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testGetPayers()
    {
        $this->markTestSkipped('This test causes the suite to hang');
        return;
        $this->get(self::ROUTE_PREFIX . '/eligible/payers');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }
}
