<?php
require_once '../admin/includes/config.php';
$d = $_REQUEST['device_date'];
$pid = $_REQUEST['pid'];
$d = date('Y-m-d', strtotime($d));
$s = "UPDATE dental_ex_page5 set dentaldevice_date='".mysql_real_escape_string($d)."' where patientid='".$pid."'";
$q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
