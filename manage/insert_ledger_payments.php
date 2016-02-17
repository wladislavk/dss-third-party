<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/authorization_functions.php';
require_once __DIR__ . '/admin/includes/claim_functions.php';
require_once __DIR__ . '/includes/claim_functions.php';
require_once __DIR__ . '/admin/includes/ledger-functions.php';

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

$isPrimary = ClaimFormData::isPrimary($claimData['status']);
$statusType = $isPrimary ? 'primary' : 'secondary';
$amountPayment = getLedgerPaymentAmount($claimId, DSS_TRXN_PAYER_PRIMARY);

$paymentsAdded = insertLedgerPayments(
    $claimId, $_POST['payments'], $_POST['payment_type'], $_POST['payer'], $_SESSION['userid'], $_SESSION['adminid']
);

if ($paymentsAdded) {
    $msg = count($paymentsAdded) . ' payments have been added.';
    echo "<br />";
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
    if ($paymentsAdded) {
        $msg = 'Could not add ledger payments, please close this window and contact your system administrator';
        error_log('Insert Ledger Payments: could not add ledger payments.');
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
