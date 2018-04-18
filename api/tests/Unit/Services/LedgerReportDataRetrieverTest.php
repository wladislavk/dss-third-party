<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Services\LedgerReportDataRetriever;
use DentalSleepSolutions\Services\QueryComposers\LedgersQueryComposer;
use DentalSleepSolutions\Structs\LedgerReportData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LedgerReportDataRetrieverTest extends UnitTestCase
{
    /** @var LedgerReportDataRetriever */
    private $ledgerReportDataRetriever;

    public function setUp()
    {
        $ledgersQueryComposer = $this->mockLedgersQueryComposer();
        $insuranceRepository = $this->mockInsuranceRepository();
        $this->ledgerReportDataRetriever = new LedgerReportDataRetriever(
            $ledgersQueryComposer, $insuranceRepository
        );
    }

    public function testWithOpenClaims()
    {
        $ledgerReportData = new LedgerReportData();
        $ledgerReportData->patientId = 1;
        $result = $this->ledgerReportDataRetriever->getReportData($ledgerReportData, true);
        $this->assertEquals(1, $result['patient_id']);
    }

    public function testWithoutOpenClaims()
    {
        $ledgerReportData = new LedgerReportData();
        $ledgerReportData->patientId = 1;
        $result = $this->ledgerReportDataRetriever->getReportData($ledgerReportData, false);
        $this->assertEquals(2, $result['patient_id']);
    }

    private function mockLedgersQueryComposer()
    {
        /** @var LedgersQueryComposer|MockInterface $ledgersQueryComposer */
        $ledgersQueryComposer = \Mockery::mock(LedgersQueryComposer::class);
        $ledgersQueryComposer->shouldReceive('getReportData')
            ->andReturnUsing(function (LedgerReportData $data) {
                $data->patientId++;
                return $data->toArray();
            });
        return $ledgersQueryComposer;
    }

    private function mockInsuranceRepository()
    {
        /** @var InsuranceRepository|MockInterface $insuranceRepository */
        $insuranceRepository = \Mockery::mock(InsuranceRepository::class);
        $insuranceRepository->shouldReceive('getOpenClaims')
            ->andReturnUsing(function (LedgerReportData $data) {
                return $data->toArray();
            });
        return $insuranceRepository;
    }
}
