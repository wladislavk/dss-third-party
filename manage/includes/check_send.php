<?php
require_once '../admin/includes/main_include.php';
require_once 'checkemail.php';
$sql = "SELECT dp.*, du.use_patient_portal AS doc_use_patient_portal FROM dental_patients dp JOIN dental_users du ON du.userid=dp.docid WHERE dp.patientid='".mysql_real_escape_string($_REQUEST['id'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if(($r['registration_status'] == 1 || $r['registration_status'] == 2) && $r['use_patient_portal']==1 && $r['doc_use_patient_portal']==1 && $r['email']!=$_REQUEST['email']){
  echo '{"success":true}';
  die();
}
?>

