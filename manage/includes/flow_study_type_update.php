<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';

	$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$t = (!empty($_REQUEST['type']) ? $_REQUEST['type'] : '');
	$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

    $s = "UPDATE dental_flow_pg2_info SET
          study_type = '".mysqli_real_escape_string($con,$t)."'
          WHERE
          patientid = '".mysqli_real_escape_string($con,$pid)."' AND
          id = '".mysqli_real_escape_string($con,$id) . "'";

	$q = $db->query($s);
	if(!empty($q)){
	  echo '{"success":true}';
	}else{
	  echo '{"error":true}';
	}
?>
