<?php

namespace DentalSleepSolutions\Helpers\LedgerDescriptionModifiers;

class DefaultDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return $description;
    }
}
