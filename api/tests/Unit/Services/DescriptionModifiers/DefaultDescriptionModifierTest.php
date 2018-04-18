<?php

namespace Tests\Unit\Services\DescriptionModifiers;

use DentalSleepSolutions\Services\LedgerDescriptionModifiers\DefaultDescriptionModifier;
use Tests\TestCases\UnitTestCase;

class DefaultDescriptionModifierTest extends UnitTestCase
{
    /** @var DefaultDescriptionModifier */
    private $defaultDescriptionModifier;

    public function setUp()
    {
        $this->defaultDescriptionModifier = new DefaultDescriptionModifier();
    }

    public function testModify()
    {
        $description = 'foo';
        $newDescription = $this->defaultDescriptionModifier->modify($description);
        $this->assertEquals('foo', $newDescription);
    }

    public function testModifyWithCheck()
    {
        $description = 'check';
        $newDescription = $this->defaultDescriptionModifier->modify($description);
        $this->assertEquals('Checks', $newDescription);
    }

    public function testModifyWithChecks()
    {
        $description = 'CHECKS';
        $newDescription = $this->defaultDescriptionModifier->modify($description);
        $this->assertEquals('Checks', $newDescription);
    }
}
