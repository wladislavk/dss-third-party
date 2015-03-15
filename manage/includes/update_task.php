<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';
	include_once 'checkemail.php';

	$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$s = "UPDATE dental_task SET status = 1
		  WHERE id='".mysqli_real_escape_string($con,$id)."'";

	if($db->query($s)){
	  echo '{"success":true}';
	}else{
	  echo '{"error":true}';
	}
?>
