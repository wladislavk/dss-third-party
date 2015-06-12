<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';

	$f = (!empty($_POST['field']) ? $_POST['field'] : '');
	$v = (!empty($_POST['val']) ? $_POST['val'] : '');
	$p = (!empty($_POST['pid']) ? $_POST['pid'] : '');
	$t = (!empty($_POST['table']) ? $_POST['table'] : '');
	$s = "UPDATE ".mysqli_real_escape_string($con,$t)." SET ".mysqli_real_escape_string($con,$f)."='".mysqli_real_escape_string($con,$v)."' WHERE patientid='".mysqli_real_escape_string($con,$p)."' OR parent_patientid='".mysqli_real_escape_string($con,$p)."'";
	
	$q = $db->query($s);
	if($q){
	  echo '{"success":true}';
	}else{
	  echo '{"error":"mysql"}';
	}
?>
