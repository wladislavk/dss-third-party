<?php namespace Ds3\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';
	
	if (!empty($_REQUEST['ids'])) {
		$ids = $_REQUEST['ids'];
	} else {
		$ids = '';
	}
	$s = "UPDATE dental_notes SET signed_id = '".mysqli_real_escape_string($con,$_SESSION['userid'])."',
			signed_on = now()
	        WHERE notesid IN (".mysqli_real_escape_string($con,$ids).")";

	if($db->query($s)){
		echo '{"success":true}';
	}else{
	 	echo '{"error":true}';
	}
?>
