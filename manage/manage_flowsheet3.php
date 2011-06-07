<?php include "includes/top.htm";
require_once('includes/constants.inc');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("[id^=delay_reason]").each(function() {
			var reason = $(this).attr('id');
			var button = reason.replace("delay_reason", "reason_btn");
			var description = reason.replace("delay_reason", "description");
			var row = reason.replace("delay_reason", "delayingtreatmentrow");
			if ($("#" + reason).val() == "other") {
				$("#" + button).attr("style", "display:inline;");
				$("tr." + row + " > td").attr("style", "border-bottom: 0px none;");
				$("#" + description).attr("style", "display:table-cell;");
			}
			$("#" + reason).change(function() {
				if ($(this).val() == "other") {
					$('#page2form').submit();
					$("#" + button).attr("style", "display:inline;");
					$("tr." + row + " > td").attr("style", "border-bottom: 0px none;");
					$("#" + description).attr("style", "display:table-cell;");
				} else {
					$("#" + button).attr("style", "display:none;");
					$("tr." + row + " > td").attr("style", "border-bottom: 1px solid #000000;");
					$("#" + description).attr("style", "display:none;");
				}
			});
		});
		$("[id^=noncomp_reason]").each(function() {
			var reason = $(this).attr('id');
			var button = reason.replace("noncomp_reason", "reason_btn");
			var description = reason.replace("noncomp_reason", "description");
			var row = reason.replace("noncomp_reason", "patientnoncomprow");
			if ($("#" + reason).val() == "other") {
				$("#" + button).attr("style", "display:inline;");
				$("tr." + row + " > td").attr("style", "border-bottom: 0px none;");
				$("#" + description).attr("style", "display:table-cell;");
			}
			$("#" + reason).change(function() {
				if ($(this).val() == "other") {
					$('#page2form').submit();
					$("#" + button).attr("style", "display:inline;");
					$("tr." + row + " > td").attr("style", "border-bottom: 0px none;");
					$("#" + description).attr("style", "display:table-cell;");
				} else {
					$("#" + button).attr("style", "display:none;");
					$("tr." + row + " > td").attr("style", "border-bottom: 1px solid #000000;");
					$("#" + description).attr("style", "display:none;");
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(':input').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#form_page1').submit(function() {
			if($('#iframestatus').val() == "dirty") {
				window.onbeforeunload = confirmExit;
			} else {
				window.onbeforeunload = null;
			}
		});
		$('#page2form').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#additional-preauth').click(function(e) {
			var r = confirm("You have already requested a Pre-Authorization. Are you sure you want to request an additional Pre-Authorization?");
			if (r == false) {
				e.preventDefault();
			}
		});
	});
</script>


<script type="text/javascript">
	$(document).ready(function() {
		if ($('#datecomp0').val() == "") {
			$('#stepselectedsubmit').css("display", "none");
		}
		$('#datecomp0').change(function() {
			if ($('#datecomp0').val() != "") {
				$('#stepselectedsubmit').css("display", "inline");
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#').click(function() {
			var edit_id = $(this).attr('id');
			var num = edit_id.replace("edit", "");
			$('#view'+num).css("display", "none");
			$('#edit'+num).css("display", "none");
			$('#file'+num).css("display", "inline");
		});
	});
</script>
<?php

function preauth_allowed(){

  $pa_sql = "SELECT * FROM dental_insurance_preauth WHERE patient_id=".$_GET['pid'];
  $pa = mysql_query($pa_sql);
  if(mysql_num_rows($pa)>0)
    return false;

  $sql = "SELECT "
       . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
       . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
       . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
       . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
       . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
       . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "
       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
       . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
       . "  d.userid as 'doc_id'  "
       . "FROM "
       . "  dental_patients p  "
       . "  JOIN dental_referredby r ON p.referred_by = r.referredbyid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE "
       . "  p.patientid = ".$_GET['pid'];

  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    return false;
  }

$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
  return false;
}else{
    $flow = mysql_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $clinnotereq = $flow['clinnotereq'];
    $clinnoterec = $flow['clinnoterec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}



    if( $insinforec == '' || $rxreq == '' || $rxrec == '' || $lomnreq == '' || $lomnrec == '' || $clinnotereq == '' || $clinnoterec == ''){
       return false;
     }



return true;
}


function preauth_errors(){
  $errors = array();
  $pa_sql = "SELECT * FROM dental_insurance_preauth WHERE patient_id=".$_GET['pid'];
  $pa = mysql_query($pa_sql);
  /*if(mysql_num_rows($pa)>0)
    array_push($errors, "Already has pre-authorization"); */

   $sql = "SELECT * FROM dental_patients p JOIN dental_referredby r ON p.referred_by = r.referredbyid WHERE p.patientid=".$_GET['pid'];
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing referral"); 
  }
  $sql = "SELECT * FROM dental_patients p JOIN dental_contact i ON p.p_m_ins_co = i.contactid WHERE p.patientid=".$_GET['pid'];
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing insurance company");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_users d ON p.docid = d.userid WHERE p.patientid=".$_GET['pid'];
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing doctor");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' WHERE p.patientid=".$_GET['pid'];
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing transaction code E0486");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_q_page2 q2 ON p.patientid = q2.patientid WHERE p.patientid=".$_GET['pid'];
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing questionnaire page 3"); // The file and table are named q_page2, but this is displayed on page 3 of questionnaire
  }


