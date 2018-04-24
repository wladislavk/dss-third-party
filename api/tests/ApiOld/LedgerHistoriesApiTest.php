<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerHistory;
use Tests\TestCases\ApiTestCase;

class LedgerHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerHistory::class;
    }

    protected function getRoute()
    {
        return '/ledger-histories';
    }

    protected function getStoreData()
    {
        return [
            "ledgerid" => 9,
            "formid" => 7,
            "patientid" => 100,
            "description" => "Soluta at quam dicta qui rerum est illo.",
            "producer" => "Ivy Walter",
            "transaction_type" => "Credit",
            "userid" => 0,
            "docid" => 1,
            "status" => 3,
            "transaction_code" => "E5629",
            "placeofservice" => "84",
            "emg" => "78",
            "diagnosispointer" => "17",
            "daysorunits" => "18",
            "epsdt" => "89",
            "idqual" => "42",
            "modcode" => "45",
            "producerid" => 7,
            "primary_claim_id" => 7,
            "primary_paper_claim_id" => "41",
            "modcode2" => "atque",
            "modcode3" => "quia",
            "modcode4" => "ut",
            "percase_date" => "2014-01-01 07:27:32",
            "percase_name" => "Vivien Carter",
            "percase_amount" => "42.03",
            "percase_status" => 9,
            "percase_invoice" => 2,
            "percase_free" => 2,
            "updated_by_user" => 5,
            "updated_by_admin" => 2,
            "primary_claim_history_id" => 7,
            "secondary_claim_id" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated ledger history',
            'status'      => 5,
        ];
    }

    public function testGetHistoriesForLedgerReport()
    {
        $this->post(self::ROUTE_PREFIX . '/ledger-histories/ledger-report');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }
}
