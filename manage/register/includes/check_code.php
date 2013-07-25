<?php
require_once '../../admin/includes/main_include.php';
require_once '../../includes/checkemail.php';
$sql = "SELECT * FROM dental_access_codes WHERE status='1' AND access_code = '".mysql_real_escape_string($_REQUEST['code'])."'";
$q = mysql_query($sql);
$n = mysql_num_rows($q);
if($n > 0){
  echo 'true';//'{"success":true}';
}else{
  echo 'false';//'{"error":false}';
}
?>
