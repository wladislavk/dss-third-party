<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\ShowAnnotator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use Tests\TestCases\UnitTestCase;

class ShowAnnotatorTest extends UnitTestCase
{
    /** @var AnnotationData */
    private $annotationData;

    /** @var ShowAnnotator */
    private $showAnnotator;

    public function setUp()
    {
        $this->annotationData = new AnnotationData();
        $this->annotationData->route = '/foo';
        $this->annotationData->shortModelClassName = 'MyModel';

        $this->showAnnotator = new ShowAnnotator();
    }

    public function testCreateAnnotation()
    {
        $annotation = $this->showAnnotator->createAnnotation($this->annotationData);
        $expected = <<<ANNOTATION
@SWG\\Get(
    path="/foo",
    @SWG\Parameter(ref="#/parameters/id_in_path"),
    @SWG\Response(
        response="200",
        description="Resource retrieved",
        @SWG\Schema(
            allOf={
                @SWG\Schema(ref="#/definitions/common_response_fields"),
                @SWG\Schema(
                    @SWG\Property(property="data", ref="#/definitions/MyModel")
                )
            }
        )
    ),
    @SWG\Response(response="404", ref="#/responses/404_response"),
    @SWG\Response(response="default", ref="#/responses/error_response")
)
ANNOTATION;
        $this->assertEquals($expected, $annotation);
    }
}
