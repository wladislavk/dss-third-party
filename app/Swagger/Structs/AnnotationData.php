<?php

namespace DentalSleepSolutions\Swagger\Structs;

class AnnotationData
{
    /** @var string */
    public $text = '';

    /** @var string */
    public $operator = '';

    /** @var string */
    public $action = '';

    /** @var string */
    public $shortModelClassName = '';

    /** @var string */
    public $route = '';

    /** @var AnnotationRule[] */
    public $rules = [];

    /** @var AnnotationParams */
    public $params;

    public function addRule(AnnotationRule $annotationRule)
    {
        $annotationRule->action = $this->action;
        $this->rules[] = $annotationRule;
    }
}
