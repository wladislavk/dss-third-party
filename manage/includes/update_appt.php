<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$comp_date = $_REQUEST['comp_date'];
$pid = $_REQUEST['pid'];

		$s = "SELECT * FROM dental_flow_pg2_info WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);
		$r = mysql_fetch_assoc($q);

		if($r['segmentid'] == 7){ //Update dental device date for device delivery step
			mysql_query("UPDATE dental_ex_page5 SET dentaldevice_date='".date('Y-m-d', strtotime(mysql_real_escape_string($comp_date)))."' where patientid='".$pid."'");
		}


		$s = "update dental_flow_pg2_info set date_completed='".date('Y-m-d', strtotime($comp_date))."' WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
