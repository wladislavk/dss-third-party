<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Swagger\AnnotationModifier;
use DentalSleepSolutions\Swagger\AnnotationTypes\ControllerType;
use DentalSleepSolutions\Swagger\AnnotationTypes\ModelType;
use DentalSleepSolutions\Swagger\AnnotationWriter;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\Generator;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * This class tests all Swagger services in isolation from the filesystem and routes.
 * This class should contain minimal possible number of tests to make sure the system
 * works, all class-specific tests should be located in their respective test classes
 *
 * Class SwaggerTest
 */
class SwaggerTest extends TestCase
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
            $namespace . 'FirstDummiesController@index' => '/first',
            $namespace . 'FirstDummiesController@show' => '/first/:id',
            $namespace . 'FirstDummiesController@store' => '/first',
            $namespace . 'FirstDummiesController@update' => '/first/:id',
            $namespace . 'FirstDummiesController@destroy' => '/first/:id',
            $namespace . 'SecondDummiesController@index' => '/second',
            $namespace . 'SecondDummiesController@store' => '/second',
            $namespace . 'SecondDummiesController@update' => '/second/:id',
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
        $controllerType = new ControllerType($actionAnnotatorFactory, $router);
        $modelType = new ModelType();
        $modelTransformerFactory = new ModelTransformerFactory($application);
        $ruleTransformerFactory = new RuleTransformerFactory($application);
        $this->generator = new Generator(
            $annotationWriter,
            $controllerType,
            $modelType,
            $modelTransformerFactory,
            $ruleTransformerFactory,
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
        $route->shouldReceive('getPath')->andReturnUsing([$this, 'getPathCallback']);
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

    public function makeCallback($className)
    {
        return new $className();
    }
}
