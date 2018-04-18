<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LedgerDescriptionModifierFactory;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\AbstractDescriptionModifier;
use DentalSleepSolutions\Services\LedgerReportTotalsRetriever;
use DentalSleepSolutions\Services\QueryComposers\LedgersQueryComposer;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LedgerReportTotalsRetrieverTest extends UnitTestCase
{
    /** @var Collection */
    private $creditsType;

    /** @var Collection */
    private $creditsNamed;

    /** @var LedgerReportTotalsRetriever */
    private $ledgerReportTotalsRetriever;

    public function setUp()
    {
        $this->creditsType = new Collection([
            [
                'payment_description' => 1,
                'payment_payer' => 1,
            ],
            [
                'payment_description' => 2,
                'payment_payer' => 2,
            ],
        ]);
        $this->creditsNamed = new Collection([
            [
                'payment_description' => 'third description',
                'payment_type' => 3,
            ],
            [
                'payment_description' => '',
                'payment_type' => 4,
            ],
        ]);

        $ledgerRepository = $this->mockLedgerRepository();
        $ledgersQueryComposer = $this->mockLedgersQueryComposer();
        $ledgerDescriptionModifierFactory = $this->mockLedgerDescriptionModifierFactory();
        $this->ledgerReportTotalsRetriever = new LedgerReportTotalsRetriever(
            $ledgerRepository, $ledgersQueryComposer, $ledgerDescriptionModifierFactory
        );
    }

    public function testWithCustomReportType()
    {
        $docId = 1;
        $patientId = 2;
        $reportType = 'foo';
        $result = $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
        $expected = [
            'credits' => [
                'docId' => 1,
                'type' => 'unspecified',
            ],
            'charges' => [],
            'adjustments' => [],
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testWithReportTypeToday()
    {
        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_TODAY;
        $result = $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
        $expected = [
            'credits' => [
                'type' => $this->creditsType,
                'named' => $this->creditsNamed,
            ],
            'charges' => [
                'docId' => 1,
                'patientId' => 2,
                'type' => LedgersController::REPORT_TYPE_TODAY,
            ],
            'adjustments' => [
                'docId' => 1,
                'patientId' => 2,
                'type' => LedgersController::REPORT_TYPE_TODAY,
            ],
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testWithReportTypeFull()
    {
        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;
        $result = $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);

        $newType = $this->creditsType->toArray();
        $newType[0]['payment_description'] = 'modified Debit';
        $newType[1]['payment_description'] = 'modified Check';
        $newNamed = $this->creditsNamed->toArray();
        $newNamed[0]['payment_description'] = 'modified third description';
        $newNamed[1]['payment_description'] = 'modified ' . LedgerReportTotalsRetriever::UNLABELLED_TRANSACTION_DESCRIPTION;

        $expected = [
            'credits' => [
                'type' => new Collection($newType),
                'named' => new Collection($newNamed),
            ],
            'charges' => [
                'docId' => 1,
                'patientId' => 2,
                'type' => LedgersController::REPORT_TYPE_FULL,
            ],
            'adjustments' => [
                'docId' => 1,
                'patientId' => 2,
                'type' => LedgersController::REPORT_TYPE_FULL,
            ],
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testWithReportTypeFullAndNoTypePaymentDescription()
    {
        $creditsType = $this->creditsType->toArray();
        unset($creditsType[1]['payment_description']);
        $this->creditsType = new Collection($creditsType);

        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Each row must have \'payment_payer\' and \'payment_description\' elements');
        $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
    }

    public function testWithReportTypeFullAndNoPayer()
    {
        $creditsType = $this->creditsType->toArray();
        unset($creditsType[1]['payment_payer']);
        $this->creditsType = new Collection($creditsType);

        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Each row must have \'payment_payer\' and \'payment_description\' elements');
        $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
    }

    public function testWithReportTypeFullAndNoNamedPaymentDescription()
    {
        $creditsNamed = $this->creditsNamed->toArray();
        unset($creditsNamed[1]['payment_description']);
        $this->creditsNamed = new Collection($creditsNamed);

        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Each row must have \'payment_type\' and \'payment_description\' elements');
        $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
    }

    public function testWithReportTypeFullAndNoPaymentType()
    {
        $creditsNamed = $this->creditsNamed->toArray();
        unset($creditsNamed[1]['payment_type']);
        $this->creditsNamed = new Collection($creditsNamed);

        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Each row must have \'payment_type\' and \'payment_description\' elements');
        $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
    }

    public function testWithReportTypeFullAndBadTypePaymentDescription()
    {
        $creditsType = $this->creditsType->toArray();
        $creditsType[1]['payment_description'] = 10;
        $this->creditsType = new Collection($creditsType);

        $docId = 1;
        $patientId = 2;
        $reportType = LedgersController::REPORT_TYPE_FULL;

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Payment description must be one of values: 0, 1, 2, 3, 4, 5; 10 given');
        $this->ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);
    }

    private function mockLedgerRepository()
    {
        /** @var LedgerRepository|MockInterface $ledgerRepository */
        $ledgerRepository = \Mockery::mock(LedgerRepository::class);
        $ledgerRepository->shouldReceive('getTotalCreditsUnspecified')
            ->andReturnUsing(function ($docId) {
                return [
                    'docId' => $docId,
                    'type' => 'unspecified',
                ];
            });
        return $ledgerRepository;
    }

    private function mockLedgersQueryComposer()
    {
        /** @var LedgersQueryComposer|MockInterface $ledgersQueryComposer */
        $ledgersQueryComposer = \Mockery::mock(LedgersQueryComposer::class);
        $ledgersQueryComposer->shouldReceive('getTotalCharges')
            ->andReturnUsing(function ($type, $docId, $patientId) {
                return [
                    'docId' => $docId,
                    'patientId' => $patientId,
                    'type' => $type,
                ];
            });
        $ledgersQueryComposer->shouldReceive('getTotalAdjustments')
            ->andReturnUsing(function ($type, $docId, $patientId) {
                return [
                    'docId' => $docId,
                    'patientId' => $patientId,
                    'type' => $type,
                ];
            });
        $ledgersQueryComposer->shouldReceive('getTotalCreditsType')
            ->andReturnUsing(function ($type, $docId, $patientId) {
                return $this->creditsType;
            });
        $ledgersQueryComposer->shouldReceive('getTotalCreditsNamed')
            ->andReturnUsing(function ($type, $docId, $patientId) {
                return $this->creditsNamed;
            });
        return $ledgersQueryComposer;
    }

    private function mockLedgerDescriptionModifierFactory()
    {
        /** @var LedgerDescriptionModifierFactory|MockInterface $ledgerDescriptionModifierFactory */
        $ledgerDescriptionModifierFactory = \Mockery::mock(LedgerDescriptionModifierFactory::class);
        $ledgerDescriptionModifierFactory->shouldReceive('getModifier')
            ->andReturn($this->mockLedgerDescriptionModifier());
        return $ledgerDescriptionModifierFactory;
    }

    private function mockLedgerDescriptionModifier()
    {
        /** @var AbstractDescriptionModifier|MockInterface $ledgerDescriptionModifier */
        $ledgerDescriptionModifier = \Mockery::mock(AbstractDescriptionModifier::class);
        $ledgerDescriptionModifier->shouldReceive('modify')
            ->andReturnUsing(function ($description) {
                return 'modified ' . $description;
            });
        return $ledgerDescriptionModifier;
    }
}
