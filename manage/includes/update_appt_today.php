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
	if(!$c){
		unset($order[array_search($id, $order)]);
		$order = array_values($order);
		$new_steparray = implode($order, ',');
        $fsData_sql = "UPDATE `dental_flow_pg2` SET steparray='".mysql_real_escape_string($new_steparray)."' WHERE `patientid` = '".$pid."';";
        $s = mysql_query($fsData_sql);

                $s = "DELETE FROM dental_flow_pg2_info
			WHERE segmentid = ".$id."
				AND patientid=".$pid;
                mysql_query($s);
		foreach($order as $i => $o){
			$u = "UPDATE dental_flow_pg2_info set stepid=".($i+1)."
                        WHERE segmentid = ".$o."
                                AND patientid=".$pid;				
			mysql_query($u);
		}
	}else{
		$new_steparray = $fsData_array['steparray'].",".$id;
		$stepid=count($order)+1;
		$s = "SELECT * from dental_flow_pg2_info WHERE segmentid=".$id." AND patientid=".$pid;
		$q = mysql_query($s);
		echo mysql_num_rows($q);
		if(mysql_num_rows($q)==0){
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

		}else{
                    $s = "update dental_flow_pg2_info SET
                        date_completed = CURDATE(),
			date_scheduled = NULL
			WHERE segmentid=".$id." AND patientid=".$pid;
                mysql_query($s);
		}
	}

if($s){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>
