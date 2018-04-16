<?php
namespace Tests\ApiOld;

use Tests\TestCases\BaseApiTestCase;

class HealthCheckApiTest extends BaseApiTestCase
{
    public function testIndex()
    {
        $this->get('/health-check');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }
}
