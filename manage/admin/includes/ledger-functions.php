<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/access.php';
require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/claim_functions.php';
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
        'payment_date' => $today,
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

/**
 * Manage Ledger query, encapsulated for easy reuse.
 *
 * @param int    $patientId
 * @param int    $docId
 * @param string $orderBy
 * @param string $limit
 * @return string
 */
function ledgerReportQuery ($patientId, $docId, $orderBy='', $limit='') {
    $docId = intval($docId);
    $patientId = intval($patientId);
    $filedByBackOfficeConditional = filedByBackOfficeConditional('i');

    $query = "SELECT
            'ledger',
            dl.ledgerid,
            dl.service_date,
            dl.entry_date,
            CONCAT(p.first_name, ' ', p.last_name) AS name,
            dl.description,
            dl.amount,
            '' AS paid_amount,
            di.status,
            dl.primary_claim_id,
            '' AS payer,
            '' AS payment_type,
            di.status AS claim_status,
            '' AS filename,
            '' AS num_notes,
            '' AS num_fo_notes,
            0 AS filed_by_bo
        FROM dental_ledger dl
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment pay ON pay.ledgerid = dl.ledgerid
            LEFT JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND (dl.paid_amount IS NULL OR dl.paid_amount = 0)
        GROUP BY dl.ledgerid

        UNION

        SELECT
            'ledger_payment',
            dlp.id,
            dlp.payment_date,
            dlp.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            '',
            '',
            dlp.amount,
            '',
            IF(dl.secondary_claim_id && dlp.is_secondary, dl.secondary_claim_id, dl.primary_claim_id),
            dlp.payer,
            dlp.payment_type,
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger dl
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND dlp.amount != 0

        UNION

        SELECT
            'ledger_paid',
            dl.ledgerid,
            dl.service_date,
            dl.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            dl.description,
            dl.amount,
            dl.paid_amount,
            dl.status,
            dl.primary_claim_id,
            tc.type,
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger dl
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment pay ON pay.ledgerid = dl.ledgerid
            LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
                AND tc.docid = '$docId'
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)

        UNION

        SELECT
            'note',
            n.id,
            n.service_date,
            n.entry_date,
            CONCAT('Note - ', p.first_name, ' ', p.last_name),
            n.note,
            '',
            '',
            n.private,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_note n
            JOIN dental_users p ON n.producerid = p.userid
        WHERE n.patientid = '$patientId'

        UNION

        SELECT
            'statement',
            s.id,
            s.service_date,
            s.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            'Ledger statement created (Click to view)',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            s.filename,
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_statement s
            JOIN dental_users p on s.producerid = p.userid
        WHERE s.patientid = '$patientId'

        UNION

        SELECT
            'note',
            n.id,
            n.service_date,
            n.entry_date,
            CONCAT('Note - Backoffice ID - ', p.adminid),
            n.note,
            '',
            '',
            n.private,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_note n
            JOIN admin p ON n.admin_producerid = p.adminid
        WHERE n.patientid = '$patientId'

        UNION

        SELECT
            'claim',
            i.insuranceid,
            i.adddate,
            i.adddate,
            'Claim',
            'Insurance Claim',
            (
                SELECT SUM(dl2.amount)
                FROM dental_ledger dl2
                    INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                WHERE i2.insuranceid = i.insuranceid
            ),
            SUM(pay.amount),
            i.status,
            i.primary_claim_id,
            '',
            '',
            '',
            '',
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = i.insuranceid
            ),
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = i.insuranceid
                    AND create_type = '1'
            ),
            $filedByBackOfficeConditional AS filed_by_bo
        FROM dental_insurance i
            LEFT JOIN dental_ledger dl ON dl.primary_claim_id = i.insuranceid
            LEFT JOIN dental_ledger_payment pay ON dl.ledgerid = pay.ledgerid
        WHERE i.patientid = '$patientId'
        GROUP BY i.insuranceid
        
        $orderBy
        $limit";

    return $query;
}

/**
 * Manage Ledger report, encapsulated for easier use
 *
 * @param int    $patientId
 * @param int    $docId
 * @param string $orderBy
 * @param string $limit
 * @return array
 */
function ledgerReportForPatient ($patientId, $docId, $orderBy='', $limit='') {
    $db = new Db();

    $query = ledgerReportQuery($patientId, $docId, $orderBy, $limit);
    $report = $db->getResults($query);

    return $report;
}

/**
 * Calculate ledger total for a patient.
 *
 * @param int $patientId
 * @param int $docId
 * @return array
 */
function ledgerBalanceForPatient ($patientId, $docId) {
    $report = ledgerReportForPatient($patientId, $docId);
    $cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;

    foreach ($report as $transaction) {
        if (!in_array($transaction['ledger'], ['ledger', 'ledger_paid', 'ledger_payment'])) {
            continue;
        }

        $cur_bal += $transaction['amount'] - $transaction['paid_amount'];
        $cur_cha += $transaction['amount'];

        if ($transaction['ledger'] == 'ledger_paid' && $transaction['payer'] == DSS_TRXN_TYPE_ADJ) {
            $cur_adj += $transaction['paid_amount'];
        } else {
            $cur_pay += $transaction['paid_amount'];
        }
    }

    $balance = [
        'debits' => number_format($cur_pay, 2, '.', ''),
        'credits' => number_format($cur_cha, 2, '.', ''),
        'adjustments' => number_format($cur_adj, 2, '.', ''),
        'total' => number_format($cur_bal, 2, '.', '')
    ];

    return $balance;
}

