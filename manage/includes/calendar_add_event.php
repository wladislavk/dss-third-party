<?php
session_start();
$docid = $_SESSION['docid'];
$sd = $_POST['start_date'];
$ed = $_POST['end_date'];
$de = $_POST['description'];
$id = $_POST['id'];
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$s = "INSERT INTO dental_calendar
	(start_date, end_date, event_id, description, docid)
	VALUES
	('".$sd."', '".$ed."', '".$id."', '".$de."', '".$docid."')";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
