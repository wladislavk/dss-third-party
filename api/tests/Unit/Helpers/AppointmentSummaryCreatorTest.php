<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LetterTriggerFactory;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Helpers\AppointmentSummaryCreator;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FirstRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\SecondRefusedTreatmentTrigger;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class AppointmentSummaryCreatorTest extends UnitTestCase
{
    private const NEW_MODEL_ID = 10;
    private const PATIENT_ID = 42;
    private const CLINICAL_EXAM_PATIENT_ID = 43;
    private const STEP_ID = 99;
    private const USER_ID = 5;
    private const DOC_ID = 6;

    /** @var Model[] */
    private $savedModels = [];

    /** @var Model[] */
    private $deletedModels = [];

    /** @var SummaryLetterTriggerData[] */
    private $triggeredLetters = [];

    /** @var AppointmentSummary|null */
    private $futureAppointment;

    /** @var TmjClinicalExam|null */
    private $clinicalExam;

    /** @var bool */
    private $shouldDelete = true;

    /** @var User|null */
    private $doctor;

    /** @var AppointmentSummaryCreator */
    private $appointmentSummaryCreator;

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     */
    public function setUp()
    {
        $this->doctor = new User();
        $this->doctor->use_letters = false;
        $this->doctor->tracker_letters = false;

        $letterTriggerFactory = $this->mockLetterTriggerFactory();
        $repositoryFactory = $this->mockRepositoryFactory();
        $dbChangeWrapper = $this->mockDBChangeWrapper();
        $this->appointmentSummaryCreator = new AppointmentSummaryCreator(
            $letterTriggerFactory, $repositoryFactory, $dbChangeWrapper
        );
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testCreateSummary()
    {
        $data = new SummaryLetterTriggerData();
        $data->stepId = self::STEP_ID;
        $data->patientId = self::PATIENT_ID;
        $newSummary = $this->appointmentSummaryCreator->createAppointmentSummary($data);
        $this->assertEquals(1, sizeof($this->savedModels));
        /** @var AppointmentSummary $savedSummary */
        $savedSummary = $this->savedModels[0];
        $this->assertEquals(self::PATIENT_ID, $newSummary->patientid);
        $this->assertEquals(self::PATIENT_ID, $savedSummary->patientid);
        $this->assertEquals(self::STEP_ID, $newSummary->segmentid);
        $this->assertEquals(1, $newSummary->appointment_type);
        $today = (new \DateTime())->format('Y-m-d');
        $this->assertEquals($today, $newSummary->date_completed->format('Y-m-d'));
        $this->assertEquals(0, sizeof($this->deletedModels));
        $this->assertEquals(0, sizeof($this->triggeredLetters));
        $this->assertEquals(self::NEW_MODEL_ID, $data->infoId);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testLetterTriggers()
    {
        $this->doctor->use_letters = true;
        $this->doctor->tracker_letters = true;
        $data = new SummaryLetterTriggerData();
        $data->stepId = 6;
        $data->patientId = self::PATIENT_ID;
        $this->appointmentSummaryCreator->createAppointmentSummary($data);
        $this->assertEquals(['first', 'second'], $this->triggeredLetters);
    }

    /**
     * @throws GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testNewClinicalExam()
    {
        $data = new SummaryLetterTriggerData();
        $data->stepId = TrackerSteps::DEVICE_DELIVERY_ID;
        $data->patientId = self::PATIENT_ID;
        $data->userId = self::USER_ID;
        $data->docId = self::DOC_ID;
        $this->appointmentSummaryCreator->createAppointmentSummary($data);
        $this->assertEquals(2, sizeof($this->savedModels));
        /** @var TmjClinicalExam $newClinicalExam */
        $newClinicalExam = $this->savedModels[0];
        $this->assertEquals(self::PATIENT_ID, $newClinicalExam->patientid);
        $this->assertEquals(self::USER_ID, $newClinicalExam->userid);
        $this->assertEquals(self::DOC_ID, $newClinicalExam->docid);
        $today = (new \DateTime())->format('Y-m-d');
        $this->assertEquals($today, $newClinicalExam->dentaldevice_date->format('Y-m-d'));
    }

    /**
     * @throws GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testUpdateClinicalExam()
    {
        $this->clinicalExam = new TmjClinicalExam();
        $this->clinicalExam->patientid = self::CLINICAL_EXAM_PATIENT_ID;
        $this->clinicalExam->dentaldevice_date = new \DateTime('2010-01-01');
        $data = new SummaryLetterTriggerData();
        $data->stepId = TrackerSteps::DEVICE_DELIVERY_ID;
        $data->patientId = self::PATIENT_ID;
        $this->appointmentSummaryCreator->createAppointmentSummary($data);
        /** @var TmjClinicalExam $newClinicalExam */
        $newClinicalExam = $this->savedModels[0];
        $this->assertEquals(self::CLINICAL_EXAM_PATIENT_ID, $newClinicalExam->patientid);
        $today = (new \DateTime())->format('Y-m-d');
        $this->assertEquals($today, $newClinicalExam->dentaldevice_date->format('Y-m-d'));
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testDeleteFutureAppointment()
    {
        $this->futureAppointment = new AppointmentSummary();
        $this->futureAppointment->id = 1;
        $data = new SummaryLetterTriggerData();
        $data->stepId = self::STEP_ID;
        $data->patientId = self::PATIENT_ID;
        $this->appointmentSummaryCreator->createAppointmentSummary($data);
        $this->assertEquals(1, sizeof($this->deletedModels));
        /** @var AppointmentSummary $deleted */
        $deleted = $this->deletedModels[0];
        $this->assertEquals(1, $deleted->id);
    }

    /**
     * @throws GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testDeleteFutureAppointmentError()
    {
        $this->shouldDelete = false;
        $this->futureAppointment = new AppointmentSummary();
        $this->futureAppointment->id = 1;
        $data = new SummaryLetterTriggerData();
        $data->stepId = self::STEP_ID;
        $data->patientId = self::PATIENT_ID;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Could not delete future appointment: foo');
        $this->appointmentSummaryCreator->createAppointmentSummary($data);
    }

    private function mockLetterTriggerFactory()
    {
        /** @var LetterTriggerFactory|MockInterface $letterTriggerFactory */
        $letterTriggerFactory = \Mockery::mock(LetterTriggerFactory::class);
        $letterTriggerFactory->shouldReceive('getLetterTriggers')->andReturn([
            $this->mockFirstRefusedTreatmentTrigger(),
            $this->mockSecondRefusedTreatmentTrigger(),
        ]);
        return $letterTriggerFactory;
    }

    private function mockFirstRefusedTreatmentTrigger()
    {
        /** @var FirstRefusedTreatmentTrigger|MockInterface $trigger */
        $trigger = \Mockery::mock(FirstRefusedTreatmentTrigger::class);
        $trigger->shouldReceive('triggerLetter')->andReturnUsing(function () {
            $this->triggeredLetters[] = 'first';
        });
        return $trigger;
    }

    private function mockSecondRefusedTreatmentTrigger()
    {
        /** @var SecondRefusedTreatmentTrigger|MockInterface $trigger */
        $trigger = \Mockery::mock(SecondRefusedTreatmentTrigger::class);
        $trigger->shouldReceive('triggerLetter')->andReturnUsing(function () {
            $this->triggeredLetters[] = 'second';
        });
        return $trigger;
    }

    private function mockRepositoryFactory()
    {
        /** @var RepositoryFactory|MockInterface $repositoryFactory */
        $repositoryFactory = \Mockery::mock(RepositoryFactory::class);
        $repositoryFactory->shouldReceive('getRepository')->andReturnUsing(function ($repoClass) {
            switch ($repoClass) {
                case AppointmentSummaryRepository::class:
                    return $this->mockAppointmentSummaryRepository();
                case TmjClinicalExamRepository::class:
                    return $this->mockClinicalExamRepository();
                case UserRepository::class:
                    return $this->mockUserRepository();
            }
            return null;
        });
        return $repositoryFactory;
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('getFutureAppointment')->andReturnUsing(function () {
            return $this->futureAppointment;
        });
        return $appointmentSummaryRepository;
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

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('find')->andReturnUsing(function () {
            return $this->doctor;
        });
        return $userRepository;
    }

    private function mockDBChangeWrapper()
    {
        /** @var DBChangeWrapper|MockInterface $dbChangeWrapper */
        $dbChangeWrapper = \Mockery::mock(DBChangeWrapper::class);
        $dbChangeWrapper->shouldReceive('save')->andReturnUsing(function (Model $model) {
            $this->savedModels[] = $model;
            $model->id = self::NEW_MODEL_ID;
        });
        $dbChangeWrapper->shouldReceive('delete')->andReturnUsing(function (Model $model) {
            if (!$this->shouldDelete) {
                throw new \Exception('foo');
            }
            $this->deletedModels[] = $model;
        });
        return $dbChangeWrapper;
    }
}
