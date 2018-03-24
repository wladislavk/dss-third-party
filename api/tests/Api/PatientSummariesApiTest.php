<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;

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
            "pid" => 999,
            "fspage1_complete" => 1,
            "vob" => "8",
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

    public function testGetTrackerNotes()
    {
        $patientId = 10;
        $this->get(self::ROUTE_PREFIX . '/patient-summaries/get-tracker-notes/' . $patientId);
        $this->assertResponseOk();
        $expected = 'Some note, yaya';
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testUpdateTrackerNotes()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);
        $requestData = [
            'patient_id' => 10,
            'tracker_notes' => 'foo',
        ];
        $this->post(self::ROUTE_PREFIX . '/patient-summaries/update-tracker-notes', $requestData);
        $this->assertResponseOk();
        $tableData = [
            'pid' => 10,
            'tracker_notes' => 'foo',
        ];
        $this->seeInDatabase('dental_patient_summary', $tableData);
    }
}
