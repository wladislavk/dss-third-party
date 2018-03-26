<?php

namespace DentalSleepSolutions\Helpers\LedgerDescriptionModifiers;

class InsuranceDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Ins. ' . $description;
    }
}
