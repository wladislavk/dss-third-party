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
        $regexp = '/\|max\:(?P<symbols>\d+)/';
        preg_match($regexp, $rule, $matches);
        if (isset($matches['symbols'])) {
            return intval($matches['symbols']);
        }
        return 0;
    }
}
