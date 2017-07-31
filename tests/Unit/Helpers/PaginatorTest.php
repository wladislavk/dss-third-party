<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCases\UnitTestCase;

class PaginatorTest extends UnitTestCase
{
    /** @var Paginator */
    private $paginator;

    public function setUp()
    {
        $this->paginator = new Paginator();
    }

    public function testWithArray()
    {
        $array = [
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
        ];
        $page = 2;
        $recordsPerPage = 3;
        $result = $this->paginator->limitResultToPage($array, $page, $recordsPerPage);
        $expected = [
            'fourth',
            'fifth',
            'sixth',
        ];
        $this->assertEquals($expected, $result);
    }

    public function testWithArrayAndZeroethPage()
    {
        $array = [
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
        ];
        $page = 0;
        $recordsPerPage = 3;
        $result = $this->paginator->limitResultToPage($array, $page, $recordsPerPage);
        $expected = [
            'first',
            'second',
            'third',
        ];
        $this->assertEquals($expected, $result);
    }

    public function testWithCollection()
    {
        $collection = new Collection();
        $collection->add('first');
        $collection->add('second');
        $collection->add('third');
        $collection->add('fourth');
        $collection->add('fifth');
        $collection->add('sixth');
        $collection->add('seventh');
        $page = 2;
        $recordsPerPage = 3;
        $result = $this->paginator->limitResultToPage($collection, $page, $recordsPerPage);
        $expected = [
            'fourth',
            'fifth',
            'sixth',
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testWithoutRecordsPerPage()
    {
        $array = [
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
        ];
        $page = 2;
        $recordsPerPage = 0;
        $result = $this->paginator->limitResultToPage($array, $page, $recordsPerPage);
        $this->assertEquals($array, $result);
    }

    public function testWithBadArgument()
    {
        $collection = 'foo';
        $page = 2;
        $recordsPerPage = 3;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Collection must be either array or object of type ' . Collection::class);
        $this->paginator->limitResultToPage($collection, $page, $recordsPerPage);
    }
}
