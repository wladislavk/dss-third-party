<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'includes/constants.inc';

$docId = intval($_SESSION['docid']);
$patientId = intval($_GET['pid']);
$trxnTypeAdjustment = $db->escape(DSS_TRXN_TYPE_ADJ);

$patientConditional = $patientId ? " AND dl.patientid = '$patientId' " : '';
$ledgerDateConditional = isset($l_date) && $l_date ? $l_date : '';
$paymentDateConditional = isset($p_date) && $p_date ? $p_date : '';

// ledger - from UNION
$chargesQuery = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        SUM(dl.amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid = dl.patientid
    WHERE dl.docid = '$docId'
        $patientConditional
        $ledgerDateConditional
        AND COALESCE(dl.paid_amount, 0) = 0
        AND dl.amount != 0
        GROUP BY payment_description";

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
