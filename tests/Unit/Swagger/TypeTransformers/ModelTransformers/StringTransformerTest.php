<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\StringTransformer;
use Tests\TestCases\UnitTestCase;

class StringTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var StringTransformer */
    private $stringTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'string';

        $this->stringTransformer = new StringTransformer();
    }

    public function testTransformRequired()
    {
        $this->stringTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="string")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertTrue($this->annotationRule->required);
    }

    public function testTransformNonRequired()
    {
        $this->annotationRule->rule = 'string|null';
        $this->stringTransformer->transform($this->annotationRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
