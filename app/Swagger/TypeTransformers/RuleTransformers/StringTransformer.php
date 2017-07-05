<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

class StringTransformer extends AbstractRuleTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }

    protected function addParams(AnnotationRule $annotationRule)
    {
        $params = parent::addParams($annotationRule);
        $maxLength = $this->getMaxLength($annotationRule->rule);
        if ($maxLength) {
            $params[] = "maxLength=$maxLength";
        }
        return $params;
    }

    /**
     * @param $rule
     * @return int
     */
    private function getMaxLength($rule)
    {
        $regexp = '/\|max\:(\d+)/';
        preg_match($regexp, $rule, $matches);
        if (isset($matches[1])) {
            return intval($matches[1]);
        }
        return 0;
    }
}
