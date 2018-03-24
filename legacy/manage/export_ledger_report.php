<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/constants.inc';

define('LEDGER_REPORT_NO_FORMAT', 0);
define('LEDGER_REPORT_FORMAT_DATE', 1);
define('LEDGER_REPORT_FORMAT_NUMBER', 2);
define('LEDGER_REPORT_FORMAT_MONEY', 4);

$file = getReportFilename($_GET);

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file.csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';

$db = new Db();
$docId = (int)$_SESSION['docid'];
$start_date = $db->escape($_GET['start_date']);
$end_date = $db->escape($_GET['end_date']);

$tot_charge = 0;
$tot_credit = 0;
$tot_adj = 0;

$reportSql = "SELECT
        'ledger',
        dl.ledgerid,
        dl.service_date,
        dl.entry_date,
        dl.amount,
        dl.paid_amount,
        dl.status,
        dl.description,
        CONCAT(p.first_name, ' ', p.last_name) AS name,
        pat.patientid,
        pat.firstname,
        pat.lastname,
        tc.type AS payer,
        '' AS payment_type,
        dl.primary_claim_id
    FROM dental_ledger dl 
        JOIN dental_patients pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
                AND tc.docid = '$docId'
    WHERE dl.docid = '$docId'
        AND dl.service_date BETWEEN '$start_date' AND '$end_date'
    
    UNION
    
    SELECT
        'ledger_payment',
        dlp.id,
        dlp.payment_date,
        dlp.entry_date,
        '',
        dlp.amount,
        '',
        '',
        CONCAT(p.first_name, ' ', p.last_name),
        pat.patientid,
        pat.firstname,
        pat.lastname,
        dlp.payer,
        dlp.payment_type,
        ''
    FROM dental_ledger dl
        JOIN dental_patients pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    WHERE dl.docid = '$docId'
        AND dlp.amount != 0
        AND dlp.payment_date BETWEEN '$start_date' AND '$end_date'
";

$transactions = $db->getResults($reportSql);
$csvRows = [];

addCsvRow($csvRows, [
    'service_date' => 'Svc Date',
    'entry_date' => 'Entry Date',
    'patient' => 'Patient',
    'producer' => 'Producer',
    'description' => 'Description',
    'charges' => 'Charges',
    'credits' => 'Credits',
    'adjustments' => 'Adjustments',
    'ins' => 'Ins',
], LEDGER_REPORT_NO_FORMAT);

foreach ($transactions as $transaction) {
    $patientSql = "SELECT CONCAT(lastname, ' ', firstname, ' ', middlename) AS name
        FROM dental_patients
        WHERE patientid = '{$transaction['patientid']}'
    ";
    $patientName = $db->getColumn($patientSql, 'name', '');

    $csvRow['service_date'] = $transaction["service_date"];
    $csvRow['entry_date'] = $transaction["entry_date"];
    $csvRow['patient'] = $patientName;
    $csvRow['producer'] = $transaction['name'];
    $csvRow['description'] = formatLedgerDescription($transaction, $dss_trxn_payer_labels, $dss_trxn_pymt_type_labels);
    $csvRow['charges'] = $transaction['amount'];
    $csvRow['adjustments'] = getLedgerAdjustment($transaction);
    $csvRow['credits'] = getLedgerCredit($transaction);
    $csvRow['ins'] = formatLedgerStatus($transaction, $dss_trxn_status_labels, $dss_claim_status_labels);

    $tot_charge += (float)$csvRow['charges'];
    $tot_adj += (float)$csvRow['adjustments'];
    $tot_credit += (float)$csvRow['credits'];

    addCsvRow($csvRows, $csvRow);
}

addCsvRow($csvRows, [
    'description' => 'Total',
    'charges' => $tot_charge,
    'credits' => $tot_credit,
    'adjustments' => $tot_adj,
], LEDGER_REPORT_FORMAT_MONEY);
addCsvRow($csvRows, [
    'description' => 'Balance',
    'charges' => $tot_charge - $tot_credit - $tot_adj,
], LEDGER_REPORT_FORMAT_MONEY);

outputCsvArray($csvRows);


