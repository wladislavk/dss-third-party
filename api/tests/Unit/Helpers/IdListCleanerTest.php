<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\IdListCleaner;
use Tests\TestCases\UnitTestCase;

class IdListCleanerTest extends UnitTestCase
{
    /** @var IdListCleaner */
    private $idListCleaner;

    public function setUp()
    {
        $this->idListCleaner = new IdListCleaner();
    }

    public function testWithoutStringList()
    {
        $string = null;
        $parsed = $this->idListCleaner->clearIdList($string);
        $this->assertNull($parsed);
    }

    public function testWithEmptyList()
    {
        $string = '';
        $parsed = $this->idListCleaner->clearIdList($string);
        $this->assertNull($parsed);
    }

    public function testWithCommaList()
    {
        $string = ',,,';
        $parsed = $this->idListCleaner->clearIdList($string);
        $this->assertNull($parsed);
    }

    public function testClearIdList()
    {
        $string = '1,,,2,3';
        $parsed = $this->idListCleaner->clearIdList($string);
        $this->assertEquals('1,2,3', $parsed);
    }
}
