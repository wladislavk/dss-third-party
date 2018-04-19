<?php

namespace Tests\Unit\Services\Patients;

use DentalSleepSolutions\Eloquent\Repositories\Factories\FindPatientQuerySectionFactory;
use DentalSleepSolutions\Services\Patients\PatientFinder;
use DentalSleepSolutions\Services\Patients\PatientsQueryComposer;
use DentalSleepSolutions\Structs\PatientFinderData;
use Mockery\MockInterface;
use Tests\Dummies\FindPatientQuerySections\FirstSection;
use Tests\Dummies\FindPatientQuerySections\SecondSection;
use Tests\TestCases\UnitTestCase;

class PatientFinderTest extends UnitTestCase
{
    const QUERY_SECTIONS = [
        'first' => FirstSection::class,
        'second' => SecondSection::class,
    ];

    /** @var int|null */
    private $patientId;

    /** @var PatientFinderData */
    private $patientFinderData;

    /** @var PatientFinder */
    private $patientFinder;

    public function setUp()
    {
        $this->patientFinderData = new PatientFinderData();

        $patientsQueryComposer = $this->mockPatientsQueryComposer();
        $findPatientQuerySectionFactory = $this->mockFindPatientQuerySectionFactory();
        $this->patientFinder = new PatientFinder($patientsQueryComposer, $findPatientQuerySectionFactory);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\RepositoryFactoryException
     */
    public function testFindPatient()
    {
        $this->patientFinderData->sortColumn = 'first';
        $this->patientFinderData->sortDir = 'asc';
        $this->patientFinderData->userType = 2;

        $result = $this->patientFinder->findPatientBy($this->patientFinderData);
        $expectedCount = [
            'tables' => 'dental_patients p LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid',
        ];
        $this->assertEquals($expectedCount, $result['count']);
        $expectedOrder = [
            'selections' => 'p.patientid, summary.vob, summary.ledger AS ledger, summary.patient_info AS patient_info',
            'tables' => 'dental_patients p LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid',
            'orderBy' => '',
        ];
        $this->assertEquals($expectedOrder, $result['order']);
        $expectedResults = [
            'selections' => 'p.patientid, summary.vob, summary.ledger AS ledger, summary.patient_info AS patient_info, 2 select SQL, p.*',
            'tables' => 'dental_patients p join SQL',
            'orderBy' => '',
            'patientIds' => [null, null, null],
        ];
        $this->assertEquals($expectedResults, $result['results']);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\RepositoryFactoryException
     */
    public function testWithOrderSelectAndJoinSQL()
    {
        $this->patientFinderData->sortColumn = 'second';
        $this->patientFinderData->sortDir = 'asc';
        $this->patientFinderData->userType = 2;

        $result = $this->patientFinder->findPatientBy($this->patientFinderData);
        $expectedCount = [
            'tables' => 'dental_patients p LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid join SQL',
        ];
        $this->assertEquals($expectedCount, $result['count']);
        $expectedOrder = [
            'selections' => 'p.patientid, summary.vob, summary.ledger AS ledger, summary.patient_info AS patient_info, 2 select SQL',
            'tables' => 'dental_patients p LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid join SQL',
            'orderBy' => 'order SQL asc',
        ];
        $this->assertEquals($expectedOrder, $result['order']);
        $expectedResults = [
            'selections' => 'p.patientid, summary.vob, summary.ledger AS ledger, summary.patient_info AS patient_info, 2 select SQL, p.*',
            'tables' => 'dental_patients p join SQL',
            'orderBy' => 'order SQL asc',
            'patientIds' => [null, null, null],
        ];
        $this->assertEquals($expectedResults, $result['results']);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\RepositoryFactoryException
     */
    public function testWithPatientIds()
    {
        $this->patientId = 1;
        $this->patientFinderData->sortColumn = 'second';
        $this->patientFinderData->sortDir = 'asc';
        $this->patientFinderData->userType = 2;

        $result = $this->patientFinder->findPatientBy($this->patientFinderData);
        $expectedIds = [null, null, null, 1];
        $this->assertEquals($expectedIds, $result['results']['patientIds']);
    }

    private function mockPatientsQueryComposer()
    {
        /** @var PatientsQueryComposer|MockInterface $patientsQueryComposer */
        $patientsQueryComposer = \Mockery::mock(PatientsQueryComposer::class);
        $patientsQueryComposer->shouldReceive('composeFindPatientCountQuery')
            ->andReturnUsing(function ($tables) {
                return [
                    'tables' => $tables,
                ];
            });
        $patientsQueryComposer->shouldReceive('composeFindPatientOrderQuery')
            ->andReturnUsing(function ($selections, $tables, $orderBy) {
                $result = [
                    'selections' => $selections,
                    'tables' => $tables,
                    'orderBy' => $orderBy,
                ];
                if ($this->patientId) {
                    $result[]['patientid'] = $this->patientId;
                }
                return $result;
            });
        $patientsQueryComposer->shouldReceive('composeFindPatientQuery')
            ->andReturnUsing(function ($selections, $tables, $orderBy, $patientIds) {
                return [
                    'selections' => $selections,
                    'tables' => $tables,
                    'orderBy' => $orderBy,
                    'patientIds' => $patientIds,
                ];
            });
        return $patientsQueryComposer;
    }

    private function mockFindPatientQuerySectionFactory()
    {
        /** @var FindPatientQuerySectionFactory|MockInterface $findPatientQuerySectionFactory */
        $findPatientQuerySectionFactory = \Mockery::mock(FindPatientQuerySectionFactory::class);
        $findPatientQuerySectionFactory->shouldReceive('getQuerySection')
            ->andReturnUsing(function ($column) {
                $className = self::QUERY_SECTIONS[$column];
                return new $className();
            });
        $findPatientQuerySectionFactory->shouldReceive('getAllSections')
            ->andReturnUsing(function () {
                $objects = [];
                foreach (self::QUERY_SECTIONS as $section) {
                    $objects[] = new $section();
                }
                return $objects;
            });
        return $findPatientQuerySectionFactory;
    }
}
