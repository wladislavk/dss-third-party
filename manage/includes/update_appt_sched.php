<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once '../admin/includes/main_include.php';

  $id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
  $sched = (!empty($_REQUEST['sched'])) ? date('Y-m-d', strtotime((!empty($_REQUEST['sched']) ? $_REQUEST['sched'] : ''))) : '';
  $pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

  clean_steps($db, $pid);
  $let_sql = "SELECT use_letters, tracker_letters FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";

  $let_r = $db->getRow($let_sql);
  $create_letters = ($let_r['use_letters'] && $let_r['tracker_letters']);
	$s = "INSERT INTO dental_flow_pg2_info SET
    		patientid= ".$pid.",
    		segmentid = '".$id."',
    		appointment_type = 0,
    		date_scheduled = '".$sched."'";

	$info_id = $db->getInsertId($s);
  $consult_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' LIMIT 1;";
  
  $consult_result = $db->getResults($consult_query);

  $consult_date = $consult_result[0]['date_completed'];
  if ($consult_date != "0000-00-00") {
    $consulted = true;
  }

	if($create_letters){
    $letterid = array();
    if ($id == "2") { // Consultation
      $letterid[] = trigger_letter6($pid, $info_id);
    }

    if ($consulted == true && $id == "4") { // Impressions
          //$letterid[] = trigger_letter9($pid, $info_id);
          //$letterid[] = trigger_letter13($pid, $numsteps);
    }
	}

  if($info_id) {
    echo '{"success":true}';
  } else {
    echo '{"error":true}';
  }
?>

<?php
  function clean_steps($db, $pid)
  { //Deletes not completed steps and clears scheduled
    $con = $GLOBALS['con'];
    
    $s = "DELETE FROM dental_flow_pg2_info where patientid='".mysqli_real_escape_string($con,$pid)."' AND appointment_type=0";
    $db->query($s);
  }

  function trigger_letter6($pid, $info_id)
  {
    $letterid = '6';
    $topatient = '1';
    $letter = create_letter($letterid, $pid, $info_id, $topatient, '', '', '', '', '', 'paper');
    if (!is_numeric($letter)) {
      print "Can't send letter 6: " . $letter;
      die();
    } else {
      return $letter;
    }
  }

  function trigger_letter9($pid, $info_id)
  {
    $letterid = '9';
    $md_list = '';//get_mdcontactids($pid);
    $md_referral_list = get_mdreferralids($pid);
    $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
    if (!is_numeric($letter)) {
      print "Can't send letter 9: " . $letter;
      //die();
    } else {
      return $letter;
    }
  }

?>
