<?php
	include_once '../admin/includes/main_include.php';
	
	$ids = $_REQUEST['ids'];
	$s = "UPDATE dental_notes SET signed_id = '".mysql_real_escape_string($_SESSION['userid'])."',
			signed_on = now()
	        WHERE notesid IN (".mysql_real_escape_string($ids).")";

	if($db->query($s)){
		echo '{"success":true}';
	}else{
	 	echo '{"error":true}';
	}
?>