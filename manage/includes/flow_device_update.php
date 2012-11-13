<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$d = $_REQUEST['device'];
$pid = $_REQUEST['pid'];

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
  $sql = "update dental_ex_page5 set dentaldevice='".mysql_real_escape_string($d)."' where patientid='".$pid."'";
}
$q = mysql_query($sql);

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
