<?php

namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class ExternalPatientsApiTest extends BaseApiTestCase
{
    public function testStore()
    {
        $this->markTestSkipped('Table homestead.dental_api_logs doesn\'t exist');
        return;
        $this->post('/external-patient');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }
}
