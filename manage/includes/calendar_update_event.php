<?php
session_start();
$docid = $_SESSION['docid'];
$sd = $_POST['start_date'];
$ed = $_POST['end_date'];
$de = $_POST['description'];
$cat = $_POST['category'];
$pi = $_POST['producer'];
$pid = $_POST['patient'];
$e_id = $_POST['e_id'];
$t_id = $_POST['t_id'];
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$s = "UPDATE dental_calendar SET
	start_date='".$sd."',
	end_date='".$ed."',
	event_id='".$e_id."',
	description='".mysql_real_escape_string($de)."',
	category='".$cat."',
	producer_id=".$pi.",
	patientid=".$pid."
	WHERE id='".$t_id."'";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
