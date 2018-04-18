<?php

namespace DentalSleepSolutions\Services\LedgerDescriptionModifiers;

class PatientDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Pt. ' . $description;
    }
}
