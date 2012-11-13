<?php
require_once '../admin/includes/config.php';
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
$q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
