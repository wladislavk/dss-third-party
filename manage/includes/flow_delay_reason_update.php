<?php
	include_once '../admin/includes/main_include.php';

	$id = $_REQUEST['id'];
	$r = $_REQUEST['reason'];
	$pid = $_REQUEST['pid'];
    $s = "UPDATE dental_flow_pg2_info SET
          delay_reason = '".mysql_real_escape_string($r)."'
          WHERE
          patientid = ".mysql_real_escape_string($pid)." AND
          id = ".mysql_real_escape_string($id);

	$q = $db->query($s);
	if($q){
	  echo '{"success":true}';
	}else{
	  echo '{"error":true}';
	}
?>
