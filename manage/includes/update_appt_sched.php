<?php
require_once '../admin/includes/config.php';
//include_once '../admin/includes/general.htm';
$id = $_REQUEST['id'];
$sched = ($_REQUEST['sched']!='')?date('Y-m-d', strtotime($_REQUEST['sched'])):'';
$pid = $_REQUEST['pid'];
clean_steps($pid);
        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$pid."';";
        $fsData_query = mysql_query($fsData_sql);
        $fsData_array = mysql_fetch_array($fsData_query);

        if (!empty($fsData_array['steparray'])) {
                $order = explode(",",$fsData_array['steparray']);
        }
		$new_steparray = $fsData_array['steparray'].",".$id;
		$stepid=count($order)+1;
		$s = "INSERT INTO dental_flow_pg2_info SET
			patientid= ".$pid.",
			stepid = ".$stepid.",
			segmentid = ".$id.",
			date_scheduled = '".$sched."'";
		mysql_query($s); 
		$fsData_sql = "UPDATE `dental_flow_pg2` SET steparray='".mysql_real_escape_string($new_steparray)."' WHERE `patientid` = '".$pid."';";	
		$q = mysql_query($fsData_sql);


        $steparray_query = "SELECT steparray FROM dental_flow_pg2 WHERE patientid = '".$pid."';";
        $steparray_result = mysql_query($steparray_query);
        $result_array = mysql_fetch_array($steparray_result);
        $flowsheet_segments = explode(",", $result_array['steparray']);
	$numsteps = (count($flowsheet_segments));
        $topstep = array_pop($flowsheet_segments);
	$topstep = array_pop($flowsheet_segments);
        $segment_query = "SELECT segmentid, date_scheduled, date_completed, letterid FROM dental_flow_pg2_info WHERE stepid = '".$numsteps."' AND segmentid = '".$topstep."' AND patientid = '".$pid."' ORDER BY stepid DESC LIMIT 1;";
        $segment_result = mysql_query($segment_query);
        while ($row = mysql_fetch_assoc($segment_result)) {
                $laststep = $row;
        }

        if (!empty($laststep['letterid'])) {
                $letter = true;
        }
        $consult_query = "SELECT stepid, date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' ORDER BY stepid DESC LIMIT 1;";
        $consult_result = mysql_query($consult_query);
        $consult_stepid = mysql_result($consult_result, 0, 0);
        $consult_date = mysql_result($consult_result, 0, 1);
        if ($consult_date != "0000-00-00" && $consult_stepid < $numsteps) {
                $consulted = true;
        }
        $letterid = array();
        if ($sched != "" && !$letter && $topstep == "2") { // Consultation
//              $letterid[] = trigger_letter5($_GET['pid'], $numsteps);
                $letterid[] = trigger_letter6($pid, $numsteps);
        }
        if ($consulted == true && $sched != "" && !$letter && $topstep == "4") { // Impressions
                $letterid[] = trigger_letter9($pid, $numsteps);
                //$letterid[] = trigger_letter13($pid, $numsteps);
        }
        if ($datecomp != "" && !$letter && $topstep == "8") { // Follow-Up/Check
                $trigger_query = "SELECT dental_flow_pg2.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2  JOIN dental_flow_pg2_info ON dental_flow_pg2.patientid=dental_flow_pg2_info.patientid WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2.steparray LIKE '%7%8%' AND dental_flow_pg2.patientid = '".$_GET['pid']."';";
                $trigger_result = mysql_query($trigger_query);
                $numrows = (mysql_num_rows($trigger_result));
                if ($numrows > 0) {
                        $letterid[] = trigger_letter16($pid, $numsteps);
                }
        }
        if ($datecomp != "" && !$letter && $topstep == "13") { // Termination
                $letterid[] = trigger_letter24($pid, $numsteps);
        }








if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>

