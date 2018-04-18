<?php

namespace Tests\Unit\Services\LetterTriggers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Structs\LetterData;
use Mockery\MockInterface;
use Tests\TestCases\LetterTriggerTestCase;

class TreatmentCompleteTriggerTest extends LetterTriggerTestCase
{
    /** @var int */
    private $referredSource;

    /** @var array */
    private $filter = [];

    /** @var TreatmentCompleteTrigger */
    private $treatmentCompleteTrigger;

    public function setUp()
    {
        $letterCreator = $this->mockLetterCreator();
        $letterRepository = $this->mockLetterRepository();
        $patientRepository = $this->mockPatientRepository();
        $this->treatmentCompleteTrigger = new TreatmentCompleteTrigger(
            $letterCreator, $letterRepository, $patientRepository
        );
    }

    public function testWithFoundPatientAndReferredSourceOne()
    {
        $this->referredSource = 1;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 1;
        $expectedLetterData->patientReferralList = '1,2';
        $expectedCreatedLetters = [
            [
                'templateId' => TreatmentCompleteTrigger::TEMPLATE_ID,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
        ];
        $this->assertEquals($expectedCreatedLetters, $this->createdLetters);
        $expectedFilter = [
            'fields' => TreatmentCompleteTrigger::TREATMENT_COMPLETE_FIELDS,
            'where' => ['patientid' => 1],
        ];
        $this->assertEquals($expectedFilter, $this->filter);
    }

    public function testWithFoundPatientAndReferredSourceTwo()
    {
        $this->referredSource = 2;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 1;
        $expectedLetterData->patientReferralList = '3,4';
        $expectedCreatedLetters = [
            [
                'templateId' => TreatmentCompleteTrigger::TEMPLATE_ID,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
        ];
        $this->assertEquals($expectedCreatedLetters, $this->createdLetters);
    }

    public function testWithFoundPatientAndReferredSourceThree()
    {
        $this->referredSource = 3;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutFoundPatient()
    {
        $patientId = 2;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithZeroPatientId()
    {
        $patientId = 0;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithLetters()
    {
        $this->shouldHaveLetters = true;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetters);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getPatientReferralIdsForReferredSourceOfOne')
            ->andReturnUsing([$this, 'getPatientReferralIdsForReferredSourceOfOneCallback']);
        $patientRepository->shouldReceive('getPatientReferralIdsForReferredSourceOfTwo')
            ->andReturnUsing([$this, 'getPatientReferralIdsForReferredSourceOfTwoCallback']);
        $patientRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getPatientWithFilterCallback']);
        return $patientRepository;
    }

    public function getPatientReferralIdsForReferredSourceOfOneCallback($patientId)
    {
        $firstContact = new Contact();
        $firstContact->ids = '1,2';
        $secondContact = new Contact();
        $secondContact->ids = '3,4';
        return [$firstContact, $secondContact];
    }

    public function getPatientReferralIdsForReferredSourceOfTwoCallback($patientId)
    {
        $firstContact = new Contact();
        $firstContact->ids = '1,2';
        $secondContact = new Contact();
        $secondContact->ids = '3,4';
        return [$secondContact, $firstContact];
    }

    public function getPatientWithFilterCallback(array $fields, array $where)
    {
        $this->filter = [
            'fields' => $fields,
            'where' => $where,
        ];
        if (in_array($where['patientid'], [0, 1])) {
            $patient1 = new Patient();
            $patient1->patientid = 1;
            $patient1->referred_source = $this->referredSource;
            $patient2 = new Patient();
            $patient2->patientid = 2;
            return [$patient1, $patient2];
        }
        return [];
    }
}
