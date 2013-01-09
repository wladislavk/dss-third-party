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
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$s = "INSERT INTO dental_calendar
	(start_date, end_date, event_id, description, category, producer_id, docid, patientid)
	VALUES
	('".$sd."', '".$ed."', '".$id."', '".mysql_real_escape_string($de)."', '".$cat."', ".$pi.", '".$docid."', '".$pid."')";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
