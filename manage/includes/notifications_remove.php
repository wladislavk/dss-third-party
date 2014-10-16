<?php
	include_once '../admin/includes/main_include.php';

	$id = $_POST['id'];
	$s = "UPDATE dental_notifications SET status='2' WHERE id='".mysql_real_escape_string($id)."'";
	
	$q = $db->query($s);
	if($q){
	  echo '{"success":true}';
	}else{
	  echo '{"error":"update"}';
	}
?>
