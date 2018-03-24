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
    'Status'
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
        CASE status WHEN 1 THEN 'Active' ELSE 'Inactive' END
    FROM dental_patients
    WHERE docid = $docId
    ORDER BY firstname, lastname, middlename";

$patients = $db->getResults($sql);

foreach ($patients as $patient) {
    fputcsv($csv, $patient);
}

fclose($csv);
