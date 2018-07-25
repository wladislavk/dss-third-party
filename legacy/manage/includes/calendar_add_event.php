<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';
include_once 'checkemail.php';

$db = new Db();
$docid = (int)$_SESSION['docid'];
$sd = $db->escape($_POST['start_date']);
$ed = $db->escape($_POST['end_date']);
$de = $db->escape($_POST['description']);
$cat = $db->escape($_POST['category']);
$pi = (int)$_POST['producer'];
$id = (int)$_POST['id'];
$pid = (int)$_POST['patient'];
$res = (int)$_POST['resource'];
$r_type = $_POST['rec_type'] != 'null' ? $db->escape($_POST['rec_type']) : ''; //to fix bug with string 'null'
$r_pattern = $_POST['rec_pattern'] != 'null' ? $db->escape($_POST['rec_pattern']) : '';
$e_length = (int)$_POST['elength'];
$e_pid = (int)$_POST['epid'];

$s = "INSERT INTO dental_calendar
    (start_date, end_date, event_id, description, category, producer_id, docid, patientid, rec_type, rec_pattern, event_length, event_pid, res_id, adddate)
    VALUES
    ('".$sd."', '".$ed."', '".$id."', '".$de."', '".$cat."', ".$pi.", '".$docid."', '".$pid."', '" . $r_type . "', '" . $r_pattern . "', " . $e_length . ", " . $e_pid . ", " . $res . ", " . "now())";

if ($db->query($s)) {
    $sql2 = "SELECT * from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid WHERE dc.event_id='".$id."' order by dc.id desc";

    if($r = $db->getRow($sql2)) {
        echo '{"success":true, "eventid":"' . $id .'"}';
    } else {
        echo '{"success":true, "eventid":"' . $id . '"}';
    }
} else {
    echo '{"error":true}';
}
