<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\RegexTransformer;
use Tests\TestCases\UnitTestCase;

class RegexTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var RegexTransformer */
    private $regexTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'regex:/.*?(\s\/)+/';

        $this->regexTransformer = new RegexTransformer();
    }

    public function testTransform()
    {
        $this->regexTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string", pattern=".*?(\s\/)+")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }

    public function testTransformWithoutRegex()
    {
        $this->annotationRule->rule = 'regex:';
        $this->regexTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
