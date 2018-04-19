<?php

namespace Tests\Unit\Services\Ledger;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Services\Ledger\LedgersQueryComposer;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use DentalSleepSolutions\Http\Requests\Ledger;
use DentalSleepSolutions\Structs\LedgerReportData;
use Tests\TestCases\QueryComposerTestCase;

class LedgersQueryComposerTest extends QueryComposerTestCase
{
    /** @var LedgersQueryComposer */
    private $ledgersQueryComposer;

    public function setUp()
    {
        $methods = [
            'getTotalChargesBaseQuery',
            'getTotalAdjustmentsBaseQuery',
            'getTotalCreditsTypeBaseQuery',
            'getTotalsPatientIdQuery',
            'getTotalsPaymentDateQuery',
            'getTotalsQueryGroupByPaymentPayer',
            'getTotalCreditsNamedBaseQuery',
            'getTotalsQueryGroupByPaymentType',
            'getTotalsServiceDateQuery',
            'getTotalsCreditsTypeQueryForReportToday',
            'getTotalsCreditsTypeQueryForReportNotToday',
            'getTotalsCreditsNamedQueryForReportToday',
            'getTotalsCreditsNamedQueryForReportNotToday',
            'getReportDataBaseQuery',
            'getReportDataBaseQueryWithLedgerPaymentFirst',
            'getReportDataBaseQueryWithLedgerPaymentSecond',
            'getReportDataAddPatientId',
            'getLedgerNoteLedgerDetailsUserQuery',
            'getLedgerNoteLedgerDetailsAdminQuery',
            'getLedgerStatementLedgerDetailsQuery',
            'getInsuranceLedgerDetailsQuery',
            'getReportDataUnionQuery',
            'getReportRowsNumberBaseQuery',
            'getReportRowsNumberBaseQueryWithLedgerPaymentFirst',
            'getReportRowsNumberBaseQueryWithLedgerPaymentSecond',
            'getLedgerNoteLedgerDetailsUserCount',
            'getLedgerNoteLedgerDetailsAdminCount',
            'getLedgerStatementLedgerDetailsCount',
            'getInsuranceLedgerDetailsCount',
        ];
        /** @var LedgerRepository $ledgerRepository */
        $ledgerRepository = $this->mockRepository(LedgerRepository::class, $methods);
        $this->ledgersQueryComposer = new LedgersQueryComposer($ledgerRepository);
    }

