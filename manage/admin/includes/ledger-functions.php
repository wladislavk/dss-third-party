<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/access.php';
require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/../../includes/claim_functions.php';

/**
 * Retrieve payments from a given claim id
 *
 * @param int $claimId
 * @return mixed
 */
function getLedgerPaymentAmount ($claimId, $payerType=false) {
    $db = new Db();
    $claimId = intval($claimId);

    $andPayerTypeConditional = $payerType === false ? '' : "AND dlp.payer = '$payerType'";

    $query = "SELECT SUM(dlp.amount) AS paid_amount
        FROM dental_ledger dl
            LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        WHERE (dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId')
          $andPayerTypeConditional";

    $amount = $db->getColumn($query, 'paid_amount', 0);
    $amount = $amount ?: 0;

    return $amount;
}

/**
 * Encapsulates the logic to add payments to claims
 *
 * $ledgerPayments is an array of arrays. The indexes represent the ledger ids:
 *
 * $ledgerPayments = [
 *      'ledgerId' => [ <array of payments for the given ledger item> ]
 * ]
 *
 * @param int   $claimId
 * @param array $ledgerPayments
 * @param int   $paymentType
 * @param int   $payer
 * @return array
 */
function insertLedgerPayments ($claimId, Array $ledgerPayments, $paymentType, $payer, $userId, $adminId) {
    $db = new Db();

    if ($claimId) {
        $claimId = intval($claimId);
        $trxnPayerPrimary = DSS_TRXN_PAYER_PRIMARY;

        $ledgerItems = $db->getResults("SELECT *
            FROM dental_ledger
            WHERE (primary_claim_id = '$claimId' OR secondary_claim_id = '$claimId')");

        $ledgerAmounts = $db->getRow("SELECT
                SUM(COALESCE(lp.amount)) AS payment,
                COUNT(id) AS num_payments,
                SUM(COALESCE(
                    IF(dl.primary_claim_id = '$claimId', 1, 0)
                )) AS num_primary,
                SUM(COALESCE(
                    IF(dl.secondary_claim_id = '$claimId', 1, 0)
                )) AS num_secondary
            FROM dental_ledger_payment lp
                JOIN dental_ledger dl ON lp.ledgerid = dl.ledgerid
            WHERE (dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId')
                AND lp.payer = '$trxnPayerPrimary'");

        $isLedgerSecondary = $ledgerAmounts ? !!$ledgerAmounts['num_secondary'] : 0;
        $hasLedgerInconsistencies = $ledgerAmounts ?
            $ledgerAmounts['num_primary'] != $ledgerAmounts['num_payments'] &&
            $ledgerAmounts['num_secondary'] != $ledgerAmounts['num_payments']
            : false;

        if ($hasLedgerInconsistencies) {
            $ledgerIds = array_pluck($ledgerItems, 'ledgerid');
            $ledgerIds = join(', ', $ledgerIds);

            error_log("Insert Ledger Payments: the following ledger ids have inconsistencies in primary/secondary claim id link - $ledgerIds");
        }
    } else {
        $isLedgerSecondary = false;
        $ledgerIds = array_keys($ledgerPayments);

        if ($ledgerIds) {
            $ledgerIds = $db->escapeList($ledgerIds);
            $ledgerItems = $db->getResults("SELECT *
                FROM dental_ledger
                WHERE ledgerid IN ($ledgerIds)");
        } else {
            $ledgerItems = [];
        }
    }

    $insertIds = [];
    $today = date('Y-m-d');

    $setFields = [
        'payment_date' => null,
        'entry_date' => $today,
        'followup' => null,
        'payment_type' => $paymentType,
        'payer' => $payer,
        'allowed',
        'ins_paid',
        'deductible',
        'copay',
        'coins',
        'overpaid',
        'note',
    ];

    foreach ($ledgerItems as $row) {
        $ledgerId = $row['ledgerid'];

        if (empty($ledgerPayments[$ledgerId])) {
            continue;
        }

        /**
         * Walk over the set of payments, which correspond to the current ledger id
         */
        foreach ($ledgerPayments[$ledgerId] as $payment) {
            if (empty($payment['amount'])) {
                continue;
            }

            $paymentData = [
                'ledgerid' => $ledgerId,
                'amount' => str_replace(',', '', $payment['amount']),
                'allowed' => str_replace(',', '', $payment['allowed']),
                'amount_allowed' => str_replace(',', '', $payment['amount_allowed']),
                'is_secondary' => $isLedgerSecondary
            ];

            foreach ($setFields as $key=>$default) {
                if (is_numeric($key)) {
                    if (isset($payment[$default])) {
                        $paymentData[$default] = $payment[$default];
                    }

                    continue;
                }

                if (in_array($key, ['payment_date', 'entry_date', 'followup'])) {
                    $paymentData[$key] = empty($payment[$key]) ? $default :
                        date('Y-m-d', strtotime($payment[$key]));

                    continue;
                }

                $paymentData[$key] = isset($payment[$key]) ? $payment[$key] : $default;
            }

            $paymentData = $db->escapeAssignmentList($paymentData);
            $paymentId = $db->getInsertId("INSERT INTO dental_ledger_payment SET $paymentData");

            $insertIds []= $paymentId;
            payment_history_update($paymentId, $userId, $adminId);
        }
    }

    return $insertIds;
}

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

/**
 * Encapsulates the logic to ledger payments
 *
 * $ledgerPayments is an array of arrays. The indexes represent the ledger payment ids:
 *
 * $ledgerPayments = [
 *      'paymentId' => [ <payment fields> ]
 * ]
 *
 * @param array $ledgerPayments
 * @param int   $paymentType
 * @param int   $payer
 * @return array
 */
function updateLedgerPayments (Array $ledgerPayments, $paymentType, $payer, $userId, $adminId) {
    $db = new Db();

    $updateIds = [];
    $today = date('Y-m-d');

    $setFields = [
        'payment_date' => null,
        'entry_date' => $today,
        'followup' => null,
        'payment_type',
        'payer',
        'allowed',
        'ins_paid',
        'deductible',
        'copay',
        'coins',
        'overpaid',
        'note',
    ];

    foreach ($ledgerPayments as $paymentId=>$payment) {
        if (empty($payment)) {
            continue;
        }

        $paymentData = [
            'amount' => str_replace(',', '', $payment['amount']),
            'allowed' => str_replace(',', '', $payment['allowed']),
            'amount_allowed' => str_replace(',', '', $payment['amount_allowed']),
        ];

        foreach ($setFields as $key=>$default) {
            if (is_numeric($key)) {
                if (isset($payment[$default])) {
                    $paymentData[$default] = $payment[$default];
                }

                continue;
            }

            if (!isset($payment[$key])) {
                continue;
            }

            if (in_array($key, ['payment_date', 'entry_date', 'followup'])) {
                $paymentData[$key] = empty($payment[$key]) ? $default :
                    date('Y-m-d', strtotime($payment[$key]));

                continue;
            }

            $paymentData[$key] = $payment[$key];
        }

        $paymentData = $db->escapeAssignmentList($paymentData);
        $paymentId = $db->getAffectedRows("UPDATE dental_ledger_payment SET $paymentData WHERE id = '$paymentId'");

        $updateIds []= $paymentId;
        payment_history_update($paymentId, $userId, $adminId);
    }

    return $updateIds;
}
