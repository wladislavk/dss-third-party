<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\UpdateAnnotator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use Tests\TestCases\UnitTestCase;

class UpdateAnnotatorTest extends UnitTestCase
{
    /** @var AnnotationData */
    private $annotationData;

    /** @var UpdateAnnotator */
    private $updateAnnotator;

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

        $this->updateAnnotator = new UpdateAnnotator();
    }

    public function testCreateAnnotation()
    {
        $annotation = $this->updateAnnotator->createAnnotation($this->annotationData);
        $expected = <<<ANNOTATION
@SWG\\Put(
    path="/foo",
    @SWG\Parameter(ref="#/parameters/id_in_path"),
firstRule,
secondRule,
    @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
    @SWG\Response(response="404", ref="#/responses/404_response"),
    @SWG\Response(response="422", ref="#/responses/422_response"),
    @SWG\Response(response="default", ref="#/responses/error_response")
)
ANNOTATION;
        $this->assertEquals($expected, $annotation);
    }
}
