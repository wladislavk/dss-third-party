<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Helpers\PatientSummaryUpdater;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientSummaryUpdaterTest extends UnitTestCase
{
    private const DOC_ID = 1;
    private const PATIENT_ID = 2;
    private const EXISTING_PATIENT_ID = 22;
    private const AMOUNT = 3;
    private const PAID_AMOUNT = 10;

    /** @var PatientSummary|null */
    private $savedSummary;

    /** @var PatientSummary|null */
    private $existingSummary;

    /** @var PatientSummaryUpdater */
    private $patientSummaryUpdater;

    public function setUp()
    {
        $ledgerRepository = $this->mockLedgerRepository();
        $patientSummaryRepository = $this->mockPatientSummaryRepository();
        $dbChangeWrapper = $this->mockDbChangeWrapper();
        $this->patientSummaryUpdater = new PatientSummaryUpdater(
            $ledgerRepository, $patientSummaryRepository, $dbChangeWrapper
        );
    }

    public function testCreate()
    {
        $result = $this->patientSummaryUpdater->updatePatientSummary(self::DOC_ID, self::PATIENT_ID);
        $this->assertEquals(PatientSummaryUpdater::CREATED, $result);
        $this->assertEquals(self::PATIENT_ID, $this->savedSummary->pid);
        $this->assertEquals(0, $this->savedSummary->ledger);
    }

    public function testUpdate()
    {
        $this->existingSummary = new PatientSummary();
        $this->existingSummary->pid = self::EXISTING_PATIENT_ID;

        $result = $this->patientSummaryUpdater->updatePatientSummary(self::DOC_ID, self::PATIENT_ID);
        $this->assertEquals(PatientSummaryUpdater::UPDATED, $result);
        $this->assertEquals(self::EXISTING_PATIENT_ID, $this->savedSummary->pid);
        $this->assertEquals(7, $this->savedSummary->ledger);
    }

    private function mockLedgerRepository()
    {
        /** @var LedgerRepository|MockInterface $ledgerRepository */
        $ledgerRepository = \Mockery::mock(LedgerRepository::class);
        $ledgerRepository->shouldReceive('getRowsForCountingLedgerBalance')
            ->andReturnUsing(function () {
                $firstRow = new \stdClass();
                $firstRow->amount = self::AMOUNT;
                $firstRow->paid_amount = self::PAID_AMOUNT;
                $secondRow = new \stdClass();
                return [$firstRow, $secondRow];
            });
        return $ledgerRepository;
    }

    private function mockPatientSummaryRepository()
    {
        /** @var PatientSummaryRepository|MockInterface $patientSummaryRepository */
        $patientSummaryRepository = \Mockery::mock(PatientSummaryRepository::class);
        $patientSummaryRepository->shouldReceive('getOneBy')->andReturnUsing(function () {
            return $this->existingSummary;
        });
        return $patientSummaryRepository;
    }

    private function mockDbChangeWrapper()
    {
        /** @var DBChangeWrapper|MockInterface $dbChangeWrapper */
        $dbChangeWrapper = \Mockery::mock(DBChangeWrapper::class);
        $dbChangeWrapper->shouldReceive('save')->andReturnUsing(function (PatientSummary $summary) {
            $this->savedSummary = $summary;
        });
        return $dbChangeWrapper;
    }
}
