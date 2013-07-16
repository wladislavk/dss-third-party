<?php
require_once '../admin/includes/main_include.php';
$id = $_REQUEST['id'];
$pid = $_REQUEST['pid'];
		$s = "DELETE from dental_flow_pg2_info WHERE id=".mysql_real_escape_string($id)." AND patientid=".mysql_real_escape_string($pid);
		$q = mysql_query($s);
		if($q){
                  mysql_query("DELETE FROM dental_letters where info_id=".mysql_real_escape_string($id));
		}

if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
