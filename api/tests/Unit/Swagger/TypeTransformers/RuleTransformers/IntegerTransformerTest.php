<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\IntegerTransformer;
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

    public function testTransform()
    {
        $this->integerTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="integer")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
