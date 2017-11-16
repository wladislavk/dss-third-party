<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\FlowDeviceUpdater;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class FlowDeviceUpdaterTest
{
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

    public function test()
    {

    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('updatePatient')
            ->andReturnUsing([$this, 'updatePatientCallback']);
        return $patientRepository;
    }

    private function mockTmjClinicalExamRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('updatePatient')
            ->andReturnUsing([$this, 'updatePatientCallback']);
        return $patientRepository;
    }
}
