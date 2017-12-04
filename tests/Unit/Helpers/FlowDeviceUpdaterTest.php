<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\FlowDeviceUpdater;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class FlowDeviceUpdaterTest extends UnitTestCase
{
    const PATIENT_ID = 123;
    const DEVICE_ID = 10;
    const USER_ID = 1;
    const DOC_ID = 1;
    const IP_ADDRESS = '127.0.0.1';

    /**
     * @var FlowDeviceUpdater
     */
    private $flowDeviceUpdater;

    public function setUp()
    {
        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $tmjClinicalExamRepository = $this->mockTmjClinicalExamRepository();

        $this->flowDeviceUpdater = new FlowDeviceUpdater(
            $appointmentSummaryRepository,
            $tmjClinicalExamRepository
        );
    }

    public function testUpdate()
    {
        $user = new User();
        $user->userid = self::USER_ID;
        $user->docid = self::DOC_ID;
        $user->ip_address = self::IP_ADDRESS;

        $patientId = self::PATIENT_ID;
        $deviceId = self::DEVICE_ID;

        $result = $this->flowDeviceUpdater->update(
            $user,
            $patientId,
            $deviceId
        );

        $expectedResult = null;
        $this->assertEquals($expectedResult, $result);
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);

        $dataForStoringInUpdateById = ['device_id' => self::DEVICE_ID];
        $appointmentSummaryRepository->shouldReceive('updateById')
            ->once()
            ->with(self::PATIENT_ID, $dataForStoringInUpdateById)
            ->andReturn(true)
        ;

        $appointmentSummaryRepository->shouldReceive('getLastAppointmentDevice')
            ->once()
            ->with(self::PATIENT_ID)
            ->andReturnUsing(function () {
                $appointmentSummary = new AppointmentSummary();
                $appointmentSummary->id = self::PATIENT_ID;

                return $appointmentSummary;
            })
        ;

        return $appointmentSummaryRepository;
    }

    private function mockTmjClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $tmjClinicalExamRepository */
        $tmjClinicalExamRepository = \Mockery::mock(TmjClinicalExamRepository::class);

        $tmjClinicalExamRepository->shouldReceive('getWithFilter')
            ->once()
            ->andReturn([])
        ;

        $expectedDataForStoring = [
            'dentaldevice' => self::DEVICE_ID,
            'patientid' => self::PATIENT_ID,
            'userid' => self::USER_ID,
            'docid' => self::DOC_ID,
            'ip_address' => self::IP_ADDRESS
        ];
        $tmjClinicalExamRepository->shouldReceive('create')
            ->once()
            ->with($expectedDataForStoring)
            ->andReturn(true)
        ;

        return $tmjClinicalExamRepository;
    }
}
