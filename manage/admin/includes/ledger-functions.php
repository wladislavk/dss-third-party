<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/access.php';
require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/../../includes/claim_functions.php';

/**
 * Retrieve payments from a given claim id
 *
 * @param int  $claimId
 * @param bool $payerType
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
 * Auxiliary function to set the range of dates in the mailing date conditional
 *
 * @param array  $dayLimit
 * @param string $claimAlias
 * @return string
 */
function mailingDateConditional (Array $dayLimit, $claimAlias='dental_insurance') {
    $lowerLimit = intval($dayLimit[0]);
    $upperLimit = intval($dayLimit[1]);
    $mailingDateConditional = [];

    if ($upperLimit) {
        $upperLimit++;
        $mailingDateConditional []= "$claimAlias.mailed_date > DATE_SUB(CURDATE(), INTERVAL $upperLimit DAY)";
    }

    if ($lowerLimit) {
        $mailingDateConditional []= "$claimAlias.mailed_date <= DATE_SUB(CURDATE(), INTERVAL $lowerLimit DAY)";
    }

    return join(' AND ', $mailingDateConditional);
}

/**
 * Retrieve charges from the claims in the given day range, for a given patient id
 *
 * @param array  $dayLimit
 * @param int    $patientId
 * @param string $andExtraConditionals
 * @return array
 */
function getClaimChargesResults (Array $dayLimit, $patientId, $andExtraConditionals='') {
    $db = new Db();

    $mailingDateConditional = mailingDateConditional($dayLimit, 'claim');
    $patientId = intval($patientId);

    $query = "SELECT
            claim.insuranceid,
            TRUNCATE(
                COALESCE(
                    (
                        SELECT SUM(COALESCE(credits.amount, 0)) AS total
                        FROM dental_ledger credits
                        WHERE credits.primary_claim_id = claim.insuranceid
                    ), 0.0
                ), 2
            ) AS total_charge
        FROM dental_insurance claim
        WHERE patientid = '$patientId'
          AND $mailingDateConditional
          $andExtraConditionals";

    return $db->getResults($query);
}

/**
 * Retrieve all the entries from the breakdown table report
 *
 * @param array $dayLimit
 * @param bool  $isBackOffice
 * @param array $filterData
 * @return array
 */
function claimAgingBreakdownResults (Array $dayLimit, $isBackOffice, $filterData) {
    $db = new Db();

    /**
     * @see CS-104
     *
     * Define simple conditionals before the complex conditionals, as MySQL has short-circuit in WHERE statements
     */
    $userCompanyJoin = $isBackOffice && is_software($_SESSION['admin_access']) ?
        'JOIN dental_user_company uc ON uc.userid = u.userid' : '';
    $docIdConditional = $isBackOffice ? '1 = 1' : "p.docid = '" . intval($_SESSION['docid']) . "'";
    $andBackOfficeConditionals = '';

    if ($isBackOffice) {
        if (isset($filterData['fid'])) {
            $andBackOfficeConditionals .= " AND p.docid = '" . intval($filterData['fid']) . "' ";
        }

        if (isset($filterData['bc'])) {
            $andBackOfficeConditionals .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
        }

        if (isset($filterData['nbc'])) {
            $andBackOfficeConditionals .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
        }

        if (is_software($_SESSION['admin_access'])) {
            $andBackOfficeConditionals .= " AND uc.companyid = '" . intval($_SESSION['admincompanyid']) . "' ";
        }

        if (is_billing($_SESSION['admin_access'])) {
            $a_sql = "SELECT ac.companyid
                FROM admin_company ac
                    JOIN admin a ON a.adminid = ac.adminid
                WHERE a.adminid = '" . intval($_SESSION['adminuserid']) . "'";

            $admin = $db->getColumn($a_sql, 'companyid');
            $andBackOfficeConditionals .= " AND u.billing_company_id = '" . intval($admin) . "' ";
        }
    }

    $mailingDateConditional = mailingDateConditional($dayLimit, 'claim');
    $subQueries = ledgerBalanceSubQueries('claim', 'claim');

    $query = "SELECT
            claim.insuranceid,
            claim.mailed_date,
            l.service_date,
            p.patientid,
            p.firstname,
            p.lastname,
            claim.total_charge,
            CONCAT(u.first_name, ' ', u.last_name) AS doc_name,
            l.amount,
            l.ledgerid,
            l.transaction_code,
            (
                SELECT TRUNCATE(
                    SUM(COALESCE(dlp.amount, 0.0)), 2
                )
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l2 ON l2.ledgerid = dlp.ledgerid
                WHERE l2.ledgerid = l.ledgerid
                    AND (
                        COALESCE(dlp.payer, 0) IN (0, 1)
                        OR dlp.payer NOT IN (0, 1, 2, 3, 4)
                    )
            ) AS ins_payment,
            (
                SELECT TRUNCATE(
                    SUM(COALESCE(dlp.amount, 0.0)), 2
                )
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l3 ON l3.ledgerid = dlp.ledgerid
                WHERE l3.ledgerid = l.ledgerid
                    AND dlp.payer IN (2)
            ) AS client_payment,
            (
                SELECT TRUNCATE(
                    SUM(COALESCE(dlp.amount, 0.0)), 2
                )
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l4 ON l4.ledgerid = dlp.ledgerid
                WHERE l4.ledgerid = l.ledgerid
                    AND dlp.payer IN (3, 4)
            ) AS adj_payment
        FROM dental_insurance claim
            LEFT JOIN dental_ledger l ON l.primary_claim_id = claim.insuranceid
            LEFT JOIN dental_patients p ON p.patientid = claim.patientid
            LEFT JOIN dental_users u ON u.userid = p.docid
            $userCompanyJoin
        WHERE $docIdConditional
            $andBackOfficeConditionals
            AND $mailingDateConditional
            AND (
                {$subQueries['debits']}
                - {$subQueries['credits']}
                - {$subQueries['adjustments']}
            ) > 0";

    return $db->getResults($query);
}

