<?php
require_once '../admin/includes/config.php';
require_once '../admin/includes/general.htm';

$lid = $_REQUEST['lid'];
$type = $_REQUEST['type'];
$rid = $_REQUEST['rid'];
$par = $_REQUEST['par'];
$s = delete_letter($lid, $par, $type, $rid);
if($s){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
