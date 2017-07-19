<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\IntegerTransformer;
use Tests\TestCases\UnitTestCase;

class IntegerTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var IntegerTransformer */
    private $integerTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'int';

        $this->integerTransformer = new IntegerTransformer();
    }

    public function testTransformRequired()
    {
        $this->integerTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="integer")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertTrue($this->annotationRule->required);
    }

    public function testTransformNonRequired()
    {
        $this->annotationRule->rule = 'int|null';
        $this->integerTransformer->transform($this->annotationRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
