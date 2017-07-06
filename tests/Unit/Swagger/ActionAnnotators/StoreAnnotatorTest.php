<?php

namespace Tests\Unit\Swagger\ActionAnnotators;

use DentalSleepSolutions\Swagger\ActionAnnotators\StoreAnnotator;
use Tests\TestCases\UnitTestCase;

class StoreAnnotatorTest extends UnitTestCase
{
    /** @var StoreAnnotator */
    private $storeAnnotator;

    public function setUp()
    {
        $this->storeAnnotator = new StoreAnnotator();
    }

    public function testCreateAnnotation()
    {
        $this->markTestIncomplete();
    }
}