/**
 * Auxiliary function that encloses the subqueries to calculate the ledger balance. It cam be done by claim
 * (aging report), or by patient (ledger balance).
 *
 * @param string $conditionalType
 * @param string $referenceTable
 * @return array
 */
function ledgerBalanceSubQueries ($conditionalType='claim', $referenceTable) {
    $trxnTypeWriteOff = DSS_TRXN_PYMT_WRITEOFF;

    if ($conditionalType === 'claim') {
        $debitsConditional = "debits.primary_claim_id = $referenceTable.insuranceid";
        $creditsConditional = "credits_base.primary_claim_id = $referenceTable.insuranceid";
        $adjustmentsLedgerConditional = "adjustments.primary_claim_id = $referenceTable.insuranceid";
        $adjustmentsPaymentConditional = "adjustment_payments_base.primary_claim_id = $referenceTable.insuranceid";
    } else {
        $debitsConditional = "debits.docid = $referenceTable.docid
            AND debits.patientid = $referenceTable.patientid";
        $creditsConditional = "credits_base.docid = $referenceTable.docid
            AND credits_base.patientid = $referenceTable.patientid";
        $adjustmentsLedgerConditional = "adjustments.docid = $referenceTable.docid
            AND adjustments.patientid = $referenceTable.patientid";
        $adjustmentsPaymentConditional = "adjustment_payments_base.docid = $referenceTable.docid
            AND adjustment_payments_base.patientid = $referenceTable.patientid";
    }

    return [
        'debits' => "TRUNCATE(
                COALESCE(
                    (
                        SELECT SUM(COALESCE(debits.amount, 0)) AS total
                        FROM dental_ledger debits
                        WHERE $debitsConditional
                    ), 0.0
                ), 2
            )",
        'credits' => "TRUNCATE(
                COALESCE(
                    (
                        SELECT SUM(COALESCE(credits.amount, 0)) AS total
                        FROM dental_ledger credits_base
                            JOIN dental_ledger_payment credits ON credits.ledgerid = credits_base.ledgerid
                        WHERE $creditsConditional
                            AND COALESCE(credits.payment_type, 0) != '$trxnTypeWriteOff'
                    ), 0.0
                ), 2
            )",
        'adjustments' => "TRUNCATE(
                COALESCE(
                    (
                        SELECT SUM(COALESCE(adjustments.paid_amount, 0)) AS total
                        FROM dental_ledger adjustments
                        WHERE $adjustmentsLedgerConditional
                    ), 0.0
                )
                + COALESCE(
                    (
                        SELECT SUM(COALESCE(adjustment_payments.amount, 0)) AS total
                        FROM dental_ledger adjustment_payments_base
                            JOIN dental_ledger_payment adjustment_payments
                                ON adjustment_payments.ledgerid = adjustment_payments_base.ledgerid
                        WHERE $adjustmentsPaymentConditional
                            AND adjustment_payments.payment_type = '$trxnTypeWriteOff'
                    ), 0.0
                ), 2
            )"
    ];
}
