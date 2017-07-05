<?php

namespace DentalSleepSolutions\Swagger\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\ArrayTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\DateTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\FloatTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\StringTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\RefTransformer;

class ModelTransformerFactory extends AbstractTransformerFactory
{
    const RULE_CLASSES = [
        'string' => StringTransformer::class,
        'int' => IntegerTransformer::class,
        'float' => FloatTransformer::class,
        '\Carbon\Carbon' => DateTransformer::class,
        'array' => ArrayTransformer::class,
    ];

    /**
     * @param string AnnotationRule $rule
     * @return string
     * @throws GeneralException
     */
    protected function findRuleClass(AnnotationRule $rule)
    {
        if ($rule->type == 'property-read') {
            return RefTransformer::class;
        }
        $splitRule = explode('|', $rule->rule);
        foreach (self::RULE_CLASSES as $name => $className) {
            $className = $this->checkRuleParts($splitRule, $name, $className);
            if ($className !== false) {
                return $className;
            }
        }
        throw new GeneralException("Rule $rule->rule not found");
    }

    private function checkRuleParts(array $splitRule, $name, $className)
    {
        foreach ($splitRule as $rulePart) {
            if ($rulePart == $name) {
                return $className;
            }
        }
        return false;
    }
}
