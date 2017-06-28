<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;

class ModelType extends AbstractAnnotationType
{
    /**
     * @param string $modelClassName
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    protected function getAnnotationData($modelClassName, AnnotationParams $annotationParams)
    {
        $annotationData = new AnnotationData();
        $annotationData->operator = "class $modelClassName";
        $annotationData->className = $modelClassName;
        $annotations[] = $annotationData;
        return $annotations;
    }

    protected function createAnnotation(AnnotationData $annotationData, array $rules)
    {
        return '';
    }

    protected function getRules(AnnotationData $annotationData)
    {
        $reflection = new \ReflectionClass($annotationData->className);
        $docBlock = $reflection->getDocComment();
        $lines = explode("\n", $docBlock);
        $properties = [];
        $regexp = '\*\s@property\s([a-zA-Z\|]+?)\s\$([a-zA-Z0-9]+)';
        $matches = [];
        foreach ($lines as $line) {
            $hasProperty = preg_match($regexp, $line, $matches);
            if ($hasProperty) {
                $properties[$matches[2]] = $matches[1];
            }
        }
        return $properties;
    }
}