$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
  array_push($errors, "Doesn\'t have flowsheet.");
}else{
    $flow = mysql_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $clinnotereq = $flow['clinnotereq'];
    $clinnoterec = $flow['clinnoterec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}


    if($insinforec == '' || /*$rxreq == '' ||*/ $rxrec == '' || /*$lomnreq == '' ||*/ $lomnrec == '' || /*$clinnotereq == '' ||*/ $clinnoterec == ''){
       array_push($errors, "Medical insurance dates are not filled out."); 
     }



return $errors;
}



if(isset($_GET['pid']) && isset($_GET['preauth'])){

  $sql = "SELECT "
       . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
       . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
       . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
       . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
       . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
       . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "
       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
       . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
       . "  d.userid as 'doc_id', p.home_phone as 'patient_phone'  "
       . "FROM "
       . "  dental_patients p  "
       . "  JOIN dental_referredby r ON p.referred_by = r.referredbyid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE "
       . "  p.patientid = ".$_GET['pid'];

  $my = mysql_query($sql);
  $my_array = mysql_fetch_array($my);
  //print_r($my_array);exit;

  $sql = "INSERT INTO dental_insurance_preauth ("
       . "  patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_phone, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, "
       . "  trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, "
       . "  front_office_request_date, status, userid "
       . ") VALUES ("
       . "  " . $_GET['pid'] . ", "
       . "  " . $my_array['doc_id'] . ", "
       . "  '" . $my_array['ins_co'] . "', "
       . "  '" . $my_array['ins_rank'] . "', "
       . "  '" . $my_array['ins_phone'] . "', "
       . "  '" . $my_array['patient_ins_group_id'] . "', "
       . "  '" . $my_array['patient_ins_id'] . "', "
       . "  '" . $my_array['patient_firstname'] . "', "
       . "  '" . $my_array['patient_lastname'] . "', "
       . "  '" . $my_array['patient_phone'] . "', "
       . "  '" . $my_array['patient_add1'] . "', "
       . "  '" . $my_array['patient_add2'] . "', "
       . "  '" . $my_array['patient_city'] . "', "
       . "  '" . $my_array['patient_state'] . "', "
       . "  '" . $my_array['patient_zip'] . "', "
       . "  '" . $my_array['patient_dob'] . "', "
       . "  '" . $my_array['insured_first_name'] . "', "
       . "  '" . $my_array['insured_last_name'] . "', "
       . "  '" . $my_array['insured_dob'] . "', "
       . "  '" . $my_array['doc_npi'] . "', "
       . "  '" . $my_array['referring_doc_npi'] . "', "
       . "  " . $my_array['trxn_code_amount'] . ", "
       . "  '" . $my_array['diagnosis_code'] . "', "
       . "  '" . $my_array['doc_medicare_npi'] . "', "
       . "  '" . $my_array['doc_tax_id_or_ssn'] . "', "
       . "  '" . date('Y-m-d H:i:s') . "', "
       . DSS_PREAUTH_PENDING . ", "
       . "  '" . $_SESSION['userid'] . "' "
       . ")";
  //print_r($my_array);
  //print_r($sql);exit;
  $my = mysql_query($sql);
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
	$letter = create_letter($letterid, $pid, $stepid, $topatient, '', '', '', '', 'mail');
	if (!is_numeric($letter)) {
		print "Can't send letter 6: " . $letter;
		die();
	} else {
		return $letter;
	}
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
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 9: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter10($pid, $stepid) {
  $letterid = '10';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 10: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter11($pid, $stepid) {
  $letterid = '11';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', $md_list, $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 11: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter13($pid, $stepid) {
  $letterid = '13';
  $md_list = get_mdcontactids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', $md_list);
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
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list);
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
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list);
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
  $letter = create_letter($letterid, $pid, $stepid, $topatient, $md_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 19: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter24($pid, $stepid) {
  $letterid = '24';
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $stepid, '', '', $md_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 24: " . $letter;
    die();
  } else {
    return $letter;
  }
}

function trigger_letter25($pid, $stepid) {
  $letterid = '25';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $stepid, $topatient);
  if (!is_numeric($letter)) {
    print "Can't send letter 25: " . $letter;
    die();
  } else {
    return $letter;
  }
}
if(is_numeric($_GET['pid'])){
$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
$message = "There is no started flowsheet for the current patient.";
}else{
    $flow = mysql_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $clinnotereq = $flow['clinnotereq'];
    $clinnoterec = $flow['clinnoterec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}


if(isset($_POST['flowsubmit'])){
    $copyreqdate = s_for($_POST['copyreqdate']);
    $referred_by = s_for($_POST['referred_by']);
    $referreddate = s_for($_POST['referreddate']);
    $thxletter = s_for($_POST['thxletter']);
    $queststartdate = s_for($_POST['queststartdate']);
    $questcompdate = s_for($_POST['questcompdate']);
    $insinforec = s_for($_POST['insinforec']);
    $rxreq = s_for($_POST['rxreq']);
    $rxrec = s_for($_POST['rxrec']);
    $lomnreq = s_for($_POST['lomnreq']);
    $lomnrec = s_for($_POST['lomnrec']);
    $clinnotereq = s_for($_POST['clinnotereq']);
    $clinnoterec = s_for($_POST['clinnoterec']);
    $contact_location = s_for($_POST['contact_location']);
    $questsendmeth = s_for($_POST['questsendmeth']);
    $questsender = s_for($_POST['questsender']);
    $refneed = s_for($_POST['refneed']);
    $refneeddate1 = s_for($_POST['refneeddate1']);
    $refneeddate2 = s_for($_POST['refneeddate2']);
    $preauth = s_for($_POST['preauth']);
    $preauth1 = s_for($_POST['preauth1']);
    $preauth2 = s_for($_POST['preauth2']);
    $insverbendate1 = s_for($_POST['insverbendate1']);
    $insverbendate2 = s_for($_POST['insverbendate2']);
    $pid = $_GET['pid'];
    if(mysql_num_rows($flowresult) <= 0){
      $referredbyqry = "UPDATE dental_patients SET referred_by = '".$referred_by."' WHERE patientid = '".$pid."';"; 
      $flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`referred_by`,`referreddate`,`thxletter`,`queststartdate`,`questcompdate`,`insinforec`,`rxreq`,`rxrec`,`lomnreq`,`lomnrec`,`clinnotereq`,`clinnoterec`,`contact_location`,`questsendmeth`,`questsender`,`refneed`,`refneeddate1`,`refneeddate2`,`preauth`,`preauth1`,`preauth2`,`insverbendate1`,`insverbendate2`,`pid`) VALUES (NULL,'".$copyreqdate."','".$referred_by."','".$referreddate."','".$thxletter."','".$queststartdate."','".$questcompdate."','".$insinforec."','".$rxreq."','".$rxrec."','".$lomnreq."','".$lomnrec."','".$clinnotereq."','".$clinnoterec."','".$contact_location."','".$questsendmeth."','".$questsender."','".$refneed."','".$refneeddate1."','".$refneeddate2."','".$preauth."','".$preauth1."','".$preauth2."','".$insverbendate1."','".$insverbendate2."','".$pid."');";
      $flowinsert = mysql_query($flowinsertqry);      
      if(!$flowinsert){
        //$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting flowsheet record, please try again!1";
      }else{
        $referred_result = mysql_query($referredbyqry);
        $message = "Successfully updated flowsheet!2";
      }  

	
      // Generate Initital Contact Letters: Letter 5 and Letter 6
      $stepid = '1';
      $segmentid = '1';
      $scheduled = strtotime($copyreqdate);
      $gen_date = date('Y-m-d H:i:s');
      $steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
      $flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$gen_date."');";
      $steparray_insert = mysql_query($steparray_query);
      if (!$steparray_insert) {
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting Initial Contact to Flowsheet Page 2";
      }
      $flow_pg2_info_insert = mysql_query($flow_pg2_info_query);
      if (!$flow_pg2_info_insert) {
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting Initial Contact Information to Flowsheet Page 2";
      }
      // Get letterid of last letter to associate with next letter
      /*$letter_query = "SELECT letterid FROM dental_letters where patientid = '".$pid."' AND stepid = '".$stepid."';";
      $result = mysql_query($letter_query);
      $parentid = array();
      if (!$result) {
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting letters from database";
      } else {
        while ($row = mysql_fetch_array($result)) {
          $parentid[] = $row;
        }
      }
      if (count($parentid) == '1') {
        $letter_result = create_letter($letter2id, $pid, '', $topatient, '', '', $parentid[0], '', 'mail');
        if (!is_numeric($letter_result)) {
          $message = $letter_result;
        }
      }*/

    }else{
      $referredbyqry = "UPDATE dental_patients SET referred_by = '".$referred_by."' WHERE patientid = '".$pid."';";  
      $flowinsertqry = "UPDATE dental_flow_pg1 SET `copyreqdate` = '".$copyreqdate."',`referred_by` = '".$referred_by."',`referreddate` = '".$referreddate."',`thxletter` = '".$thxletter."',`queststartdate` = '".$queststartdate."',`questcompdate` = '".$questcompdate."',`insinforec` = '".$insinforec."',`rxreq` = '".$rxreq."',`rxrec` = '".$rxrec."',`lomnreq` = '".$lomnreq."',`lomnrec` = '".$lomnrec."',`clinnotereq` = '".$clinnotereq."',`clinnoterec` = '".$clinnoterec."',`contact_location` = '".$contact_location."',`questsendmeth` = '".$questsender."',`questsender` = '".$questsendmeth."',`refneed` = '".$refneed."',`refneeddate1` = '".$refneeddate1."',`refneeddate2` = '".$refneeddate2."',`preauth` = '".$preauth."',`preauth1` = '".$preauth1."',`preauth2` = '".$preauth2."',`insverbendate1` = '".$insverbendate1."',`insverbendate2` = '".$insverbendate2."' WHERE `pid` = '".$_GET['pid']."';";
      $flowinsert = mysql_query($flowinsertqry);      
      if(!$flowinsert){
        //$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error updating flowsheet, please try again!3";
      }else{
        $referredby_result = mysql_query($referredbyqry);
        $message = "Successfully updated flowsheet!4";
      } 
    }

    // Trigger Letter 24
    $referral_query = "SELECT dental_referredby.referredbyid FROM dental_referredby JOIN dental_contacttype ON dental_referredby.referredbyid=dental_contacttype.contacttypeid WHERE (dental_contacttype.contacttype = 'Other' OR dental_contacttype.contacttype = 'Parent' OR dental_contacttype.contacttype = 'Patient' OR dental_contacttype.contacttype = 'Unknown') AND dental_referredby.referredbyid IN('".$referred_by."') UNION SELECT letterid FROM dental_letters WHERE patientid = '".$_GET['pid']."' AND md_referral_list = '".$referred_by."' AND templateid = 24;";
    $referral_result = mysql_query($referral_query);
    $numrows = mysql_num_rows($referral_result);
    //print $numrows;
    if ($numrows == 1) {
      trigger_letter24($_GET['pid']);
    }
}


if(isset($_POST['stepselectedsubmit']) && $_POST['stepselectedsubmit'] != 'Next Step'){	
	function updateflowsheet2($patientid, $value){
		$getstepqrysql = "SELECT * FROM `dental_flow_pg2` WHERE `patientid`='".$patientid."' LIMIT 1;";
		$getstepqry = mysql_query($getstepqrysql);
		
    	$posqry = "SELECT * FROM `segments_order` WHERE `patientid`='".$patientid."' LIMIT 1;";
		$getposqry = mysql_query($posqry);   
		
		if(mysql_num_rows($getstepqry) < 1){
			$insertstepqry = "INSERT INTO `dental_flow_pg2` (`patientid` , `steparray`) VALUES ('".$patientid."','".$value."')";
			if(!mysql_query($insertstepqry)){
			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."1";
			echo "error inserting";
			}
			$insertorderqry = "INSERT INTO `segments_order` (`patientid` , `consultrow` , `sleepstudyrow` , `delayingtreatmentrow` , `refusedtreatmentrow` , `devicedeliveryrow` , `impressionrow` , `checkuprow` , `patientnoncomprow` , `homesleeptestrow` , `starttreatmentrow` , `annualrecallrow`, `terminationrow`) VALUES ('".$patientid."','2','3','4','5','6','7','8','9','10','11','12','13')";
			if(!mysql_query($insertorderqry)){
			echo "error updating order";
			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."2";
			}
		}else{
			$steparray = mysql_fetch_array($getstepqry);
			$whatsinarray = $steparray['steparray'];
			$amtinarray = count($whatsinarray);
      
      
         if(in_array($_POST['stepselectedsubmit'], $whatsinarray)){
          echo "Item in db";
         }else{
          $updatestepqry = "UPDATE `dental_flow_pg2` SET `steparray`='".$steparray['steparray'].",".$value."' WHERE `patientid`='".$patientid."'";
			    mysql_query($updatestepqry);
			
    			if(!mysql_query($updatestepqry)){
    			echo "error updating record";
    			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."3";
    			} else {
						// Automatically enter Date Complete for Delaying Treatment (5), Refused Treatment (6), Patient Non-Compliant (9), Treatment Complete (11)
						if ($value == "5" || $value == "6" || $value == "9" || $value == "11") {
							$numsteps = count($_POST['data']) + 1; // +1 because we just added this additional step
							$consult_query = "SELECT stepid, date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$_GET['pid']."' ORDER BY stepid DESC LIMIT 1;";
							$consult_result = mysql_query($consult_query);
							$consult_stepid = mysql_result($consult_result, 0, 0);
							$consult_date = mysql_result($consult_result, 0, 1);
							if ($consult_date != "0000-00-00" && $consult_stepid < $numsteps) {
								$consulted = true;
							}
							// Delaying Treatment / Waiting
							if ($consulted == true && $value == "5") { 								
								$letterid[] = trigger_letter10($_GET['pid'], $numsteps);
							}
							// Refused Treatment
							if ($consulted == true && $value == "6") { 
								$letterid[] = trigger_letter8($_GET['pid'], $numsteps);
								$letterid[] = trigger_letter11($_GET['pid'], $numsteps);
							}
							// Patient Non Compliant
							if ($value == "9") { 
								$letterid[] = trigger_letter17($_GET['pid'], $numsteps);
							}
							$letteridlist = implode(",", $letterid);
							$select_query = "SELECT stepid FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' ORDER BY stepid DESC;";
							$select_result = mysql_query($select_query);
							if(!$select_result) {
								print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting information from flowsheet during update.";
								die();
							}
							$stepid = mysql_result($select_result, 0);
							$stepid++;
							$ins_date = "INSERT INTO dental_flow_pg2_info (patientid, stepid, segmentid, date_completed, letterid) VALUES ('".$patientid."', '".$stepid."', '".$value."', NOW(), '".$letteridlist."');";
							$ins_result = mysql_query($ins_date);
						}
					}
          $getcurrpos1 = "UPDATE `segments_order` SET `".$_POST['formsegment']."` = '2' WHERE `patientid` ='".$patientid."'";
          $currpos1 = mysql_query($getcurrpos1);
          if(!$currpos1){
            echo "error updating order";
            $error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."4";
          }
		  
		  // Get the data from the segments_order table
          // $pos = mysql_fetch_array($getposqry);
		 
		$posqsoResult = array();
	
		while ($posResultRow = mysql_fetch_assoc($getposqry))
		{
			$posqsoResult []= $posResultRow;
		}
		  
		$posqsoResultFinal = $posqsoResult[0];	  		  
		  
		// echo print_r($posqsoResultFinal);
		// exit();

/* it doesn't seem like we need to update segments_order for the flowsheet to work		  
		  foreach($posqsoResultFinal as $key => $value)
          {
			if($value < $_POST['stepselectedsubmit'])
            {
				$fnew_key = $value++;			
				
				$updatecurrpos = "UPDATE `segments_order` SET `".$key."` = '".$fnew_key."' WHERE `".$key."` != 'patientid'";
 				print "[".$fnew_key."]<br />";
	      print $updatecurrpos . "<br /><br />";       
	             /*
	             "UPDATE `segments_order` SET `consultrow` = '1',
`sleepstudyrow` = '2',
`delayingtreatmentrow` = '3',
`refusedtreatmentrow` = '4',
`devicedeliveryrow` = '5',
`checkuprow` = '6',
`patientnoncomprow` = '7',
`homesleeptestrow` = '8',
`starttreatmentrow` = '9',
`annualrecallrow` = '10',
`impressionrow` = '11' WHERE `segments_order`.`patientid` = '16';"
	             //*
	             
	             $currpos = mysql_query($updatecurrpos);
				 
	              if(!mysql_query($currpos)){
		              echo "error updating order";
		              $error = "MySQL error ".mysql_errno().": ".mysql_error();
						echo $error."5";
              		}
           	 }
          } */
          /* //dental_flow_pg2 doesn't contain the column that $_POST['formsegment'] contains			
    			$updatesegments = "UPDATE `dental_flow_pg2` SET `".$_POST['formsegment']."` = 2";
    			if(!mysql_query($updatesegments)){
    				echo "error updating order";
						print $updatesegments;
    				$error = "MySQL error ".mysql_errno().": ".mysql_error();
						echo $error."6";
    			} */
         }       	
		}
	}
	updateflowsheet2($_GET['pid'], $_POST['stepselectedsubmit']);
	?>
	<script type="text/javascript">
		window.location.href='manage_flowsheet3.php?page=page2&pid='+<?php echo($_GET['pid']); ?>+'&addtopat=1';		
	</script>	
	<?php
}

if(isset($_POST['flowsubmitpgtwo'])){
	$numsteps = count($_POST['data']);

	$steparray_query = "SELECT steparray FROM dental_flow_pg2 WHERE patientid = '".$_GET['pid']."';";
	$steparray_result = mysql_query($steparray_query);
	$result_array = mysql_fetch_array($steparray_result);
	$flowsheet_segments = explode(",", $result_array['steparray']);
	$topstep = array_pop($flowsheet_segments); 

	$segment_query = "SELECT segmentid, date_scheduled, date_completed, letterid FROM dental_flow_pg2_info WHERE segmentid = '".$topstep."' AND patientid = '".$_GET['pid']."' ORDER BY stepid DESC LIMIT 1;";
	$segment_result = mysql_query($segment_query);
	while ($row = mysql_fetch_assoc($segment_result)) {
		$laststep = $row;
	}
	if ($laststep['letterid'] != '') {
		$letter = true;
	}

	$consult_query = "SELECT stepid, date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$_GET['pid']."' ORDER BY stepid DESC LIMIT 1;";
	$consult_result = mysql_query($consult_query);
	$consult_stepid = mysql_result($consult_result, 0, 0);
	$consult_date = mysql_result($consult_result, 0, 1);
	if ($consult_date != "0000-00-00" && $consult_stepid < $numsteps) {
		$consulted = true;
	}

	$datesched = s_for($_POST['data'][$numsteps]['datesched']);
	$datecomp = s_for($_POST['data'][$numsteps]['datecomp']);

/*print $topstep . "<br />";
print ($consulted) ? "true" . "<br />" : "false<br />";
print $datesched . "<br />";
print (strtotime($datesched) != strtotime($laststep['date_scheduled'])) ? "Not equal<br />": "equal<br />";
print $datecomp . "<br />";
print (strtotime($datecomp) != strtotime($laststep['date_comp'])) ? "Not equal<br />": "equal<br />";*/
print $datesched . " " . $letter ? "true":"false" . " " . $topstep;
	$letterid = array();
	if ($datesched != "" && !$letter && $topstep == "2") { // Consultation
		$letterid[] = trigger_letter5($_GET['pid'], $numsteps);
		$letterid[] = trigger_letter6($_GET['pid'], $numsteps);
	}
	if ($consulted == true && $datesched != "" && !$letter && $topstep == "6") { // Refused Treatment
		$letterid[] = trigger_letter8($_GET['pid'], $numsteps);
		$letterid[] = trigger_letter11($_GET['pid'], $numsteps);
	}
	if ($consulted == true && $datesched != "" && !$letter && $topstep == "4") { // Impressions
		$letterid[] = trigger_letter9($_GET['pid'], $numsteps);
		$letterid[] = trigger_letter13($_GET['pid'], $numsteps);
	}
	if ($datecomp != "" && !$letter && $topstep == "8") { // Follow-Up/Check
		$trigger_query = "SELECT dental_flow_pg2.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2  JOIN dental_flow_pg2_info ON dental_flow_pg2.patientid=dental_flow_pg2_info.patientid WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2.steparray LIKE '%7%8%' AND dental_flow_pg2.patientid = '".$_GET['pid']."';";
		$trigger_result = mysql_query($trigger_query);
		$numrows = (mysql_num_rows($trigger_result));
		if ($numrows > 0) {
			$letterid[] = trigger_letter16($_GET['pid'], $numsteps);
		}
	}
	if ($consulted == true && $datesched != "" && !$letter && $topstep == "5") { // Delaying Treatment / Waiting
		$letterid[] = trigger_letter10($_GET['pid'], $numsteps);
	}
	if ($datesched != "" && !$letter && $topstep == "9") { // Patient Non Compliant
		$letterid[] = trigger_letter17($_GET['pid'], $numsteps);
	}
	if ($consulted == true && $datecomp != "" && !$letter && $topstep == "11") { // Treatment Complete
		$letterid[] = trigger_letter19($_GET['pid'], $numsteps);
	}
	if ($datecomp != "" && !$letter && $topstep == "13") { // Termination
		$letterid[] = trigger_letter25($_GET['pid'], $numsteps);
	}

	//print_r($_POST);
	$pid = $_GET['pid'];
	$i = 1; // first step is always 1
	while ($i <= $numsteps) {
		$numrows = 0;
		$select_query = "SELECT stepid FROM dental_flow_pg2_info WHERE patientid = '".$pid."' AND stepid = '".$i."';";
		$select_result = mysql_query($select_query);
		if(!$select_result) {
			print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting information from flowsheet during update.";
			die();
		}
		$numrows = mysql_num_rows($select_result);

		$segmentid = s_for($_POST['data'][$i]['segmentid']);
		$columns = "patientid, stepid, segmentid";
		$values = "'$pid', '$i', '$segmentid'";
		$setstring = "stepid='$i', segmentid='$segmentid'";
		if (count($letterid) > 0 && $i == $numsteps) {
			$columns .= ", letterid";
			$letteridlist = implode(",", $letterid);
			$values .= ", '".$letteridlist."'";
			$setstring .= ", letterid='$letteridlist'";
		}
		if	(isset($_POST['data'][$i]['datesched'])) {
			$datestring = s_for($_POST['data'][$i]['datesched']);
			if ($datestring != '') {
				$dateTime = date_create_from_format("m/d/Y", $datestring);
				$date = date('Y-m-d H:i:s', $dateTime->getTimestamp());
			} else {
				$date = NULL;
			}
			$columns .= ", date_scheduled";
			$values .= ", '$date'";
			$setstring .= ", date_scheduled='" . $date . "'";
		}
		if	(isset($_POST['data'][$i]['datecomp'])) {
			$datestring = s_for($_POST['data'][$i]['datecomp']);
			if ($datestring != '') {
				$dateTime = date_create_from_format("m/d/Y", $datestring);
				$date = date('Y-m-d H:i:s', $dateTime->getTimestamp());
			} else {
				$date = NULL;
			}
			$columns .= ", date_completed";
			$values .= ", '$date'";
			$setstring .= ", date_completed='" . $date . "'";
		}
		if	(isset($_POST['data'][$i]['study_type'])) {
			$columns .= ", study_type";
			$values .= ", '" . s_for($_POST['data'][$i]['study_type']) . "'";
			$setstring .= ", study_type='" . s_for($_POST['data'][$i]['study_type']) . "'";
		}
		if	(isset($_POST['data'][$i]['delay_reason'])) {
			$columns .= ", delay_reason";
			$values .= ", '" . s_for($_POST['data'][$i]['delay_reason']) . "'";
			$setstring .= ", delay_reason='" . s_for($_POST['data'][$i]['delay_reason']) . "'";
		}
		if	(isset($_POST['data'][$i]['noncomp_reason'])) {
			$columns .= ", noncomp_reason";
			$values .= ", '" . s_for($_POST['data'][$i]['noncomp_reason']) . "'";
			$setstring .= ", noncomp_reason='" . s_for($_POST['data'][$i]['noncomp_reason']) . "'";
		}

		if ($numrows == 0) {
			$insertquery = "INSERT INTO dental_flow_pg2_info (".$columns.") VALUES (".$values.");";
			$result = mysql_query($insertquery);
			if(!$result) {
				print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting new information into flowsheet during update.";
				die();
			}
		} else {
			$updatequery = "UPDATE dental_flow_pg2_info SET ".$setstring." WHERE patientid='".$pid."' AND stepid='".$i."';";
			$result = mysql_query($updatequery);
			if(!$result) {
				print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error updating new information into flowsheet during update.";
				die();
			}
		}
		$i++;
	}
	//die();
	/*
	if(mysql_num_rows($flowresult) <= 0){
		$flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`referred_by`,`referreddate`,`thxletter`,`queststartdate`,`questcompdate`,`insinforec`,`rxreq`,`rxrec`,`lomnreq`,`lomnrec`,`clinnotereq`,`clinnoterec`,`contact_location`,`questsendmeth`,`questsender`,`refneed`,`refneeddate1`,`refneeddate2`,`preauth`,`preauth1`,`preauth2`,`insverbendate1`,`insverbendate2`,`pid`) VALUES (NULL,'".$copyreqdate."','".$referred_by."','".$referreddate."','".$thxletter."','".$queststartdate."','".$questcompdate."','".$insinforec."','".$rxreq."','".$rxrec."','".$lomnreq."','".$lomnrec."','".$clinnotereq."','".$clinnoterec."','".$contact_location."','".$questsendmeth."','".$questsender."','".$refneed."','".$refneeddate1."','".$refneeddate2."','".$preauth."','".$preauth1."','".$preauth2."','".$insverbendate1."','".$insverbendate2."','".$pid."');";
		$flowinsert = mysql_query($flowinsertqry);      
		if(!$flowinsert){
			//$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting flowsheet record, please try again!1";
		}else{
			$message = "Successfully updated flowsheet!2";
		}  
	}else{
		$flowinsertqry = "UPDATE dental_flow_pg1 SET `copyreqdate` = '".$copyreqdate."',`referred_by` = '".$referred_by."',`referreddate` = '".$referreddate."',`thxletter` = '".$thxletter."',`queststartdate` = '".$queststartdate."',`questcompdate` = '".$questcompdate."',`insinforec` = '".$insinforec."',`rxreq` = '".$rxreq."',`rxrec` = '".$rxrec."',`lomnreq` = '".$lomnreq."',`lomnrec` = '".$lomnrec."',`clinnotereq` = '".$clinnotereq."',`clinnoterec` = '".$clinnoterec."',`contact_location` = '".$contact_location."',`questsendmeth` = '".$questsender."',`questsender` = '".$questsendmeth."',`refneed` = '".$refneed."',`refneeddate1` = '".$refneeddate1."',`refneeddate2` = '".$refneeddate2."',`preauth` = '".$preauth."',`preauth1` = '".$preauth1."',`preauth2` = '".$preauth2."',`insverbendate1` = '".$insverbendate1."',`insverbendate2` = '".$insverbendate2."' WHERE `pid` = '".$_GET['pid']."';";
		$flowinsert = mysql_query($flowinsertqry);      
		if(!$flowinsert){
			//$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error updating flowsheet, please try again!3";
		}else{
			$message = "Successfully updated flowsheet!4";
		} 
	} 
	*/
}





if(isset($_POST['dellaststep'])){
$patientid = $_POST['patientid'];
$getsteparray = "SELECT `steparray` FROM dental_flow_pg2 WHERE `patientid` = '".$patientid."';";
$query = mysql_query($getsteparray);
$array = mysql_fetch_array($query);

$explode = explode(",", $array['steparray']);

$stepid = count($explode);

$letter_query = "SELECT dental_flow_pg2_info.stepid, dental_letters.status FROM dental_flow_pg2_info JOIN dental_letters ON dental_flow_pg2_info.stepid=dental_letters.stepid WHERE dental_letters.patientid = '".$patientid."' AND dental_letters.status = '1' AND dental_flow_pg2_info.stepid = '".$stepid."';";
$letter_result = mysql_query($letter_query);
$numrows = mysql_num_rows($letter_result);
if ($numrows == 0) {
	array_pop($explode);

	$implode = implode(",", $explode);
	//echo $implode;

	$updatesteparray = "UPDATE `dental_flow_pg2` SET `steparray` = '".$implode."' WHERE `patientid` = '".$patientid."' LIMIT 1;";
	if ($stepid != 1) {
	if(mysql_query($updatesteparray)){

		$delete_pg2_info_query = "DELETE FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND stepid = '".$stepid."';";
		$result = mysql_query($delete_pg2_info_query);
		$delete_letters_query = "SELECT letterid FROM dental_letters WHERE patientid = '".$patientid."' AND stepid = '".$stepid."' AND status = '0';";
		$result2 = mysql_query($delete_letters_query);
		$parent = true;
		while ($row = mysql_fetch_assoc($result2)) {
			delete_letter($row['letterid'], $parent);
		}
	?>
	<script type="text/javascript">
	window.location.href='manage_flowsheet3.php?pid=<?php echo($_GET["pid"]); ?>&page=page2&msg=Deleted Successfully';
	</script>

	<?php
	}
	} else {
		print "Can not delete Initial Contact step";
	}
} else {
	print "Can not delete last step, because letters have already been sent";
}

}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
if (!$pat_my) {
  print "MySQL error ".mysql_errno().": ".mysql_error();
}
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$referred_by = $pat_myarray['referred_by'];
$referredby_sql = "select * from dental_referredby where `referredbyid` = ".$reffered_by.";";
$referredby_my = mysql_query($referredby_sql);
$referrer_array = mysql_fetch_array($referredby_my);
$referrer = $referrer_array['firstname']." ".$referrer_array['middlename']." ".$referrer_array['lastname'];

}
?>


<style>
/*
table{
 margin-bottom:20px;
border:1px solid #000;
}
*/
td{
vertical-align:top;
}

.highrow{
height:35px;
}
</style>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>

<span class="admin_head">
	Manage Flowsheet
	-
    Patient <i><?=$name;?></i>
</span>

<form action="#" method="post">
<div style="margin:0 auto; width:500px; margin-bottom:10px;margin-top:10px;font-weight:bold;font-size:15px;color:#00457c;"><?php echo $message; ?></div>
<div style="width:200px; float:right;">
<input type="button" class="addButton" onclick="document.getElementById('flowsheet_page1').style.display='block';document.getElementById('flowsheet_page2').style.display='none';" value="Page 1" />
<input type="button" class="addButton" onclick="document.getElementById('flowsheet_page2').style.display='block';document.getElementById('flowsheet_page1').style.display='none';" value="Page 2" />
</div>
</form>
<div style="clear:both;height:10px;width:100%;"></div>


<!-- START FLOWSHEET PAGE 1 ***************************** -->
<div id="flowsheet_page1">

<div id="not-complete" style="width:98%; margin:0 auto; text-align:center;">
    <?php
		$sleepstudies = "SELECT completed FROM dental_sleepstudy WHERE completed = 'Yes' AND patientid = '".$_GET['pid']."';";
		$result = mysql_query($sleepstudies);
		$numrows = mysql_num_rows($result);
    if(	$numrows == '0' && $copyreqdate == '' || $referred_by == '' || $contact_location == '' || $referreddate == ''
				|| $thxletter == '' || $queststartdate == '' || $questcompdate == '' || $insinforec == '' 
				|| $rxreq == '' || $rxrec == '' || $lomnreq == '' || $lomnrec == '' || $clinnotereq == '' || $clinnoterec == ''){
      echo "<strong><h2>Page 1 Information NOT COMPLETE</h2></strong>";    
    }
    ?>
</div>

<form id="form_page1" name="form_page1" action="/manage/manage_flowsheet3.php?pid=<?php echo $_GET['pid']; ?>" method="post">
<input id="iframestatus" name="iframestatus" type="hidden" />
<!-- START INITIAL CONTACT TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">INITIAL CONTACT</div>
<table width="60%" align="center">

<tr>

<td>

Date

</td>

<td>

Referral Source

</td>

<td>

Contact Location

</td>

</tr>



<tr>

<td>

<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onClick="cal1.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>

</td>

<td>

<?php

								$referredby_sql = "select * from dental_referredby where status=1 and docid='".$_SESSION['docid']."' order by firstname";

								$referredby_my = mysql_query($referredby_sql);

								?>

								<select name="referred_by" class="field text addr tbox">

									<option value=""></option>

									<?php while($referredby_myarray = mysql_fetch_array($referredby_my)) 

									{

										$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);

									?>

										<option value="<?=st($referredby_myarray['referredbyid'])?>" <? if($referred_by == st($referredby_myarray['referredbyid']) ) echo " selected";?>>

											<?php echo $ref_name;?>

										</option>

									<? }?>

								</select>

							

                               <!-- <input id="referred_by" name="referred_by" type="text" class="field text addr tbox" value="<?=$referred_by?>" maxlength="255" style="width:300px;" /> -->

                <br /><!--<button class="addButton" onclick="Javascript: loadPopup('add_referredby.php?addtopat=<?php echo $_GET['pid']; ?>');">Add New Referrer</button>-->
											<!--<button class="addButton" onclick="Javascript: window.location='add_referredby.php?addtopat=<?php echo $_GET['pid']; ?>';">Add New Referrer</button>-->
											<a onclick="Javascript: loadPopup('add_referredby.php?addtopat=<?php echo $_GET['pid']; ?>');" href="Javascript: ;">Add New Referrer</a>

