<?php

namespace DentalSleepSolutions\Swagger\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\BooleanTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\DateTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\EmailTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\RegexTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\StringTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\UrlTransformer;

class RuleTransformerFactory extends AbstractTransformerFactory
{
    const DEFAULT_RULE_CLASS = StringTransformer::class;

    const RULE_CLASSES = [
        'string' => StringTransformer::class,
        'email' => EmailTransformer::class,
        'integer' => IntegerTransformer::class,
        'regex' => RegexTransformer::class,
        'date' => DateTransformer::class,
        'boolean' => BooleanTransformer::class,
        'url' => UrlTransformer::class,
    ];

    /**
     * @param AnnotationRule $annotationRule
     * @return string
     * @throws GeneralException
     */
    protected function findRuleClass(AnnotationRule $annotationRule)
    {
        foreach (self::RULE_CLASSES as $name => $className) {
            $regexp = "/(^|\|){$name}($|\||\:)/";
            if (preg_match($regexp, $annotationRule->rule)) {
                return $className;
            }
        }
        return self::DEFAULT_RULE_CLASS;
    }
}
