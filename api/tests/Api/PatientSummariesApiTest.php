<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
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

    public function testShow()
    {
        $this->markTestSkipped('dental_patient_summary table does not have a primary key');
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

    public function testUpdateTrackerNotes()
    {
        $this->markTestSkipped('dental_patient_summary table does not have a primary key');
        return;

        $this->post(self::ROUTE_PREFIX . '/patient-summaries/update-tracker-notes');
        $this->assertResponseOk();
    }
}
