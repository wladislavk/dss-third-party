<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\RuleTransformers\DateTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\EmailTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\RegexTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\StringTransformer;

class SwaggerRuleTransformerFactory extends AbstractSwaggerTransformerFactory
{
    const DEFAULT_RULE_CLASS = StringTransformer::class;

    const RULE_CLASSES = [
        'string' => StringTransformer::class,
        'email' => EmailTransformer::class,
        'integer' => IntegerTransformer::class,
        'regex' => RegexTransformer::class,
        'date' => DateTransformer::class,
    ];

    /**
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
        return self::DEFAULT_RULE_CLASS;
    }
}
