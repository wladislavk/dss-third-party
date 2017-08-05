<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use Tests\TestCases\ApiTestCase;

class ExternalUsersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ExternalUser::class;
    }

    protected function getRoute()
    {
        return '/external-user';
    }

    protected function getStoreData()
    {
        return [
            'user_id' => 100,
            'api_key' => 'test api key',
            'valid_from' => 'test valid from',
            'valid_to' => 'test valid to',
            'created_by' => 0,
            'updated_by' => 1,
            'enabled' => true,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'api_key' => 'updated api key',
        ];
    }

    public function testShow()
    {
        $this->markTestSkipped('Current controller implementation is not RESTful');
    }

    public function testUpdate()
    {
        $this->markTestSkipped('Current controller implementation is not RESTful');
    }

    public function testDestroy()
    {
        $this->markTestSkipped('Current controller implementation is not RESTful');
    }
}
