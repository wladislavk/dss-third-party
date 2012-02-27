<?php
require_once '../../manage/admin/includes/config.php';
require_once '../../manage/includes/checkemail.php';
$e = checkEmail($_REQUEST['email'], $_REQUEST['id']);
if($e==0){
  echo 'true';//'{"success":true}';
}else{
  echo 'false';//'{"error":false}';
}
?>
