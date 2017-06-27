<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\RuleTransformers\AbstractRuleTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\DateTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\EmailTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\RegexTransformer;
use DentalSleepSolutions\Swagger\RuleTransformers\StringTransformer;
use Illuminate\Support\Facades\App;

class SwaggerRuleTransformerFactory
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
     * @return AbstractRuleTransformer
     * @throws GeneralException
     */
    public function getTransformer($rule)
    {
        $className = $this->findRuleClass($rule);
        $transformer = App::make($className);
        if (!$transformer instanceof AbstractRuleTransformer) {
            throw new GeneralException("Class $className must implement " . AbstractRuleTransformer::class);
        }
        return $transformer;
    }

    /**
     * @param string $rule
     * @return string
     */
    private function findRuleClass($rule)
    {
        foreach (self::RULE_CLASSES as $name => $className) {
            if (strstr($rule, $name)) {
                return $className;
            }
        }
        return self::DEFAULT_RULE_CLASS;
    }
}
