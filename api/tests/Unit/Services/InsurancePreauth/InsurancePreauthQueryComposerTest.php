<?php

namespace Tests\Unit\Services\InsurancePreauth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsurancePreauthRepository;
use DentalSleepSolutions\Services\InsurancePreauth\InsurancePreauthQueryComposer;
use DentalSleepSolutions\Structs\ListVOBQueryData;
use Tests\TestCases\QueryComposerTestCase;

class InsurancePreauthQueryComposerTest extends QueryComposerTestCase
{
    /** @var ListVOBQueryData */
    private $queryData;

    /** @var InsurancePreauthQueryComposer */
    private $insurancePreauthQueryComposer;

    public function setUp()
    {
        $this->queryData = new ListVOBQueryData();
        $this->queryData->sortColumn = 'column 1';
        $this->queryData->sortDir = 'asc';
        $this->queryData->offset = 10;
        $this->queryData->vobsPerPage = 5;

        $mockedMethods = [
            'getListVobsBaseQuery',
            'getListVobsSetOrderBy',
            'getPagedResult',
            'getListVobsSetPreauthViewedWithViewed',
            'getListVobsSetPreauthViewedWithoutViewed',
        ];

        /** @var InsurancePreauthRepository $repository */
        $repository = $this->mockRepository(InsurancePreauthRepository::class, $mockedMethods);
        $this->insurancePreauthQueryComposer = new InsurancePreauthQueryComposer($repository);
    }

    public function testWithDataViewedNull()
    {
        $this->insurancePreauthQueryComposer->composeGetListVobsQuery($this->queryData);
        $expected = [
            InsurancePreauthRepository::class => [
                'getListVobsBaseQuery' => [
                    [$this->queryData],
                ],
                'getListVobsSetOrderBy' => [
                    ['column 1', 'asc'],
                ],
                'getPagedResult' => [
                    [10, 5],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithDataViewedTrue()
    {
        $this->queryData->viewed = true;
        $this->insurancePreauthQueryComposer->composeGetListVobsQuery($this->queryData);
        $expected = [
            InsurancePreauthRepository::class => [
                'getListVobsBaseQuery' => [
                    [$this->queryData],
                ],
                'getListVobsSetOrderBy' => [
                    ['column 1', 'asc'],
                ],
                'getPagedResult' => [
                    [10, 5],
                ],
                'getListVobsSetPreauthViewedWithViewed' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithDataViewedFalse()
    {
        $this->queryData->viewed = false;
        $this->insurancePreauthQueryComposer->composeGetListVobsQuery($this->queryData);
        $expected = [
            InsurancePreauthRepository::class => [
                'getListVobsBaseQuery' => [
                    [$this->queryData],
                ],
                'getListVobsSetOrderBy' => [
                    ['column 1', 'asc'],
                ],
                'getPagedResult' => [
                    [10, 5],
                ],
                'getListVobsSetPreauthViewedWithoutViewed' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithSortColumn()
    {
        $this->queryData->sortColumn = 'request_date';
        $this->insurancePreauthQueryComposer->composeGetListVobsQuery($this->queryData);
        $expected = [
            InsurancePreauthRepository::class => [
                'getListVobsBaseQuery' => [
                    [$this->queryData],
                ],
                'getListVobsSetOrderBy' => [
                    ['preauth.front_office_request_date', 'asc'],
                ],
                'getPagedResult' => [
                    [10, 5],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }
}