</td>

<td>

<select name="contact_location">

<option value="DSS Franchisee"<?php if($contact_location == "DSS Franchisee"){echo " selected='selected'";} ?>>DSS Franchisee</option>

<option value="Corporate Office"<?php if($contact_location == "Corporate Office"){echo " selected='selected'";} ?>>Corporate Office</option>

</select>

</td>

</tr>

</table>

<!-- END INITIAL CONTACT TABLE -->





<!-- START REFERRED TO DSS OFFICE TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">REFERRED TO DSS OFFICE</div>
<table width="50%" align="center">

<tr>

<td>

Dentist Name/Office

</td>

<td>

Date

</td>

<td>

Thank You Sent

</td>

</tr>



<tr>
<td>

<?php
echo $referrer;
?> 

</td>
<td>
<input id="referreddate" name="referreddate" type="text" class="field text addr tbox" value="<?php echo $referreddate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('referreddate');" onClick="cal2.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
<td>
<input id="thxletter" name="thxletter" type="text" class="field text addr tbox" value="<?php echo $thxletter; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('thxletter');" onClick="cal3.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
</tr>

</table>

<!-- END REFERRED TO DSS OFFICE TABLE -->







<!-- START SEND PATIENT QUESTIONNAIRE TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">SEND PATIENT QUESTIONNAIRE</div>
<table width="50%" align="center">

