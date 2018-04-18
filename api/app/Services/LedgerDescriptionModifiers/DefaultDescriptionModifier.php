<?php

namespace DentalSleepSolutions\Services\LedgerDescriptionModifiers;

class DefaultDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return $description;
    }
}
