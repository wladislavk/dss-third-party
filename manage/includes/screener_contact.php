<?php
require_once '../admin/includes/main_include.php';
$id = $_REQUEST['id'];
$c = $_REQUEST['c'];
$s = "UPDATE dental_screener SET contacted = '".mysql_real_escape_string($c)."'
	WHERE id='".mysql_real_escape_string($id)."'";
echo $s;
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
