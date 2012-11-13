<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$comp_date = $_REQUEST['comp_date'];
$pid = $_REQUEST['pid'];

		$s = "SELECT * FROM dental_flow_pg2_info WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);
		$r = mysql_fetch_assoc($q);

		if($r['segmentid'] == 7){ //Update dental device date for device delivery step
			$sql = "SELECT * FROM dental_ex_page5 where patientid='".$pid."'";
			$q = mysql_query($sql);
			if(mysql_num_rows($q)==0){
  				$s = "INSERT INTO dental_ex_page5 set 
                			dentaldevice='".mysql_real_escape_string($d)."', 
                			patientid='".$pid."',
                			userid = '".s_for($_SESSION['userid'])."',
               	 			docid = '".s_for($_SESSION['docid'])."',
                			adddate = now(),
                			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
			}else{

				mysql_query("UPDATE dental_ex_page5 SET dentaldevice_date='".date('Y-m-d', strtotime(mysql_real_escape_string($comp_date)))."' where patientid='".$pid."'");
			}
		}


		$s = "update dental_flow_pg2_info set date_completed='".date('Y-m-d', strtotime($comp_date))."' WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
