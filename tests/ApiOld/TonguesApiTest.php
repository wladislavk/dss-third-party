<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Tongue;
use Tests\TestCases\ApiTestCase;

class TonguesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Tongue::class;
    }

    protected function getRoute()
    {
        return '/tongues';
    }

    protected function getStoreData()
    {
        return [
            "tongue" => "added tongue",
            "description" => "Est qui qui qui quia deleniti dicta magnam doloribus.",
            "sortby" => 4,
            "status" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated tongue',
            'status'      => 8,
        ];
    }
}
