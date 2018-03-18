<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use Tests\TestCases\ApiTestCase;

class AppointmentSummariesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AppointmentSummary::class;
    }

    protected function getRoute()
    {
        return '/appt-summaries';
    }

    protected function getStoreData()
    {
        return [
            'patientid' => 1,
            'stepid' => 2,
            'segmentid' => 3,
            'date_scheduled' => '2013-04-03',
            'date_completed' => '2013-04-03',
            'delay_reason' => 'test reason',
            'study_type' => 'test type',
            'letterid' => '4',
            'description' => 'test description',
            'noncomp_reason' => 'test noncomp reason',
            'appointment_type' => 1,
            'device_id' => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [];
    }

    public function testStore()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);

        $stepId = 1;
        $patientId = 200;
        $requestData = [
            'step_id' => $stepId,
            'patient_id' => $patientId,
        ];
        $this->post(self::ROUTE_PREFIX . '/appt-summaries', $requestData);
        $this->assertResponseOk();
        $this->seeInDatabase('dental_flow_pg2_info', [
            'patientid' => $patientId,
            'segmentid' => $stepId,
            'appointment_type' => 1,
            'date_completed' => (new \DateTime())->format('Y-m-d'),
        ]);
    }

    public function testUpdate()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);

        $summaryId = 15;
        $patientId = 51;
        $completionDate = '06/25/2016';
        $requestData = [
            'patient_id' => $patientId,
            'comp_date' => $completionDate,
        ];
        $this->put(self::ROUTE_PREFIX . '/appt-summaries/' . $summaryId, $requestData);
        $this->assertResponseOk();
        $this->seeInDatabase('dental_flow_pg2_info', [
            'id' => $summaryId,
            'date_completed' => '2016-06-25',
        ]);
        $this->notSeeInDatabase('dental_ex_page5', [
            'patientid' => $patientId,
            'dentaldevice_date' => '2016-06-25',
        ]);
    }

    public function testDestroy()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);

        /** @var Letter $testLetter */
        $testLetter = factory(Letter::class)->create();
        $letterId = $testLetter->letterid;
        /** @var AppointmentSummary $testRecord */
        $testRecord = factory($this->getModel())->create();
        $testLetter->info_id = $testRecord->id;
        $testLetter->deleted = 0;
        $testLetter->deleted_by = null;
        $testLetter->save();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $testRecord->$primaryKey]);
        $data = [
            'letterid' => $letterId,
            'deleted' => 1,
            'deleted_by' => 1,
        ];
        $this->seeInDatabase($testLetter->getTable(), $data);
    }

    public function testGetFinalRank()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);

        $patientId = 170;

        $endpoint = self::ROUTE_PREFIX . '/appt-summaries/final-rank/' . $patientId;
        $this->get($endpoint);

        $this->assertResponseOk();
        $expected = [
            'last_segment' => 4,
            'final_segment' => 4,
            'final_rank' => 4,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetByPatient()
    {
        $patientId = 10;
        $this->get(self::ROUTE_PREFIX . '/appt-summaries/by-patient/' . $patientId);
        $this->assertResponseOk();
        $ids = array_column($this->getResponseData(), 'id');
        $expected = [448, 233, 232, 231, 228, 164, 142, 450];
        $this->assertEquals($expected, $ids);
    }

    public function testGetFutureAppointment()
    {
        /** @var AppointmentSummary $testRecord */
        $testRecord = factory($this->getModel())->create();
        $patientId = $testRecord->patientid;
        $testRecord->appointment_type = 0;
        $testRecord->save();
        $this->get(self::ROUTE_PREFIX . '/appt-summaries/future-appointment/' . $patientId);
        $this->assertResponseOk();
        $response = $this->getResponseData();
        $this->assertEquals($testRecord->id, $response['id']);
    }
}
