<?php

namespace DentalSleepSolutions\Helpers\LedgerDescriptionModifiers;

class PatientDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return 'Pt. ' . $description;
    }
}
