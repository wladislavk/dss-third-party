<?php

namespace Tests\Unit\Services\Patients;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Services\Patients\PatientSummaryUpdater;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientSummaryUpdaterTest extends UnitTestCase
{
    /** @var array */
    private $createdData = [];

    /** @var array */
    private $updatedData = [];

    /** @var PatientSummaryUpdater */
    private $patientSummaryUpdater;

    public function setUp()
    {
        $ledgerRepository = $this->mockLedgerRepository();
        $patientSummaryRepository = $this->mockPatientSummaryRepository();
        $this->patientSummaryUpdater = new PatientSummaryUpdater($ledgerRepository, $patientSummaryRepository);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreate()
    {
        $docId = 1;
        $patientId = 2;
        $result = $this->patientSummaryUpdater->updatePatientSummary($docId, $patientId);
        $this->assertEquals(PatientSummaryUpdater::CREATED, $result);
        $expected = [
            'pid' => 2,
            'ledger' => 0,
        ];
        $this->assertEquals($expected, $this->createdData);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdate()
    {
        $docId = 1;
        $patientId = 1;
        $result = $this->patientSummaryUpdater->updatePatientSummary($docId, $patientId);
        $this->assertEquals(PatientSummaryUpdater::UPDATED, $result);
        $expected = [
            'ledger' => 7,
        ];
        $this->assertEquals($expected, $this->updatedData);
    }

    private function mockLedgerRepository()
    {
        /** @var LedgerRepository|MockInterface $ledgerRepository */
        $ledgerRepository = \Mockery::mock(LedgerRepository::class);
        $ledgerRepository->shouldReceive('getRowsForCountingLedgerBalance')
            ->andReturnUsing(function () {
                $firstRow = new \stdClass();
                $firstRow->amount = 3;
                $firstRow->paid_amount = 10;
                $secondRow = new \stdClass();
                return [$firstRow, $secondRow];
            });
        return $ledgerRepository;
    }

    private function mockPatientSummaryRepository()
    {
        /** @var PatientSummaryRepository|MockInterface $patientSummaryRepository */
        $patientSummaryRepository = \Mockery::mock(PatientSummaryRepository::class);
        $patientSummaryRepository->shouldReceive('getPatientInfo')
            ->andReturnUsing(function ($patientId) {
                if ($patientId == 1) {
                    return true;
                }
                return false;
            });
        $patientSummaryRepository->shouldReceive('create')
            ->andReturnUsing(function (array $data) {
                $this->createdData = $data;
            });
        $patientSummaryRepository->shouldReceive('updatePatientSummary')
            ->andReturnUsing(function ($patientId, array $data) {
                $this->updatedData = $data;
            });
        return $patientSummaryRepository;
    }
}
