<?php
 
if($_GET['backoffice'] == '1') {
  include 'admin/includes/top.htm';
} else {
  include 'includes/top.htm';
}

?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js"></script>
<?php

$letterid = mysql_real_escape_string($_GET['lid']);

// Select Letter
$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list, template FROM dental_letters where letterid = ".$letterid.";";
$letter_result = mysql_query($letter_query);
while ($row = mysql_fetch_assoc($letter_result)) {
  $templateid = $row['templateid'];
  $patientid = $row['patientid'];
  $topatient = $row['topatient'];
  $md_list = $row['md_list'];
  $md_referral_list = $row['md_referral_list'];
  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
	$altered_template = $row['template'];
}

// Pending and Sent Contacts
$othermd_query = "SELECT md_list, md_referral_list FROM dental_letters where letterid = '".$letterid."' OR parentid = '".$letterid."' ORDER BY letterid ASC;";
$othermd_result = mysql_query($othermd_query);
$md_array = array();
$md_referral_array = array();
while ($row = mysql_fetch_assoc($othermd_result)) {
	if ($row['md_list'] != null) {
		$md_array = array_merge($md_array, explode(",", $row['md_list']));
	} 
	if ($row['md_referral_list'] != null) {
		$md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
	}
}
$full_md_list = implode(",", $md_array);
$full_md_referral_list = implode(",", $md_referral_array);
$contacts = get_contact_info('', $full_md_list, $full_md_referral_list);
foreach ($contacts['mds'] as $contact) {
  $md_contacts[] = array_merge(array('type' => 'md'), $contact);
}
foreach ($contacts['md_referrals'] as $contact) {
  $md_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
}

// Get Letter Subject
$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
$template_result = mysql_query($template_query);
$title = mysql_result($template_result, 0);
?>


<br />
<span class="admin_head">
	<?php print $title; ?>
</span>
<br />
&nbsp;&nbsp;
<a href="<?php print ($_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<?php
//print_r ($_POST);

// Get Contact Info for Recipients
if ($topatient) {
  $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
} else {
  $contact_info = get_contact_info('', $md_list, $md_referral_list);
}

$letter_contacts = array();
foreach ($contact_info['patient'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
}
foreach ($contact_info['mds'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'md'), $contact);
}
foreach ($contact_info['md_referrals'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
}
$numletters = count($letter_contacts);
// Get Date

$todays_date = date('F d, Y');

// Get Franchisee Name and Address
$franchisee_query = "SELECT name, practice, address, city, state, zip, email FROM dental_users WHERE userid = '".$_SESSION['docid']."';";
$franchisee_result = mysql_query($franchisee_query);
while ($row = mysql_fetch_assoc($franchisee_result)) {
	$franchisee_info = $row;
}

// Get Patient Information
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob, email FROM dental_patients WHERE patientid = '".$patientid."';";
$patient_result = mysql_query($patient_query);
$patient_info = array();
while ($row = mysql_fetch_assoc($patient_result)) {
	$patient_info = $row;
}
$patient_info['age'] = floor((time() - strtotime($patient_info['dob']))/31556926);

// Consult Appointment Date
$consult_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 2 ORDER BY stepid DESC LIMIT 1;";
$consult_result = mysql_query($consult_query);
$consult_date = date('F d, Y', strtotime(mysql_result($consult_result, 0)));

// Impressions Appointment Date
$impressions_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
$impressions_result = mysql_query($impressions_query);
$impressions_date = date('F d, Y', strtotime(mysql_result($impressions_result, 0)));

// Get Medical Information
$q3_sql = "SELECT history, medications from dental_q_page3 WHERE patientid = '".$patientid."';";
$q3_my = mysql_query($q3_sql);
$q3_myarray = mysql_fetch_array($q3_my);

$history = $q3_myarray['history'];
$medications = $q3_myarray['medications'];

$history_arr = explode('~',$history);
$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val)
{
	if(trim($val) <> "")
	{
		$his_sql = "select history from dental_history where historyid='".trim($val)."' and status=1;";
		$his_my = mysql_query($his_sql);
		$his_myarray = mysql_fetch_array($his_my);
		
		if($his_myarray['history'] <> '')
		{
			if($history_disp <> '')
				$history_disp .= ' and ';
				
			$history_disp .= $his_myarray['history'];
		}
	}
}

