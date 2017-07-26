<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\EmailTransformer;
use Tests\TestCases\UnitTestCase;

class EmailTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var EmailTransformer */
    private $emailTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'email';

        $this->emailTransformer = new EmailTransformer();
    }

    public function testTransform()
    {
        $this->emailTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string", format="email")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }

    public function testTransformWithMaxLength()
    {
        $this->annotationRule->rule = 'email|max:250';
        $this->emailTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="string", format="email", maxLength=250)
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
