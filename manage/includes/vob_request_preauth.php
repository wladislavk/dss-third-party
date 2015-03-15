<?php namespace Ds3\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';
	include_once '../includes/constants.inc';
	include_once '../includes/preauth_functions.php';

	$pid = (!empty($_POST['pid']) ? $_POST['pid'] : '');
	$c = create_vob( $pid );
	if ($c===true){
	  echo '{"success":true}';
	  $up_sql = "UPDATE dental_insurance_preauth SET viewed=1 WHERE (viewed=0 OR viewed is NULL) AND patient_id='".mysqli_real_escape_string($con,$pid)."'";
	  
	  $db->query($up_sql);
	}else{
	  echo '{"error":true, "code":"'.$c.'"}';
	}
?>
