<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\DestroyAnnotator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use Tests\TestCases\UnitTestCase;

class DestroyAnnotatorTest extends UnitTestCase
{
    /** @var AnnotationData */
    private $annotationData;

    /** @var DestroyAnnotator */
    private $destroyAnnotator;

    public function setUp()
    {
        $this->annotationData = new AnnotationData();
        $this->annotationData->route = '/foo';

        $this->destroyAnnotator = new DestroyAnnotator();
    }

    public function testCreateAnnotation()
    {
        $annotation = $this->destroyAnnotator->createAnnotation($this->annotationData);
        $expected = <<<ANNOTATION
@SWG\\Delete(
    path="/foo",
    @SWG\Parameter(ref="#/parameters/id_in_path"),
    @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
    @SWG\Response(response="404", ref="#/responses/404_response"),
    @SWG\Response(response="default", ref="#/responses/error_response")
)
ANNOTATION;
        $this->assertEquals($expected, $annotation);
    }
}
