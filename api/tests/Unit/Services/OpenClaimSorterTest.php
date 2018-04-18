<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Services\OpenClaimSorter;
use Tests\TestCases\UnitTestCase;

class OpenClaimSorterTest extends UnitTestCase
{
    /** @var OpenClaimSorter */
    private $openClaimSorter;

    public function setUp()
    {
        $this->openClaimSorter = new OpenClaimSorter();
    }

    public function testGetSortColumn()
    {
        $sort = 'producer';
        $result = $this->openClaimSorter->getSortColumnForList($sort);
        $this->assertEquals(OpenClaimSorter::SORT_COLUMNS['producer'], $result);
    }

    public function testGetDefaultSortColumn()
    {
        $sort = 'foo';
        $result = $this->openClaimSorter->getSortColumnForList($sort);
        $this->assertEquals(OpenClaimSorter::DEFAULT_SORT_COLUMN, $result);
    }
}
