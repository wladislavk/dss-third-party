<?php

namespace DentalSleepSolutions\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\AbstractTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;

abstract class AbstractAnnotationComposer
{
    /** @var AbstractTransformerFactory */
    private $transformerFactory;

    public function __construct(AbstractTransformerFactory $transformerFactory)
    {
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @param AnnotationParams|null $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    public function composeAnnotation(AnnotationParams $annotationParams)
    {
        $annotations = $this->getAnnotationData($annotationParams);
        foreach ($annotations as $annotation) {
            $this->parseRules($annotation);
            $annotation->text = $this->createAnnotation($annotation);
        }
        return $annotations;
    }

    /**
     * @param AnnotationData $annotationData
     * @return string
     */
    abstract protected function createAnnotation(AnnotationData $annotationData);

    /**
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    abstract protected function getAnnotationData(AnnotationParams $annotationParams);

    /**
     * @param AnnotationData $annotationData
     */
    protected function parseRules(AnnotationData $annotationData)
    {
        $this->setRules($annotationData);
        foreach ($annotationData->rules as $rule) {
            $transformer = $this->transformerFactory->getTransformer($rule);
            $transformer->transform($rule);
        }
    }

    /**
     * @param string $modelClassName
     * @return string
     */
    protected function getShortModelClass($modelClassName)
    {
        $explodedClassName = explode('\\', $modelClassName);
        $shortClassName = $explodedClassName[count($explodedClassName) - 1];
        return $shortClassName;
    }

    /**
     * @param AnnotationData $annotationData
     */
    abstract protected function setRules(AnnotationData $annotationData);
}
