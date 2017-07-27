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
            'enabled' => true,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'api_key' => 'updated api key',
        ];
    }

    public function testIndex()
    {
        $this->markTestSkipped('Table dental_external_users does not exist');
    }

    public function testShow()
    {
        $this->markTestSkipped('Table dental_external_users does not exist');
    }

    public function testStore()
    {
        $this->markTestSkipped('Table dental_external_users does not exist');
    }

    public function testUpdate()
    {
        $this->markTestSkipped('Table dental_external_users does not exist');
    }

    public function testDestroy()
    {
        $this->markTestSkipped('Table dental_external_users does not exist');
    }
}
