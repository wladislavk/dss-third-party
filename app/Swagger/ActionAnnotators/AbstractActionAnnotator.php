<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

abstract class AbstractActionAnnotator
{
    /**
     * @param AnnotationData $annotationData
     * @return string
     */
    public function createAnnotation(AnnotationData $annotationData)
    {
        $annotation = <<<ANNOTATION
@SWG\\{$this->getMethod()}(
    path="{$annotationData->route}",

ANNOTATION;
        $parameters = $this->getParameters($annotationData);
        if ($parameters) {
            $annotation .= $parameters . "\n";
        }
        $annotation .= $this->getResponses($annotationData->shortModelClassName);
        $annotation .= <<<ANNOTATION
)
ANNOTATION;
        return $annotation;
    }

    /**
     * @return string
     */
    abstract protected function getMethod();

    /**
     * @param AnnotationData $annotationData
     * @return string
     */
    abstract protected function getParameters(AnnotationData $annotationData);

    /**
     * @param string $modelClass
     * @return string
     */
    abstract protected function getResponses($modelClass);

    /**
     * @return string
     */
    protected function getIdParameter()
    {
        $annotation = <<<ANNOTATION
    @SWG\Parameter(ref="#/parameters/id_in_path"),
ANNOTATION;
        return $annotation;
    }

    /**
     * @return string
     */
    protected function get404()
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(response="404", ref="#/responses/404_response"),

ANNOTATION;
        return $annotation;
    }

    /**
     * @return string
     */
    protected function get422()
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(response="422", ref="#/responses/422_response"),

ANNOTATION;
        return $annotation;
    }

    /**
     * @return string
     */
    protected function getDefaultError()
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(response="default", ref="#/responses/error_response")

ANNOTATION;
        return $annotation;
    }

    /**
     * @param AnnotationData $annotationData
     * @return string
     */
    protected function insertFromRules(AnnotationData $annotationData)
    {
        $rules = [];
        foreach ($annotationData->rules as $annotationRule) {
            $rules[] = $annotationRule->parsedRule . ',';
        }
        return join("\n", $rules);
    }
}
