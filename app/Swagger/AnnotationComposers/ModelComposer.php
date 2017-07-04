<?php

namespace DentalSleepSolutions\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;

class ModelComposer extends AbstractAnnotationComposer
{
    public function __construct(ModelTransformerFactory $modelTransformerFactory)
    {
        parent::__construct($modelTransformerFactory);
    }

    /**
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    protected function getAnnotationData(AnnotationParams $annotationParams)
    {
        $shortClassName = $this->getShortModelClass($annotationParams->modelClassName);
        $annotationData = new AnnotationData();
        $annotationData->operator = "class $shortClassName";
        $annotationData->params = $annotationParams;
        $annotationData->shortModelClassName = $shortClassName;
        $annotations[] = $annotationData;
        return $annotations;
    }

    /**
     * @param AnnotationData $annotationData
     * @return string
     */
    protected function createAnnotation(AnnotationData $annotationData)
    {
        $annotation = <<<ANNOTATION
@SWG\Definition(
    definition="{$annotationData->shortModelClassName}",
    type="object",

ANNOTATION;
        $required = [];
        foreach ($annotationData->rules as $rule) {
            if ($rule->required) {
                $required[] = $rule->field;
            }
        }
        if (sizeof($required)) {
            $requiredString = '"' . join('", "', $required) . '"';
            $annotation .= <<<ANNOTATION
    required={{$requiredString}},

ANNOTATION;
        }
        $rules = [];
        foreach ($annotationData->rules as $rule) {
            $rules[] = $rule->parsedRule;
        }
        $annotation .= join(",\n", $rules) . "\n";
        $annotation .= <<<ANNOTATION
)
ANNOTATION;
        return $annotation;
    }

    /**
     * @param AnnotationData $annotationData
     */
    protected function setRules(AnnotationData $annotationData)
    {
        $reflection = new \ReflectionClass($annotationData->params->modelClassName);
        $docBlock = $reflection->getDocComment();
        $lines = explode("\n", $docBlock);
        $regexp = '/\*\s@(property(?:\-read)?)\s(\S+?)\s\$([a-zA-Z0-9]+)/';
        $matches = [];
        foreach ($lines as $line) {
            $hasProperty = preg_match($regexp, $line, $matches);
            if ($hasProperty && sizeof($matches) >= 4) {
                $this->addRule($annotationData, $matches);
            }
        }
    }

    /**
     * @param AnnotationData $annotationData
     * @param array $matches
     */
    private function addRule(AnnotationData $annotationData, array $matches)
    {
        $rule = new AnnotationRule();
        $rule->rule = $matches[2];
        $rule->field = $matches[3];
        $rule->type = $matches[1];
        $annotationData->rules[] = $rule;
    }
}
