<?php
	include_once '../admin/includes/main_include.php';

	$id = (!empty($_POST['id']) ? $_POST['id'] : '');
	$s = "UPDATE dental_notifications SET status='2' WHERE id='".mysqli_real_escape_string($con,$id)."'";
	
	$q = $db->query($s);
	if(!empty($q)){
	  echo '{"success":true}';
	}else{
	  echo '{"error":"update"}';
	}
?>
