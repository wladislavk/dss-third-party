<?php

namespace DentalSleepSolutions\Swagger\RuleTransformers;

abstract class AbstractRuleTransformer
{
    public function transform($rule)
    {
        $transformed = [];
        return $transformed;
    }

    private function handleRequired($rule)
    {

    }

    abstract protected function handleRule($modifiedRule);
}
