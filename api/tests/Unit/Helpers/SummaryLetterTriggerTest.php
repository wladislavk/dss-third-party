<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Constants\SummaryLetterTable;
use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Helpers\SummaryLetterDataUpdater;
use DentalSleepSolutions\Helpers\SummaryLetterTrigger;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class SummaryLetterTriggerTest extends UnitTestCase
{
    private const DOC_ID = 12;
    private const LETTER_ID = 13;
    private const PATIENT_ID = 14;
    private const USER_ID = 15;
    private const INFO_ID = 16;
    private const MD_LIST = [1, 2, 3];

    /** @var SummaryLetterTriggerData */
    private $initialData;

    /** @var User|null */
    private $docUser;

    /** @var int */
    private $completedRows = 0;

    /** @var Letter|null */
    private $savedLetter;

    /** @var SummaryLetterTrigger */
    private $summaryLetterTrigger;

    public function setUp()
    {
        $this->docUser = new User();
        $this->docUser->use_letters = 1;

        $this->initialData = new SummaryLetterTriggerData();
        $this->initialData->docId = self::DOC_ID;
        $this->initialData->userId = self::USER_ID;
        $this->initialData->letterId = self::LETTER_ID;
        $this->initialData->patientId = self::PATIENT_ID;
        $this->initialData->infoId = self::INFO_ID;
        $this->initialData->mdList = self::MD_LIST;

        $summaryLetterDataUpdater = $this->mockSummaryLetterDataUpdater();
        $userRepository = $this->mockUserRepository();
        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $dbChangeWrapper = $this->mockDbChangeWrapper();
        $this->summaryLetterTrigger = new SummaryLetterTrigger(
            $summaryLetterDataUpdater, $userRepository, $appointmentSummaryRepository, $dbChangeWrapper
        );
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithDocIdAndStepId()
    {
        $this->completedRows = 3;
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::DELAYING_TREATMENT_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNotNull($this->savedLetter);
        $this->assertEquals(self::LETTER_ID, $this->savedLetter->templateid);
        $this->assertEquals(self::PATIENT_ID, $this->savedLetter->patientid);
        $this->assertEquals(self::INFO_ID, $this->savedLetter->info_id);
        $this->assertEquals(0, $this->savedLetter->topatient);
        $this->assertEquals(0, $this->savedLetter->cc_topatient);
        $this->assertEquals('1,2,3', $this->savedLetter->md_list);
        $this->assertEquals('1,2,3', $this->savedLetter->cc_md_list);
        $this->assertEquals('', $this->savedLetter->md_referral_list);
        $this->assertEquals('', $this->savedLetter->cc_md_referral_list);
        $this->assertEquals(0, $this->savedLetter->status);
        $this->assertEquals(0, $this->savedLetter->deleted);
        $this->assertInstanceOf(\DateTime::class, $this->savedLetter->deleted_on);
        $this->assertEquals(self::USER_ID, $this->savedLetter->deleted_by);
        $this->assertInstanceOf(\DateTime::class, $this->savedLetter->generated_date);
        $this->assertEquals(0, $this->savedLetter->delivered);
        $this->assertEquals(self::DOC_ID, $this->savedLetter->docid);
        $this->assertEquals(self::USER_ID, $this->savedLetter->userid);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutDocId()
    {
        $this->completedRows = 3;
        $this->initialData->docId = 0;
        $this->docUser->use_letters = 0;
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::DELAYING_TREATMENT_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNotNull($this->savedLetter);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithDocNotUsingLetters()
    {
        $this->completedRows = 3;
        $this->docUser->use_letters = 0;
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::DELAYING_TREATMENT_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNull($this->savedLetter);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutStepId()
    {
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::IMPRESSION_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNotNull($this->savedLetter);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutCompletedRows()
    {
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::DELAYING_TREATMENT_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNull($this->savedLetter);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutToPatientAndMdLists()
    {
        $this->completedRows = 3;
        $this->initialData->mdList = [];
        $tableElement = SummaryLetterTable::SUMMARY_LETTERS[TrackerSteps::DELAYING_TREATMENT_ID][0];
        $this->summaryLetterTrigger->triggerLetter($this->initialData, $tableElement);
        $this->assertNull($this->savedLetter);
    }

    private function mockSummaryLetterDataUpdater()
    {
        /** @var SummaryLetterDataUpdater|MockInterface $summaryLetterDataUpdater */
        $summaryLetterDataUpdater = \Mockery::mock(SummaryLetterDataUpdater::class);
        $summaryLetterDataUpdater->shouldReceive('completeSummaryLetterData')->andReturnNull();
        return $summaryLetterDataUpdater;
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('findOrNull')->andReturnUsing(function () {
            return $this->docUser;
        });
        return $userRepository;
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('getCompletedByPatient')->andReturnUsing(function () {
            return $this->completedRows;
        });
        return $appointmentSummaryRepository;
    }

    private function mockDbChangeWrapper()
    {
        /** @var DBChangeWrapper|MockInterface $dbChangeWrapper */
        $dbChangeWrapper = \Mockery::mock(DBChangeWrapper::class);
        $dbChangeWrapper->shouldReceive('save')->andReturnUsing(function ($model) {
            $this->savedLetter = $model;
        });
        return $dbChangeWrapper;
    }
}
