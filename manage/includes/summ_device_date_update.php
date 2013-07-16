<?php
require_once '../admin/includes/main_include.php';
$d = $_REQUEST['device_date'];
$pid = $_REQUEST['pid'];
$d = date('Y-m-d', strtotime($d));
$sql = "SELECT * FROM dental_ex_page5 where patientid='".$pid."'";
$q = mysql_query($sql);
if(mysql_num_rows($q)==0){
  $s = "INSERT INTO dental_ex_page5 set 
                dentaldevice_date='".mysql_real_escape_string($d)."', 
                patientid='".$pid."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
}else{
  $s = "UPDATE dental_ex_page5 set dentaldevice_date='".mysql_real_escape_string($d)."' where patientid='".$pid."'";
}

                        $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".mysql_real_escape_string($pid)." ORDER BY date_completed DESC";
                        $last_q = mysql_query($last_sql);
                        $last_r = mysql_fetch_assoc($last_q);
			$u = "UPDATE dental_flow_pg2_info SET date_completed='".mysql_real_escape_string($d)."' WHERE id='".$last_r['id']."'";
			mysql_query($u);

$q = mysql_query($s);

  $imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysql_real_escape_string($pid)."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
  $imp_q = mysql_query($imp_s);
  $imp_r = mysql_fetch_assoc($imp_q);
  $flow_sql = "UPDATE dental_flow_pg2_info SET
                completed_date='".mysql_real_escape_string($d)."'
                WHERE id='".mysql_real_escape_string($imp_r['id'])."'";
  mysql_query($flow_sql);


if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
