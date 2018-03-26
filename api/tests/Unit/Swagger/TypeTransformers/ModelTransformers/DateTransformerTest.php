<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\DateTransformer;
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

    public function testTransformRequired()
    {
        $this->dateTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="string", format="dateTime")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertTrue($this->annotationRule->required);
    }

    public function testTransformNonRequired()
    {
        $this->annotationRule->rule = 'date|null';
        $this->dateTransformer->transform($this->annotationRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