$medications_arr = explode('~',$medications);
$medications_disp = '';
$medcount = 0;
foreach ($medications_arr as $val) {
	if ($val != "") {
		$medcount++;
	}
}
foreach($medications_arr as $key => $val)
{
	if(trim($val) <> "")
	{
		$medications_sql = "select medications from dental_medications where medicationsid='".trim($val)."' and status=1;";
		$medications_my = mysql_query($medications_sql);
		$medications_myarray = mysql_fetch_array($medications_my);
		
		if($medications_myarray['medications'] <> '')
		{
			if($medications_disp <> '') {
				if ($medcount == $key) {
					$medications_disp .= ', and ';
				} else {
					$medications_disp .= ', ';
				}
			}
				
			$medications_disp .= $medications_myarray['medications'];
		}
	}
}

// Oldest Sleepstudy Results
$q1_sql = "SELECT date, sleeptesttype, ahi, rdi, t9002, o2nadir, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id ASC LIMIT 1;";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);
$first_study_date = st($q1_myarray['date']);
$first_diagnosis = st($q1_myarray['diagnosis']);
$first_ahi = st($q1_myarray['ahi']);
$first_rdi = st($q1_myarray['rdi']);
$first_o2sat90 = st($q1_myarray['t9002']);
$first_o2nadir = st($q1_myarray['o2nadir']);
$first_type_study = st($q1_myarray['sleeptesttype']) . " sleep test";

// Newest Sleep Study Results
$q2_sql = "SELECT date, sleeptesttype, ahi, ahisupine, rdi, t9002, o2nadir, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);
$second_study_date = st($q2_myarray['date']);
$second_diagnosis = st($q2_myarray['diagnosis']);
$second_ahi = st($q2_myarray['ahi']);
$second_ahisupine = st($q2_myarray['ahisupine']);
$second_rdi = st($q2_myarray['rdi']);
$second_o2sat90 = st($q2_myarray['t9002']);
$second_o2nadir = st($q2_myarray['o2nadir']);
$second_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);
$dentaldevice = st($q2_myarray['dentaldevice']);

$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";
$sleeplab_my = mysql_query($sleeplab_sql);
$sleeplab_myarray = mysql_fetch_array($sleeplab_my);

$sleeplab_name = st($sleeplab_myarray['company']);

// Oldest Subjective results
$subj1_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$subj1_result = mysql_query($subj1_query);
while ($row = mysql_fetch_assoc($subj1_result)) {
	$subj1 = $row;
}

// Newest Subjective Results
$subj2_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";
$subj2_result = mysql_query($subj2_query);
while ($row = mysql_fetch_assoc($subj2_result)) {
	$subj2 = $row;
}

// Device Delivery Date
$device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";
$device_result = mysql_query($device_query);
$delivery_date = date('F d, Y', strtotime(mysql_result($device_result, 0)));


// Delay Reason and Description
$reason_query = "SELECT delay_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 5 AND letterid = '".$letterid."';";
$reason_result = mysql_query($reason_query);
while ($row = mysql_fetch_assoc($reason_result)) {
	$delay = $row;
}
$delay['description'] = str_replace(".", "", strtolower($delay['description']));

// Select BMI
$bmi_query = "SELECT bmi FROM dental_q_page1 WHERE patientid = '".$patientid."';";
$bmi_result = mysql_query($bmi_query);
$bmi = mysql_result($bmi_result, 0);

// Reason seeking treatment
$reason_query = "SELECT reason_seeking_tx FROM dental_summary WHERE patientid = '".$patientid."';";
$reason_result = mysql_query($reason_query);
$reason_seeking_tx = mysql_result($reason_result, 0);

// Symptoms 
$sql = "SELECT complaintid FROM dental_q_page1 WHERE patientid = '".$patientid."' LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
	$complaint = explode("~", rtrim($row['complaintid'], "~"));
}
foreach ($complaint as $pair) {
	$idscore = explode("|", $pair);
	$compid[] = $idscore[0];
}
foreach ($compid as $id) {
	$sql = "SELECT complaint FROM dental_complaint WHERE complaintid = '".$id."';";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
		$symptoms[] = $row['complaint'];
	}
}
foreach ($symptoms as $key => $value) {
	if ($key != count($symptoms) -1 && $key != count($symptoms) -2) {
		$symptom_list .= $value . ", ";
	} elseif ($key == count($symptoms) -2) {
		$symptom_list .= $value . " and ";
	} else {
		$symptom_list .= $value;
	}
}

