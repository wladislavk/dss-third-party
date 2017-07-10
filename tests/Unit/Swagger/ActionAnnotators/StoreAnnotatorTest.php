<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\StoreAnnotator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use Tests\TestCases\UnitTestCase;

class StoreAnnotatorTest extends UnitTestCase
{
    /** @var AnnotationData */
    private $annotationData;

    /** @var StoreAnnotator */
    private $storeAnnotator;

    public function setUp()
    {
        $this->annotationData = new AnnotationData();
        $this->annotationData->route = '/foo';
        $this->annotationData->shortModelClassName = 'MyModel';
        $rules = ['firstRule', 'secondRule'];
        foreach ($rules as $rule) {
            $annotationRule = new AnnotationRule();
            $annotationRule->parsedRule = $rule;
            $this->annotationData->rules[] = $annotationRule;
        }

        $this->storeAnnotator = new StoreAnnotator();
    }

    public function testCreateAnnotation()
    {
        $annotation = $this->storeAnnotator->createAnnotation($this->annotationData);
        $expected = <<<ANNOTATION
@SWG\\Post(
    path="/foo",
firstRule,
secondRule,
    @SWG\Response(
        response="200",
        description="Resource created",
        @SWG\Schema(
            allOf={
                @SWG\Schema(ref="#/definitions/common_response_fields"),
                @SWG\Schema(
                    @SWG\Property(property="data", ref="#/definitions/MyModel")
                )
            }
        )
    ),
    @SWG\Response(response="422", ref="#/responses/422_response"),
    @SWG\Response(response="default", ref="#/responses/error_response")
)
ANNOTATION;
        $this->assertEquals($expected, $annotation);
    }
}
