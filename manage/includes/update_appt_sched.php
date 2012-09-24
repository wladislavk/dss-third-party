<?php
require_once '../admin/includes/config.php';
//include_once '../admin/includes/general.htm';
$id = $_REQUEST['id'];
$sched = ($_REQUEST['sched']!='')?date('Y-m-d', strtotime($_REQUEST['sched'])):'';
$pid = $_REQUEST['pid'];
clean_steps($pid);
		$s = "INSERT INTO dental_flow_pg2_info SET
			patientid= ".$pid.",
			segmentid = ".$id.",
			date_scheduled = '".$sched."'";
		$q = mysql_query($s); 


        $consult_query = "SELECT stepid, date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' ORDER BY stepid DESC LIMIT 1;";
        $consult_result = mysql_query($consult_query);
        $consult_stepid = mysql_result($consult_result, 0, 0);
        $consult_date = mysql_result($consult_result, 0, 1);
        if ($consult_date != "0000-00-00" && $consult_stepid < $numsteps) {
                $consulted = true;
        }
        $letterid = array();
        if ($id == "2") { // Consultation
//              $letterid[] = trigger_letter5($_GET['pid'], $numsteps);
                $letterid[] = trigger_letter6($pid, $numsteps);
        }
        if ($consulted == true && $id == "4") { // Impressions
                $letterid[] = trigger_letter9($pid, $numsteps);
                //$letterid[] = trigger_letter13($pid, $numsteps);
        }








if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>

<?php
function clean_steps($pid){ //Deletes not completed steps and clears scheduled
	
	$s = "SELECT id, segmentid, date_scheduled, date_completed from dental_flow_pg2_info where patientid=".$pid;
	$q = mysql_query($s);
	while($r = mysql_fetch_assoc($q)){
	  if( $r['date_completed']==''){
                $s = "DELETE FROM dental_flow_pg2_info
                        WHERE id = ".$r['id']."
                                AND patientid=".$pid;
                mysql_query($s);

	  }else{
		mysql_query("UPDATE dental_flow_pg2_info set 
                        date_scheduled=''
                        WHERE id=".$r['id']);
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
