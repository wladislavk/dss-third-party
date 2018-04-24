<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\TransactionCode;
use Tests\TestCases\ApiTestCase;

class TransactionCodesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TransactionCode::class;
    }

    protected function getRoute()
    {
        return '/transaction-codes';
    }

    protected function getStoreData()
    {
        return [
            "transaction_code" => "L4447",
            "description" => "Atque provident aut nihil dolorem.",
            "type" => "9",
            "sortby" => 4,
            "status" => 9,
            "default_code" => 1,
            "docid" => 100,
            "amount" => "589.75",
            "place" => 7,
            "modifier_code_1" => "illum",
            "modifier_code_2" => "esse",
            "days_units" => "1",
            "amount_adjust" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated transaction code',
            'docid'       => 123,
        ];
    }
}