// Nights per Week and Current ESS TSS 
$followup_query = "SELECT nightsperweek, ep_eadd, ep_tsadd FROM dentalsummfu where patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";
$followup_result = mysql_query($followup_query);
while ($row = mysql_fetch_assoc($followup_result)) {
	$followup = $row;
}

// Nights per Week and Current ESS TSS 
$initesstss_query = "SELECT ep_eadd, ep_tsadd FROM dentalsummfu where patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$initesstss_result = mysql_query($initesstss_query);
$initess = mysql_result($initesstss_result, 0, 0);
$inittss = mysql_result($initesstss_result, 0, 1);

// Non Compliance Reason and Description
$reason_query = "SELECT noncomp_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 9 AND letterid = '".$letterid."';";
$reason_result = mysql_query($reason_query);
while ($row = mysql_fetch_assoc($reason_result)) {
	$noncomp = $row;
}
$noncomp['description'] = str_replace(".", "", strtolower($noncomp['description']));

// Load $template

switch ($templateid) {
	case 1:
		require_once("letter_templates/letter1.php");
		break;
	case 2:
		require_once("letter_templates/letter2.php");
		break;
	case 3:
		require_once("letter_templates/letter3.php");
		break;
	case 4:
		require_once("letter_templates/letter4.php");
		break;
	case 5:
		require_once("letter_templates/letter5.php");
		break;
	case 6:
		require_once("letter_templates/letter6.php");
		break;
	case 7:
		require_once("letter_templates/letter7.php");
		break;
	case 8:
		require_once("letter_templates/letter8.php");
		break;
	case 9:
		require_once("letter_templates/letter9.php");
		break;
	case 10:
		require_once("letter_templates/letter10.php");
		break;
	case 11:
		require_once("letter_templates/letter11.php");
		break;
	case 12:
		require_once("letter_templates/letter12.php");
		break;
	case 13:
		require_once("letter_templates/letter13.php");
		break;
	case 14:
		require_once("letter_templates/letter14.php");
		break;
	case 15:
		require_once("letter_templates/letter15.php");
		break;
	case 16:
		require_once("letter_templates/letter16.php");
		break;
	case 17:
		require_once("letter_templates/letter17.php");
		break;
	case 18:
		require_once("letter_templates/letter18.php");
		break;
	case 19:
		require_once("letter_templates/letter19.php");
		break;
	case 20:
		require_once("letter_templates/letter20.php");
		break;
	case 21:
		require_once("letter_templates/letter21.php");
		break;
	case 22:
		require_once("letter_templates/letter22.php");
		break;
	case 23:
		require_once("letter_templates/letter23.php");
		break;
	case 24:
		require_once("letter_templates/letter24.php");
		break;
	case 25:
		require_once("letter_templates/letter25.php");
		break;
}

if (!empty($altered_template)) $template = html_entity_decode($altered_template);

