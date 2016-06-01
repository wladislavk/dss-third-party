<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once 'admin/includes/main_include.php';
include_once 'includes/sescheck.php';
include_once 'includes/constants.inc';
require_once __DIR__ . '/admin/includes/ledger-functions.php';

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=dss_patient_export.csv");
header("Pragma: no-cache");
header("Expires: 0");

$csv = fopen('php://output', 'w');

if (!$csv) {
    error_log('Export Patients: could not create output handler');

    ?>
    <script>
        alert('There was a problem creating the csv file. Please wait a few minutes and try again.');
    </script>
    <?php

    trigger_error('die called', E_USER_ERROR);
}

$header = [
    'Salutation',
    'First Name',
    'Last Name',
    'Middle Init',
    'Preferred Name',
    'Address 1',
    'Address 2',
    'City',
    'State',
    'Zip',
    'Date Of Birth',
    'Gender',
    'Marital Status',
    'SSN',
    'Home Phone',
    'Work Phone',
    'Cell Phone',
    'Email',
    'Status',
    'Credits',
    'Debits',
    'Adjustments',
    'Ledger Balance',
    'Progress Note'
];

fputcsv($csv, $header);

$docId = intval($_SESSION['userid']);
$trxnTypeAdj = DSS_TRXN_TYPE_ADJ;
$reportQuery = ledgerTransactionsQuery($docId);

$sql = "SELECT
        p.patientid AS id,
        TRIM(p.salutation),
        TRIM(p.firstname),
        TRIM(p.lastname),
        TRIM(p.middlename),
        TRIM(p.preferred_name),
        TRIM(p.add1),
        TRIM(p.add2),
        TRIM(p.city),
        TRIM(p.state),
        p.zip,
        p.dob,
        TRIM(p.gender),
        TRIM(p.marital_status),
        TRIM(p.ssn),
        TRIM(p.home_phone),
        TRIM(p.work_phone),
        TRIM(p.cell_phone),
        TRIM(p.email),
        CASE p.status WHEN 1 THEN 'Active' ELSE 'Inactive' END,
        SUM(COALESCE(
            report.amount, 0.0
        )) AS debits,
        SUM(COALESCE(
            IF(
                report.ledger = 'ledger_paid' && report.payer = '$trxnTypeAdj',
                0.0,
                report.paid_amount
            ), 0.0
        )) AS credits,
        SUM(COALESCE(
            IF(
                report.ledger = 'ledger_paid' && report.payer = '$trxnTypeAdj',
                report.paid_amount,
                0.0
            ), 0.0
        )) AS adjustments,
        (
            SUM(COALESCE(
                report.amount, 0.0
            )) -
            SUM(COALESCE(
                report.paid_amount, 0.0
            ))
        ) AS balance
    FROM dental_patients p
        LEFT JOIN (
            $reportQuery
        ) report ON report.patientid = p.patientid
    WHERE p.docid = '$docId'
    GROUP BY p.patientid
    ORDER BY p.firstname, p.lastname, p.middlename, p.patientid";

$patients = $db->getResults($sql);
$dateFormat = '%Y-%m-%d %h:%i%p';

foreach ($patients as $patient) {
    $patient['credits'] = number_format($patient['credits'], 2);
    $patient['debits'] = number_format($patient['debits'], 2);
    $patient['adjustments'] = number_format($patient['adjustments'], 2);
    $patient['total'] = number_format($patient['total'], 2);

    $notes = $db->getResults("SELECT
            note.notesid AS `NoteID`,
            IF(note.signed_on IS NULL, '', 'Signed') AS `Status`,
            note.procedure_date AS `Procedure Date`,
            DATE_FORMAT(note.adddate, '$dateFormat') AS `Entry Date`,
            CONCAT(author.first_name, ' ', author.last_name) AS `Added By`,
            CONCAT(signer.first_name, ' ', signer.last_name) AS `Signed By`,
            DATE_FORMAT(note.signed_on, '$dateFormat') AS `Signed By Date`,
            note.notes AS `Text`
        FROM dental_notes note
            LEFT JOIN dental_users author ON author.userid = note.userid
            LEFT JOIN dental_users signer ON signer.userid = note.signed_id
        WHERE note.patientid = '{$patient['id']}'");

    unset($patient['id']);

    if ($notes) {
        array_walk_recursive($notes, function (&$each) {
            $each = utf8_encode($each);
        });
    }

    $patient['progress_notes'] = json_encode($notes);

    fputcsv($csv, $patient);
}

fclose($csv);
