<?php
require_once '../admin/includes/config.php';
require_once '../includes/constants.inc';
require_once '../includes/preauth_functions.php';
$pid = $_REQUEST['pid'];
$c = create_vob( $pid );
if ($c===true){
  echo '{"success":true}';
}else{
  echo '{"error":true, "code":"'.$c.'"}';
}
?>
