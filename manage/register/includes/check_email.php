<?php
require_once '../../admin/includes/main_include.php';
require_once '../../includes/checkemail.php';
$e = checkUserEmail($_REQUEST['email'], $_REQUEST['id']);
if($e==0){
  echo 'true';//'{"success":true}';
}else{
  echo 'false';//'{"error":false}';
}
?>
