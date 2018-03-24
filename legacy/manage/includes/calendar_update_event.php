<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once '../admin/includes/main_include.php';
include_once 'checkemail.php';

$docid = mysqli_real_escape_string($con, $_SESSION['docid']);
$sd = mysqli_real_escape_string($con, $_POST['start_date']);
$ed = mysqli_real_escape_string($con, $_POST['end_date']);
$de = mysqli_real_escape_string($con, $_POST['description']);
$cat = mysqli_real_escape_string($con, $_POST['category']);
$pi = mysqli_real_escape_string($con, $_POST['producer']);
$pid = mysqli_real_escape_string($con, $_POST['patient']);
$e_id = mysqli_real_escape_string($con, $_POST['e_id']);
$t_id = mysqli_real_escape_string($con, $_POST['t_id']);
$res = mysqli_real_escape_string($con, $_POST['resource']);
$r_type = mysqli_real_escape_string($con, ($_POST['rec_type'] != 'null') ? $_POST['rec_type'] : ''); //to fix bug with string 'null'
$r_pattern = mysqli_real_escape_string($con, ($_POST['rec_pattern'] != 'null') ? $_POST['rec_pattern'] : '');
$e_length = mysqli_real_escape_string($con, empty($_POST['elength']) ? '' : $_POST['elength']);
$e_pid = mysqli_real_escape_string($con, empty($_POST['epid']) ? '' : $_POST['epid']);

$s = "UPDATE dental_calendar SET
        start_date = '$sd',
        end_date = '$ed',
        event_id = '$e_id',
        description = '$de',
        category = '$cat',
        producer_id = '$pi',
        res_id = '$res',
        rec_type = '$r_type',
        rec_pattern = '$r_pattern',
        event_length = '$e_length',
        event_pid = '$e_pid',
        patientid = '$pid'
    WHERE event_id = '$e_id'";

if ($db->query($s)) {
    echo '{"success":true, "eventid":"' . $e_id .'"}';
} else {
    echo '{"error":true}';
}