    public function testGetTotalCharges()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCharges($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalChargesBaseQuery' => [
                    [1],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalChargesWithPatientId()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 2;
        $result = $this->ledgersQueryComposer->getTotalCharges($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalChargesBaseQuery' => [
                    [1],
                ],
                'getTotalsPatientIdQuery' => [
                    [2],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalChargesWithTodayType()
    {
        $type = LedgersController::REPORT_TYPE_TODAY;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCharges($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalChargesBaseQuery' => [
                    [1],
                ],
                'getTotalsServiceDateQuery' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalAdjustments()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalAdjustments($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalAdjustmentsBaseQuery' => [
                    [1],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalAdjustmentsWithPatientId()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 2;
        $result = $this->ledgersQueryComposer->getTotalAdjustments($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalAdjustmentsBaseQuery' => [
                    [1],
                ],
                'getTotalsPatientIdQuery' => [
                    [2],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalAdjustmentsWithTodayType()
    {
        $type = LedgersController::REPORT_TYPE_TODAY;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalAdjustments($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalAdjustmentsBaseQuery' => [
                    [1],
                ],
                'getTotalsServiceDateQuery' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsType()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsType($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsTypeBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsTypeQueryForReportNotToday' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsTypeWithPatientId()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 2;
        $result = $this->ledgersQueryComposer->getTotalCreditsType($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsTypeBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsTypeQueryForReportNotToday' => [
                    [],
                ],
                'getTotalsPatientIdQuery' => [
                    [2],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsTypeWithTodayType()
    {
        $type = LedgersController::REPORT_TYPE_TODAY;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsType($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsTypeBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsTypeQueryForReportToday' => [
                    [],
                ],
                'getTotalsPaymentDateQuery' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsTypeWithFullType()
    {
        $type = LedgersController::REPORT_TYPE_FULL;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsType($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsTypeBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsTypeQueryForReportNotToday' => [
                    [],
                ],
                'getTotalsQueryGroupByPaymentPayer' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsNamed()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsNamed($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsNamedBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsNamedQueryForReportNotToday' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsNamedWithPatientId()
    {
        $type = 'foo';
        $docId = 1;
        $patientId = 2;
        $result = $this->ledgersQueryComposer->getTotalCreditsNamed($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsNamedBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsNamedQueryForReportNotToday' => [
                    [],
                ],
                'getTotalsPatientIdQuery' => [
                    [2],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsNamedWithTodayType()
    {
        $type = LedgersController::REPORT_TYPE_TODAY;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsNamed($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsNamedBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsNamedQueryForReportToday' => [
                    [],
                ],
                'getTotalsServiceDateQuery' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetTotalCreditsNamedWithFullType()
    {
        $type = LedgersController::REPORT_TYPE_FULL;
        $docId = 1;
        $patientId = 0;
        $result = $this->ledgersQueryComposer->getTotalCreditsNamed($type, $docId, $patientId);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getTotalCreditsNamedBaseQuery' => [
                    [1],
                ],
                'getTotalsCreditsNamedQueryForReportNotToday' => [
                    [],
                ],
                'getTotalsQueryGroupByPaymentType' => [
                    [],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetReportData()
    {
        $data = new LedgerReportData();
        $data->patientId = 1;
        $data->docId = 2;
        $result = $this->ledgersQueryComposer->getReportData($data);
        $this->assertEquals([], $result);
        $expected = [
            LedgerRepository::class => [
                'getReportDataBaseQuery' => [
                    [$data],
                ],
                'getReportDataBaseQueryWithLedgerPaymentFirst' => [
                    [$data],
                ],
                'getReportDataBaseQueryWithLedgerPaymentSecond' => [
                    [$data],
                ],
                'getLedgerNoteLedgerDetailsUserQuery' => [
                    [1],
                ],
                'getLedgerNoteLedgerDetailsAdminQuery' => [
                    [1],
                ],
                'getLedgerStatementLedgerDetailsQuery' => [
                    [2, 1],
                ],
                'getInsuranceLedgerDetailsQuery' => [
                    [1],
                ],
                'getReportDataUnionQuery' => [
                    [$data],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetReportRowsNumberWithoutModel()
    {
        $patientId = 1;
        $docId = 2;
        $result = $this->ledgersQueryComposer->getReportRowsNumber($docId, $patientId);
        $this->assertEquals(0, $result);
        $expected = [
            LedgerRepository::class => [
                'getReportRowsNumberBaseQuery' => [
                    [2, 1],
                ],
                'getReportRowsNumberBaseQueryWithLedgerPaymentFirst' => [
                    [2, 1],
                ],
                'getReportRowsNumberBaseQueryWithLedgerPaymentSecond' => [
                    [2, 1],
                ],
                'getLedgerNoteLedgerDetailsUserCount' => [
                    [1],
                ],
                'getLedgerNoteLedgerDetailsAdminCount' => [
                    [1],
                ],
                'getLedgerStatementLedgerDetailsCount' => [
                    [1],
                ],
                'getInsuranceLedgerDetailsCount' => [
                    [1],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }

    public function testGetReportRowsNumberWithModel()
    {
        $this->firstResult = new Ledger();
        $this->firstResult->number = 1;
        $patientId = 1;
        $docId = 2;
        $result = $this->ledgersQueryComposer->getReportRowsNumber($docId, $patientId);
        $this->assertEquals(7, $result);
    }
}
