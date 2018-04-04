<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\AppointmentSummaryUpdater;
use DentalSleepSolutions\Structs\AppointmentSummaryData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class AppointmentSummaryUpdaterTest extends UnitTestCase
{
    private const SUMMARY_ID = 11;
    private const SEGMENT_ID = 8;
    private const PATIENT_ID = 20;
    private const EXISTING_PATIENT_ID = 21;
    private const USER_ID = 30;
    private const DOC_ID = 40;
    private const EXISTING_STUDY_TYPE = 'foo';
    private const NEW_STUDY_TYPE = 'bar';

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
        $this->summary->id = self::SUMMARY_ID;
        $this->summary->segmentid = self::SEGMENT_ID;
        $this->summary->date_completed = new \DateTime('2016-01-01');
        $this->summary->study_type = self::EXISTING_STUDY_TYPE;

        $clinicalExamRepository = $this->mockClinicalExamRepository();
        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $dbChangeWrapper = $this->mockDbChangeWrapper();
        $this->appointmentSummaryUpdater = new AppointmentSummaryUpdater(
            $clinicalExamRepository, $appointmentSummaryRepository, $dbChangeWrapper
        );
    }

    /**
     * @throws GeneralException
     */
    public function testWithoutExamUpdate()
    {
        $data = new AppointmentSummaryData();
        $data->summaryId = self::SUMMARY_ID;
        $data->studyType = self::NEW_STUDY_TYPE;
        $newDate = '2017-02-02';
        $data->setCompletionDate($newDate);
        $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
        $this->assertEquals(1, sizeof($this->savedModels));
        /** @var AppointmentSummary $newSummary */
        $newSummary = $this->savedModels[0];
        $this->assertEquals($newDate, $newSummary->date_completed->format('Y-m-d'));
        $this->assertEquals(self::NEW_STUDY_TYPE, $newSummary->study_type);
    }

    /**
     * @throws GeneralException
     */
    public function testWithNewExam()
    {
        $this->summary->segmentid = TrackerSteps::DEVICE_DELIVERY_ID;
        $data = new AppointmentSummaryData();
        $data->summaryId = self::SUMMARY_ID;
        $data->patientId = self::PATIENT_ID;
        $data->userId = self::USER_ID;
        $data->docId = self::DOC_ID;
        $newDate = '2017-02-02';
        $data->setCompletionDate($newDate);
        $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
        $this->assertEquals(2, sizeof($this->savedModels));
        /** @var TmjClinicalExam $newExam */
        $newExam = $this->savedModels[0];
        $this->assertEquals(self::PATIENT_ID, $newExam->patientid);
        $this->assertEquals(self::USER_ID, $newExam->userid);
        $this->assertEquals(self::DOC_ID, $newExam->docid);
        $this->assertEquals($newDate, $newExam->dentaldevice_date->format('Y-m-d'));
    }

    /**
     * @throws GeneralException
     */
    public function testWithExistingExam()
    {
        $this->clinicalExam = new TmjClinicalExam();
        $this->clinicalExam->patientid = self::EXISTING_PATIENT_ID;
        $this->clinicalExam->dentaldevice_date = new \DateTime('2016-02-02');

        $this->summary->segmentid = TrackerSteps::DEVICE_DELIVERY_ID;
        $data = new AppointmentSummaryData();
        $data->summaryId = self::SUMMARY_ID;
        $data->patientId = self::PATIENT_ID;
        $newDate = '2017-02-02';
        $data->setCompletionDate($newDate);

        $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
        $this->assertEquals(2, sizeof($this->savedModels));
        /** @var TmjClinicalExam $existingExam */
        $existingExam = $this->savedModels[0];
        $this->assertEquals(self::EXISTING_PATIENT_ID, $existingExam->patientid);
        $this->assertEquals($newDate, $existingExam->dentaldevice_date->format('Y-m-d'));
    }

    /**
     * @throws GeneralException
     */
    public function testWithExamAndWithoutNewData()
    {
        $this->clinicalExam = new TmjClinicalExam();
        $this->clinicalExam->patientid = self::EXISTING_PATIENT_ID;
        $this->clinicalExam->dentaldevice_date = new \DateTime('2016-02-02');
        $today = (new \DateTime())->format('Y-m-d');

        $this->summary->segmentid = TrackerSteps::DEVICE_DELIVERY_ID;
        $data = new AppointmentSummaryData();
        $data->summaryId = self::SUMMARY_ID;

        $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
        $this->assertEquals(2, sizeof($this->savedModels));
        /** @var TmjClinicalExam $existingExam */
        $existingExam = $this->savedModels[0];
        $this->assertNull($existingExam->dentaldevice_date);
        /** @var AppointmentSummary $newSummary */
        $newSummary = $this->savedModels[1];
        $this->assertEquals($today, $newSummary->date_completed->format('Y-m-d'));
        $this->assertEquals(self::EXISTING_STUDY_TYPE, $newSummary->study_type);
    }

    /**
     * @throws GeneralException
     */
    public function testWithoutSummary()
    {
        $this->summary = null;
        $data = new AppointmentSummaryData();
        $data->summaryId = self::SUMMARY_ID;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Appointment summary with ID ' . self::SUMMARY_ID . ' not found');
        $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
    }

    private function mockClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $clinicalExamRepository */
        $clinicalExamRepository = \Mockery::mock(TmjClinicalExamRepository::class);
        $clinicalExamRepository->shouldReceive('getOneBy')->andReturnUsing(function () {
            return $this->clinicalExam;
        });
        return $clinicalExamRepository;
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('find')->andReturnUsing(function () {
            return $this->summary;
        });
        $appointmentSummaryRepository->shouldReceive('getByPatient')->andReturnUsing(function () {
            return [$this->summary];
        });
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
