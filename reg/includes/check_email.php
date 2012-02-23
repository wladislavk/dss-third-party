<?php
require_once '../../manage/admin/includes/config.php';
require_once '../../manage/includes/checkemail.php';
$e = checkEmail($_POST['email'], $_POST['id']);

if($e==0){
  echo '{"success":true}';
}else{
  echo '{"error":"taken"}';
}
?>
