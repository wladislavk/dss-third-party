<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\AbstractTypeTransformer;

abstract class AbstractRuleTransformer extends AbstractTypeTransformer
{
    protected function getInitialData($field)
    {
        return "@SWG\Parameter(name=\"$field\", in=\"formData\", ";
    }

    protected function checkIfRequired(AnnotationRule $annotationRule)
    {
        if ($annotationRule->action != 'store') {
            return false;
        }
        if (!strstr($annotationRule->rule, 'required|')) {
            return false;
        }
        return true;
    }

    protected function addParams(AnnotationRule $annotationRule)
    {
        $params = [];
        if ($annotationRule->required) {
            $params[] = "required=true";
        }
        return $params;
    }
}
