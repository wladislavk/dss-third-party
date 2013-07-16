<?php
session_start();
$docid = $_SESSION['docid'];
$sd = $_POST['start_date'];
$ed = $_POST['end_date'];
$de = $_POST['description'];
$cat = $_POST['category'];
$pi = $_POST['producer'];
$id = $_POST['id'];
$pid = $_POST['patient'];

$res = $_POST['resource'];

$r_type = $_POST['rec_type'];
$e_length = empty($_POST['elength']) ? "''" : $_POST['elength'];
$e_pid = empty($_POST['epid']) ? "''" : $_POST['epid'];


require_once '../admin/includes/main_include.php';
require_once 'checkemail.php';
$s = "INSERT INTO dental_calendar
	(start_date, end_date, event_id, description, category, producer_id, docid, patientid, rec_type, event_length, event_pid, res_id)
	VALUES
	('".$sd."', '".$ed."', '".$id."', '".mysql_real_escape_string($de)."', '".$cat."', ".$pi.", '".$docid."', '".$pid."', '" . $r_type . "', " . $e_length . ", " . $e_pid . ", " . $res . ")";

if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
