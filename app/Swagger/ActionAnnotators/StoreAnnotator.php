<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class StoreAnnotator extends AbstractActionAnnotator
{
    protected function getMethod()
    {
        return 'Post';
    }

    protected function getParameters(AnnotationData $annotationData)
    {
        return $this->insertFromRules($annotationData);
    }

    protected function getResponses($modelClass)
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(
        response="200",
        description="Resource created",
        allOf={
            @SWG\Schema(ref="#/definitions/common_response_fields"),
            @SWG\Schema(
                @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/$modelClass"))
            )
        }
    ),
ANNOTATION;
        $annotation .= $this->get422();
        $annotation .= $this->getDefaultError();
        return $annotation;
    }
}
