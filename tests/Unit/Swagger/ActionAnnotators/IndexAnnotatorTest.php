<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\IndexAnnotator;
use Tests\TestCases\UnitTestCase;

class IndexAnnotatorTest extends UnitTestCase
{
    /** @var IndexAnnotator */
    private $indexAnnotator;

    public function setUp()
    {
        $this->indexAnnotator = new IndexAnnotator();
    }

    public function testCreateAnnotation()
    {
        $this->markTestIncomplete();
    }
}
