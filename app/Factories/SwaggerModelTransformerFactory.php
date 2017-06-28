<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\ModelTransformers\DateTransformer;
use DentalSleepSolutions\Swagger\ModelTransformers\FloatTransformer;
use DentalSleepSolutions\Swagger\ModelTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\ModelTransformers\StringTransformer;

class SwaggerModelTransformerFactory extends AbstractSwaggerTransformerFactory
{
    const RULE_CLASSES = [
        'string' => StringTransformer::class,
        'integer' => IntegerTransformer::class,
        'float' => FloatTransformer::class,
        'date' => DateTransformer::class,
    ];

    /**
     * @todo: strstr() should be replaced
     *
     * @param string $rule
     * @return string
     * @throws GeneralException
     */
    protected function findRuleClass($rule)
    {
        foreach (self::RULE_CLASSES as $name => $className) {
            if (strstr($rule, $name)) {
                return $className;
            }
        }
        throw new GeneralException("Rule $rule not found");
    }
}
