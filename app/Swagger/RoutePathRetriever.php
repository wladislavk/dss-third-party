<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;

class RoutePathRetriever
{
    /** @var Route[]|RouteCollection */
    private $routes;

    public function __construct(Router $router)
    {
        $this->routes = $router->getRoutes();
    }

    /**
     * @param string $controllerClassName
     * @param string $action
     * @return string
     * @throws SwaggerGeneratorException
     */
    public function getRoutePath($controllerClassName, $action)
    {
        $qualifiedAction = "$controllerClassName@$action";
        $route = $this->routes->getByAction($qualifiedAction);
        if (!$route) {
            throw new SwaggerGeneratorException("Route not found for action $qualifiedAction");
        }
        $path = '/' . $route->getPath();
        $path = str_replace($route->getPrefix(), '', $path);
        $regexp = '/(?<=\/)\{([a-z_]+?)\}(?=\/|$)/';
        $path = preg_replace($regexp, '{id}', $path);
        return $path;
    }
}
