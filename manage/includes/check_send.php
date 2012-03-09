<?php
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$sql = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_REQUEST['id'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if(($r['registration_status'] == 1 || $r['registration_status'] == 2) && $r['email']!=$_REQUEST['email']){
  echo '{"success":true}';
  die();
}
?>

