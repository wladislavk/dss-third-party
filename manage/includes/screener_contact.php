<?php
	include_once '../admin/includes/main_include.php';

	$id = $_REQUEST['id'];
	$c = $_REQUEST['c'];
	$s = "UPDATE dental_screener SET contacted = '".mysqli_real_escape_string($con,$c)."'
		  WHERE id='".mysqli_real_escape_string($con,$id)."'";

	echo $s;
	if($db->query($s)){
		echo '{"success":true}';
	}else{
		echo '{"error":true}';
	}
?>