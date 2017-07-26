<?php

namespace DentalSleepSolutions\Swagger\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\TypeTransformers\AbstractTypeTransformer;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

abstract class AbstractTransformerFactory
{
    /** @var Application */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param AnnotationRule $rule
     * @return AbstractTypeTransformer
     * @throws GeneralException
     */
    public function getTransformer(AnnotationRule $rule)
    {
        $className = $this->findRuleClass($rule);
        $transformer = $this->application->make($className);
        if (!$transformer instanceof AbstractTypeTransformer) {
            throw new GeneralException("Class $className must extend " . AbstractTypeTransformer::class);
        }
        return $transformer;
    }

    /**
     * @param AnnotationRule $rule
     * @return string
     * @throws GeneralException
     */
    abstract protected function findRuleClass(AnnotationRule $rule);
}
