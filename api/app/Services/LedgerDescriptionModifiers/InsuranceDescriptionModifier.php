<?php

namespace DentalSleepSolutions\Services\LedgerDescriptionModifiers;

class InsuranceDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Ins. ' . $description;
    }
}