<?php
function clean_steps($pid){
	
	$s = "SELECT stepid, segmentid, date_scheduled, date_completed from dental_flow_pg2_info where patientid=".$pid;
	$q = mysql_query($s);
	while($r = mysql_fetch_assoc($q)){
	  if( $r['date_completed']==''){
		        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$pid."';";
        		$fsData_query = mysql_query($fsData_sql);
        		$fsData_array = mysql_fetch_array($fsData_query);

        		if (!empty($fsData_array['steparray'])) {
                		$order = explode(",",$fsData_array['steparray']);
        		}
                unset($order[array_search($r['segmentid'], $order)]);
                $order = array_values($order);
                $new_steparray = implode($order, ',');
        $fsData_sql = "UPDATE `dental_flow_pg2` SET steparray='".mysql_real_escape_string($new_steparray)."' WHERE `patientid` = '".$pid."';";
        $s = mysql_query($fsData_sql);
                $s = "DELETE FROM dental_flow_pg2_info
                        WHERE segmentid = ".$r['segmentid']."
                                AND patientid=".$pid;
                mysql_query($s);
                foreach($order as $i => $o){
                        $u = "UPDATE dental_flow_pg2_info set stepid=".($i+1)."
                        WHERE segmentid = ".$o."
                                AND patientid=".$pid;
                        mysql_query($u);
                }

	  }else{
		mysql_query("UPDATE dental_flow_pg2_info set 
                        date_scheduled=''
                        WHERE stepid=".$r['stepid']);
	  }
	}

} 




function trigger_letter5($pid, $stepid) {
        $letterid = '5';
        $topatient = '1';
        $letter = create_letter($letterid, $pid, $stepid, $topatient, '', '', '', '', 'email');
        if (!is_numeric($letter)) {
                print "Can't send letter 5: " . $letter;
                die();
        } else {
                return $letter;
        }
}

function trigger_letter6($pid, $stepid) {
        $letterid = '6';
        $topatient = '1';
        $letter = create_letter($letterid, $pid, $stepid, $topatient, '', '', '', '', 'paper');
        if (!is_numeric($letter)) {
                print "Can't send letter 6: " . $letter;
                die();
        } else {
                return $letter;
        }
}

function trigger_letter7($pid, $stepid) {
  $letterid = '7';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
        //if ($md_referral_list != "") {
                $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
                if (!is_numeric($letter)) {
                        print "Can't send letter 7: " . $letter;
                        die();
                } else {
                        return $letter;
                }
        //}
}

function trigger_letter8($pid, $stepid) {
  $letterid = '8';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $stepid, $topatient);
  if (!is_numeric($letter)) {
    print "Can't send letter 8: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter9($pid, $stepid) {
  $letterid = '9';
  $md_list = '';//get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);

        //if ($md_referral_list != "") {
                $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
                if (!is_numeric($letter)) {
                        print "Can't send letter 9: " . $letter;
                        //die();
                } else {
                        return $letter;
                }
        //}
}

function trigger_letter10($pid, $stepid) {
  $letterid = '10';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
        //if ($md_referral_list != "") {
                $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
                if (!is_numeric($letter)) {
                        print "Can't send letter 10: " . $letter;
                        die();
                } else {
                        return $letter;
                }
        //}
}


function trigger_letter11($pid, $stepid) {
  $letterid = '11';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
        //if ($md_referral_list != "") {
                $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
                if (!is_numeric($letter)) {
                        print "Can't send letter 11: " . $letter;
                        die();
                } else {
                        return $letter;
                }
        //}
}

function trigger_letter13($pid, $stepid) {
  $letterid = '13';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 13: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter16($pid, $stepid) {
  $letterid = '16';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 16: " . $letter;
    die();
  } else {
    return $letter;
  }
}


function trigger_letter17($pid, $stepid) {
  $letterid = '17';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 17: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter19($pid, $stepid) {
  $letterid = '19';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 19: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter20($pid) {
  $letterid = '20';
  $md_list = get_mdcontactids($pid);
        $pt_referral_list = get_ptreferralids($pid);
  $letter = create_letter($letterid, $pid, '', '', $md_list, $pt_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 20: " . $letter;
    die();
  } else {
    return $letter;
  }
}



function trigger_letter24($pid, $stepid) {
  $letterid = '24';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $stepid, $topatient);
  if (!is_numeric($letter)) {
    print "Can't send letter 24: " . $letter;
    die();
  } else {
    return $letter;
  }
}



?>
