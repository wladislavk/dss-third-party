<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Factories\SwaggerRuleTransformerFactory;
use DentalSleepSolutions\Http\Requests\Request;

class RuleParser
{
    /** @var SwaggerRuleTransformerFactory */
    private $transformerFactory;

    public function __construct(SwaggerRuleTransformerFactory $transformerFactory)
    {
        $this->transformerFactory = $transformerFactory;
    }

    public function parseRulesToSwagger($requestClass)
    {
        /** @var Request $request */
        $request = new $requestClass();
        $rules = $request->getRawRules();
        $parsedRules = [];
        foreach ($rules as $field => $rule) {
            $transformer = $this->transformerFactory->getTransformer($rule);
            $parsedRules[$field] = $transformer->transform($rule);
        }
        return $parsedRules;
    }
}
