<?php
require_once '../admin/includes/main_include.php';
$id = $_REQUEST['id'];
$t = $_REQUEST['type'];
$pid = $_REQUEST['pid'];

                    $s = "UPDATE dental_flow_pg2_info SET
                        study_type = '".mysql_real_escape_string($t)."'
                        WHERE
                                patientid = ".mysql_real_escape_string($pid)." AND
                                id = ".mysql_real_escape_string($id);
                $q = mysql_query($s);
if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
