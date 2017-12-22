<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerRecord;
use Tests\TestCases\ApiTestCase;

class LedgerRecordsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerRecord::class;
    }

    protected function getRoute()
    {
        return '/ledger-records';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 2,
            "patientid" => 100,
            "description" => "Voluptates voluptates cum voluptatem.",
            "producer" => "suscipit",
            "amount" => 811.75,
            "transaction_type" => "None",
            "userid" => 1,
            "docid" => 8,
            "status" => 0,
            "transaction_code" => "U0863",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated ledger record',
            'status'      => 8,
        ];
    }
}
