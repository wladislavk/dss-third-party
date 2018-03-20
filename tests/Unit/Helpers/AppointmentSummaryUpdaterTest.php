<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Helpers\AppointmentSummaryUpdater;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class AppointmentSummaryUpdaterTest extends UnitTestCase
{
    /** @var AppointmentSummary|null */
    private $summary;

    /** @var TmjClinicalExam|null */
    private $clinicalExam;

    /** @var Model[] */
    private $savedModels = [];

    /** @var AppointmentSummaryUpdater */
    private $appointmentSummaryUpdater;

    public function setUp()
    {
        $this->summary = new AppointmentSummary();

        $clinicalExamRepository = $this->mockClinicalExamRepository();
        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $dbChangeWrapper = $this->mockDbChangeWrapper();
        $this->appointmentSummaryUpdater = new AppointmentSummaryUpdater(
            $clinicalExamRepository, $appointmentSummaryRepository, $dbChangeWrapper
        );
    }

    public function testWithoutExamUpdate()
    {

    }

    public function testWithNewExam()
    {

    }

    public function testWithExistingExam()
    {

    }

    public function testWithExamAndWithoutCompletionDate()
    {

    }

    public function testWithoutSummary()
    {

    }

    private function mockClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $clinicalExamRepository */
        $clinicalExamRepository = \Mockery::mock(TmjClinicalExamRepository::class);
        $clinicalExamRepository->shouldReceive('getOneBy')->andReturn($this->clinicalExam);
        return $clinicalExamRepository;
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('find')->andReturn($this->summary);
        return $appointmentSummaryRepository;
    }

    private function mockDbChangeWrapper()
    {
        /** @var DBChangeWrapper|MockInterface $dbChangeWrapper */
        $dbChangeWrapper = \Mockery::mock(DBChangeWrapper::class);
        $dbChangeWrapper->shouldReceive('save')->andReturnUsing(function (Model $model) {
            $this->savedModels[] = $model;
        });
        return $dbChangeWrapper;
    }
}
