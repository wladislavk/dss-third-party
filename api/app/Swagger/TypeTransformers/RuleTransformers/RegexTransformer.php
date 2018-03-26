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
        $regexp = '/regex\:\/(?P<regex>.+?)(?<!\\\\)\//';
        preg_match($regexp, $annotationRule->rule, $matches);
        if (isset($matches['regex'])) {
            $params[] = "pattern=\"{$matches['regex']}\"";
        }
        return $params;
    }
}
