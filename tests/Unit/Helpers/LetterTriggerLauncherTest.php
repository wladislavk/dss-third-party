<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\LetterTriggerLauncher;
use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\MDContacts;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LetterTriggerLauncherTest extends UnitTestCase
{
    /** @var array */
    private $treatmentCompleteTriggerParams = [];

    /** @var array */
    private $lettersToMDTriggerParams = [];

    /** @var array */
    private $letterToPatientTriggerParams = [];

    /** @var LetterTriggerLauncher */
    private $letterTriggerLauncher;

    public function setUp()
    {
        $treatmentCompleteTrigger = $this->mockTreatmentCompleteTrigger();
        $lettersToMDTrigger = $this->mockLettersToMDTrigger();
        $letterToPatientTrigger = $this->mockLetterToPatientTrigger();
        $this->letterTriggerLauncher = new LetterTriggerLauncher(
            $treatmentCompleteTrigger, $lettersToMDTrigger, $letterToPatientTrigger
        );
    }

    public function testWithIntroLetter()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $requestData = new EditPatientRequestData();
        $mdContacts = new MDContacts();
        $mdContacts->docent = 5;
        $requestData->mdContacts = $mdContacts;
        $requestData->shouldSendIntroLetter = true;
        $this->letterTriggerLauncher->triggerLetters(
            $patientId, $docId, $userId, $userType, $requestData
        );
        $expectedTreatmentComplete = [
            'patientId' => 1,
            'docId' => 2,
            'userId' => 3,
        ];
        $expectedLettersToMD = [
            'patientId' => 1,
            'docId' => 2,
            'userId' => 3,
            'userType' => 4,
            'params' => [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts],
        ];
        $this->assertEquals($expectedTreatmentComplete, $this->treatmentCompleteTriggerParams);
        $this->assertEquals($expectedLettersToMD, $this->lettersToMDTriggerParams);
        $this->assertEquals($expectedTreatmentComplete, $this->letterToPatientTriggerParams);
    }

    public function testWithoutIntroLetter()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $requestData = new EditPatientRequestData();
        $mdContacts = new MDContacts();
        $mdContacts->docent = 5;
        $requestData->mdContacts = $mdContacts;
        $requestData->shouldSendIntroLetter = false;
        $this->letterTriggerLauncher->triggerLetters(
            $patientId, $docId, $userId, $userType, $requestData
        );
        $expectedTreatmentComplete = [
            'patientId' => 1,
            'docId' => 2,
            'userId' => 3,
        ];
        $expectedLettersToMD = [
            'patientId' => 1,
            'docId' => 2,
            'userId' => 3,
            'userType' => 4,
            'params' => [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts],
        ];
        $this->assertEquals($expectedTreatmentComplete, $this->treatmentCompleteTriggerParams);
        $this->assertEquals($expectedLettersToMD, $this->lettersToMDTriggerParams);
        $this->assertEquals([], $this->letterToPatientTriggerParams);
    }

    private function mockTreatmentCompleteTrigger()
    {
        /** @var TreatmentCompleteTrigger|MockInterface $trigger */
        $trigger = \Mockery::mock(TreatmentCompleteTrigger::class);
        $trigger->shouldReceive('trigger')
            ->andReturnUsing([$this, 'triggerTreatmentCompleteCallback']);
        return $trigger;
    }

    private function mockLettersToMDTrigger()
    {
        /** @var LettersToMDTrigger|MockInterface $trigger */
        $trigger = \Mockery::mock(LettersToMDTrigger::class);
        $trigger->shouldReceive('trigger')
            ->andReturnUsing([$this, 'triggerLettersToMDCallback']);
        return $trigger;
    }

    private function mockLetterToPatientTrigger()
    {
        /** @var LetterToPatientTrigger|MockInterface $trigger */
        $trigger = \Mockery::mock(LetterToPatientTrigger::class);
        $trigger->shouldReceive('trigger')
            ->andReturnUsing([$this, 'triggerLetterToPatientCallback']);
        return $trigger;
    }

    public function triggerTreatmentCompleteCallback($patientId, $docId, $userId)
    {
        $this->treatmentCompleteTriggerParams = [
            'patientId' => $patientId,
            'docId' => $docId,
            'userId' => $userId,
        ];
    }

    public function triggerLettersToMDCallback($patientId, $docId, $userId, $userType, array $params)
    {
        $this->lettersToMDTriggerParams = [
            'patientId' => $patientId,
            'docId' => $docId,
            'userId' => $userId,
            'userType' => $userType,
            'params' => $params,
        ];
    }

    public function triggerLetterToPatientCallback($patientId, $docId, $userId)
    {
        $this->letterToPatientTriggerParams = [
            'patientId' => $patientId,
            'docId' => $docId,
            'userId' => $userId,
        ];
    }
}
