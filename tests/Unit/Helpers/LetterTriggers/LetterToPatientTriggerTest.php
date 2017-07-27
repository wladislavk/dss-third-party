<?php

namespace Tests\Unit\Helpers\LetterTriggers;

use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\LetterTriggerTestCase;

class LetterToPatientTriggerTest extends LetterTriggerTestCase
{
    /** @var LetterToPatientTrigger */
    private $letterToPatientTrigger;

    public function setUp()
    {
        $letterCreator = $this->mockLetterCreator();
        $letterRepository = $this->mockLetterRepository();
        $this->letterToPatientTrigger = new LetterToPatientTrigger(
            $letterCreator, $letterRepository
        );
    }

    public function testTrigger()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->letterToPatientTrigger->trigger($patientId, $docId, $userId);
        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 1;
        $expectedLetterData->toPatient = true;
        $expectedCreatedLetters = [
            [
                'templateId' => LetterToPatientTrigger::TEMPLATE_ID,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
        ];
        $this->assertEquals($expectedCreatedLetters, $this->createdLetters);
    }
}
