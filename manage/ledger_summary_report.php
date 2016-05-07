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

$chargesQuery = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        TRUNCATE(SUM(COALESCE(dl.amount, 0)), 2) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_insurance claim ON claim.insuranceid = dl.primary_claim_id
            AND claim.mailed_date IS NOT NULL
    WHERE dl.docid = '$docId'
        $andPatientConditional
        $andLedgerDateConditional
    GROUP BY payment_description
    ";

$creditsQuery = "SELECT
        COALESCE(dlp.payment_type, '0') AS payment_description,
        TRUNCATE(SUM(COALESCE(dlp.amount, 0)), 2) AS payment_amount,
        COALESCE(dlp.payer, '') AS payment_payer,
        1 AS rectify_description
    FROM dental_ledger dl
        JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id
            AND di.mailed_date IS NOT NULL
        JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    WHERE dl.docid = '$docId'
        $andPatientConditional
        AND COALESCE(dlp.payment_type, 0) != '$trxnTypeWriteOff'
        $andPaymentDateConditional
    GROUP BY payment_description, payment_payer
    ";

$adjustmentsQuery = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        TRUNCATE(SUM(COALESCE(dl.paid_amount, 0)), 2) AS payment_amount,
        COALESCE(tc.type, '') AS payment_payer,
        1 AS rectify_description
    FROM dental_ledger dl
        JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id
            AND di.mailed_date IS NOT NULL
        LEFT JOIN dental_transaction_code tc ON (
            tc.transaction_code = dl.transaction_code
            OR tc.description = dl.description
        )
    WHERE dl.docid = '$docId'
        $andPatientConditional
        $andLedgerDateConditional
    GROUP BY dl.description
    
    UNION
    
    SELECT
        COALESCE(dlp.payment_type, '0') AS payment_description,
        TRUNCATE(SUM(COALESCE(dlp.amount, 0)), 2) AS payment_amount,
        COALESCE(dlp.payer, '') AS payment_payer,
        0 AS rectify_description
    FROM dental_ledger dl
        JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id
            AND di.mailed_date IS NOT NULL
        JOIN dental_ledger_payment dlp
            ON dlp.ledgerid = dl.ledgerid
    WHERE dl.docid = '$docId'
        $andPatientConditional
        $andPaymentDateConditional
        AND dlp.payment_type = '$trxnTypeWriteOff'
    GROUP BY dlp.payment_type
    ";

$chargeItems = $db->getResults($chargesQuery);
$creditItems = $db->getResults($creditsQuery);
$adjustmentItems = $db->getResults($adjustmentsQuery);

// Set proper values of labels in credit items
foreach (['credit'] as $name) {
    array_walk(${"{$name}Items"}, function (&$item) use ($dss_trxn_payer_labels, $dss_trxn_pymt_type_labels) {
        if (!empty($item['rectify_description'])) {
            return;
        }

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
}

array_walk($adjustmentItems, function (&$item) {
    if (empty($item['rectify_description'])) {
        return;
    }

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

// dd($adjustmentItems);

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
