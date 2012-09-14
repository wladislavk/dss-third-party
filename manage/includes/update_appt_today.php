<?php
require_once '../admin/includes/config.php';
$id = $_REQUEST['id'];
$c = $_REQUEST['c'];
$pid = $_REQUEST['pid'];
        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$pid."';";
        $fsData_query = mysql_query($fsData_sql);
        $fsData_array = mysql_fetch_array($fsData_query);

        if (!empty($fsData_array['steparray'])) {
                $order = explode(",",$fsData_array['steparray']);
        }
		$new_steparray = $fsData_array['steparray'].",".$id;
		$stepid=count($order)+1;
		$s = "SELECT * from dental_flow_pg2_info WHERE segmentid=".$id." AND patientid=".$pid;
		$q = mysql_query($s);
		//echo mysql_num_rows($q);
		    $s = "INSERT INTO dental_flow_pg2_info SET
			patientid= ".$pid.",
			stepid = ".$stepid.",
			segmentid = ".$id.",
			date_completed = CURDATE()";
		mysql_query($s); 
                $new_steparray = $fsData_array['steparray'].",".$id;
                $stepid=count($order)+1;
        $fsData_sql = "UPDATE `dental_flow_pg2` SET steparray='".mysql_real_escape_string($new_steparray)."' WHERE `patientid` = '".$pid."';";
        $s = mysql_query($fsData_sql);


if($s){
  echo '{"success":true, "datecomp":"'.date('m/d/Y').'"}';
}else{
  echo '{"error":true}';
}
?>
