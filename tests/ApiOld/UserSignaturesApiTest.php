<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\UserSignature;
use Tests\TestCases\ApiTestCase;

class UserSignaturesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return UserSignature::class;
    }

    protected function getRoute()
    {
        return '/user-signatures';
    }

    protected function getStoreData()
    {
        return [
            "user_id" => 100,
            "signature_json" => "{\"lx\":18,\"ly\":18,\"mx\":18,\"my\":17}",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'user_id'        => 7,
            'signature_json' => '{"lx":18,"ly":18,"mx":18,"my":18}',
        ];
    }
}
