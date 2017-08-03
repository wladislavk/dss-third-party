<?php

namespace Tests\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCases\BaseApiTestCase;

class ExternalPatientsApiTest extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * @todo: check how to return 200
     */
    public function testStore()
    {
        $this->post('/external-patient');
        $this->assertResponseStatus(422);
    }
}
