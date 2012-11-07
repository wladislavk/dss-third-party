<?php
require_once '../../admin/includes/config.php';
require_once '../../includes/checkemail.php';
$e = checkUsername($_REQUEST['username'], $_REQUEST['id']);
if($e==0){
  echo 'true';//'{"success":true}';
}else{
  echo 'false';//'{"error":false}';
}
?>
