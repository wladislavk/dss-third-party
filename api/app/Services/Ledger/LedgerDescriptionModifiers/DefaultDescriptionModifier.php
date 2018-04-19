<?php

namespace DentalSleepSolutions\Services\Ledger\LedgerDescriptionModifiers;

class DefaultDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return $description;
    }
}
