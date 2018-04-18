<?php

namespace Tests\Unit\Services\DescriptionModifiers;

use DentalSleepSolutions\Constants\Transactions;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\WriteoffDescriptionModifier;
use Tests\TestCases\UnitTestCase;

class WriteoffDescriptionModifierTest extends UnitTestCase
{
    /** @var WriteoffDescriptionModifier */
    private $writeoffDescriptionModifier;

    public function setUp()
    {
        $this->writeoffDescriptionModifier = new WriteoffDescriptionModifier();
    }

    public function testModify()
    {
        $description = 'foo';
        $newDescription = $this->writeoffDescriptionModifier->modify($description);
        $this->assertEquals(Transactions::TRANSACTION_PAYER_LABELS[Transactions::TRANSACTION_PAYER_WRITEOFF], $newDescription);
    }
}
