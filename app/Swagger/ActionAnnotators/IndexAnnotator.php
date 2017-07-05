<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class IndexAnnotator extends AbstractActionAnnotator
{
    protected function getMethod()
    {
        return 'Get';
    }

    protected function getParameters(AnnotationData $annotationData)
    {
        return '';
    }

    protected function getResponses($modelClass)
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(
        response="200",
        description="Resources retrieved",
        @SWG\Schema
            allOf={
                ref="#/definitions/common_response_fields",
                @SWG\Property(
                    property="data",
                    type="array",
                    @SWG\Items(@SWG\Schema(ref="#/definitions/$modelClass"))
                )
            }
        )
    ),

ANNOTATION;
        $annotation .= $this->getDefaultError();
        return $annotation;
    }
}
