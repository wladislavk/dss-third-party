<?php

namespace Tests\Unit\Swagger\TypeTransformers\ModelTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers\RefTransformer;
use Tests\TestCases\UnitTestCase;

class RefTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var RefTransformer */
    private $refTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'Foo\\Bar\\Baz';

        $this->refTransformer = new RefTransformer();
    }

    public function testTransformElement()
    {
        $this->refTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", ref="#/definitions/Baz")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertFalse($this->annotationRule->required);
    }

    public function testTransformCollection()
    {
        $this->annotationRule->rule = 'Foo\\Bar\\Baz[]';
        $this->refTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Property(property="foo", type="array", @SWG\Items(ref="#/definitions/Baz"))
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
        $this->assertFalse($this->annotationRule->required);
    }
}
