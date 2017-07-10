<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\StringTransformer;
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

    public function testTransform()
    {
        $this->stringTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }

    public function testTransformWithMaxLength()
    {
        $this->annotationRule->rule = 'email|max:250';
        $this->stringTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string", maxLength=250)
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
