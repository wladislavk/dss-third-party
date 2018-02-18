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
        return [
           'delay_reason' => 'new reason',
        ];
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
}
