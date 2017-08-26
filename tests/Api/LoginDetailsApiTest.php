<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\LoginDetail;
use Tests\TestCases\ApiTestCase;

class LoginDetailsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LoginDetail::class;
    }

    protected function getRoute()
    {
        return '/login-details';
    }

    protected function getStoreData()
    {
        return [
            "userid" => 0,
            "cur_page" => "architecto",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'userid'   => 33,
            'cur_page' => '/manage/test.php',
        ];
    }
}
