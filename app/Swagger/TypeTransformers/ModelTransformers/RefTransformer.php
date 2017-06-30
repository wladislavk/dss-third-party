<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

class RefTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        $shortType = $this->getShortType($rule);
        if ($this->isCollection($shortType)) {
            return 'array';
        }
        return '';
    }

    protected function checkIfRequired($rule)
    {
        return false;
    }

    protected function addParams(AnnotationRule $annotationRule)
    {
        $shortType = $this->getShortType($annotationRule->rule);
        if ($this->isCollection($shortType)) {
            $strippedType = str_replace('[]', '', $shortType);
            return ["@SWG\Items(ref=\"#/definitions/$strippedType\")"];
        }
        return ["ref=\"#/definitions/$shortType\""];
    }

    private function getShortType($rule)
    {
        $explodedType = explode('\\', $rule);
        $shortType = $explodedType[count($explodedType) - 1];
        return $shortType;
    }

    private function isCollection($shortType)
    {
        if (substr($shortType, -2) == '[]') {
            return true;
        }
        return false;
    }
}
