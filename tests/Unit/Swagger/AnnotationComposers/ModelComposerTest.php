<?php

namespace Tests\Unit\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\AnnotationComposers\ModelComposer;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\AbstractModelTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\IntegerTransformer;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\StringTransformer;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use Mockery\MockInterface;
use Tests\Dummies\Eloquent\FirstDummy;
use Tests\TestCases\UnitTestCase;

class ModelComposerTest extends UnitTestCase
{
    /** @var AnnotationParams */
    private $annotationParams;

    /** @var ModelComposer */
    private $modelComposer;

    public function setUp()
    {
        $this->annotationParams = new AnnotationParams();
        $this->annotationParams->modelClassName = FirstDummy::class;

        $modelTransformerFactory = $this->mockModelTransformerFactory();
        $docBlockRetriever = $this->mockDocBlockRetriever();
        $this->modelComposer = new ModelComposer($modelTransformerFactory, $docBlockRetriever);
    }

    public function testWithRequiredRules()
    {
        $annotations = $this->modelComposer->composeAnnotation($this->annotationParams);
    }

    public function testWithoutRequiredRules()
    {
        $annotations = $this->modelComposer->composeAnnotation($this->annotationParams);
    }

    private function mockDocBlockRetriever()
    {
        /** @var DocBlockRetriever|MockInterface $docBlockRetriever */
        $docBlockRetriever = \Mockery::mock(DocBlockRetriever::class);
        $docBlockRetriever->shouldReceive('getFromClass')
            ->andReturnUsing([$this, 'getFromClassCallback']);
        return $docBlockRetriever;
    }

    private function mockModelTransformerFactory()
    {
        /** @var ModelTransformerFactory|MockInterface $modelTransformerFactory */
        $modelTransformerFactory = \Mockery::mock(ModelTransformerFactory::class);
        $modelTransformerFactory->shouldReceive('getTransformer')
            ->andReturnUsing([$this, 'getTransformerCallback']);
        return $modelTransformerFactory;
    }

    private function mockModelTransformer($className)
    {
        /** @var AbstractModelTransformer|MockInterface $modelTransformer */
        $modelTransformer = \Mockery::mock($className);
        $modelTransformer->shouldReceive('transform')->andReturnUsing([$this, 'transformCallback']);
        return $modelTransformer;
    }

    public function getFromClassCallback($className)
    {

    }

    public function getTransformerCallback(AnnotationRule $rule)
    {
        $className = '';
        switch ($rule->rule) {
            case 'string':
                $className = StringTransformer::class;
                break;
            case 'integer':
                $className = IntegerTransformer::class;
                break;
        }
        return $this->mockModelTransformer($className);
    }

    public function transformCallback(AnnotationRule $rule)
    {

    }
}
