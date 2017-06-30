<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

abstract class AbstractTypeTransformer
{
    const FIVE_WHITESPACES = '     ';

    /**
     * @param AnnotationRule $annotationRule
     */
    public function transform(AnnotationRule $annotationRule)
    {
        $transformed = ' *' . self::FIVE_WHITESPACES;
        $transformed .= $this->getInitialData($annotationRule->field);
        if ($this->checkIfRequired($annotationRule)) {
            $annotationRule->required = true;
        }
        $newRule = $this->getType($annotationRule->rule);
        if ($newRule) {
            $transformed .= "type=\"$newRule\"";
        }
        $format = $this->addFormat();
        if ($format) {
            $transformed .= ", format=\"$format\"";
        }
        $params = $this->addParams($annotationRule);
        foreach ($params as $param) {
            $transformed .= ", $param";
        }
        $transformed .= ')';
        $annotationRule->parsedRule = $transformed;
    }

    /**
     * @param string $field
     * @return string
     */
    abstract protected function getInitialData($field);

    /**
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