?>
<form action="/manage/edit_letter.php?pid=<?=$patientid?>&lid=<?=$letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
<input type="hidden" name="numletters" value="<?=$numletters?>" />
<?php
if ($_POST != array()) {
	foreach ($_POST['duplicate_letter'] as $key => $value) {
    $dupekey = $key;
  }
  // Check for updated templates
	// search and replace 1 of 2
  foreach ($letter_contacts as $key => $contact) {
		$search = array();
		$replace = array();
		$search[] = '%todays_date%';
		$replace[] = "<strong>" . $todays_date . "</strong>";
		$search[] = '%contact_fullname%';
		$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
		$search[] = '%contact_firstname%';
		$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
		$search[] = '%contact_lastname%';
		$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
		$search[] = "%salutation%";
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
		$search[] = '%practice%';
		$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
		$search[] = '%contact_email%';
		$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
		$search[] = '%addr1%';
		$replace[] = "<strong>" . $contact['add1'] . "</strong>";
		$search[] = '%addr2%';
		$replace[] = ($contact['add2']) ? "<strong>" . $contact['add2'] . "</strong><br />" : "<!--%addr2%-->";
		$search[] = '%city%';
		$replace[] = "<strong>" . $contact['city'] . "</strong>";
		$search[] = '%state%';
		$replace[] = "<strong>" . $contact['state'] . "</strong>";
		$search[] = '%zip%';
		$replace[] = "<strong>" . $contact['zip'] . "</strong>";
		$search[] = "%franchisee_fullname%";
		$replace[] = "<strong>" . $franchisee_info['name'] . "</strong>";
		$search[] = "%franchisee_lastname%";
		$replace[] = "<strong>" . end(explode(" ", $franchisee_info['name'])) . "</strong>";
		$search[] = "%franchisee_practice%";
		$replace[] = "<strong>" . $franchisee_info['practice'] . "</strong>";
		$search[] = "%franchisee_phone%";
		$replace[] = "<strong>" . $franchisee_info['phone'] . "</strong>";
		$search[] = "%franchisee_addr%";
		$replace[] = "<strong>" . nl2br($franchisee_info['address']) . "<br />" . $franchisee_info['city'] . ", " . $franchisee_info['state'] . " " . $franchisee_info['zip'] . "</strong>";
		$search[] = "%patient_fullname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_lastname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%ccpatient_fullname%";
		$replace[] = ($key == 0) ? "" : "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_dob%";
		$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
		$search[] = "%patient_firstname%";
		$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
		$search[] = "%patient_age%";
		$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
		$search[] = "%patient_gender%";
		$replace[] = "<strong>" . $patient_info['gender'] . "</strong>";
		$search[] = "%His/Her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
		$search[] = "%his/her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
		$search[] = "%he/she%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
		$search[] = "%him/her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
		$search[] = "%He/She%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
		$search[] = "%history%";
		$replace[] = "<strong>" . $history_disp . "</strong>";
		$search[] = "%medications%";
		$replace[] = "<strong>" . $medications_disp . "</strong>";
		$search[] = "%sleeplab_name%";
		$replace[] = "<strong>" . $sleeplab_name . "</strong>";
		$search[] = "%type_study%";
		$replace[] = "<strong>" . $second_type_study . "</strong>";
		$search[] = "%ahi%";
		$replace[] = "<strong>" . $second_ahi . "</strong>";
		$search[] = "%diagnosis%";
		$replace[] = "<strong>" . $second_diagnosis . "</strong>";
		$search[] = "%1ststudy_date%";
		$replace[] = "<strong>" . $first_study_date . "</strong>";
		$search[] = "%1stRDI/AHI%";
		$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
		$search[] = "%1stLowO2%";
		$replace[] = "<strong>" . $first_o2nadir . "</strong>";
		$search[] = "%1stTO290%";
		$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
		$search[] = "%2ndtype_study%";
		$replace[] = "<strong>" . $second_type_study . "</strong>";
		$search[] = "%2ndahi%";
		$replace[] = "<strong>" . $second_ahi . "</strong>";
		$search[] = "%2ndahisupine%";
		$replace[] = "<strong>" . $second_ahisupine . "</strong>";
		$search[] = "%2ndrdi%";
		$replace[] = "<strong>" . $second_rdi . "</strong>";
		$search[] = "%2ndO2Sat90%";
		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
		$search[] = "%2ndstudy_date%";
		$replace[] = "<strong>" . $second_study_date . "</strong>";
		$search[] = "%2ndRDI/AHI%";
		$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
		$search[] = "%2ndLowO2%";
		$replace[] = "<strong>" . $second_o2nadir . "</strong>";
		$search[] = "%2ndTO290%";
		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
		$search[] = "%2nddiagnosis%";
		$replace[] = "<strong>" . $second_diagnosis . "</strong>";
		$search[] = "%delivery_date%";
		$replace[] = "<strong>" . $delivery_date . "</strong>";
		$search[] = "%dental_device%";
		$replace[] = "<strong>" . $dentaldevice . "</strong>";
		$search[] = "%1stESS%";
		$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
		$search[] = "%1stSnoring%";
		$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
		$search[] = "%1stEnergy%";
		$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
		$search[] = "%1stQuality%";
		$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
		$search[] = "%2ndESS%";
		$replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
		$search[] = "%2ndSnoring%";
		$replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
		$search[] = "%2ndEnergy%";
		$replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
		$search[] = "%2ndQuality%";
		$replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
		$search[] = "%bmi%";
		$replace[] = "<strong>" . $bmi . "</strong>";
		$search[] = "%reason_seeking_tx%";
		$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
		$search[] = "%symptoms%";
		$replace[] = "<strong>" . $symptom_list . "</strong>";
		$search[] = "%nightsperweek%";
		$replace[] = "<strong>" . $followup['nightsperweek'] . "</strong>";
		$search[] = "%currESS/TSS%";
		$replace[] = "<strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>";
		$search[] = "%initESS/TSS%";
		$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
		$search[] = "%patient_email%";
		$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
		$search[] = "%consult_date%";
		$replace[] = "<strong>" . $consult_date . "</strong>";
		$search[] = "%impressions_date%";
		$replace[] = "<strong>" . $impressions_date . "</strong>";
		$search[] = "%delay_reason%";
		switch ($delay['reason']) {
			case 'insurance':
				$replace[] = "<strong>insurance problems or issues</strong>";
				break;
			case 'dental work':
				$replace[] = "<strong>additional pending dental work</strong>";
				break;
			case 'deciding':
				$replace[] = "<strong>personal decision</strong>";
				break;
			case 'sleep study':
				$replace[] = "<strong>a pending sleep study</strong>";
				break;
			case 'other':
				if ($delay['description'] == '') {
					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
				} else {
					$replace[] = "<strong>" . $delay['description'] . "</strong>";
				}
				break;
			default:
				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
		}
		$search[] = "%noncomp_reason%";
		switch ($noncomp['reason']) {
			case 'pain/discomfort':
				$replace[] = "<strong>pain and/or discomfort</strong>";
				break;
			case 'lost device':
				$replace[] = "<strong>the device being lost and not replaced</strong>";
				break;
			case 'device not working':
				$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
				break;
			case 'other':
				if ($noncomp['description'] == '') {
					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
				} else {
					$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
				}
				break;
			default:
				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
		}
		$search[] = "%other_mds%";
		$other_mds = "";
		$count = 1;
		foreach ($md_contacts as $index => $md) {
			$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
			if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
				$other_mds .= $md_fullname;
				if ($count < count($md_contacts)) {
					$other_mds .= ", ";
				}	
				$count++;
			}
		}
		$other_mds = rtrim($other_mds, ", ");
		$replace[] = "<strong>" . $other_mds . "</strong>";

		$new_template[$key] = html_entity_decode($new_template[$key]);
    $new_template[$key] = str_replace($replace, $search, $_POST['letter'.$key]);
    // Letter hasn't been edited, but a new template exists in hidden field
 		if ($new_template[$key] == null && $_POST['new_template'][$key] != null) {
			$new_template[$key] = $_POST['new_template'][$key];
    }
    // Template hasn't changed
    if ($new_template[$key] == $template) {
			$new_template[$key] = null;	
    }
  }
  // Duplicate Letter Template
	if (isset($_POST['duplicate_letter']) && !$duplicated) {
		$dupe_template = $new_template[$dupekey];
    foreach ($letter_contacts as $key => $contact) {
      $new_template[$key] = $dupe_template;
    }
		$duplicated = true;
	}
	// Reset Letter
	if (isset($_POST['reset_letter'])) {
		foreach ($_POST['reset_letter'] as $key => $value) {
			$resetid = $key;
		}
		$new_template[$resetid] = null;
	}
}

