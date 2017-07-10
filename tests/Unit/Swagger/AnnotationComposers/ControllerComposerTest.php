<?php

namespace Tests\Unit\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\ActionAnnotators\AbstractActionAnnotator;
use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\RoutePathRetriever;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\AbstractRuleTransformer;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use Mockery\MockInterface;
use Tests\Dummies\Eloquent\SecondDummy as SecondDummyModel;
use Tests\Dummies\Http\Controllers\SecondDummiesController;
use Tests\Dummies\Http\Requests\SecondDummy as SecondDummyRequest;
use Tests\TestCases\UnitTestCase;

class ControllerComposerTest extends UnitTestCase
{
    /** @var AnnotationParams */
    private $annotationParams;

    /** @var array */
    private $storeRules = [];

    /** @var array */
    private $updateRules = [];

    /** @var ControllerComposer */
    private $controllerComposer;

    public function setUp()
    {
        $this->annotationParams = new AnnotationParams();
        $this->annotationParams->controllerClassName = SecondDummiesController::class;
        $this->annotationParams->modelClassName = SecondDummyModel::class;
        $this->annotationParams->requestClassName = SecondDummyRequest::class;

        $request = new SecondDummyRequest();
        $this->storeRules = $request->storeRules();
        $this->updateRules = $request->updateRules();

        $ruleTransformerFactory = $this->mockRuleTransformerFactory();
        $docBlockRetriever = $this->mockDocBlockRetriever();
        $actionAnnotatorFactory = $this->mockActionAnnotatorFactory();
        $routePathRetriever = $this->mockRoutePathRetriever();
        $this->controllerComposer = new ControllerComposer(
            $ruleTransformerFactory,
            $docBlockRetriever,
            $actionAnnotatorFactory,
            $routePathRetriever
        );
    }

    public function testComposeAnnotation()
    {
        $annotations = $this->controllerComposer->composeAnnotation($this->annotationParams);
        $this->assertEquals(5, sizeof($annotations));

        $indexAnnotation = $annotations[0];
        $this->assertEquals('index', $indexAnnotation->action);
        $this->assertEquals('public function index(', $indexAnnotation->operator);
        $this->assertEquals(
            "/**\n" . SecondDummiesController::class . "\nindex\n*/",
            $indexAnnotation->docBlock
        );
        $this->assertEquals(SecondDummiesController::class . '/index', $indexAnnotation->route);
        $this->assertEquals($this->annotationParams, $indexAnnotation->params);
        $this->assertEquals('SecondDummy', $indexAnnotation->shortModelClassName);
        $this->assertEquals('@index', $indexAnnotation->text);
        $this->assertEquals(0, sizeof($indexAnnotation->rules));

        $storeAnnotation = $annotations[2];
        $this->assertEquals('store', $storeAnnotation->action);
        $this->assertEquals(
            "/**\n" . SecondDummiesController::class . "\nstore\n*/",
            $storeAnnotation->docBlock
        );
        $this->assertEquals(SecondDummiesController::class . '/store', $storeAnnotation->route);
        $this->assertEquals('@store', $storeAnnotation->text);
        $this->assertEquals(3, sizeof($storeAnnotation->rules));
        $this->assertEquals('boolean@fifth', $storeAnnotation->rules[0]->parsedRule);
        $this->assertEquals('regex:/foo/@sixth', $storeAnnotation->rules[1]->parsedRule);
        $this->assertEquals('required|regex:/[bar|baz]/@seventh', $storeAnnotation->rules[2]->parsedRule);

        $updateAnnotation = $annotations[3];
        $this->assertEquals('update', $updateAnnotation->action);
        $this->assertEquals(
            "/**\n" . SecondDummiesController::class . "\nupdate\n*/",
            $updateAnnotation->docBlock
        );
        $this->assertEquals(SecondDummiesController::class . '/update', $updateAnnotation->route);
        $this->assertEquals('@update', $updateAnnotation->text);
        $this->assertEquals(3, sizeof($updateAnnotation->rules));
        $this->assertEquals('boolean@fifth', $updateAnnotation->rules[0]->parsedRule);
        $this->assertEquals('regex:/foo/@sixth', $updateAnnotation->rules[1]->parsedRule);
        $this->assertEquals('sometimes|required|regex:/[bar|baz]/@seventh', $updateAnnotation->rules[2]->parsedRule);
    }

    private function mockDocBlockRetriever()
    {
        /** @var DocBlockRetriever|MockInterface $docBlockRetriever */
        $docBlockRetriever = \Mockery::mock(DocBlockRetriever::class);
        $docBlockRetriever->shouldReceive('getFromFunction')
            ->andReturnUsing([$this, 'getFromFunctionCallback']);
        return $docBlockRetriever;
    }

    private function mockRuleTransformerFactory()
    {
        /** @var RuleTransformerFactory|MockInterface $ruleTransformerFactory */
        $ruleTransformerFactory = \Mockery::mock(RuleTransformerFactory::class);
        $ruleTransformerFactory->shouldReceive('getTransformer')
            ->andReturn($this->mockRuleTransformer());
        return $ruleTransformerFactory;
    }

    private function mockRuleTransformer()
    {
        /** @var AbstractRuleTransformer|MockInterface $ruleTransformer */
        $ruleTransformer = \Mockery::mock(AbstractRuleTransformer::class);
        $ruleTransformer->shouldReceive('transform')
            ->andReturnUsing([$this, 'transformCallback']);
        return $ruleTransformer;
    }

    private function mockActionAnnotatorFactory()
    {
        /** @var ActionAnnotatorFactory|MockInterface $actionAnnotatorFactory */
        $actionAnnotatorFactory = \Mockery::mock(ActionAnnotatorFactory::class);
        $actionAnnotatorFactory->shouldReceive('findAnnotator')
            ->andReturn($this->mockActionAnnotator());
        return $actionAnnotatorFactory;
    }

    private function mockActionAnnotator()
    {
        /** @var AbstractActionAnnotator|MockInterface $actionAnnotator */
        $actionAnnotator = \Mockery::mock(AbstractActionAnnotator::class);
        $actionAnnotator->shouldReceive('createAnnotation')
            ->andReturnUsing([$this, 'createAnnotationCallback']);
        return $actionAnnotator;
    }

    private function mockRoutePathRetriever()
    {
        /** @var RoutePathRetriever|MockInterface $routePathRetriever */
        $routePathRetriever = \Mockery::mock(RoutePathRetriever::class);
        $routePathRetriever->shouldReceive('getRoutePath')
            ->andReturnUsing([$this, 'getRoutePathCallback']);
        return $routePathRetriever;
    }

    public function getFromFunctionCallback($controllerClassName, $action)
    {
        return "/**\n$controllerClassName\n$action\n*/";
    }

    public function getRoutePathCallback($controllerClassName, $action)
    {
        return $controllerClassName . '/' . $action;
    }

    public function transformCallback(AnnotationRule $rule)
    {
        $rule->parsedRule = $rule->rule . '@' . $rule->field;
    }

    public function createAnnotationCallback(AnnotationData $annotationData)
    {
        return '@' . $annotationData->action;
    }
}
