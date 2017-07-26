<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\ArrayTransformer;
use Tests\TestCases\UnitTestCase;

class ArrayTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var ArrayTransformer */
    private $arrayTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'array';

        $this->arrayTransformer = new ArrayTransformer();
    }

    public function testTransformRequired()
    {
        $this->arrayTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="string")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertTrue($this->annotationRule->required);
    }

    public function testTransformNonRequired()
    {
        $this->annotationRule->rule = 'array|null';
        $this->arrayTransformer->transform($this->annotationRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