foreach ($letter_contacts as $key => $contact) {
	// Token search and replace arrays
	// search and replace 2 of 2
	$search = array();
	$replace = array();
	$search[] = '%todays_date%';
	$replace[] = "<strong>" . $todays_date . "</strong>";
	$search[] = '%contact_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%contact_firstname%';
	$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
	$search[] = '%contact_lastname%';
	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
	$search[] = "%salutation%";
	$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
	$search[] = '%practice%';
	$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
	$search[] = '%contact_email%';
	$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
	$search[] = '%addr1%';
	$replace[] = "<strong>" . $contact['add1'] . "</strong>";
  $search[] = '%addr2%';
	$replace[] = ($contact['add2']) ? "<strong>" . $contact['add2'] . "</strong><br />" : "<!--%addr2%-->";
  $search[] = '%city%';
	$replace[] = "<strong>" . $contact['city'] . "</strong>";
  $search[] = '%state%';
	$replace[] = "<strong>" . $contact['state'] . "</strong>";
  $search[] = '%zip%';
	$replace[] = "<strong>" . $contact['zip'] . "</strong>";
	$search[] = "%franchisee_fullname%";
	$replace[] = "<strong>" . $franchisee_info['name'] . "</strong>";
	$search[] = "%franchisee_lastname%";
	$replace[] = "<strong>" . end(explode(" ", $franchisee_info['name'])) . "</strong>";
	$search[] = "%franchisee_practice%";
	$replace[] = "<strong>" . $franchisee_info['practice'] . "</strong>";
	$search[] = "%franchisee_phone%";
	$replace[] = "<strong>" . $franchisee_info['phone'] . "</strong>";
	$search[] = "%franchisee_addr%";
	$replace[] = "<strong>" . nl2br($franchisee_info['address']) . "<br />" . $franchisee_info['city'] . ", " . $franchisee_info['state'] . " " . $franchisee_info['zip'] . "</strong>";
	$search[] = "%patient_fullname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_lastname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%ccpatient_fullname%";
	$replace[] = ($key == 0) ? "" : "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_dob%";
	$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
	$search[] = "%patient_firstname%";
	$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
	$search[] = "%patient_age%";
	$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
	$search[] = "%patient_gender%";
	$replace[] = "<strong>" . $patient_info['gender'] . "</strong>";
	$search[] = "%His/Her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
	$search[] = "%his/her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
	$search[] = "%he/she%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
	$search[] = "%him/her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
	$search[] = "%He/She%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
	$search[] = "%history%";
	$replace[] = "<strong>" . $history_disp . "</strong>";
	$search[] = "%medications%";
	$replace[] = "<strong>" . $medications_disp . "</strong>";
	$search[] = "%sleeplab_name%";
	$replace[] = "<strong>" . $sleeplab_name . "</strong>";
	$search[] = "%type_study%";
	$replace[] = "<strong>" . $second_type_study . "</strong>";
	$search[] = "%ahi%";
	$replace[] = "<strong>" . $second_ahi . "</strong>";
	$search[] = "%diagnosis%";
	$replace[] = "<strong>" . $second_diagnosis . "</strong>";
	$search[] = "%1ststudy_date%";
	$replace[] = "<strong>" . $first_study_date . "</strong>";
	$search[] = "%1stRDI/AHI%";
	$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
	$search[] = "%1stLowO2%";
	$replace[] = "<strong>" . $first_o2nadir . "</strong>";
	$search[] = "%1stTO290%";
	$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
	$search[] = "%2ndtype_study%";
	$replace[] = "<strong>" . $second_type_study . "</strong>";
	$search[] = "%2ndahi%";
	$replace[] = "<strong>" . $second_ahi . "</strong>";
	$search[] = "%2ndahisupine%";
	$replace[] = "<strong>" . $second_ahisupine . "</strong>";
	$search[] = "%2ndrdi%";
	$replace[] = "<strong>" . $second_rdi . "</strong>";
	$search[] = "%2ndO2Sat90%";
	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
	$search[] = "%2ndstudy_date%";
	$replace[] = "<strong>" . $second_study_date . "</strong>";
	$search[] = "%2ndRDI/AHI%";
	$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
	$search[] = "%2ndLowO2%";
	$replace[] = "<strong>" . $second_o2nadir . "</strong>";
	$search[] = "%2ndTO290%";
	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
	$search[] = "%2nddiagnosis%";
	$replace[] = "<strong>" . $second_diagnosis . "</strong>";
	$search[] = "%delivery_date%";
	$replace[] = "<strong>" . $delivery_date . "</strong>";
	$search[] = "%dental_device%";
	$replace[] = "<strong>" . $dentaldevice . "</strong>";
	$search[] = "%1stESS%";
	$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
	$search[] = "%1stSnoring%";
	$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
	$search[] = "%1stEnergy%";
	$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
	$search[] = "%1stQuality%";
	$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
	$search[] = "%2ndESS%";
	$replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
	$search[] = "%2ndSnoring%";
	$replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
	$search[] = "%2ndEnergy%";
	$replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
	$search[] = "%2ndQuality%";
	$replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
	$search[] = "%bmi%";
	$replace[] = "<strong>" . $bmi . "</strong>";
	$search[] = "%reason_seeking_tx%";
	$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
	$search[] = "%symptoms%";
	$replace[] = "<strong>" . $symptom_list . "</strong>";
	$search[] = "%nightsperweek%";
	$replace[] = "<strong>" . $followup['nightsperweek'] . "</strong>";
	$search[] = "%currESS/TSS%";
	$replace[] = "<strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>";
	$search[] = "%initESS/TSS%";
	$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
	$search[] = "%patient_email%";
	$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
	$search[] = "%consult_date%";
	$replace[] = "<strong>" . $consult_date . "</strong>";
	$search[] = "%impressions_date%";
	$replace[] = "<strong>" . $impressions_date . "</strong>";
	$search[] = "%delay_reason%";
	switch ($delay['reason']) {
		case 'insurance':
			$replace[] = "<strong>insurance problems or issues</strong>";
			break;
		case 'dental work':
			$replace[] = "<strong>additional pending dental work</strong>";
			break;
		case 'deciding':
			$replace[] = "<strong>personal decision</strong>";
			break;
		case 'sleep study':
			$replace[] = "<strong>a pending sleep study</strong>";
			break;
		case 'other':
			if ($delay['description'] == '') {
				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
			} else {
				$replace[] = "<strong>" . $delay['description'] . "</strong>";
			}
			break;
		default:
			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
	}
	$search[] = "%noncomp_reason%";
	switch ($noncomp['reason']) {
		case 'pain/discomfort':
			$replace[] = "<strong>pain and/or discomfort</strong>";
			break;
		case 'lost device':
			$replace[] = "<strong>the device being lost and not replaced</strong>";
			break;
		case 'device not working':
			$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
			break;
		case 'other':
			if ($noncomp['description'] == '') {
				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
			} else {
				$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
			}
			break;
		default:
			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
	}
	$search[] = "%other_mds%";
	$other_mds = "";
	$count = 1;
	foreach ($md_contacts as $index => $md) {
		$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
		if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
			$other_mds .= $md_fullname;
			if ($count < count($md_contacts)) {
				$other_mds .= ", ";
			}	
			$count++;
		}
	}
	$other_mds = rtrim($other_mds, ", ");
	$replace[] = "<strong>" . $other_mds . "</strong>";
	
 	if ($new_template[$key] != null) {
	  $letter[$key] = str_replace($search, $replace, $new_template[$key]);
	} else {
	  $letter[$key] = str_replace($search, $replace, $template);
 	}

	?>
	<?php // loop through letters ?>
	<div align="right">
		<button class="addButton" onclick="Javascript: edit_letter('letter<?=$key?>');return false;" >
			Edit Letter
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php if($numletters > 1): ?>
		<input type="submit" name="duplicate_letter[<?=$key?>]" class="addButton" value="Duplicate" />
		<?php endif; ?>
		<!--&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_print.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_word.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>-->
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="send_letter[<?=$key?>]" class="addButton" value="Send Letter" />
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<div id="letter<?=$key?>">
				<?php print $letter[$key]; ?>
				</div>
				<input type="hidden" name="new_template[<?=$key?>]" value="<?=htmlentities($new_template[$key])?>" />
			</td>
		</tr>
	</table>
	<div align="right">
		<input type="submit" name="reset_letter[<?=$key?>]" class="addButton" value="Reset" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="delete_letter[<?=$key?>]" class="addButton" value="Delete" />
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<hr width="90%" />

