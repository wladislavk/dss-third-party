<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\Transactions;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LedgerDescriptionModifierFactory;
use DentalSleepSolutions\Helpers\QueryComposers\LedgersQueryComposer;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use DentalSleepSolutions\Structs\LedgerReportTotals;
use DentalSleepSolutions\Structs\LedgerReportTotalsCredits;

class LedgerReportTotalsRetriever
{
    const UNLABELLED_TRANSACTION_DESCRIPTION = 'Unlabelled transaction type';

    /** @var LedgerRepository */
    private $ledgerRepository;

    /** @var LedgersQueryComposer */
    private $ledgersQueryComposer;

    /** @var LedgerDescriptionModifierFactory */
    private $ledgerDescriptionModifierFactory;

    public function __construct(
        LedgerRepository $ledgerRepository,
        LedgersQueryComposer $ledgersQueryComposer,
        LedgerDescriptionModifierFactory $ledgerDescriptionModifierFactory
    ) {
        $this->ledgerRepository = $ledgerRepository;
        $this->ledgersQueryComposer = $ledgersQueryComposer;
        $this->ledgerDescriptionModifierFactory = $ledgerDescriptionModifierFactory;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @param string $reportType
     * @return LedgerReportTotals
     */
    public function getReportTotals($docId, $patientId, $reportType)
    {
        $totals = new LedgerReportTotals();

        if (!in_array($reportType, LedgersController::REPORT_TYPES)) {
            $totals->credits = $this->ledgerRepository->getTotalCreditsUnspecified($docId);
            return $totals;
        }

        $totals->charges = $this->ledgersQueryComposer->getTotalCharges($reportType, $docId, $patientId);
        $totals->adjustments = $this->ledgersQueryComposer->getTotalAdjustments($reportType, $docId, $patientId);

        $totals->credits = new LedgerReportTotalsCredits();
        $totals->credits->type = $this->ledgersQueryComposer->getTotalCreditsType($reportType, $docId, $patientId);
        $totals->credits->named = $this->ledgersQueryComposer->getTotalCreditsNamed($reportType, $docId, $patientId);

        if ($reportType != LedgersController::REPORT_TYPE_FULL) {
            return $totals;
        }

        $totals->credits->type = $totals->credits->type->map([$this, 'setTypePaymentDescription']);
        $totals->credits->named = $totals->credits->named->map([$this, 'setNamedPaymentDescription']);

        return $totals;
    }

    /**
     * @param array $row
     * @return array
     * @throws GeneralException
     */
    /*private*/ function setTypePaymentDescription(array $row)
    {
        if (!isset($row['payment_description']) || !isset($row['payment_payer'])) {
            throw new GeneralException('Each row must have \'payment_payer\' and \'payment_description\' elements');
        }

        if (!array_key_exists($row['payment_description'], Transactions::TRANSACTION_PAYMENT_TYPE_LABELS)) {
            $allLabels = join(', ', array_keys(Transactions::TRANSACTION_PAYMENT_TYPE_LABELS));
            throw new GeneralException("Payment description must be one of values: $allLabels; {$row['payment_description']} given");
        }
        $description = Transactions::TRANSACTION_PAYMENT_TYPE_LABELS[$row['payment_description']];

        $descriptionModifier = $this->ledgerDescriptionModifierFactory
            ->getModifier($row['payment_payer']);
        $description = $descriptionModifier->modify($description);

        $row['payment_description'] = $description;

        return $row;
    }

    /**
     * @param array $row
     * @return array
     * @throws GeneralException
     */
    /*private*/ function setNamedPaymentDescription(array $row)
    {
        if (!isset($row['payment_description']) || !isset($row['payment_type'])) {
            throw new GeneralException('Each row must have \'payment_type\' and \'payment_description\' elements');
        }

        $description = self::UNLABELLED_TRANSACTION_DESCRIPTION;
        if (trim($row['payment_description'])) {
            $description = trim($row['payment_description']);
        }

        $descriptionModifier = $this->ledgerDescriptionModifierFactory
            ->getModifier($row['payment_type']);
        $description = $descriptionModifier->modify($description);

        $row['payment_description'] = $description;

        return $row;
    }
}
