<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Admin;
use Tests\TestCases\ApiTestCase;

class AdminsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Admin::class;
    }

    protected function getRoute()
    {
        return '/admins';
    }

    protected function getStoreData()
    {
        $username = 'new' . date('Y-m-d H:i:s');
        return [
            'name'               => 'PHPUnit admin',
            'username'           => $username,
            'password'           => 'testPassword',
            'status'             => 2,
            'admin_access'       => 4,
            'email'              => 'test@email.com',
            'first_name'         => 'testFirstName',
            'last_name'          => 'testLastName',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'       => 'PHPUnit updated admin',
            'first_name' => 'testFirstNameUpdated',
            'password'   => 'test',
        ];
    }
}
