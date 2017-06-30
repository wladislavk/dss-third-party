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
    public $modelClassName = '';

    /** @var string */
    public $requestClassName = '';

    /** @var string */
    public $route = '';

    /** @var AnnotationRule[] */
    public $rules = [];

    public function addRule(AnnotationRule $annotationRule)
    {
        $annotationRule->action = $this->action;
        $this->rules[] = $annotationRule;
    }
}
