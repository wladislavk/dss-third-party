<?php

namespace DentalSleepSolutions\Swagger\RuleTransformers;

use DentalSleepSolutions\Swagger\TransformerInterface;

abstract class AbstractRuleTransformer implements TransformerInterface
{
    public function transform($name, $type)
    {
        $transformed = [];
        return $transformed;
    }

    private function handleRequired($rule)
    {

    }

    abstract protected function handleRule($modifiedRule);
}
