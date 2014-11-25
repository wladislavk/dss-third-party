<?php
	require_once '../admin/includes/main_include.php';

	$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$s = "UPDATE dental_faxes SET viewed = 1
		WHERE id='".mysqli_real_escape_string($con,$id)."'";

	if($db->query($s)){
	  echo '{"success":true}';
	}else{
	  echo '{"error":true}';
	}
?>
