<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class ShowAnnotator extends AbstractActionAnnotator
{
    protected function getMethod()
    {
        return 'Get';
    }

    protected function getParameters(AnnotationData $annotationData)
    {
        return $this->getIdParameter();
    }

    protected function getResponses($modelClass)
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(
        response="200",
        description="Resource retrieved",
        @SWG\Schema(
            allOf={
                ref="#/definitions/common_response_fields",
                @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/$modelClass"))
            }
        )
    ),

ANNOTATION;
        $annotation .= $this->get404();
        $annotation .= $this->getDefaultError();
        return $annotation;
    }
}
