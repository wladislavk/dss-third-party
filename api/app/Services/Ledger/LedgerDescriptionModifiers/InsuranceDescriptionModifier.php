<?php

namespace DentalSleepSolutions\Services\Ledger\LedgerDescriptionModifiers;

class InsuranceDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Ins. ' . $description;
    }
}
