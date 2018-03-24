<?php

namespace Tests\Unit\Helpers\DescriptionModifiers;

use DentalSleepSolutions\Helpers\LedgerDescriptionModifiers\PatientDescriptionModifier;
use Tests\TestCases\UnitTestCase;

class PatientDescriptionModifierTest extends UnitTestCase
{
    /** @var PatientDescriptionModifier */
    private $patientDescriptionModifier;

    public function setUp()
    {
        $this->patientDescriptionModifier = new PatientDescriptionModifier();
    }

    public function testModify()
    {
        $description = 'foo';
        $newDescription = $this->patientDescriptionModifier->modify($description);
        $this->assertEquals('Pt. foo', $newDescription);
    }
}
