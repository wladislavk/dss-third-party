<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\FloatTransformer;
use Tests\TestCases\UnitTestCase;

class FloatTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var FloatTransformer */
    private $floatTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'float';

        $this->floatTransformer = new FloatTransformer();
    }

    public function testTransformRequired()
    {
        $this->floatTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="float")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertTrue($this->annotationRule->required);
    }

    public function testTransformNonRequired()
    {
        $this->annotationRule->rule = 'float|null';
        $this->floatTransformer->transform($this->annotationRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
