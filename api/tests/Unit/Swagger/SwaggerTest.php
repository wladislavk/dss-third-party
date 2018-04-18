<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Services\ClassRetriever;
use DentalSleepSolutions\Swagger\AnnotationModifier;
use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\AnnotationComposers\ModelComposer;
use DentalSleepSolutions\Swagger\AnnotationWriter;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\Generator;
use DentalSleepSolutions\Swagger\RoutePathRetriever;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

/**
 * This class tests all Swagger services in isolation from the filesystem and routes.
 * This class should contain minimal possible number of tests to make sure the system
 * works, all class-specific tests should be located in their respective test classes
 *
 * Class SwaggerTest
 */
class SwaggerTest extends UnitTestCase
{
    const HTTP_DIR = __DIR__ . '/../../Dummies/Http';
    const MODEL_DIR = __DIR__ . '/../../Dummies/Eloquent';

    /** @var string[] */
    private $models = [];

    /** @var string[] */
    private $controllers = [];

    /** @var string[] */
    private $newContents = [];

    private $routes = [];

    /** @var string */
    private $routeUri;

    /** @var Generator */
    private $generator;

    public function setUp()
    {
        $firstController = file_get_contents(realpath(__DIR__ . '/../../Dummies/Http/Controllers/FirstDummiesController.php'));
        $secondController = file_get_contents(realpath(__DIR__ . '/../../Dummies/Http/Controllers/SecondDummiesController.php'));

        $firstModel = file_get_contents(realpath(__DIR__ . '/../../Dummies/Eloquent/FirstDummy.php'));
        $secondModel = file_get_contents(realpath(__DIR__ . '/../../Dummies/Eloquent/SecondDummy.php'));

        $this->controllers = [
            __DIR__ . '/../../Dummies/Http/Controllers/FirstDummiesController.php' => $firstController,
            __DIR__ . '/../../Dummies/Http/Controllers/SecondDummiesController.php' => $secondController,
        ];
        $this->models = [
            __DIR__ . '/../../Dummies/Eloquent/FirstDummy.php' => $firstModel,
            __DIR__ . '/../../Dummies/Eloquent/SecondDummy.php' => $secondModel,
        ];

        $namespace = 'Tests\Dummies\Http\Controllers\\';
        $this->routes = [
            $namespace . 'FirstDummiesController@index' => 'api/v1/first',
            $namespace . 'FirstDummiesController@show' => 'api/v1/first/{first}',
            $namespace . 'FirstDummiesController@store' => 'api/v1/first',
            $namespace . 'FirstDummiesController@update' => 'api/v1/first/{first}',
            $namespace . 'FirstDummiesController@destroy' => 'api/v1/first/{first}',
            $namespace . 'SecondDummiesController@index' => 'api/v1/second',
            $namespace . 'SecondDummiesController@store' => 'api/v1/second',
            $namespace . 'SecondDummiesController@update' => 'api/v1/second/{second}',
        ];

        $this->initialize();
    }

    private function initialize()
    {
        $application = $this->mockApplication();
        $annotationModifier = new AnnotationModifier();
        $filesystemWrapper = $this->mockFilesystemWrapper();
        $annotationWriter = new AnnotationWriter($annotationModifier, $filesystemWrapper);
        $actionAnnotatorFactory = new ActionAnnotatorFactory($application);
        $router = $this->mockRouter();
        $modelTransformerFactory = new ModelTransformerFactory($application);
        $ruleTransformerFactory = new RuleTransformerFactory($application);
        $docBlockRetriever = new DocBlockRetriever();
        $routePathRetriever = new RoutePathRetriever($router);
        $controllerComposer = new ControllerComposer(
            $ruleTransformerFactory,
            $docBlockRetriever,
            $actionAnnotatorFactory,
            $routePathRetriever
        );
        $modelComposer = new ModelComposer($modelTransformerFactory, $docBlockRetriever);
        $classRetriever = new ClassRetriever();
        $this->generator = new Generator(
            $annotationWriter,
            $controllerComposer,
            $modelComposer,
            $classRetriever,
            $filesystemWrapper
        );
    }

    public function testGenerateAnnotations()
    {
        $this->generator->generateSwagger(self::HTTP_DIR, self::MODEL_DIR);
        $expectedFirstModel = file_get_contents(realpath(__DIR__ . '/../../Dummies/Expected/ExpectedFirstModel.txt'));
        $expectedSecondModel = file_get_contents(realpath(__DIR__ . '/../../Dummies/Expected/ExpectedSecondModel.txt'));
        $expectedFirstController = file_get_contents(realpath(__DIR__ . '/../../Dummies/Expected/ExpectedFirstController.txt'));
        $expectedSecondController = file_get_contents(realpath(__DIR__ . '/../../Dummies/Expected/ExpectedSecondController.txt'));
        $this->assertEquals($expectedFirstModel, $this->newContents[0]);
        $this->assertEquals($expectedSecondModel, $this->newContents[1]);
        $this->assertEquals($expectedFirstController, $this->newContents[2]);
        $this->assertEquals($expectedSecondController, $this->newContents[3]);
    }

    private function mockFilesystemWrapper()
    {
        /** @var FilesystemWrapper|MockInterface $filesystemWrapper */
        $filesystemWrapper = \Mockery::mock(FilesystemWrapper::class);
        $filesystemWrapper->shouldReceive('fOpen')->andReturnNull();
        $filesystemWrapper->shouldReceive('fClose')->andReturnNull();
        $filesystemWrapper->shouldReceive('allFiles')
            ->andReturnUsing([$this, 'allFilesCallback']);
        $filesystemWrapper->shouldReceive('fileGetContents')
            ->andReturnUsing([$this, 'fileGetContentsCallback']);
        $filesystemWrapper->shouldReceive('fWrite')
            ->andReturnUsing([$this, 'fWriteCallback']);
        return $filesystemWrapper;
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
        $routeCollection->shouldReceive('getByAction')->andReturnUsing([$this, 'getByActionCallback']);
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

    private function mockApplication()
    {
        /** @var Application|MockInterface $application */
        $application = \Mockery::mock(Application::class);
        $application->shouldReceive('make')->andReturnUsing([$this, 'makeCallback']);
        return $application;
    }

    public function allFilesCallback($dir)
    {
        if (strstr($dir, 'Controllers')) {
            return array_keys($this->controllers);
        }
        if (strstr($dir, 'Eloquent')) {
            return array_keys($this->models);
        }
        return [];
    }

    public function fileGetContentsCallback($filename)
    {
        if (array_key_exists($filename, $this->controllers)) {
            return $this->controllers[$filename];
        }
        if (array_key_exists($filename, $this->models)) {
            return $this->models[$filename];
        }
        return '';
    }

    /**
     * @param string $contents
     */
    public function fWriteCallback($contents)
    {
        $this->newContents[] = $contents;
    }

    public function getByActionCallback($action)
    {
        foreach ($this->routes as $routeAction => $routeUri) {
            if ($action == $routeAction) {
                $this->routeUri = $routeUri;
            }
        }
        return $this->mockRoute();
    }

    public function getPathCallback()
    {
        return $this->routeUri;
    }

    public function getPrefixCallback()
    {
        return '/api/v1';
    }

    public function makeCallback($className)
    {
        return new $className();
    }
}
