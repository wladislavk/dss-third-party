<?php
	include_once '../admin/includes/main_include.php';

	$id = $_REQUEST['id'];
	$comp_date = $_REQUEST['comp_date'];
	$pid = $_REQUEST['pid'];
	$s = "SELECT * FROM dental_flow_pg2_info WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
	
	$r = $db->getRow($s);

	if($r['segmentid'] == 7){ //Update dental device date for device delivery step
		$last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".mysql_real_escape_string($pid)." ORDER BY date_completed DESC";
		
		$last_r = $db->getRow($last_sql);
		if($id == $last_r['id']){
			$sql = "SELECT * FROM dental_ex_page5 where patientid='".$pid."'";
			
			if($db->getNumberRows($sql) == 0){
				$s = "INSERT INTO dental_ex_page5 set 
        			  dentaldevice_date='".date('Y-m-d', strtotime(mysql_real_escape_string($comp_date)))."', 
        			  patientid='".$pid."',
        			  userid = '".s_for($_SESSION['userid'])."',
       	 			  docid = '".s_for($_SESSION['docid'])."',
        			  adddate = now(),
        			  ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
			} else {
				$db->query("UPDATE dental_ex_page5 SET dentaldevice_date='".date('Y-m-d', strtotime(mysql_real_escape_string($comp_date)))."' where patientid='".$pid."'");
			}
		}
	}

	$s = "update dental_flow_pg2_info set date_completed='".date('Y-m-d', strtotime($comp_date))."' WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
	$q = $db->query($s);

	if($q) {
	  echo '{"success":true}';
	} else {
	  echo '{"error":true}';
	}
?>
