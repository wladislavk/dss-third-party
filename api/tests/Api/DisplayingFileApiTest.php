<?php

namespace Tests\Api;

use Tests\TestCases\BaseApiTestCase;

class DisplayingFileApiTest extends BaseApiTestCase
{
    public function testWithNonExistentFile()
    {
        $filename = 'foo.jpg';
        $this->get(self::ROUTE_PREFIX . '/display-file/' . $filename);
        $this->assertResponseStatus(400);
    }
}
