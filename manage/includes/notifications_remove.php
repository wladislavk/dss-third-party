<?php
require_once '../admin/includes/config.php';
$id = $_POST['id'];
$s = "UPDATE dental_notifications SET status='2' WHERE id='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":"update"}';
}
?>
