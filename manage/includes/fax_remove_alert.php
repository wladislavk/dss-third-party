<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$s = "UPDATE dental_faxes SET viewed = 1
	WHERE id='".mysql_real_escape_string($id)."'";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