<tr>
<td>
Date


</td>
<td>
Method

</td>
<td>
Who Sent


</td>
<td>
Completed/Uploaded


</td>
</tr>



<tr>
<td>
<input id="queststartdate" name="queststartdate" type="text" class="field text addr tbox" value="<?php echo $queststartdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('queststartdate');" onClick="cal4.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
<td>
<select name="questsendmeth">
<option value="Online">Online</option>
<option value="Email">Email</option>
<option value="Fax">Fax</option>
<option value="Mail">Mail</option>
<option value="At Office">At Office</option>
</select>


</td>
<td>
<select name="questsender">
<option value="DSS Franchisee">DSS Franchisee</option>
<option value="Corporate Office">Corporate Office</option>
</select>


</td>
<td>
<input id="questcompdate" name="questcompdate" type="text" class="field text addr tbox" value="<?php echo $questcompdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('questcompdate');" onClick="cal5.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>


</td>
</tr>

</table>

<!-- END SEND PATIENT QUESTIONNAIRE TABLE -->




<!-- START SLEEP LABS TABLE -->
<style>
	#sleepstudyscrolltable tr td	{ border-bottom: 1px solid #000; height: 35px; }
	#sleeplablabels					{ /* line-height:22.6px; */ }
	#sleeplablabels 	   tr td 	{ height: 35px; padding: 0; border-bottom: 1px solid #000; font-weight: bold; text-align: right; padding-right: 10px; }
