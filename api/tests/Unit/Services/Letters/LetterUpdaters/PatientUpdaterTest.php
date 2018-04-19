<?php

namespace Tests\Unit\Services\Letters\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\PatientUpdater;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class PatientUpdaterTest extends UnitTestCase
{
    /** @var PatientUpdater */
    private $patientUpdater;

    public function setUp()
    {
        $this->patientUpdater = new PatientUpdater();
    }

    public function testGetUpdatedFields()
    {
        $updatedFields = $this->patientUpdater->getUpdatedFields();
        $this->assertEquals(['topatient', 'cc_topatient'], $updatedFields);
    }

    public function testUpdateDataBeforeDeleting()
    {
        $letter = new Letter();
        $recipientId = 2;
        $newLetterData = new LetterData();
        $dataForUpdate = new LetterData();
        $this->patientUpdater->updateDataBeforeDeleting(
            $letter, $recipientId, $newLetterData, $dataForUpdate
        );
        $this->assertTrue($newLetterData->toPatient);
        $this->assertFalse($dataForUpdate->toPatient);
        $this->assertFalse($dataForUpdate->ccToPatient);
    }
}
