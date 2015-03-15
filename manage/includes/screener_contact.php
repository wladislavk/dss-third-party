<?php namespace Ds3\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';

	if (!empty($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
	} else {
		$id = '';
	}

	if (!empty($_REQUEST['c'])) {
		$c = $_REQUEST['c'];
	} else {
		$c = '';
	}
	
	$s = "UPDATE dental_screener SET contacted = '".mysqli_real_escape_string($con,$c)."'
		  WHERE id='".mysqli_real_escape_string($con,$id)."'";

	echo $s;
	if($db->query($s)){
		echo '{"success":true}';
	}else{
		echo '{"error":true}';
	}
?>
