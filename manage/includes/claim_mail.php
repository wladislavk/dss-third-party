<?php
require_once '../admin/includes/main_include.php';
require_once '../admin/includes/general.htm';

$lid = $_REQUEST['lid'];
$mailed = $_REQUEST['mailed'];
$s = mail_claim($lid, $mailed);
if($s){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
