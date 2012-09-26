<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$device_date = $_REQUEST['device_date'];
$pid = $_REQUEST['pid'];
		$s = "update dental_flow_pg2_info set device_date='".date('Y-m-d', strtotime(mysql_real_escape_string($device_date)))."' WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);
	
	mysql_query("UPDATE dental_ex_page5 SET dentaldevice_date='".date('Y-m-d', strtotime(mysql_real_escape_string($device_date)))."' where patientid='".$pid."'");

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
