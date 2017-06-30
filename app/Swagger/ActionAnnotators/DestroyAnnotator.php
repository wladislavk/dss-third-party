<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class DestroyAnnotator extends AbstractActionAnnotator
{
    protected function getMethod()
    {
        return 'Delete';
    }

    protected function getParameters(AnnotationData $annotationData)
    {
        return $this->getIdParameter();
    }

    protected function getResponses($modelClass)
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
ANNOTATION;
        $annotation .= $this->get404();
        $annotation .= $this->getDefaultError();
        return $annotation;
    }
}
