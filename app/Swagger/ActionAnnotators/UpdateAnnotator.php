<?php

namespace DentalSleepSolutions\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class UpdateAnnotator extends AbstractActionAnnotator
{
    protected function getMethod()
    {
        return 'Put';
    }

    protected function getParameters(AnnotationData $annotationData)
    {
        $idParameter = $this->getIdParameter();
        $formParameters = $this->insertFromRules($annotationData);
        return "$idParameter\n$formParameters";
    }

    protected function getResponses($modelClass)
    {
        $annotation = <<<ANNOTATION
    @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
ANNOTATION;
        $annotation .= $this->get404();
        $annotation .= $this->get422();
        $annotation .= $this->getDefaultError();
        return $annotation;
    }
}
