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

$sql = "SELECT
        TRIM(salutation),
        TRIM(firstname),
        TRIM(lastname),
        TRIM(middlename),
        TRIM(preferred_name),
        TRIM(add1),
        TRIM(add2),
        TRIM(city),
        TRIM(state),
        zip,
        dob,
        TRIM(gender),
        TRIM(marital_status),
        TRIM(ssn),
        TRIM(home_phone),
        TRIM(work_phone),
        TRIM(cell_phone),
        TRIM(email),
        CASE status WHEN 1 THEN 'Active' ELSE 'Inactive' END,
        COALESCE(
            (
                SELECT SUM(COALESCE(first.amount, 0)) AS total
                FROM dental_ledger first
                WHERE first.docid = p.docid
                    AND first.patientid = p.patientid
                    AND COALESCE(first.paid_amount, 0) = 0
            ), 0
        ) AS amount1,
        COALESCE(
            (
                SELECT SUM(COALESCE(second.amount, 0))
                FROM dental_ledger second
                WHERE second.docid = p.docid
                    AND second.patientid = p.patientid
                    AND second.paid_amount != 0
            ), 0
        ) AS amount2,
        COALESCE(
            (
                SELECT SUM(COALESCE(second.paid_amount, 0))
                FROM dental_ledger second
                WHERE second.docid = p.docid
                    AND second.patientid = p.patientid
                    AND second.paid_amount != 0
            ), 0
        ) AS amount3,
        COALESCE(
            (
                SELECT SUM(COALESCE(third_payment.amount, 0))
                FROM dental_ledger third
                    LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
                WHERE third.docid = p.docid
                    AND third.patientid = p.patientid
                    AND third_payment.amount != 0
            ), 0
        ) AS amount4
    FROM dental_patients
    WHERE docid = '$docId'
    ORDER BY firstname, lastname, middlename";

$patients = $db->getResults($sql);
$dateFormat = '%Y-%m-%d %h:%i%p';

foreach ($patients as $patient) {
    [
        "NoteID" => "123",
        "Status" => "Signed",
        "Procedure Date" => "2012-01-01 12:12pm",
        "Entry Date" => "2012-01-01 12:12pm",
        "Added By" => "Jack Smith",
        "Signed By" => "Jack Smith",
        "Signed By Date" => "2012-01-01 12:12pm",
        "Text" => "note text is stored here"
    ];

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
        WHERE note.patientid = '{$patient['patientid']}'");

    if ($notes) {
        array_walk($notes, function (&$each) {
            $each = utf8_encode($each);
        });
    }

    $patients['progress_notes'] = json_encode($notes);

    fputcsv($csv, $patient);
}

fclose($csv);
