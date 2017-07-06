<?php

namespace Tests\Unit\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use Illuminate\Routing\Router;
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
        $router = $this->mockRouter();
        $this->controllerComposer = new ControllerComposer(
            $ruleTransformerFactory, $docBlockRetriever, $actionAnnotatorFactory, $router
        );
    }

    public function testComposeAnnotation()
    {

    }

    public function testWithoutRoute()
    {

    }

    private function mockDocBlockRetriever()
    {
        /** @var DocBlockRetriever|MockInterface $docBlockRetriever */
        $docBlockRetriever = \Mockery::mock(DocBlockRetriever::class);
        return $docBlockRetriever;
    }

    private function mockRuleTransformerFactory()
    {
        /** @var RuleTransformerFactory|MockInterface $ruleTransformerFactory */
        $ruleTransformerFactory = \Mockery::mock(RuleTransformerFactory::class);
        return $ruleTransformerFactory;
    }

    private function mockActionAnnotatorFactory()
    {
        /** @var ActionAnnotatorFactory|MockInterface $actionAnnotatorFactory */
        $actionAnnotatorFactory = \Mockery::mock(ActionAnnotatorFactory::class);
        return $actionAnnotatorFactory;
    }

    private function mockRouter()
    {
        /** @var Router|MockInterface $router */
        $router = \Mockery::mock(Router::class);
        return $router;
    }
}
