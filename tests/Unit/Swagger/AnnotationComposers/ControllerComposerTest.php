<?php

namespace Tests\Unit\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\RoutePathRetriever;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class ControllerComposerTest extends UnitTestCase
{
    /** @var ControllerComposer */
    private $controllerComposer;

    public function setUp()
    {
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
        $this->markTestIncomplete();
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
            ->andReturnUsing([$this, 'getTransformerCallback']);
        return $ruleTransformerFactory;
    }

    private function mockActionAnnotatorFactory()
    {
        /** @var ActionAnnotatorFactory|MockInterface $actionAnnotatorFactory */
        $actionAnnotatorFactory = \Mockery::mock(ActionAnnotatorFactory::class);
        $actionAnnotatorFactory->shouldReceive('findAnnotator')
            ->andReturnUsing([$this, 'findAnnotatorCallback']);
        return $actionAnnotatorFactory;
    }

    private function mockRoutePathRetriever()
    {
        /** @var RoutePathRetriever|MockInterface $routePathRetriever */
        $routePathRetriever = \Mockery::mock(RoutePathRetriever::class);
        $routePathRetriever->shouldReceive('getRoutePath')
            ->andReturnUsing([$this, 'getRoutePathCallback']);
        return $routePathRetriever;
    }

    public function getFromFunctionCallback()
    {

    }

    public function getRoutePathCallback()
    {

    }

    public function getTransformerCallback(AnnotationRule $rule)
    {

    }

    public function transformCallback(AnnotationRule $rule)
    {

    }

    public function findAnnotatorCallback($action)
    {

    }
}
