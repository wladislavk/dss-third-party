<?php

namespace Tests\Unit\Services\DescriptionModifiers;

use DentalSleepSolutions\Services\LedgerDescriptionModifiers\InsuranceDescriptionModifier;
use Tests\TestCases\UnitTestCase;

class InsuranceDescriptionModifierTest extends UnitTestCase
{
    /** @var InsuranceDescriptionModifier */
    private $insuranceDescriptionModifier;

    public function setUp()
    {
        $this->insuranceDescriptionModifier = new InsuranceDescriptionModifier();
    }

    public function testModify()
    {
        $description = 'foo';
        $newDescription = $this->insuranceDescriptionModifier->modify($description);
        $this->assertEquals('Ins. foo', $newDescription);
    }
}
