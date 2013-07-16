<?php
require_once '../admin/includes/main_include.php';
$f = $_POST['field'];
$v = $_POST['val'];
$p = $_POST['pid'];
$t = $_POST['table'];
$s = "UPDATE ".mysql_real_escape_string($t)." SET ".mysql_real_escape_string($f)."='".mysql_real_escape_string($v)."' WHERE patientid='".mysql_real_escape_string($p)."' OR parent_patientid='".mysql_real_escape_string($p)."'";
$q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":"mysql"}';
}
?>
