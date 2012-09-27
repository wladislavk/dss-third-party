<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$d = $_REQUEST['device'];
$pid = $_REQUEST['pid'];

$sql = "update dental_ex_page5 set dentaldevice='".mysql_real_escape_string($d)."' where patientid='".$pid."'";
$q = mysql_query($sql);

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
