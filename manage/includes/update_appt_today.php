<?php
require_once '../admin/includes/config.php';
require_once 'letter_triggers.php';
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
		$numsteps = $stepid;
		$s = "SELECT * from dental_flow_pg2_info WHERE segmentid=".$id." AND patientid=".$pid;
		$q = mysql_query($s);
		//echo mysql_num_rows($q);
		    $s = "INSERT INTO dental_flow_pg2_info SET
			patientid= ".$pid.",
			stepid = ".$stepid.",
			segmentid = ".$id.",
			date_completed = CURDATE()";
		mysql_query($s); 
		$insert_id=mysql_insert_id();
                $new_steparray = $fsData_array['steparray'].",".$id;
                $stepid=count($order)+1;
        $fsData_sql = "UPDATE `dental_flow_pg2` SET steparray='".mysql_real_escape_string($new_steparray)."' WHERE `patientid` = '".$pid."';";
        $s = mysql_query($fsData_sql);


        if ($id == "8") { // Follow-Up/Check
                $trigger_query = "SELECT dental_flow_pg2.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2  JOIN dental_flow_pg2_info ON dental_flow_pg2.patientid=dental_flow_pg2_info.patientid WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2.steparray LIKE '%7%8%' AND dental_flow_pg2.patientid = '".$pid."';";
                $trigger_result = mysql_query($trigger_query);
                $numrows = (mysql_num_rows($trigger_result));
                if ($numrows > 0) {
                        $letterid[] = trigger_letter16($pid, $numsteps);
                }
        }
        if ($id == "13") { // Termination
		echo trigger_letter24($pid, $numsteps); 
                //$letterid[] = trigger_letter24($pid, $numsteps);
        }

                                                        $consult_query = "SELECT stepid, date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' ORDER BY stepid DESC LIMIT 1;";
                                                        $consult_result = mysql_query($consult_query);
                                                        $consult_stepid = mysql_result($consult_result, 0, 0);
                                                        $consult_date = mysql_result($consult_result, 0, 1);
                                                        if ($consult_date != "0000-00-00" && $consult_stepid < $numsteps) {
                                                                $consulted = true;
                                                        }
                                                        // Delaying Treatment / Waiting
                                                        if ($consulted == true && $value == "5") {
                                                                $letterid[] = trigger_letter10($pid, $numsteps);
                                                        }
                                                        // Refused Treatment
                                                        if ($consulted == true && $value == "6") {
                                                                $letterid[] = trigger_letter8($pid, $numsteps);
                                                                $letterid[] = trigger_letter11($pid, $numsteps);
                                                        }
                                                        // Patient Non Compliant
                                                        if ($value == "9") {
                                                                $letterid[] = trigger_letter17($pid, $numsteps);
                                                        }
                                                        // Treatment Complete
                                                        if ($value == "11") {
                                                                $letterid[] = trigger_letter19($pid, $numsteps);
                                                        }
                                                        if ($value == "14") {
                                                                $letterid[] = trigger_letter7($pid, $numsteps);
                                                        }





$segments = Array();
$segments[15] = "Baseline Sleep Test";
$segments[2] = "Consult";
$segments[4] = "Impressions";
$segments[7] = "Device Delivery";
$segments[8] = "Check / Follow Up";
$segments[10] = "Home Sleep Test";
$segments[3] = "Sleep Study";
$segments[11] = "Treatment Complete";
$segments[12] = "Annual Recall";
$segments[14] = "Not a Candidate";
$segments[5] = "Delaying Tx / Waiting";
$segments[9] = "Pt. Non-Compliant";
$segments[6] = "Refused Treatment";
$segments[13] = "Termination";

$title = $segments[$id];

if($s){
  echo '{"success":true, "datecomp":"'.date('m/d/Y').'", "id":"'.$insert_id.'", "title":"'.$title.'"}';
}else{
  echo '{"error":true}';
}
?>