<br><br>
</form>
		</td>
	</tr>
</table>

<?php

	// Catch Post Send Submit Button and Send letters Here
  if ($_POST['send_letter'][$key] != null && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
  		$parent = true;
    }
 		$type = $contact['type'];
		$recipientid = $contact['id'];
		if ($_GET['backoffice'] == '1') {
			$message = $letter[$key];
			$search= array("<strong>","</strong>");
			$message = str_replace($search, "", $message);	
			deliver_letter($letterid, $message);
			$sql = "SELECT send_method FROM dental_letters WHERE letterid = '" . $letterid . "'";
			$result = mysql_query($sql);
			$method = mysql_result($result, 0);
			if ($method == "paper") {
			?>
				<form name="printpreview" action="/manage/print_preview.php" method="post" target="_blank">
				<input type="hidden" name="message" value="<?= htmlentities($message) ?>" />
				</form>
				
				<script type="text/javascript">
					document.printpreview.submit();
				</script>
			<?php
			}
		} else {
	    $sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
		}
  }
	// Catch Post Delete Button and Delete letters Here
  if ($_POST['delete_letter'][$key] != null && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
  		$parent = true;
    } else {
			$parent = false;
		}
 		$type = $contact['type'];
		$recipientid = $contact['id'];
    delete_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
		if ($parent) {
			?>
			<script type="text/javascript">
				window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
			</script>
			<?php
		}

    continue;
  }
?>

<?php
if ($parent) {
	?>
	<script type="text/javascript">
		window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
	</script>
	<?php
}

continue;

} // End foreach loop through letters


if($_GET['backoffice'] == '1') {
  include 'admin/includes/bottom.htm';
} else {
	include 'includes/bottom.htm';

} 
?>
