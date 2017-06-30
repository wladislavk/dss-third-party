<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\AbstractSwaggerTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;

abstract class AbstractAnnotationType
{
    /** @var AbstractSwaggerTransformerFactory */
    private $transformerFactory;

    /**
     * @param AbstractSwaggerTransformerFactory $transformerFactory
     */
    public function setTransformerFactory(AbstractSwaggerTransformerFactory $transformerFactory)
    {
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @param string $className
     * @param AnnotationParams|null $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    public function composeAnnotation($className, AnnotationParams $annotationParams = null)
    {
        if (!$this->transformerFactory) {
            throw new SwaggerGeneratorException('setTransformerFactory() must be called before composeAnnotation()');
        }
        if (!$annotationParams) {
            $annotationParams = new AnnotationParams();
        }
        $annotations = $this->getAnnotationData($className, $annotationParams);
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
     * @param string $className
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    abstract protected function getAnnotationData($className, AnnotationParams $annotationParams);

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
     * @param AnnotationData $annotationData
     */
    abstract protected function setRules(AnnotationData $annotationData);
}
