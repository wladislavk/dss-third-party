<?php
require_once '../admin/includes/config.php';
require_once 'checkemail.php';
$e = checkEmail($_REQUEST['email'], $_REQUEST['id']);
if($e==0){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>

