<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../../admin/includes/main_include.php';
	include_once '../../includes/checkemail.php';

	$id = $_REQUEST['id'];

linkRequestData('dental_users', $id);

	$sql = "UPDATE dental_users SET status=1, recover_hash='', recover_time='' WHERE userid='".$db->escape($id)."'";
	$db->query($sql);
?>
