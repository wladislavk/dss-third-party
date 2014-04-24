<?php
require_once '../admin/includes/main_include.php';
require_once '../admin/includes/general.htm';
require_once 'claim_functions.php';

$lid = $_REQUEST['lid'];
$mailed = $_REQUEST['mailed'];
$type = $_REQUEST['type'];
$s = mail_claim($lid, $mailed, $type);
if($s){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
