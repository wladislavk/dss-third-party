<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
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
        'destroy',
    ];

    /** @var Route[]|RouteCollection */
    private $routes;

    /** @var ActionAnnotatorFactory */
    private $annotatorFactory;

    public function __construct(
        ActionAnnotatorFactory $annotatorFactory,
        Router $router
    ) {
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
            $annotationData->route = $this->replaceWildcard($route->getPath());
            $annotationData->requestClassName = $requestClassName;
            $annotationData->modelClassName = $annotationParams->modelClassName;
            $annotationData->shortModelClassName = $this->getShortModelClass($annotationParams->modelClassName);
            $annotationData->operator = "public function $action";
            $annotations[] = $annotationData;
        }
        return $annotations;
    }

    /**
     * @param string $path
     * @return string
     */
    private function replaceWildcard($path)
    {
        $regexp = '/(?<=\/)\:([a-z]+?)(?=\/|$)/';
        $replaced = preg_replace($regexp, '{$1}', $path);
        return $replaced;
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
            $stringRule = $this->getStringRule($rule);
            $annotationRule->rule = $stringRule;
            $annotationRule->field = $field;
            $annotationData->addRule($annotationRule);
        }
    }

    /**
     * @param string|array $rule
     * @return string
     */
    private function getStringRule($rule)
    {
        if (is_array($rule)) {
            return join('|', $rule);
        }
        return $rule;
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