</style>

<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">SLEEP STUDY</div>

<!--sleep study table-->

<div style="width: 622px; margin: auto; display: table;" id="sleeplabtable">
	
	<div style="float: left; width: 180px;">
		<table id="sleeplablabels" style="border: 0; width: 100%;" cellpadding="0">
			<tr>
			
			<td>
			
			Test Number
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Needed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Date Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Where Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Completed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Type
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Interpretation
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Requested
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Sleep Study Request From
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Scanned Copy
			
			</td>
			
			</tr>
		
		</table>
	</div>
	
	<div style=" border: medium none;float: left;height: 440px;margin-bottom: 20px;margin-top: -4px;overflow: auto;width: 433px;">
		 <table width="700" style="overflow-x: auto;">
		   <tr>
		    <td>
<!-- Begin repeat sleep study section -->
      






	<iframe src="manage_sleep_studies.php?pid=<?php echo $_GET['pid']; ?>" height="410" width="10000" style="border: medium none; overflow:hidden;">Iframes must be enabled to view this area.</iframe>









      
 
 
 
<!-- End repeat sleep study section -->
         </td>
      </tr>
		 </table>
	</div>
	
</div>


<!--
<table width="500px;" align="center" id="sleeplabtable">
<tr>
	<td style="width:200px;">
		<table width="200px" align="center" id="sleeplablabels" style="border:none; float:left;">
			<tr>
			
			<td>
			
			Test Number
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Needed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Date Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Where Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Completed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Interpolation
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Type
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Requested
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Sleep Study Request From
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Obtained/Scanned In
			
			</td>
			
			</tr>
		
		</table>
	</td>

	<td width="300">
		<div style="width: 300px; height: 295px; overflow-x: scroll; overflow-y: hidden;">
			<div style="width: 500px; height: 295px; overflow-x: scroll; overflow-y: hidden;"> 
				<table align="center" style="border:none; float: left;width: 140px;" id="sleepstudyscrolltable">
	
					<tr>
					
					<td>
					
					<input type="text" style="width:25px;" readonly="readonly">
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="needed" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="needed" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>Sleep Lab 1</option>
					
					<option>Sleep Lab 2</option>
					
					<option>Sleep Lab 3</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="completed" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="completed" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="interpretation" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="interpretation" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>PSG</option>
					
					<option>HST</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>Sleep Lab 1</option>
					
					<option>Sleep Lab 2</option>
					
					<option>Sleep Lab 3</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<button class="addButton" onclick="">
							Upload
					</button>
					&nbsp;&nbsp;&nbsp;<a href="#"> View</a>
					
					</td>
					
					</tr>
					
				</table>

			</div>
		</div> 
	</td>

