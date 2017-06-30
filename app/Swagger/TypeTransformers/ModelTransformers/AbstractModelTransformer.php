<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\AbstractTypeTransformer;

abstract class AbstractModelTransformer extends AbstractTypeTransformer
{
    protected function getInitialData($field)
    {
        return "@SWG\Property(property=\"$field\", ";
    }

    protected function checkIfRequired(AnnotationRule $annotationRule)
    {
        if (!strstr($annotationRule->rule, '|null')) {
            return true;
        }
        return false;
    }

    protected function addParams(AnnotationRule $annotationRule)
    {
        return [];
    }
}
