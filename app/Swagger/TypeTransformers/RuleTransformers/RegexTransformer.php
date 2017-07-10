<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

class RegexTransformer extends AbstractRuleTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }

    protected function addParams(AnnotationRule $annotationRule)
    {
        $params = parent::addParams($annotationRule);
        $regexp = '/regex\:\/(.+?)(?<!\\\\)\//';
        preg_match($regexp, $annotationRule->rule, $matches);
        if (isset($matches[1])) {
            $params[] = "pattern=\"{$matches[1]}\"";
        }
        return $params;
    }
}
