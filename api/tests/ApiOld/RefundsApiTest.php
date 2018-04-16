<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Refund;
use Tests\TestCases\ApiTestCase;

class RefundsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Refund::class;
    }

    protected function getRoute()
    {
        return '/refunds';
    }

    protected function getStoreData()
    {
        return [
            "amount" => 417.4,
            "userid" => 100,
            "adminid" => 6,
            "refund_date" => "1987-01-13 06:17:24",
            "charge_id" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'adminid' => 100,
        ];
    }
}
