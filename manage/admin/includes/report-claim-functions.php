<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/access.php';
require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/ledger-functions.php';

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

    $mailingDateConditional = mailingDateConditional($dayLimit);
    $patientId = intval($patientId);

    $query = "SELECT
            insuranceid,
            COALESCE(
                CONVERT(
                    REPLACE(IF(primary_claim_id, 0, total_charge), ',', ''),
                    DECIMAL(11, 2)
                ), 0
            ) AS total_charge
        FROM dental_insurance
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

    $mailingDateConditional = mailingDateConditional($dayLimit, 'i');

    $query = "SELECT
            i.insuranceid,
            i.mailed_date,
            l.service_date,
            p.patientid,
            p.firstname,
            p.lastname,
            i.total_charge,
            CONCAT(u.first_name, ' ', u.last_name) AS doc_name,
            l.amount,
            l.ledgerid,
            l.transaction_code,
            (
                SELECT SUM(dlp.amount)
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l2 ON l2.ledgerid = dlp.ledgerid
                WHERE l2.ledgerid = l.ledgerid
                    AND dlp.payer IN (0, 1)
            ) AS ins_payment,
            (
                SELECT SUM(dlp.amount)
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l3 ON l3.ledgerid = dlp.ledgerid
                WHERE l3.ledgerid = l.ledgerid
                    AND dlp.payer IN (2)
            ) AS client_payment,
            (
                SELECT SUM(dlp.amount)
                FROM dental_ledger_payment dlp
                    INNER JOIN dental_ledger l4 ON l4.ledgerid = dlp.ledgerid
                WHERE l4.ledgerid = l.ledgerid
                    AND dlp.payer in (3, 4)
            ) AS adj_payment
        FROM dental_insurance i
            LEFT JOIN dental_ledger l ON l.primary_claim_id = i.insuranceid
            LEFT JOIN dental_patients p ON p.patientid = i.patientid
            LEFT JOIN dental_users u ON u.userid = p.docid
            $userCompanyJoin
        WHERE $docIdConditional
            $andBackOfficeConditionals
            AND $mailingDateConditional
            AND (
                COALESCE(
                    CONVERT(
                        REPLACE(IF(i.primary_claim_id, 0, i.total_charge), ',', ''),
                        DECIMAL(11, 2)
                    ), 0
                )
                -
                COALESCE(
                    (
                        SELECT SUM(dlp.amount)
                        FROM dental_ledger_payment dlp
                            INNER JOIN dental_ledger l ON l.ledgerid = dlp.ledgerid
                        WHERE l.primary_claim_id = i.insuranceid
                    ), 0
                )
            ) > 0";

    return $db->getResults($query);
}
