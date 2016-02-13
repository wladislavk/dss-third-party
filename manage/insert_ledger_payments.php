<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/authorization_functions.php';
require_once __DIR__ . '/admin/includes/claim_functions.php';
require_once __DIR__ . '/includes/claim_functions.php';

?>
<html>
<head>
</head>
<body>
<?php

if (!authorize($_POST['username'], $_POST['password'], DSS_USER_TYPE_ADMIN)) { ?>
    <script type="text/javascript">
        alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST');
        history.go(-1);
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

$newStatus = false;
$secondaryStatus = false;

$claimId = intval($_POST['claimid']);
$patientId = intval($_POST['patientid']);

$claimData = $db->getRow("SELECT *, REPLACE(i.total_charge, ',', '') AS amount_due
    FROM dental_insurance i
    WHERE i.insuranceid = '$claimId'");

$patientData = $db->getRow("SELECT *
    FROM dental_patients p
    WHERE p.patientid = '$patientId'");

$ledgerItems = $db->getResults("SELECT *
    FROM dental_ledger
    WHERE (primary_claim_id = '$claimId' OR secondary_claim_id = '$claimId')");

$trxnPayerPrimary = DSS_TRXN_PAYER_PRIMARY;
$amountPayment = $db->getColumn("SELECT SUM(lp.amount) AS payment
    FROM dental_ledger_payment lp
        JOIN dental_ledger dl ON lp.ledgerid = dl.ledgerid
    WHERE dl.primary_claim_id = '$claimId'
        AND lp.payer = '$trxnPayerPrimary'", 'payment');

$amountPayment = $amountPayment ?: 0;

$isPrimary = ClaimFormData::isPrimary($claimData['status']);
$statusType = $isPrimary ? 'primary' : 'secondary';

$paymentsToAdd = [];
$today = date('Y-m-d');

foreach ($ledgerItems as $row) {
    $ledgerId = $row['ledgerid'];

    if (!empty($_POST['payment_date_' . $ledgerId])) {
        $paymentDate = date('Y-m-d', strtotime($_POST['payment_date_' . $ledgerId]));
    } else {
        $paymentDate = null;
    }

    if ($_POST['amount_' . $ledgerId] != '') {
        $paymentsToAdd []= '(' . $db->escapeList([
            'ledgerid' => $ledgerId,
            'payment_date' => $paymentDate,
            'entry_date' => $today,
            'amount' => str_replace(',', '', $_POST['amount_' . $ledgerId]),
            'amount_allowed' => str_replace(',', '', $_POST['allowed_' . $ledgerId]),
            'payment_type' => $_POST['payment_type'],
            'payer' => $_POST['payer']
        ]) . ')';
    }
}

if ($paymentsToAdd) {
    $totalPayments = count($paymentsToAdd);
    $paymentsToAdd = join(', ', $paymentsToAdd);

    $paymentId = $db->getInsertId("INSERT INTO dental_ledger_payment (
            ledgerid,
            payment_date,
            entry_date,
            amount,
            amount_allowed,
            payment_type,
            payer
        ) VALUES $paymentsToAdd");

    $msg = "$totalPayments payments have been added.";
    echo "<br />";

    payment_history_update($paymentId, $_SESSION['userid'], '');
} elseif ($_POST['empty-claim']) {
    $msg = "No payments were added, the claim will be forcefully closed.";
    echo "<br />";
} else {
    $msg = "No payments were added. Please verify the amounts and try again.";
    echo "<br />";
}

if ($_POST['dispute'] == 1) { // Dispute
    $noteData = $db->escapeAssignmentList([
        'docid' => $_SESSION['docid'],
        'patientid' => $patientId,
        'producerid' => $_SESSION['userid'],
        'note' => "Insurance claim $claimId disputed because: {$_POST['dispute_reason']}."
    ]);

    $db->query("INSERT INTO dental_ledger_note
        SET service_date = CURDATE(), entry_date = CURDATE(), private = 1, $noteData");

    if (ClaimFormData::isStatus(['sent', 'paid-insurance', 'paid-patient'], $claimData['status'])) {
        if (ClaimFormData::isStatus('paid-patient', $claimData['status'])) {
            $newStatus = $isPrimary ? DSS_CLAIM_PATIENT_DISPUTE : DSS_CLAIM_SEC_PATIENT_DISPUTE;
        } else {
            $newStatus = $isPrimary ? DSS_CLAIM_DISPUTE : DSS_CLAIM_SEC_DISPUTE;
        }

        $msg = 'Disputed ' . ucfirst($statusType) . ' Insurance';

        uploadInsuranceFile($_FILES['attachment']['name'], $_FILES['attachment']['tmp_name'], [
            'claimid' => $claimId,
            'claimtype' => $statusType,
            'status' => $newStatus,
            'description' => $_POST['dispute_reason']
        ]);
    }
} elseif (ClaimFormData::isStatus('paid-insurance', $claimData['status'])) {
    $msg = "Claim saved, status is PAID.";
} elseif (ClaimFormData::isStatus('pending', $claimData['status'])) {
    //SAVE WITHOUT CHANGING STATUS
} elseif ($_POST['close'] == 1) { // Close
    $newStatus = $isPrimary ? DSS_CLAIM_PAID_INSURANCE : DSS_CLAIM_PAID_SEC_INSURANCE;

    if ($isPrimary && ClaimFormData::isStatus(['sent', 'efile-accepted'], $claimData['status'])) {
        /**
         * IF has secondary insurance AND there's amount due THEN create secondary claims
         */
        if (isOptionSelected($patientData['has_s_m_ins']) && ($amountPayment < $claimData['amount_due'])) { //secondary
            if ($patientData['p_m_ins_type'] == 1) { //medicare
                if (isOptionSelected($patientData['s_m_ins_ass'])) { // Accept assignment of benefits
                    $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Sent".';
                    $secondaryStatus = DSS_CLAIM_SEC_SENT;
                } else { // Payment to patient
                    $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Paid to Patient".';
                    $secondaryStatus = DSS_CLAIM_PAID_SEC_PATIENT;
                }
            } else {
                $msg = 'Payment Successfully Added\n\nPrimary Insurance claim closed. This patient has secondary insurance and a claim has been auto-generated for the Secondary Insurer.';
                $secondaryStatus = DSS_CLAIM_SEC_PENDING;
            }
        }

        uploadInsuranceFile($_FILES['attachment']['name'], $_FILES['attachment']['tmp_name'], [
            'claimid' => $claimId,
            'claimtype' => $statusType,
            'status' => $newStatus
        ]);
    } elseif (!$isPrimary && ClaimFormData::isStatus('sent', $claimData['status'])) {
        $newStatus = DSS_CLAIM_PAID_SEC_INSURANCE;

        uploadInsuranceFile($_FILES['attachment']['name'], $_FILES['attachment']['tmp_name'], [
            'claimid' => $claimId,
            'claimtype' => $statusType,
            'status' => $newStatus
        ]);
    }
}

if ($newStatus !== false) {
    $updateClaimData = [
        'status' => $newStatus
    ];

    if ($_POST['close'] == 1) {
        $updateClaimData['closed_by_office_type'] = 1;
    }

    $updateClaimData = $db->escapeAssignmentList($updateClaimData);

    if (ClaimFormData::isStatus(['sent', 'efile-accepted', 'rejected', 'dispute'], $newStatus)) {
        $db->query("UPDATE dental_insurance
            SET $updateClaimData, mailed_date = NULL
            WHERE insuranceid = '$claimId'");
    } else {
        $db->query("UPDATE dental_insurance
            SET $updateClaimData
            WHERE insuranceid = '$claimId'");
    }

    claim_status_history_update($claimId, $newStatus, $claimData['status'], $_SESSION['userid']);
}

if ($secondaryStatus !== false && empty($_POST['empty-claim'])) {
    $msg = 'Payment Successfully Added\n\nPrimary Insurance claim closed. This patient has secondary insurance and a claim has been auto-generated for the Secondary Insurer.';

    ClaimFormData::createSecondaryClaim($patientId, $_SESSION['userid'], $claimId, $secondaryStatus);
}

if (empty($paymentId) && empty($_POST['empty-claim'])) {
    if ($paymentsToAdd) {
        $msg = 'Could not add ledger payments, please close this window and contact your system administrator';
        error_log('Insert Ledger Payments: could not add ledger payments: ' . $paymentsToAdd);
    } elseif ($_POST['empty-claim']) {
        $msg = 'There were no payments to add. The claim has been forcefully closed.';
    } else {
        $msg = 'There were no payments to add. Please verify the amounts and try again.';
    }
} else {
    claim_history_update($claimId, $_SESSION['userid'], $_SESSION['adminuserid']);
}

?>
<script type="text/javascript">
    alert('<?= e($msg) ?>');
    history.go(-1);
</script>
<?php

/**
 * Auxiliary function to avoid duplicated code
 *
 * @param string $targetName
 * @param string $tempName
 * @param array  $imageData
 * @return string
 */
function uploadInsuranceFile ($targetName, $tempName, Array $imageData) {
    $db = new Db();

    if ($targetName == '') {
        return '';
    }

    $lastdot = strrpos($targetName, '.');
    $name = substr($targetName, 0, $lastdot);
    $extension = substr($targetName, $lastdot + 1);
    $banner1 = $name . '_' . date('dmy_Hi');
    $banner1 = str_replace(' ', '_', $banner1);
    $banner1 = str_replace('.', '_', $banner1);
    $banner1 .= '.' . $extension;

    $fileName = '../../../shared/q_file/' . $banner1;

    @move_uploaded_file($tempName, $fileName);
    @chmod($fileName, 0777);

    $imageData += [
        'filename' => $banner1,
        'ip_address' => $_SERVER['REMOTE_ADDR']
    ];
    $imageData = $db->escapeAssignmentList($imageData);

    $db->query("INSERT INTO dental_insurance_file SET $imageData, adddate = NOW()");

    return $banner1;
}
