<?php

namespace DentalSleepSolutions\Swagger\AnnotationTypes;

use DentalSleepSolutions\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Swagger\RequestRuleParser;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
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

    public function __construct(Router $router)
    {
        $this->routes = $router->getRoutes();
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

    protected function createAnnotation(AnnotationData $annotationData, array $rules)
    {
        return '';
    }

    protected function getRules(AnnotationData $annotationData)
    {
        /** @var Request $request */
        $request = new $annotationData->requestClassName();
        if ($annotationData->action == 'store') {
            return $request->storeRules();
        }
        if ($annotationData->action == 'update') {
            return $request->updateRules();
        }
        return [];
    }
}
