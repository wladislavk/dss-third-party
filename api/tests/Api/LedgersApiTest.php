<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Ledger;
use Tests\TestCases\ApiTestCase;

class LedgersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Ledger::class;
    }

    protected function getRoute()
    {
        return '/ledgers';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 7,
            "patientid" => 88,
            "service_date" => "1984-06-08 00:52:09",
            "entry_date" => "2004-06-23 01:40:03",
            "description" => "Voluptatem id nisi quo.",
            "producer" => "est",
            "transaction_type" => "None",
            "userid" => 7,
            "docid" => 6,
            "status" => 0,
            "transaction_code" => "O0785",
            "placeofservice" => "ut",
            "emg" => "7",
            "diagnosispointer" => "5",
            "daysorunits" => "1",
            "epsdt" => "7",
            "idqual" => "148",
            "modcode" => "Dicta est voluptas expedita debitis a.",
            "producerid" => 8,
            "primary_claim_id" => 1,
            "primary_paper_claim_id" => "39868",
            "modcode2" => "expedita",
            "modcode3" => "labore",
            "modcode4" => "possimus",
            "percase_date" => "1996-06-26 14:59:50",
            "percase_name" => "Janessa Cummerata",
            "percase_amount" => "227.76",
            "percase_status" => 3,
            "percase_invoice" => 2,
            "percase_free" => 0,
            "secondary_claim_id" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test ledger',
            'docid'       => 33,
        ];
    }

    public function testGetListOfLedgerRows()
    {
        $this->post(self::ROUTE_PREFIX . '/ledgers/list');
        $this->assertResponseOk();
        $expected = [
            'total' => 0,
            'result' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetReportTotals()
    {
        $this->post(self::ROUTE_PREFIX . '/ledgers/totals');
        $this->assertResponseOk();
        $expected = [
            'charges' => [],
            'credits' => [
                'type' => [],
                'named' => [],
            ],
            'adjustments' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetReportData()
    {
        $this->post(self::ROUTE_PREFIX . '/ledgers/report-data');
        $this->assertResponseOk();
        $expected = [
            [
                'patientid' => 0,
                'docid' => '0',
                'ledger' => 'claim',
                'ledgerid' => 5,
                'service_date' => null,
                'entry_date' => null,
                'name' => 'Claim',
                'description' => 'Insurance Claim',
                'amount' => null,
                'paid_amount' => null,
                'status' => '0',
                'primary_claim_id' => null,
                'mailed_date' => null,
                'payer' => '',
                'payment_type' => '',
                'claim_status' => '',
                'filename' => '',
                'num_notes' => '0',
                'num_fo_notes' => '0',
                'filed_by_bo' => 0,
            ],
            [
                'patientid' => 0,
                'docid' => '0',
                'ledger' => 'claim',
                'ledgerid' => 201,
                'service_date' => '2016-03-14 21:46:12',
                'entry_date' => '2016-03-14 21:46:12',
                'name' => 'Claim',
                'description' => 'Insurance Claim',
                'amount' => null,
                'paid_amount' => null,
                'status' => '0',
                'primary_claim_id' => null,
                'mailed_date' => null,
                'payer' => '',
                'payment_type' => '',
                'claim_status' => '',
                'filename' => '',
                'num_notes' => '0',
                'num_fo_notes' => '0',
                'filed_by_bo' => 0,
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetReportRowsNumber()
    {
        $this->post(self::ROUTE_PREFIX . '/ledgers/report-rows-number');
        $this->assertResponseOk();
        $expected = [
            'number' => 2,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testUpdatePatientSummaryWithCreate()
    {
        $this->post(self::ROUTE_PREFIX . '/ledgers/update-patient-summary');
        $this->assertResponseOk();
        $content = json_decode($this->response->getContent(), true);
        $this->assertEquals('Patient Summary was successfully inserted.', $content['message']);
        $this->seeInDatabase('dental_patient_summary', ['pid' => 0, 'ledger' => 0]);
    }
}
