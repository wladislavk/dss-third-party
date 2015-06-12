<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';

	$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
	$s = "DELETE from dental_flow_pg2_info WHERE id = ".mysqli_real_escape_string($con,$id)." AND patientid=".mysqli_real_escape_string($con,$pid);
	
	$q = $db->query($s);
	if(!empty($q)){
        $db->query("DELETE FROM dental_letters where info_id = ".mysqli_real_escape_string($con,$id));
		echo '{"success":true}';
	} else {
	  	echo '{"error":true}';
	}
?>