function getReportFilename(array $get)
{
    if ($get['dailysub']) {
        return 'Ledger_Report_' . formatDate($get['start_date']);
    }
    
    if ($get['monthlysub']) {
        return 'Ledger_Report_' . formatDate($get['start_date'], 'm-Y');
    }
    
    if ($get['weeklysub'] || $get['weeklysub']) {
        return 'Ledger_Report_' . formatDate($get['start_date']) . '_TO_' . formatDate($get['end_date']);
    }
    
    return 'Ledger_Report';
}

/**
 * @param string|int|float $amount
 * @param string           $prepend
 * @return string
 */
function formatNumber($amount, $prepend = '')
{
    if (!is_numeric($amount)) {
        return $amount;
    }

    return $prepend . number_format($amount, 2, '.', '');
}

/**
 * @param string $stringDate
 * @param string $format
 * @return string
 */
function formatDate($stringDate, $format = 'm-d-Y')
{
    if (is_null($stringDate)) {
        return $stringDate;
    }
    $time = strtotime($stringDate);
    return date($format, $time);
}

/**
 * @param array $transaction
 * @param array $dss_trxn_payer_labels
 * @param array $dss_trxn_pymt_type_labels
 * @return string
 */
function formatLedgerDescription(array $transaction, array $dss_trxn_payer_labels, array $dss_trxn_pymt_type_labels)
{
    if ($transaction['ledger'] === 'ledger_payment') {
        return $dss_trxn_payer_labels[$transaction['payer']]
            . ' Payment - '
            . $dss_trxn_pymt_type_labels[$transaction['payment_type']];
    }

    $claimId = (int)$transaction['primary_claim_id'];

    if ($claimId) {
        return "{$transaction['description']} ($claimId)";
    }

    return $transaction['description'];
}

/**
 * @param array $transaction
 * @param array $dss_trxn_status_labels
 * @param array $dss_claim_status_labels
 * @return string
 */
function formatLedgerStatus(array $transaction, array $dss_trxn_status_labels, array $dss_claim_status_labels)
{
    if ($transaction['ledger'] === 'ledger') {
        return $dss_trxn_status_labels[$transaction['status']];
    }

    if ($transaction['ledger'] === 'claim') {
        return $dss_claim_status_labels[$transaction['status']];
    }

    return '';
}

/**
 * @param array $transaction
 * @return string
 */
function getLedgerAdjustment(array $transaction)
{
    if ($transaction['ledger'] === 'ledger' && $transaction['payer'] == DSS_TRXN_TYPE_ADJ) {
        return $transaction['paid_amount'];
    }
    
    return '';
}

/**
 * @param array $transaction
 * @return string
 */
function getLedgerCredit(array $transaction)
{
    if ($transaction['ledger'] === 'ledger' && $transaction['payer'] == DSS_TRXN_TYPE_ADJ) {
        return '';
    }
    
    return $transaction['paid_amount'];
}

/**
 * @param array $csvRows
 * @param array $csvRow
 * @param int   $format
 */
function addCsvRow(array &$csvRows, array $csvRow, $format = LEDGER_REPORT_FORMAT_DATE | LEDGER_REPORT_FORMAT_NUMBER)
{
    $baseRow = [
        'service_date' => '',
        'entry_date' => '',
        'patient' => '',
        'producer' => '',
        'description' => '',
        'charges' => '',
        'credits' => '',
        'adjustments' => '',
        'ins' => '',
    ];
    $newRow = array_merge($baseRow, $csvRow);

    if ($format & LEDGER_REPORT_FORMAT_DATE) {
        $newRow['service_date'] = formatDate($csvRow['service_date']);
        $newRow['entry_date'] = formatDate($csvRow['entry_date']);
    }

    if ($format & LEDGER_REPORT_FORMAT_NUMBER) {
        $newRow['charges'] = formatNumber($csvRow['charges']);
        $newRow['credits'] = formatNumber($csvRow['credits']);
        $newRow['adjustments'] = formatNumber($csvRow['adjustments']);
    }

    if ($format & LEDGER_REPORT_FORMAT_MONEY) {
        $newRow['charges'] = formatNumber($csvRow['charges'], '$');
        $newRow['credits'] = formatNumber($csvRow['credits'], '$');
        $newRow['adjustments'] = formatNumber($csvRow['adjustments'], '$');
    }

    $csvRows[] = array_values($newRow);
}


function outputCsvArray(array $csvRows)
{
    $output = fopen('php://output', 'w');
    foreach ($csvRows as $csvRow) {
        fputcsv($output, $csvRow);
    }
    fclose($output);
}
