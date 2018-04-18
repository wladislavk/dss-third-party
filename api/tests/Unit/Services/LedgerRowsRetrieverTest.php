<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\MissingElementException;
use DentalSleepSolutions\Exceptions\ObjectTypeException;
use DentalSleepSolutions\Services\LedgerRowsRetriever;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use DentalSleepSolutions\Structs\LedgerReportData;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LedgerRowsRetrieverTest extends UnitTestCase
{
    /** @var array */
    private $todayData = [];

    /** @var array */
    private $fullData = [];

    /** @var LedgerRowsRetriever */
    private $ledgerRowsRetriever;

    public function setUp()
    {
        $todayResult = new Collection();
        $todayResult->push(['patientid' => 1]);
        $todayResult->push(['patientid' => 2]);
        $this->todayData = [
            'total' => 2,
            'result' => $todayResult,
        ];

        $fullResult = new Collection();
        $fullResult->push(['patientid' => 3]);
        $fullResult->push(['patientid' => 4]);
        $this->fullData = [
            'total' => 2,
            'result' => $fullResult,
        ];

        $ledgerRepository = $this->mockLedgerRepository();
        $patientRepository = $this->mockPatientRepository();
        $this->ledgerRowsRetriever = new LedgerRowsRetriever($ledgerRepository, $patientRepository);
    }

    public function testWithTodayList()
    {
        $data = new LedgerReportData();
        $reportType = LedgersController::REPORT_TYPE_TODAY;
        $result = $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
        $expected = [
            'total' => 2,
            'result' => new Collection([
                [
                    'patientid' => 1,
                    'patient_info' => 1,
                ],
                [
                    'patientid' => 2,
                    'patient_info' => null,
                ],
            ]),
        ];
        $this->assertEquals($expected, $result);
    }

    public function testWithFullList()
    {
        $data = new LedgerReportData();
        $reportType = 'foo';
        $result = $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
        $expected = [
            'total' => 2,
            'result' => new Collection([
                [
                    'patientid' => 3,
                    'patient_info' => 1,
                ],
                [
                    'patientid' => 4,
                    'patient_info' => null,
                ],
            ]),
        ];
        $this->assertEquals($expected, $result);
    }

    public function testWithZeroResult()
    {
        $this->fullData = [
            'total' => 0,
            'result' => new Collection(),
        ];

        $data = new LedgerReportData();
        $reportType = 'foo';
        $result = $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
        $this->assertEquals($this->fullData, $result);
    }

    public function testWithoutTotal()
    {
        $this->fullData = [
            'result' => new Collection(),
        ];

        $data = new LedgerReportData();
        $reportType = 'foo';
        $this->expectException(MissingElementException::class);
        $this->expectExceptionMessage('Rows array must contain keys \'total\', \'result\'');
        $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
    }

    public function testWithoutResult()
    {
        $this->fullData = [
            'total' => 0,
        ];

        $data = new LedgerReportData();
        $reportType = 'foo';
        $this->expectException(MissingElementException::class);
        $this->expectExceptionMessage('Rows array must contain keys \'total\', \'result\'');
        $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
    }

    public function testWithNonCollectionResult()
    {
        $this->fullData = [
            'total' => 0,
            'result' => 'string',
        ];

        $data = new LedgerReportData();
        $reportType = 'foo';
        $this->expectException(ObjectTypeException::class);
        $this->expectExceptionMessage('Result must be of type or extend ' . Collection::class);
        $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
    }

    public function testWithoutPatientId()
    {
        $fullResult = new Collection();
        $fullResult->push(['foo' => 'bar']);
        $this->fullData = [
            'total' => 2,
            'result' => $fullResult,
        ];

        $data = new LedgerReportData();
        $reportType = 'foo';
        $this->expectException(MissingElementException::class);
        $this->expectExceptionMessage('Each row must contain key \'patientid\'');
        $this->ledgerRowsRetriever->getLedgerRows($data, $reportType);
    }

    private function mockLedgerRepository()
    {
        /** @var LedgerRepository|MockInterface $ledgerRepository */
        $ledgerRepository = \Mockery::mock(LedgerRepository::class);
        $ledgerRepository->shouldReceive('getTodayList')
            ->andReturnUsing(function () {
                return $this->todayData;
            });
        $ledgerRepository->shouldReceive('getFullList')
            ->andReturnUsing(function () {
                return $this->fullData;
            });
        return $ledgerRepository;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getWithFilter')
            ->andReturnUsing(function (array $fields, array $where) {
                if ($where['patientid'] == 1 || $where['patientid'] == 3) {
                    return [1, 2];
                }
                return null;
            });
        return $patientRepository;
    }
}
