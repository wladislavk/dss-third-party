<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\DestroyAnnotator;
use Tests\TestCases\UnitTestCase;

class DestroyAnnotatorTest extends UnitTestCase
{
    /** @var DestroyAnnotator */
    private $destroyAnnotator;

    public function setUp()
    {
        $this->destroyAnnotator = new DestroyAnnotator();
    }

    public function testCreateAnnotation()
    {
        $this->markTestIncomplete();
    }
}
