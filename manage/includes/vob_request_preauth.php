<?php
require_once '../admin/includes/main_include.php';
require_once '../includes/constants.inc';
require_once '../includes/preauth_functions.php';
$pid = $_REQUEST['pid'];
$c = create_vob( $pid );
if ($c===true){
  echo '{"success":true}';
  $up_sql = "UPDATE dental_insurance_preauth SET viewed=1 WHERE (viewed=0 OR viewed is NULL) AND patient_id='".mysql_real_escape_string($pid)."'";
  mysql_query($up_sql);
}else{
  echo '{"error":true, "code":"'.$c.'"}';
}
?>
