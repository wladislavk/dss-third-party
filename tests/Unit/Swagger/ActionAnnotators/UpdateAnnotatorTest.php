<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\UpdateAnnotator;
use Tests\TestCases\UnitTestCase;

class UpdateAnnotatorTest extends UnitTestCase
{
    /** @var UpdateAnnotator */
    private $updateAnnotator;

    public function setUp()
    {
        $this->updateAnnotator = new UpdateAnnotator();
    }

    public function testCreateAnnotation()
    {
        $this->markTestIncomplete();
    }
}