</tr>

</table>
-->

<!-- END SLEEP LABS TABLE -->




<!-- START MED INS TABLE -->

<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">MEDICAL INSURANCE</div>
<table width="50%" align="center">

<td>
<h3>Procedure</h3>
</td>
<td>
<h3>Requested</h3>
</td>
<td>
<h3>Received</h3>
</td>

</tr>

<tr>

<td>
Insurance Information
</td>
<td>
N/A
</td>
<td>
<input id="insinforec" name="insinforec" type="text" class="field text addr tbox" value="<?php echo $insinforec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('insinforec');" onClick="cal6.popup();"value="example 11/11/1234" /><span id="req_0" class="req">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="" target="_self">Add/Edit Info</a>
</td>

</tr>

<tr>

<td>
Rx.
</td>
<td>
<input id="rxreq" name="rxreq" type="text" class="field text addr tbox" value="<?php echo $rxreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxreq');" onClick="cal7.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="rxrec" name="rxrec" type="text" class="field text addr tbox" value="<?php echo $rxrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxrec');" onClick="cal8.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="q_image.php?pid=<?php echo $_GET['pid']; ?>&sh=6" id="add-rx" target="_self">Add/Edit RX</a>
</td>

</tr>

<tr>

<td>
L.O.M.N.
</td>
<td>
<input id="lomnreq" name="lomnreq" type="text" class="field text addr tbox" value="<?php echo $lomnreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnreq');" onClick="cal9.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="lomnrec" name="lomnrec" type="text" class="field text addr tbox" value="<?php echo $lomnrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnrec');" onClick="cal10.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="q_image.php?pid=<?php echo $_GET['pid']; ?>&sh=7" target="_self">Add/Edit LOMN</a>
</td>

</tr>

<tr>

<td>
Clinical notes
</td>
<td>
<input id="clinnotereq" name="clinnotereq" type="text" class="field text addr tbox" value="<?php echo $clinnotereq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('clinnotereq');" onClick="cal11.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="clinnoterec" name="clinnoterec" type="text" class="field text addr tbox" value="<?php echo $clinnoterec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('clinnoterec');" onClick="cal12.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="q_image.php?pid=<?php echo $_GET['pid']; ?>&sh=8" target="_self">Add/Edit Notes</a>
</td>

</tr>

</table>

<!-- END MED INS TABLE -->

