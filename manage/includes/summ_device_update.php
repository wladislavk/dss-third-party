<?php
require_once '../admin/includes/config.php';
$d = $_REQUEST['device'];
$pid = $_REQUEST['pid'];

$s = "UPDATE dental_ex_page5 set dentaldevice='".mysql_real_escape_string($d)."' where patientid='".$pid."'";
$q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
