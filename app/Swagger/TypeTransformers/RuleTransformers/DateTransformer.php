<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

class DateTransformer extends AbstractRuleTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }

    protected function addFormat()
    {
        return 'dateTime';
    }
}
