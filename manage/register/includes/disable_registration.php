<?php
	include_once '../../admin/includes/main_include.php';
	include_once '../../includes/checkemail.php';

	$id = $_REQUEST['id'];
	$sql = "UPDATE dental_users SET status=1, recover_hash='', recover_time='' WHERE userid='".mysql_real_escape_string($id)."'";
	$db->query($sql);
?>
