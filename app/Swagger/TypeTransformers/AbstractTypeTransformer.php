<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

abstract class AbstractTypeTransformer
{
    const INDENTATION = '    ';

    /**
     * @param AnnotationRule $annotationRule
     */
    public function transform(AnnotationRule $annotationRule)
    {
        $transformed = self::INDENTATION;
        $transformed .= $this->getInitialData($annotationRule->field);
        if ($this->checkIfRequired($annotationRule)) {
            $annotationRule->required = true;
        }
        $properties = [];
        $newRule = $this->getType($annotationRule->rule);
        if ($newRule) {
            $properties[] = "type=\"$newRule\"";
        }
        $format = $this->addFormat();
        if ($format) {
            $properties[] = "format=\"$format\"";
        }
        $params = $this->addParams($annotationRule);
        foreach ($params as $param) {
            $properties[] = $param;
        }
        if (sizeof($properties)) {
            $transformed .= ', ';
        }
        $transformed .= join(', ', $properties);
        $transformed .= $this->getFinalData();
        $annotationRule->parsedRule = $transformed;
    }

    /**
     * @return string
     */
    private function getFinalData()
    {
        return ')';
    }

    /**
     * @param string $field
     * @return string
     */
    abstract protected function getInitialData($field);

    /**
     * @param string $rule
     * @return string
     */
    abstract protected function getType($rule);

    /**
     * @param AnnotationRule $annotationRule
     * @return bool
     */
    abstract protected function checkIfRequired(AnnotationRule $annotationRule);

    /**
     * @return string
     */
    protected function addFormat()
    {
        return '';
    }

    /**
     * @param AnnotationRule $annotationRule
     * @return array
     */
    abstract protected function addParams(AnnotationRule $annotationRule);
}
