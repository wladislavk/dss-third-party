<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\RoutePathRetriever;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class RoutePathRetrieverTest extends UnitTestCase
{
    /** @var RoutePathRetriever */
    private $routePathRetriever;

    public function setUp()
    {
        $router = $this->mockRouter();
        $this->routePathRetriever = new RoutePathRetriever($router);
    }

    /**
     * @throws SwaggerGeneratorException
     */
    public function testWithRoute()
    {
        $controllerClassName = 'MyController';
        $action = 'index';
        $path = $this->routePathRetriever->getRoutePath($controllerClassName, $action);
        $this->assertEquals('/my-controller/index/{id}', $path);
    }

    /**
     * @throws SwaggerGeneratorException
     */
    public function testWithoutRoute()
    {
        $controllerClassName = 'foo';
        $action = 'bar';
        $this->expectException(SwaggerGeneratorException::class);
        $this->expectExceptionMessage("Route not found for action foo@bar");
        $this->routePathRetriever->getRoutePath($controllerClassName, $action);
    }

    private function mockRouter()
    {
        /** @var Router|MockInterface $router */
        $router = \Mockery::mock(Router::class);
        $router->shouldReceive('getRoutes')->andReturn($this->mockRouteCollection());
        return $router;
    }

    private function mockRouteCollection()
    {
        /** @var RouteCollection|MockInterface $routeCollection */
        $routeCollection = \Mockery::mock(RouteCollection::class);
        $routeCollection->shouldReceive('getByAction')
            ->andReturnUsing([$this, 'getByActionCallback']);
        return $routeCollection;
    }

    private function mockRoute()
    {
        /** @var Route|MockInterface $route */
        $route = \Mockery::mock(Route::class);
        $route->shouldReceive('uri')->andReturnUsing([$this, 'getPathCallback']);
        $route->shouldReceive('getPrefix')->andReturnUsing([$this, 'getPrefixCallback']);
        return $route;
    }

    public function getByActionCallback($qualifiedAction)
    {
        if ($qualifiedAction == 'MyController@index') {
            return $this->mockRoute();
        }
        return null;
    }

    public function getPathCallback()
    {
        return 'api/v1/my-controller/index/{param}';
    }

    public function getPrefixCallback()
    {
        return '/api/v1';
    }
}
