<?php

namespace Tests\Unit\Services\Patients;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\Patients\PatientsQueryComposer;
use DentalSleepSolutions\Structs\PatientFinderData;
use Tests\TestCases\QueryComposerTestCase;

class PatientsQueryComposerTest extends QueryComposerTestCase
{
    /** @var PatientFinderData */
    private $data;

    /** @var PatientsQueryComposer */
    private $patientsQueryComposer;

    public function setUp()
    {
        $this->data = new PatientFinderData();
        $this->data->pageNumber = 2;
        $this->data->patientsPerPage = 10;
        $this->data->patientId = 0;
        $this->data->type = 0;
        $this->data->letter = '';

        $methods = [
            'getFindPatientBaseQuery',
            'getFindPatientCountBaseQuery',
            'getFindPatientOrderBaseQuery',
            'paginateFindPatientQuery',
            'paginateFindPatientOrderQuery',
            'addDocIdToFindPatientQuery',
            'addLastNameToFindPatientQuery',
            'addPatientIdToFindPatientQuery',
            'addPatientIdsArrayToFindPatientQuery',
            'addStatusToFindPatientQuery',
            'addSeveralStatusesToFindPatientQuery',
        ];
        /** @var PatientRepository $patientRepository */
        $patientRepository = $this->mockRepository(PatientRepository::class, $methods);
        $this->patientsQueryComposer = new PatientsQueryComposer($patientRepository);
    }

    public function testComposeFindPatientQuery()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [];

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testComposeFindPatientCountQuery()
    {
        $tables = 'table';

        $result = $this->patientsQueryComposer->composeFindPatientCountQuery(
            $tables, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientCountBaseQuery' => [
                    ['table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testComposeFindPatientOrderQuery()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';

        $result = $this->patientsQueryComposer->composeFindPatientOrderQuery(
            $selections, $tables, $orderBy, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientOrderBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'paginateFindPatientOrderQuery' => [
                    ['order', 20, 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithPatientId()
    {
        $this->data->patientId = 1;
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [1,2];

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'addPatientIdToFindPatientQuery' => [
                    [1],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithMultiplePatientIds()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [1,2];

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'addPatientIdsArrayToFindPatientQuery' => [
                    [
                        [1,2],
                    ],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithScalarStatus()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [];
        $this->data->type = 3;

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'addStatusToFindPatientQuery' => [
                    [2],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithArrayStatus()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [];
        $this->data->type = 2;

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'addSeveralStatusesToFindPatientQuery' => [
                    [
                        [1,2],
                    ],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testWithLetter()
    {
        $selections = 'selection';
        $tables = 'table';
        $orderBy = 'order';
        $patientIds = [];
        $this->data->letter = 'foo';

        $result = $this->patientsQueryComposer->composeFindPatientQuery(
            $selections, $tables, $orderBy, $patientIds, $this->data
        );
        $this->assertEquals([], $result);
        $expected = [
            PatientRepository::class => [
                'getFindPatientBaseQuery' => [
                    ['selection', 'table'],
                ],
                'addDocIdToFindPatientQuery' => [
                    [0],
                ],
                'addLastNameToFindPatientQuery' => [
                    ['foo%'],
                ],
                'paginateFindPatientQuery' => [
                    ['order', 10],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }
}
