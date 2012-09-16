<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$pid = $_REQUEST['pid'];
		$s = "DELETE from dental_flow_pg2_info WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
