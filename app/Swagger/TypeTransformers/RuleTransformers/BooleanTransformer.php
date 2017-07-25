<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

class BooleanTransformer extends AbstractRuleTransformer
{
    protected function getType($rule)
    {
        return 'boolean';
    }
}
