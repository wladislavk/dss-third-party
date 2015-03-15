<?php namespace Ds3\Legacy; ?><?php
	$docid = $_SESSION['docid'];
	$e_id = $_POST['e_id'];

	$foo = (string) $e_id;
	if(strpos($foo, '#') !== FALSE) {
		return;
	} else {
		include_once '../admin/includes/main_include.php';
		include_once 'checkemail.php';
		$s = "delete from dental_calendar
			WHERE event_id='".$e_id."'";
		
		if($db->query($s)) {
		  echo '{"success":true}';
		} else {
		  echo '{"error":true}';
		}
	}
?>
