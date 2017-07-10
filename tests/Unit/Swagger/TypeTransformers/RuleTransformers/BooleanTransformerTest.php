<?php

namespace Tests\Unit\Swagger\TypeTransformers\RuleTransformers;

use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers\BooleanTransformer;
use Tests\TestCases\UnitTestCase;

class BooleanTransformerTest extends UnitTestCase
{
    /** @var AnnotationRule */
    private $annotationRule;

    /** @var BooleanTransformer */
    private $booleanTransformer;

    public function setUp()
    {
        $this->annotationRule = new AnnotationRule();
        $this->annotationRule->field = 'foo';
        $this->annotationRule->rule = 'boolean';

        $this->booleanTransformer = new BooleanTransformer();
    }

    public function testTransformNonRequired()
    {
        $this->booleanTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="boolean")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }

    public function testTransformRequired()
    {
        $this->annotationRule->rule = 'required|boolean';
        $this->booleanTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="boolean", required=true)
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }

    public function testTransformSometimesRequired()
    {
        $this->annotationRule->rule = 'sometimes|required|boolean';
        $this->booleanTransformer->transform($this->annotationRule);
        $expected = <<<ANNOTATION
    @SWG\Parameter(name="foo", in="formData", type="boolean")
ANNOTATION;
        $this->assertEquals($expected, $this->annotationRule->parsedRule);
    }
}
