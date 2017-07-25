<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use Tests\TestCases\ApiTestCase;

class PatientSummariesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PatientSummary::class;
    }

    protected function getRoute()
    {
        return '/patient-summaries';
    }

    protected function getStoreData()
    {
        return [
            "pid" => 100,
            "fspage1_complete" => 1,
//            "next_visit":{"date":"1981-01-10 09:27:42.000000","timezone_type":3,"timezone":"UTC"},"last_visit":{"date":"2016-12-20 05:31:43.000000","timezone_type":3,"timezone":"UTC"},"last_treatment":"Voluptatem doloremque reiciendis velit.","appliance":0,"delivery_date":{"date":"1971-08-19 16:47:37.000000","timezone_type":3,"timezone":"UTC"},
            "vob" => "8",
            "ledger" => 56.84,
            "patient_info" => 1,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'last_treatment' => 'test treatment',
            'appliance'      => 8,
        ];
    }

    public function testStore()
    {
        $this->markTestSkipped('dental_patient_summary table does not have a primary key');
    }

    public function testUpdate()
    {
        $this->markTestSkipped('dental_patient_summary table does not have a primary key');
    }

    public function testDestroy()
    {
        $this->markTestSkipped('dental_patient_summary table does not have a primary key');
    }
}
