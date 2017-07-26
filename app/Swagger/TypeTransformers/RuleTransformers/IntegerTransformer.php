<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

class IntegerTransformer extends AbstractRuleTransformer
{
    protected function getType($rule)
    {
        return 'integer';
    }
}
