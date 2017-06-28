<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Factories\AbstractSwaggerTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;

abstract class AbstractAnnotationType
{
    /** @var AbstractSwaggerTransformerFactory */
    private $transformerFactory;

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
            $rules = $this->parseRules($annotation);
            $annotation->text = $this->createAnnotation($annotation, $rules);
        }
        return $annotations;
    }

    /**
     * @param AnnotationData $annotationData
     * @param string[] $rules
     * @return string
     */
    abstract protected function createAnnotation(AnnotationData $annotationData, array $rules);

    /**
     * @param string $className
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    abstract protected function getAnnotationData($className, AnnotationParams $annotationParams);

    /**
     * @param AnnotationData $annotationData
     * @return string[]
     */
    protected function parseRules(AnnotationData $annotationData)
    {
        $rules = $this->getRules($annotationData);
        $parsedRules = [];
        foreach ($rules as $field => $rule) {
            $transformer = $this->transformerFactory->getTransformer($rule);
            $parsedRules[$field] = $transformer->transform($field, $rule);
        }
        return $parsedRules;
    }

    /**
     * @param AnnotationData $annotationData
     * @return array
     */
    abstract protected function getRules(AnnotationData $annotationData);
}
