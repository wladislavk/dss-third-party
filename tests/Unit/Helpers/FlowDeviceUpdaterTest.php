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
    const PATIENT_ID = 123;
    const DEVICE_ID = 10;
    const USER_ID = 1;
    const DOC_ID = 1;
    const IP_ADDRESS = '127.0.0.1';

    /**
     * @var FlowDeviceUpdater
     */
    private $flowDeviceUpdater;

    /**
     * @var AppointmentSummary|null
     */
    private $appointmentSummary;

    /**
     * @var array
     */
    private $tmjClinicalExams;

    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        $this->appointmentSummary = new AppointmentSummary();
        $this->appointmentSummary->id = self::PATIENT_ID;

        $this->tmjClinicalExams = null;

        $this->user = new User();
        $this->user->userid = self::USER_ID;
        $this->user->docid = self::DOC_ID;
        $this->user->ip_address = self::IP_ADDRESS;

        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $tmjClinicalExamRepository = $this->mockTmjClinicalExamRepository();

        $this->flowDeviceUpdater = new FlowDeviceUpdater(
            $appointmentSummaryRepository,
            $tmjClinicalExamRepository
        );
    }

    public function testUpdateWithoutLastAppointmentDevice()
    {
        $this->appointmentSummary = null;

        $result = $this->flowDeviceUpdater->update(
            $this->user,
            self::PATIENT_ID,
            self::DEVICE_ID
        );

        $this->assertEquals(null, $result);
    }

    public function testUpdateWithWrongLastAppointmentDeviceId()
    {
        $this->appointmentSummary->id = 0;

        $result = $this->flowDeviceUpdater->update(
            $this->user,
            self::PATIENT_ID,
            self::DEVICE_ID
        );

        $this->assertEquals(null, $result);
    }

    public function testUpdateWithLastAppointmentDevice()
    {
        $this->tmjClinicalExams = [];

        $result = $this->flowDeviceUpdater->update(
            $this->user,
            self::PATIENT_ID,
            self::DEVICE_ID
        );

        $this->assertEquals(null, $result);
    }

    public function testUpdateWithTmjClinicalExamUpdating()
    {
        $this->tmjClinicalExams = [
            new TmjClinicalExam()
        ];

        $result = $this->flowDeviceUpdater->update(
            $this->user,
            self::PATIENT_ID,
            self::DEVICE_ID
        );

        $this->assertEquals(null, $result);
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);

        $dataForStoringInUpdateById = ['device_id' => self::DEVICE_ID];
        $appointmentSummaryRepository->shouldReceive('update')
            ->once()
            ->with($dataForStoringInUpdateById, self::PATIENT_ID)
            ->andReturn(true)
        ;

        $appointmentSummaryRepository->shouldReceive('getLastAppointmentDevice')
            ->once()
            ->with(self::PATIENT_ID)
            ->andReturnUsing(function () {
                return $this->appointmentSummary;
            })
        ;

        return $appointmentSummaryRepository;
    }

    private function mockTmjClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $tmjClinicalExamRepository */
        $tmjClinicalExamRepository = \Mockery::mock(TmjClinicalExamRepository::class);

        $tmjClinicalExamRepository
            ->shouldReceive('getWithFilter')
            ->never()
        ;

        $tmjClinicalExamRepository
            ->shouldReceive('getWithFilter')
            ->once()
            ->andReturnUsing(function () {
                return $this->tmjClinicalExams;
            })
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

        $data = ['dentaldevice' => self::DEVICE_ID];
        $where = ['patientid' => self::PATIENT_ID];
        $tmjClinicalExamRepository->shouldReceive('updateWhere')
            ->once()
            ->with($data, $where)
            ->andReturn(true)
        ;

        return $tmjClinicalExamRepository;
    }
}
