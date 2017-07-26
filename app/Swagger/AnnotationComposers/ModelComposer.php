<?php

namespace DentalSleepSolutions\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;

class ModelComposer extends AbstractAnnotationComposer
{
    public function __construct(
        ModelTransformerFactory $modelTransformerFactory,
        DocBlockRetriever $docBlockRetriever
    ) {
        parent::__construct($modelTransformerFactory, $docBlockRetriever);
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
        $annotationData->docBlock = $this->docBlockRetriever->getFromClass($annotationParams->modelClassName);
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
        $lines = explode("\n", $annotationData->docBlock);
        $regexp = '/\*\s@(?P<type>property(?:\-read)?)\s(?P<rule>\S+?)\s\$(?P<field>[a-zA-Z0-9_]+)/';
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
     * @param string[] $matches
     */
    private function addRule(AnnotationData $annotationData, array $matches)
    {
        $rule = new AnnotationRule();
        $rule->rule = $matches['rule'];
        $rule->field = $matches['field'];
        $rule->type = $matches['type'];
        $annotationData->rules[] = $rule;
    }
}
