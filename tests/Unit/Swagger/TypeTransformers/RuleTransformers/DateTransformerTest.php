<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\DateTransformer;
use Tests\TestCases\UnitTestCase;

class DateTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var DateTransformer */
    private $dateTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'date';

        $this->dateTransformer = new DateTransformer();
    }

    public function testTransform()
    {
        $this->dateTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string", format="dateTime")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
