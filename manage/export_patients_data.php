<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once 'admin/includes/main_include.php';
include_once 'includes/sescheck.php';
include_once 'includes/constants.inc';

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
$trxnTypeWriteOff = DSS_TRXN_PYMT_WRITEOFF;

$sql = "SELECT
        patientid AS id,
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
        TRUNCATE(
            COALESCE(
                (
                    SELECT SUM(COALESCE(credits.amount, 0)) AS total
                    FROM dental_ledger credits
                    WHERE credits.docid = p.docid
                        AND credits.patientid = p.patientid
                ), 0.0
            ), 2
        ) AS credits,
        TRUNCATE(
            COALESCE(
                (
                    SELECT SUM(COALESCE(debits.amount, 0))
                    FROM dental_ledger debits_base
                        JOIN dental_ledger_payment debits ON debits.ledgerid = debits_base.ledgerid
                    WHERE debits_base.docid = p.docid
                        AND debits_base.patientid = p.patientid
                        AND COALESCE(debits.payment_type, 0) != '$trxnTypeWriteOff'
                ), 0.0
            ), 2
        ) AS debits,
        TRUNCATE(
            COALESCE(
                (
                    SELECT SUM(COALESCE(adjustments.paid_amount, 0))
                    FROM dental_ledger adjustments
                    WHERE adjustments.docid = p.docid
                        AND adjustments.patientid = p.patientid
                ), 0.0
            )
            + COALESCE(
                (
                    SELECT SUM(COALESCE(adjustment_payments.amount, 0))
                    FROM dental_ledger adjustment_payments_base
                        JOIN dental_ledger_payment adjustment_payments ON adjustment_payments.ledgerid = adjustment_payments_base.ledgerid
                    WHERE adjustment_payments_base.docid = p.docid
                        AND adjustment_payments_base.patientid = p.patientid
                        AND adjustment_payments.payment_type = '$trxnTypeWriteOff'
                ), 0.0
            ), 2
        ) AS adjustments
    FROM dental_patients p
    WHERE p.docid = '$docId'
    ORDER BY p.firstname, p.lastname, p.middlename";

$patients = $db->getResults($sql);
$dateFormat = '%Y-%m-%d %h:%i%p';

foreach ($patients as $patient) {
    $patient['total'] = $patient['credits'] - $patient['debits'] - $patient['adjustments'];

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
