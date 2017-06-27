<?php

namespace DentalSleepSolutions\Swagger;

class ControllerAnnotationWriter
{
    const REST_METHODS = [
        'index',
        'show',
        'store',
        'update',
        'delete',
    ];

    /** @var RuleParser */
    private $ruleParser;

    /** @var RouteRetriever */
    private $routeRetriever;

    public function __construct(RuleParser $ruleParser, RouteRetriever $routeRetriever)
    {
        $this->ruleParser = $ruleParser;
        $this->routeRetriever = $routeRetriever;
    }

    public function writeAnnotations($controllerFile, $requestClass)
    {
        $rules = $this->ruleParser->parseRulesToSwagger($requestClass);
        $fh = fopen($controllerFile, 'r+');
        try {
            //fwrite($fh, $rules);
        } catch (\Exception $e) {

        } finally {
            fclose($fh);
        }
    }

    private function composeAnnotation(array $rules, $route)
    {

    }
}
