<?php
session_start();
$docid = $_SESSION['docid'];
$e_id = $_POST['e_id'];
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$s = "delete from dental_calendar
	WHERE event_id='".$e_id."'";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
