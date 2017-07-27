<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;

class LedgerStatementsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerStatement::class;
    }

    protected function getRoute()
    {
        return '/ledger-statements';
    }

    protected function getStoreData()
    {
        return [
            "producerid" => 100,
            "filename" => "/manage/letterpdfs/statement_4238_1249456.pdf",
            "patientid" => 4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'  => 50,
            'producerid' => 40,
        ];
    }
}