<!-- START PRE-AUTHORIZATION TABLE -->

<?php
$sql = "SELECT "
     . "  * "
     . "FROM "
     . "  dental_insurance_preauth "
     . "WHERE "
     . "  patient_id = " . $_GET['pid'] . " "
     . "ORDER BY "
     . "  front_office_request_date DESC "
     . "LIMIT 1";
$my = mysql_query($sql) or die(mysql_error());
?>

<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">PRE-AUTHORIZATION</div>
<table width="50%" align="center">
	<? if (mysql_num_rows($my) == 0) { ?>
      <tr class="tr_bg">
        <td valign="top" align="center">
          No pre-authorizations on record.
        </td>
      </tr>
	<?php } else { ?> 
      <?php while ($preauth = mysql_fetch_array($my)) { ?>

	<?php if($preauth['status']==DSS_PREAUTH_PENDING){ ?>

      <tr class="tr_bg">
        <td valign="top" align="center">
		Pre-Authorization request was submitted <?= date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently pending.
        </td>
      </tr>



	<?php } elseif ($preauth['status']==DSS_PREAUTH_COMPLETE) { ?>
        <tr class="tr_bg">
          <td valign="top" colspan="2" align="center">
		    Pre-Authorization completed on <?= date('m/d/Y', strtotime($preauth['date_completed'])); ?>.
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/manage/manage_insurance.php?pid=<?= $_GET['pid'] ?>">VIEW Pre-Authorization</a>
          </td>
        </tr>
	<?php } ?>
      <?php } ?>
    <?php } ?>
	<tr>
		<td style="padding:10px;">
			<?php 
			$errors = preauth_errors();
			if(count($errors)>0){ 
				$e_text = 'Unable to request pre-authorization:\n';
				foreach($errors as $e){
					$e_text .= '\n'.$e;
				}
			}
			if (mysql_num_rows($my) == 0) {
				if ($e_text) {
			?>
				 <a href="javascript:alert('<?= $e_text; ?>');" class="addButton" >Request Pre-authorization</a>
				<? }else{ ?>
				 <a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&preauth=1" class="addButton" >Request Pre-authorization</a>
				<?php } ?>
			<? } else { 
				if ($e_text) { ?>
				 <a href="javascript:alert('<?= $e_text; ?>');" class="addButton" >Request Additional Pre-authorization</a>
				<? }else{ ?>
				 <a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&preauth=1" id="additional-preauth" class="addButton" >Request Additional Pre-authorization</a>
				<?php } ?>			
			<?php } ?>
		</td>
	</tr>
</table>

<!-- END PRE-AUTHORIZATION TABLE -->

<!-- 
START MED INS CORP TABLE 

<table width="50%" align="center">
<tr>
<td>
Referral Needed
</td>
<td>
<select name="refneed">
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td>
<input id="refneeddate1" name="refneeddate" type="text" class="field text addr tbox" value="<?php echo $refneeddate1; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('refneeddate1');" onClick="cal13.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="refneeddate2" name="refneeddate2" type="text" class="field text addr tbox" value="<?php echo $refneeddate2; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('refneeddate2');" onClick="cal14.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>



<tr>
<td>
Preauthorization
</td>
<td>
<select>
<option>Yes</option>
<option>No</option>
</select>
</td>
<td>
<input id="preautho1" name="preautho1" type="text" class="field text addr tbox" value="<?php echo $preautho1; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('preautho1');" onClick="cal15.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="preautho2" name="preautho2" type="text" class="field text addr tbox" value="<?php echo $preautho2; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('preautho2');" onClick="cal16.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>



<tr>
<td>
Ins. Ver. of Benefits
</td>
<td>
N/A
</td>
<td>
N/A
</td>
<td>
<input id="insverbendate" name="insverbendate" type="text" class="field text addr tbox" value="<?php echo $insverbendate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('insverbendate');" onClick="cal17.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>


</table>

-->

<!-- START MED INS CORP TABLE -->



<input type="submit" class="addButton" style="float:right;margin-right:20px;" name="flowsubmit" value="Update Flowsheet">
<br /><br />

</form>
</div>
<!-- END FLOWSHEET PAGE 1 ***************************** -->




<!-- START FLOWSHEET PAGE 2 ***************************** -->


<div id="flowsheet_page2" style="border-right: 1px solid rgb(0, 0, 0); margin-left: 20px; min-height: 400px; overflow: hidden; width: 932px;">  

<form action="manage_flowsheet3.php?pid=<?php echo $_GET['pid']; ?>&page=page2" method="POST" style="clear: both;">
<input type="submit" name="dellaststep" value="Delete Last Step" style="float:right;" />
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>" />
</form>

<form id="page2form" action="manage_flowsheet3.php?pid=<?php echo $_GET['pid']; ?>&page=page2" method="POST" name="page2submit" style="clear: both;">
<h2 style="float:left;width:200px;">Treatment Steps</h2>

<style>
#flowsheet_page2 td{
border-bottom:1px solid #000;
}
</style>




<style>
	
	#flowsheetpage2{
		overflow:hidden;
	}
	#flowsheetpage2 td{
		overflow:hidden;
	}
	
</style>

<table align="center" style="width:100%; overflow: hidden;clear: left;" id="flowsheetpage2">
<tr>
<td width="109">
Procedure
</td>

<td width="117">
Date Complete<br />
Date Scheduled<br />
(mm/dd/yyyy)
</td>


<td width="247">
Correspondence
</td>


<td width="115">
Generated On
</td>


<!--<td width="26" style="text-align:center;">
&#8730;&nbsp;
</td>


<td width="102">
Sent via
</td>-->
                                              

<td width="250">
Next Appointment
</td>
</tr>


<?php

?>


  


<?php
/*
    function array_sort($array, $on, $order)
    {
      $new_array = array();
      $sortable_array = array();
 
      if (count($array) > 0) {
          foreach ($array as $k => $v) {
              if (is_array($v)) {
                  foreach ($v as $k2 => $v2) {
                      if ($k2 == $on) {
                          $sortable_array[$k] = $v2;
                      }
                  }
              } else {
                  $sortable_array[$k] = $v;
              }
          }
 
          switch($order)
          {
              case 'SORT_ASC':   
                  echo "ASC";
                  asort($sortable_array);
              break;
              case 'SORT_DESC':
                  echo "DESC";               
                  arsort($sortable_array);
              break;
          }
 
          foreach($sortable_array as $k => $v) {
              $new_array[] = $array[$k];
          }
      }
      return $new_array;
    }   

 */

	$qso = "SELECT `consultrow`, `sleepstudyrow`, `impressionrow`, `delayingtreatmentrow`, `refusedtreatmentrow`, `devicedeliveryrow`, `checkuprow`, `patientnoncomprow`, `homesleeptestrow`, `starttreatmentrow`, `annualrecallrow`, `terminationrow` FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."'";
	$qso_query = mysql_query($qso);
	
	$qsoResult = array();
	
	while ($qsoTmpResult = mysql_fetch_assoc($qso_query))
	{
		$qsoResult []= $qsoTmpResult;
	}
		
	$fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$_GET['pid']."';";
	$fsData_query = mysql_query($fsData_sql);
	$fsData_array = mysql_fetch_array($fsData_query);
	
	
	/*
	$final_fsData_array = array();
	$fsIt = 1;
	
	while ($fsdataRow = mysql_fetch_assoc($fsData_query))
	{
		$current_section = $fsdataRow['section'];
		
		$final_fsData_array[$fsIt] = array( 'order' => $qsoResult[0]["$current_section"], 'section' => $current_section);
		
		$fsIt++;
	}
	
	*/
	
	
 	if (!empty($fsData_array['steparray'])) {
		$order = explode(",",$fsData_array['steparray']);
  	$order = array_reverse($order);
  	//print_r($order);
	}
	
	
	/*
	echo '<pre>';
	echo print_r($final_fsData_array);
	echo '</pre>';	
  echo '<br /><br />';
  */
   
  
  
  
  
  $flow_pg2_info_query = "SELECT stepid, UNIX_TIMESTAMP(date_scheduled) as date_scheduled, UNIX_TIMESTAMP(date_completed) as date_completed, delay_reason, noncomp_reason, study_type, description, letterid FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY stepid ASC;";
  $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
  while ($row = mysql_fetch_assoc($flow_pg2_info_res)) {
    $flow_pg2_info[$row['stepid']] = $row;
  }
