<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\ShowAnnotator;
use Tests\TestCases\UnitTestCase;

class ShowAnnotatorTest extends UnitTestCase
{
    /** @var ShowAnnotator */
    private $showAnnotator;

    public function setUp()
    {
        $this->showAnnotator = new ShowAnnotator();
    }

    public function testCreateAnnotation()
    {
        $this->markTestIncomplete();
    }
}
