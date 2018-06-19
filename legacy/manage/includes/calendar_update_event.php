<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once '../admin/includes/main_include.php';
include_once 'checkemail.php';

$docid = $db->escape( $_SESSION['docid']);
$sd = $db->escape( $_POST['start_date']);
$ed = $db->escape( $_POST['end_date']);
$de = $db->escape( $_POST['description']);
$cat = $db->escape( $_POST['category']);
$pi = $db->escape( $_POST['producer']);
$pid = $db->escape( $_POST['patient']);
$e_id = $db->escape( $_POST['e_id']);
$t_id = $db->escape( $_POST['t_id']);
$res = $db->escape( $_POST['resource']);
$r_type = $db->escape( ($_POST['rec_type'] != 'null') ? $_POST['rec_type'] : ''); //to fix bug with string 'null'
$r_pattern = $db->escape( ($_POST['rec_pattern'] != 'null') ? $_POST['rec_pattern'] : '');
$e_length = $db->escape( empty($_POST['elength']) ? '' : $_POST['elength']);
$e_pid = $db->escape( empty($_POST['epid']) ? '' : $_POST['epid']);

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