//print_r($flow_pg2_info);
  foreach ($flow_pg2_info as $row) {
		if ($row['letterid'] != "") {
			$letters[$row['stepid']] = $row['letterid'];
		}
  }
//print_r($letters);
  $letter_list = implode(",", $letters);
  $dental_letters_query = "SELECT patientid, stepid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$_GET['pid']."' AND (letterid IN(".$letter_list.") OR parentid IN(".$letter_list."))ORDER BY stepid ASC;";
  $dental_letters_res = mysql_query($dental_letters_query);
  $dental_letters = array();
  while ($row = mysql_fetch_assoc($dental_letters_res)) {
    $dental_letters[$row['stepid']][] = $row;
  }
//print $dental_letters_query;

  //print_r($flow_pg2_info);
	$calendar_vars = array();
  $i = 0;
  while($section = $order && $i < count($order)){
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$order[$i].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
  }else{
    echo "Error selecting segments from flowsheet"; 
  }
	if ($order[$i] != 1 && $order[$i] != 5 && $order[$i] != 6 && $order[$i] != 9 && $order[$i] != 13) {
		$calendar_vars[$i]['datesched'] .= "var cal_sched$i = new calendar2(document.getElementById('datesched$i'));";
		$calendar_vars[$i]['varsched'] = "cal_sched$i";
	}
	$calendar_vars[$i]['datecomp'] .= "var cal_comp$i = new calendar2(document.getElementById('datecomp$i'));";
	$calendar_vars[$i]['varcomp'] = "cal_comp$i";
	$caldatesched = $calendar_vars[$i]['varsched'];
	$caldatecomp = $calendar_vars[$i]['varcomp'];
	$schedid = "datesched$i";
	$compid = "datecomp$i";

  /*$getsteparray = "SELECT * FROM dental_flow_pg2 WHERE `patientid` = '".$_GET['pid']."' LIMIT 1;";
  $steparrayqry = mysql_query($getsteparray);
  $steparray = mysql_fetch_array($steparrayqry);
  $steparray = explode(",", $steparray['steparray']);
  $stepcount = count($steparray);
  $steparray_last = end($steparray);*/

  $step = count($order) - $i;
  $datesched = date('m/d/Y', $flow_pg2_info[$step]['date_scheduled']);
  if ($datesched == '12/31/1969') $datesched = '';
  $datecomp = date('m/d/Y', $flow_pg2_info[$step]['date_completed']);
  if ($datecomp == '12/31/1969') $datecomp = '';
	$sleepstudy = $flow_pg2_info[$step]['study_type'];
	$delayreason = strtolower($flow_pg2_info[$step]['delay_reason']);
	$noncompreason = strtolower($flow_pg2_info[$step]['noncomp_reason']);
	$description = $flow_pg2_info[$step]['description'];

  $pid = $_GET['pid'];
  $letterlink = "";
	foreach ($dental_letters[$step] as $letter) {
		$contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list']);
		$lid = $letter['letterid'];
		$template = $letter['template'];
		$gendate = date('m/d/Y', $letter['generated_date']);
		if ($lid != '') {
			foreach ($contacts['patient'] as $contact) {
				$preferred = "";
				if ($contact['preferredcontact'] == "email") {
					$preferred = "(E)";
				}
				if ($contact['preferredcontact'] == "paper") {
					$preferred = "(M)";
				}
				if ($contact['preferredcontact'] == "fax") {
					$preferred = "(F)";
				}
				$name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
				if ($letter['status'] == 0) {
					$letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['status'] == 1) {
					$letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
					$letterlink .= "<a class=\"darkblue\" href=\"" . $letter['pdf_path'] . "\">$name</a><br />";
				}
			}
			foreach ($contacts['md_referrals'] as $contact) {
				$preferred = "";
				if ($contact['preferredcontact'] == "email") {
					$preferred = "(E)";
				}
				if ($contact['preferredcontact'] == "paper") {
					$preferred = "(M)";
				}
				if ($contact['preferredcontact'] == "fax") {
					$preferred = "(F)";
				}
				$name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
				if ($letter['status'] == 0) {
					$letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['status'] == 1) {
					$letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
					$letterlink .= "<a class=\"darkblue\" href=\"" . $letter['pdf_path'] . "\">$name</a><br />";
				}
			}
			foreach ($contacts['mds'] as $contact) {
				$preferred = "";
				if ($contact['preferredcontact'] == "email") {
					$preferred = "(E)";
				}
				if ($contact['preferredcontact'] == "paper") {
					$preferred = "(M)";
				}
				if ($contact['preferredcontact'] == "fax") {
					$preferred = "(F)";
				}
				$name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
				if ($letter['status'] == 0) {
					$letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['status'] == 1) {
					$letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
				} elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
					$letterlink .= "<a class=\"darkblue\" href=\"" . $letter['pdf_path'] . "\">$name</a><br />";
				}
			}
		}
	}
  eval('?>' . $segment['content'] . '<?');
  
  //echo "<br />".$i."<br />";
  $i++; 
  }
//	print "<tr><td style=\"border-bottom: 0px;\">";
  if (!empty($calendar_vars)) {
		print '<script type="text/javascript">';
		foreach ($calendar_vars as $var) {
			print (isset($var['datesched'])) ? $var['datesched'] . "\n" : "";
			print (isset($var['datecomp'])) ? $var['datecomp'] . "\n" : "";
		}
		print "</script>";
	}
	/*
  	asort($final_fsData_array, SORT_NUMERIC);	
	
	foreach($final_fsData_array as $sectiondata)
	{
    	echo $sectiondata['section']."<br />";
  	}
	*/
	
	/*     
  $i = 2;
  while($section = mysql_fetch_array($s)){
	  $q2 = "SELECT * FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."'";
	  $s2 = mysql_query($q2);
	  $a2 = mysql_fetch_array($s2);
	  $title = $section['section'];
	  echo $title;
	      if(1==1){
	        eval('?>' . $section['content'] . '<?');
	      }else{
	        continue;
	      }
  }

*/
    

?>
<input type="hidden" name="flowsubmitpgtwo" value="1">
<input type="submit" class="addButton" value="Submit" <?php print $order == null ? 'style="display: none"' : ''; ?> />
</form> 
</table>


</div>
<!-- END FLOWSHEET PAGE 2 ***************************** -->



<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('copyreqdate'));
var cal2 = new calendar2(document.getElementById('referreddate'));
var cal3 = new calendar2(document.getElementById('thxletter'));
var cal4 = new calendar2(document.getElementById('queststartdate'));
var cal5 = new calendar2(document.getElementById('questcompdate'));
var cal6 = new calendar2(document.getElementById('insinforec'));
var cal7 = new calendar2(document.getElementById('rxreq'));
var cal8 = new calendar2(document.getElementById('rxrec'));
var cal9 = new calendar2(document.getElementById('lomnreq'));
var cal10 = new calendar2(document.getElementById('lomnrec'));
var cal11 = new calendar2(document.getElementById('clinnotereq'));
var cal12 = new calendar2(document.getElementById('clinnoterec'));
// var cal13 = new calendar2(document.getElementById('refneeddate1'));
// var cal14 = new calendar2(document.getElementById('refneeddate2'));
// var cal15 = new calendar2(document.getElementById('preautho1'));
// var cal16 = new calendar2(document.getElementById('preautho2'));
// var cal17 = new calendar2(document.getElementById('insverbendate'));
</script>


<? include "includes/bottom.htm";?>
