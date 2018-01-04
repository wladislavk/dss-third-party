<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\FlowDeviceUpdater;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class FlowDeviceUpdaterTest extends UnitTestCase
{
    /** @var FlowDeviceUpdater */
    private $flowDeviceUpdater;

    /** @var array */
    private $appointmentSummary = [];

    /** @var array */
    private $createParams = [];

    /** @var array */
    private $updateParams = [];

    /** @var array */
    private $updateSummaryParams = [];

    /** @var array */
    private $tmjClinicalExams = [];

    /** @var User */
    private $user;

    public function setUp()
    {
        $this->appointmentSummary = ['id' => 123];

        $this->user = new User();
        $this->user->userid = 1;
        $this->user->docid = 2;
        $this->user->ip_address = '127.0.0.1';

        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $tmjClinicalExamRepository = $this->mockTmjClinicalExamRepository();

        $this->flowDeviceUpdater = new FlowDeviceUpdater(
            $appointmentSummaryRepository,
            $tmjClinicalExamRepository
        );
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateWithoutLastAppointmentDevice()
    {
        $this->appointmentSummary = [];
        $this->flowDeviceUpdater->update($this->user, 123, 10);
        $expectedSummaryParams = [
            'device_id' => 10,
            'patient_id' => 123,
        ];
        $this->assertEquals($expectedSummaryParams, $this->updateSummaryParams);
        $this->assertEquals([], $this->createParams);
        $this->assertEquals([], $this->updateParams);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateWithLastAppointmentDevice()
    {
        $this->tmjClinicalExams = [];
        $this->flowDeviceUpdater->update($this->user, 123, 10);
        $expected = [
            'dentaldevice' => 10,
            'patientid' => 123,
            'userid' => 1,
            'docid' => 2,
            'ip_address' => '127.0.0.1',
        ];
        $this->assertEquals($expected, $this->createParams);
        $this->assertEquals([], $this->updateParams);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateWithTmjClinicalExamUpdating()
    {
        $this->tmjClinicalExams = [
            new TmjClinicalExam(),
        ];
        $this->flowDeviceUpdater->update($this->user, 123, 10);
        $expected = [
            'data' => ['dentaldevice' => 10],
            'condition' => ['patientid' => 123],
        ];
        $this->assertEquals([], $this->createParams);
        $this->assertEquals($expected, $this->updateParams);
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('updateWhere')
            ->andReturnUsing(function (array $data, array $condition) {
                $this->updateSummaryParams = [
                    'device_id' => $data['device_id'],
                    'patient_id' => $condition['patientid'],
                ];
            })
        ;
        $appointmentSummaryRepository->shouldReceive('getLastAppointmentDevice')->andReturnUsing(function () {
            return $this->appointmentSummary;
        });
        return $appointmentSummaryRepository;
    }

    private function mockTmjClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $tmjClinicalExamRepository */
        $tmjClinicalExamRepository = \Mockery::mock(TmjClinicalExamRepository::class);
        $tmjClinicalExamRepository->shouldReceive('getWithFilter')->andReturnUsing(function () {
            return $this->tmjClinicalExams;
        });
        $tmjClinicalExamRepository->shouldReceive('create')->andReturnUsing(function (array $params) {
            $this->createParams = $params;
        });
        $tmjClinicalExamRepository->shouldReceive('updateWhere')->andReturnUsing(function (array $data, array $condition) {
            $this->updateParams = [
                'data' => $data,
                'condition' => $condition,
            ];
        });
        return $tmjClinicalExamRepository;
    }
}
