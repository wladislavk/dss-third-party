<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\IndexAnnotator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use Tests\TestCases\UnitTestCase;

class IndexAnnotatorTest extends UnitTestCase
{
    /** @var AnnotationData */
    private $annotationData;

    /** @var IndexAnnotator */
    private $indexAnnotator;

    public function setUp()
    {
        $this->annotationData = new AnnotationData();
        $this->annotationData->route = '/foo';
        $this->annotationData->shortModelClassName = 'MyModel';

        $this->indexAnnotator = new IndexAnnotator();
    }

    public function testCreateAnnotation()
    {
        $annotation = $this->indexAnnotator->createAnnotation($this->annotationData);
        $expected = <<<ANNOTATION
@SWG\\Get(
    path="/foo",
    @SWG\Response(
        response="200",
        description="Resources retrieved",
        @SWG\Schema(
            allOf={
                @SWG\Schema(ref="#/definitions/common_response_fields"),
                @SWG\Schema(
                    @SWG\Property(
                        property="data",
                        type="array",
                        @SWG\Items(ref="#/definitions/MyModel")
                    )
                )
            }
        )
    ),
    @SWG\Response(response="default", ref="#/responses/error_response")
)
ANNOTATION;
        $this->assertEquals($expected, $annotation);
    }
}
