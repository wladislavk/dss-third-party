<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\SwaggerActionAnnotatorFactory;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;

class ControllerType extends AbstractAnnotationType
{
    const REST_ACTIONS = [
        'index',
        'show',
        'store',
        'update',
        'delete',
    ];

    /** @var Route[]|RouteCollection */
    private $routes;

    /** @var SwaggerActionAnnotatorFactory */
    private $annotatorFactory;

    public function __construct(Router $router, SwaggerActionAnnotatorFactory $annotatorFactory)
    {
        $this->routes = $router->getRoutes();
        $this->annotatorFactory = $annotatorFactory;
    }

    /**
     * @param string $controllerClassName
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    protected function getAnnotationData($controllerClassName, AnnotationParams $annotationParams)
    {
        $requestClassName = $annotationParams->requestClassName;
        $annotations = [];
        foreach (self::REST_ACTIONS as $action) {
            $qualifiedAction = "$controllerClassName@$action";
            $route = $this->routes->getByAction($qualifiedAction);
            if (!$route) {
                throw new SwaggerGeneratorException("Route not found for action $qualifiedAction");
            }
            $annotationData = new AnnotationData();
            $annotationData->action = $action;
            $annotationData->route = $route;
            $annotationData->requestClassName = $requestClassName;
            $annotationData->operator = "public function $action";
            $annotations[] = $annotationData;
        }
        return $annotations;
    }

    protected function createAnnotation(AnnotationData $annotationData)
    {
        $annotator = $this->annotatorFactory->findAnnotator($annotationData->action);
        $annotation = $annotator->createAnnotation($annotationData);
        return $annotation;
    }

    /**
     * @param AnnotationData $annotationData
     */
    protected function setRules(AnnotationData $annotationData)
    {
        /** @var Request $request */
        $request = new $annotationData->requestClassName();
        $rules = $this->getRequestRules($request, $annotationData->action);
        foreach ($rules as $field => $rule) {
            $annotationRule = new AnnotationRule();
            $annotationRule->rule = $rule;
            $annotationRule->field = $field;
            $annotationData->addRule($annotationRule);
        }
    }

    private function getRequestRules(Request $request, $action)
    {
        if ($action == 'store') {
            return $request->storeRules();
        }
        if ($action == 'update') {
            return $request->updateRules();
        }
        return [];
    }
}
