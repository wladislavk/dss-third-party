<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/admin/includes/ledger-functions.php';

$docId = intval($_SESSION['docid']);
$patientId = intval($_GET['pid']);
$trxnTypeAdjustment = $db->escape(DSS_TRXN_TYPE_ADJ);

$andPatientConditional = $patientId ? " AND dl.patientid = '$patientId' " : '';
$andLedgerDateConditional = isset($l_date) && $l_date ? $l_date : '';
$andPaymentDateConditional = isset($p_date) && $p_date ? $p_date : '';

if (!empty($_GET['mailed'])) {
    $andMailedOnlyConditional = 'AND di.mailed_date IS NOT NULL';
    $mailedOnlyJoin = "JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id $andMailedOnlyConditional";
} else {
    $andMailedOnlyConditional = '';
    $mailedOnlyJoin = '';
}

$trxnTypeWriteOff = DSS_TRXN_PYMT_WRITEOFF;

$debits = $db->getResults("SELECT
        COALESCE(dl.description, '') AS payment_description,
        TRUNCATE(SUM(COALESCE(dl.amount, 0)), 2) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_insurance claim ON claim.insuranceid = dl.primary_claim_id
            AND claim.mailed_date IS NOT NULL
    WHERE claim.docid = '$docId'
        $andPatientConditional
        $andLedgerDateConditional
    GROUP BY payment_description
    ");

$credits = $db->getResults("SELECT credits.payer, credits.payment_type, TRUNCATE(SUM(COALESCE(credits.amount, 0)), 2) AS total
    FROM dental_ledger credits_base
        JOIN dental_insurance claim ON claim.insuranceid = credits_base.primary_claim_id
            AND claim.mailed_date IS NOT NULL
        JOIN dental_ledger_payment credits ON credits.ledgerid = credits_base.ledgerid
    WHERE claim.docid = '$docId'
        AND claim.patientid = '$patientId'
        AND COALESCE(credits.payment_type, 0) != '$trxnTypeWriteOff'
    GROUP BY credits.payment_type
    ");

$adjustments = $db->getResults("SELECT adjustments.description, TRUNCATE(SUM(COALESCE(adjustments.paid_amount, 0)), 2) AS total
    FROM dental_ledger adjustments
        JOIN dental_insurance claim ON claim.insuranceid = adjustments.primary_claim_id
            AND claim.mailed_date IS NOT NULL
    WHERE claim.docid = '$docId'
        AND claim.patientid = '$patientId'
    GROUP BY adjustments.description
    
    UNION
    
    SELECT adjustment_payments.payment_type, TRUNCATE(SUM(COALESCE(adjustment_payments.amount, 0)), 2) AS total
    FROM dental_ledger adjustment_payments_base
        JOIN dental_insurance claim ON claim.insuranceid = adjustment_payments_base.primary_claim_id
            AND claim.mailed_date IS NOT NULL
        JOIN dental_ledger_payment adjustment_payments
            ON adjustment_payments.ledgerid = adjustment_payments_base.ledgerid
    WHERE claim.docid = '$docId'
        AND claim.patientid = '$patientId'
        AND adjustment_payments.payment_type = '$trxnTypeWriteOff'
    GROUP BY adjustment_payments.payment_type
    ");

// ledger - from UNION


// ledger_payment - from UNION
$creditsTypeQuery = "SELECT
        COALESCE(dlp.payment_type, '0') AS payment_description,
        SUM(dlp.amount) AS payment_amount,
        COALESCE(dlp.payer, '') AS payment_payer
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid = dl.patientid
        LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    WHERE dl.docid = '$docId'
        $patientConditional
        AND dlp.amount != 0
        $paymentDateConditional
        GROUP BY payment_description, payment_payer";

// ledger_paid - from UNION
$creditsNamedQuery = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        SUM(dl.paid_amount) AS payment_amount,
        tc.type AS payment_type
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid = dl.patientid
        LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
            AND tc.docid = '$docId'
    WHERE dl.docid = '$docId'
        $patientConditional
        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
        AND COALESCE(tc.type, '') != '$trxnTypeAdjustment'
        $ledgerDateConditional
        GROUP BY payment_type, payment_description";

// ledger_paid - from UNION -- but, tx.type conditional INVERTED
// No need to use COALESCE(tc.type, '') because we WANT TO IGNORE null values
$adjustmentsQuery = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        SUM(dl.paid_amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid = dl.patientid
        LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
            AND tc.docid = '$docId'
    WHERE dl.docid = '$docId'
        $patientConditional
        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
        AND tc.type = '$trxnTypeAdjustment'
        $ledgerDateConditional
        GROUP BY payment_description";

$chargeItems = $db->getResults($chargesQuery);
$creditTypeItems = $db->getResults($creditsTypeQuery);
$creditNamedItems = $db->getResults($creditsNamedQuery);
$adjustmentItems = $db->getResults($adjustmentsQuery);

// Set proper values of labels in credit items
array_walk($creditTypeItems, function (&$item) use ($dss_trxn_payer_labels, $dss_trxn_pymt_type_labels) {
    $payer = $item['payment_payer'];
    $description = trim($dss_trxn_pymt_type_labels[$item['payment_description']]);

    $description = preg_match('/^checks?$/i', $description) ? 'Checks' : $description;

    switch ($payer) {
        case DSS_TRXN_PAYER_PRIMARY:
        case DSS_TRXN_PAYER_SECONDARY:
            $description = "Ins. $description";
            break;
        case DSS_TRXN_PAYER_PATIENT:
            $description = "Pt. $description";
            break;
        case DSS_TRXN_PAYER_WRITEOFF:
            $description = $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF];
            break;
    }

    $item['payment_description'] = $description;
});

array_walk($creditNamedItems, function (&$item) {
    $payer = $item['payment_type'];
    $description = strlen(trim($item['payment_description'])) ?
        trim($item['payment_description']) : 'Unlabelled transaction type';

    $description = preg_match('/^checks?$/i', $description) ? 'Checks' : $description;

    switch ($payer) {
        case DSS_TRXN_TYPE_INS:
            $description = "Ins. $description";
            break;
        case DSS_TRXN_TYPE_PATIENT:
            $description = "Pt. $description";
            break;
    }

    $item['payment_description'] = $description;
});

/**
 * @see DSS-246
 *
 * Merge credit arrays, "type" items precede named items
 */
$creditItems = [];

array_map(function ($each) use (&$creditItems) {
    $amount = $each['payment_amount'];
    $description = $each['payment_description'];

    $description = preg_replace('/^(Ins\. |Pt\. ){2}/', '$1', $description);

    if (!isset($creditItems[$description])) {
        $creditItems[$description] = [
            'payment_description' => $description,
            'payment_amount' => 0
        ];
    }

    $creditItems[$description]['payment_amount'] += $amount;
}, array_merge($creditTypeItems, $creditNamedItems));

// Calculate totals
$totalCharges = array_sum(array_pluck($chargeItems, 'payment_amount'));
$totalCredits = array_sum(array_pluck($creditItems, 'payment_amount'));
$totalAdjustments = array_sum(array_pluck($adjustmentItems, 'payment_amount'));

?>
<div class="fullwidth">
    <h3>Charges</h3>
    <ul>
        <?php foreach ($chargeItems as $item) {?>
            <li>
                <label><?= e($item['payment_description']) ?></label>
                $<?= number_format($item['payment_amount'], 2) ?>
            </li>
        <?php } ?>
        <li>
            <label>Charges Total</label>
            $<?= number_format($totalCharges, 2) ?>
        </li>
    </ul>

    <h3>Credit</h3>
    <ul>
        <?php foreach ($creditItems as $item) {?>
            <li>
                <label><?= e($item['payment_description']) ?></label>
                $<?= number_format($item['payment_amount'], 2) ?>
            </li>
        <?php } ?>
        <li>
            <label>Credits Total</label>
            $<?= number_format($totalCredits, 2) ?>
        </li>
    </ul>

    <h3>Adjustments</h3>
    <ul>
        <?php foreach ($adjustmentItems as $item) {?>
            <li>
                <label><?= e($item['payment_description']) ?></label>
                $<?= number_format($item['payment_amount'], 2) ?>
            </li>
        <?php } ?>
        <li>
            <label>Adjust. Total</label>
            $<?= number_format($totalAdjustments, 2) ?>
        </li>
    </ul>
</div>
