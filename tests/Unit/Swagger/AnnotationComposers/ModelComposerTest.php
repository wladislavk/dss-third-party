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

    /** @var string */
    private $docBlock = '';

    /** @var ModelComposer */
    private $modelComposer;

    public function setUp()
    {
        $this->docBlock = <<<ANNOTATION
/**
 * @property integer \$id
 * @property-read string \$name
 * @property string|null \$ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereAdddate(\$value)
 */
ANNOTATION;

        $this->annotationParams = new AnnotationParams();
        $this->annotationParams->modelClassName = FirstDummy::class;

        $modelTransformerFactory = $this->mockModelTransformerFactory();
        $docBlockRetriever = $this->mockDocBlockRetriever();
        $this->modelComposer = new ModelComposer($modelTransformerFactory, $docBlockRetriever);
    }

    public function testWithRequiredRules()
    {
        $annotations = $this->modelComposer->composeAnnotation($this->annotationParams);
        $this->assertEquals(1, sizeof($annotations));
        $annotationData = $annotations[0];
        $this->assertEquals('class FirstDummy', $annotationData->operator);
        $this->assertEquals($this->annotationParams, $annotationData->params);
        $this->assertEquals('FirstDummy', $annotationData->shortModelClassName);
        $this->assertEquals($this->docBlock, $annotationData->docBlock);
        $expectedText = <<<ANNOTATION
@SWG\Definition(
    definition="FirstDummy",
    type="object",
    required={"id", "name"},
    @Rule(field="id", rule="integer", type="property"),
    @Rule(field="name", rule="string", type="property-read"),
    @Rule(field="ip_address", rule="string", type="property")
)
ANNOTATION;
        $this->assertEquals($expectedText, $annotationData->text);
    }

    public function testWithoutRequiredRules()
    {
        $this->docBlock = <<<ANNOTATION
/**
 * @property integer|null \$id
 * @property-read string|null \$name
 * @property string|null \$ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereAdddate(\$value)
 */
ANNOTATION;

        $annotations = $this->modelComposer->composeAnnotation($this->annotationParams);
        $this->assertEquals(1, sizeof($annotations));
        $annotationData = $annotations[0];
        $expectedText = <<<ANNOTATION
@SWG\Definition(
    definition="FirstDummy",
    type="object",
    @Rule(field="id", rule="integer", type="property"),
    @Rule(field="name", rule="string", type="property-read"),
    @Rule(field="ip_address", rule="string", type="property")
)
ANNOTATION;
        $this->assertEquals($expectedText, $annotationData->text);
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
        return $this->docBlock;
    }

    public function getTransformerCallback(AnnotationRule $rule)
    {
        $className = '';
        switch ($rule->rule) {
            case 'string':
            case 'string|null':
                $className = StringTransformer::class;
                break;
            case 'integer':
            case 'integer|null':
                $className = IntegerTransformer::class;
                break;
        }
        return $this->mockModelTransformer($className);
    }

    public function transformCallback(AnnotationRule $rule)
    {
        if (!strstr($rule->rule, '|null')) {
            $rule->required = true;
        }
        $rule->rule = str_replace('|null', '', $rule->rule);
        $parsedRule = <<<ANNOTATION
    @Rule(field="{$rule->field}", rule="{$rule->rule}", type="{$rule->type}")
ANNOTATION;
        $rule->parsedRule = $parsedRule;
    }
}
