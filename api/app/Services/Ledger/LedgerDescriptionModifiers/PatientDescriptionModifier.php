<?php

namespace DentalSleepSolutions\Services\Ledger\LedgerDescriptionModifiers;

class PatientDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Pt. ' . $description;
    }
}
