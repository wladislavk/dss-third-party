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

/*$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
$form_my = mysql_query($form_sql);
$form_myarray = mysql_fetch_array($form_my);

if($form_myarray['formid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_forms.php?pid=<?=$_GET['pid'];?>';
	</script>
	<?
	die();
}

$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}*/

$letterid = mysql_real_escape_string($_GET['lid']);

// Select Letter
$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$letterid.";";
$letter_result = mysql_query($letter_query);
while ($row = mysql_fetch_assoc($letter_result)) {
  $templateid = $row['templateid'];
  $patientid = $row['patientid'];
  $topatient = $row['topatient'];
  $md_list = $row['md_list'];
  $md_referral_list = $row['md_referral_list'];
  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
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

// Get Franchisee Name
$franchisee_query = "SELECT name FROM dental_users WHERE userid = '".$_SESSION['docid']."';";
$franchisee_result = mysql_query($franchisee_query);
$franchisee_name = mysql_result($franchisee_result, 0);

// Get Patient Information
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob FROM dental_patients WHERE patientid = '".$patientid."';";
$patient_result = mysql_query($patient_query);
$patient_info = array();
while ($row = mysql_fetch_assoc($patient_result)) {
	$patient_info = $row;
}
$patient_info['age'] = floor((time() - strtotime($patient_info['dob']))/31556926);

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

$q2_sql = "SELECT date, sleeptesttype, ahi, rdi, t9002, o2nadir, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);
$second_study_date = st($q2_myarray['date']);
$second_diagnosis = st($q2_myarray['diagnosis']);
$second_ahi = st($q2_myarray['ahi']);
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

$subj1_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$subj1_result = mysql_query($subj1_query);
while ($row = mysql_fetch_assoc($subj1_result)) {
	$subj1 = $row;
}

$subj2_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";
$subj2_result = mysql_query($subj2_query);
while ($row = mysql_fetch_assoc($subj2_result)) {
	$subj2 = $row;
}

// Device Delivery Date
$device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";
$device_result = mysql_query($device_query);
$delivery_date = date('F d, Y', strtotime(mysql_result($device_result, 0)));

// Appointment Date
$appt_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
$appt_result = mysql_query($appt_query);
$appt_date = date('F d, Y', strtotime(mysql_result($appt_result, 0)));

function trigger_letter20($pid) {
  $letterid = '20';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, '', $topatient);
  if (!is_numeric($letter)) {
    print $letter;
    die();
  } else {
    return $letter;
  }
}

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
$todays_date = date('F d, Y');

$template = "<p>%todays_date%</p>
<p>
%md_fullname%<br />
%practice%
%addr1%<br />
%addr2%
%city%, %state% %zip%<br />
</p>
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - DENTAL DEVICE TREATMENT RESULTS</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear %salutation% %md_lastname%:</p>

<p>We have a mutual patient, %patient_fullname%, a %patient_age% year old %patient_gender% who was diagnosed with %2nddiagnosis% after undergoing %2ndtype_study% on %2ndstudy_date% where %he/she% scored an AHI of %2ndahi% and/or RDI of %2ndrdi%; and spent %2ndO2Sat90%% of the night below 90% O2.</p>

<p>We delivered %dental_device% device on %delivery_date%, and %he/she% has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study. %patient_firstname%'s results, baseline and post appliance insertion appear below.</p>

<table cellpadding=\"7px\">
	<tr>
		<th>OBJECTIVE</th>
		<th>Before</th>
		<th>%1ststudy_date%&nbsp;&nbsp;&nbsp;&nbsp;</th>
		<th>After</th>
		<th>%2ndstudy_date%</th>
	</tr>
	<tr>
		<td>RDI / AHI</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stRDI/AHI%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndRDI/AHI%</td>
	</tr>
	<tr>
		<td>Low O2</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stLowO2%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndLowO2%</td>
	</tr>
	<tr>
		<td>T O2 &#8804; 90%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stTO290%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndTO290%</td>
	</tr>
	<tr>
		<td>ESS</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stESS%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndESS%</td>
	</tr>
	<tr>
		<th>SUBJECTIVE</th>
		<td colspan=\"2\" style=\"text-align:center;\"></td>
		<td colspan=\"2\" style=\"text-align:center;\"></td>
	</tr>
	<tr>
		<td>Snoring</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stSnoring%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndSnoring%</td>
	</tr>
	<tr>
		<td>Energy Level</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stEnergy%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndEnergy%</td>
	</tr>
	<tr>
		<td>Sleep Quality</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stQuality%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndQuality%</td>
	</tr>
</table>

<p>%patient_firstname% has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up.   I believe we have reached maximum medical improvement with a dental device, and at this point I plan to refer %patient_firstname% back to your office for further medical care.</p>

<p>Please don't hesitate to call if you have any questions. I thank you again for the opportunity to participate in this patient's treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:  %patient_fullname%</p>";


?>
<form action="/manage/dss_to_md_pt_treatment_complete.php?pid=<?=$patientid?>&lid=<?=$letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
<input type="hidden" name="numletters" value="<?=$numletters?>" />
<?php
if ($_POST != array()) {
	foreach ($_POST['duplicate_letter'] as $key => $value) {
    $dupekey = $key;
  }
  // Check for updated templates
  foreach ($letter_contacts as $key => $contact) {
		$search = array();
		$replace = array();
		$search[] = '%todays_date%';
		$replace[] = "<strong>" . $todays_date . "</strong>";
		$search[] = '%md_fullname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . " " . $letter_contacts[$key]['firstname'] . " " . $letter_contacts[$key]['lastname'] . "</strong>";
		$search[] = '%md_lastname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['lastname'] . "</strong>";
		$search[] = "%salutation%";
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
		$search[] = '%practice%';
		$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
		$search[] = '%addr1%';
		$replace[] = "<strong>" . $letter_contacts[$key]['add1'] . "</strong>";
		$search[] = '%addr2%';
		$replace[] = ($letter_contacts[$key]['add2']) ? "<strong>" . $letter_contacts[$key]['add2'] . "</strong><br />" : "<!--%addr2%-->";
		$search[] = '%city%';
		$replace[] = "<strong>" . $letter_contacts[$key]['city'] . "</strong>";
		$search[] = '%state%';
		$replace[] = "<strong>" . $letter_contacts[$key]['state'] . "</strong>";
		$search[] = '%zip%';
		$replace[] = "<strong>" . $letter_contacts[$key]['zip'] . "</strong>";
		$search[] = "%franchisee_fullname%";
		$replace[] = "<strong>" . $franchisee_name . "</strong>";
		$search[] = "%patient_fullname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
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
		$search[] = "%he/she%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
		$search[] = "%He/She%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
		$search[] = "%history%";
		$replace[] = "<strong>" . $history_disp . "</strong>";
		$search[] = "%medications%";
		$replace[] = "<strong>" . $medications_disp . "</strong>";
		$search[] = "%sleeplab_name%";
		$replace[] = "<strong>" . $sleeplab_name . "</strong>";
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
		$search[] = "%appt_date%";
		$replace[] = "<strong>" . $appt_date . "</strong>";
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


//print_r($new_template);


foreach ($letter_contacts as $key => $contact) {
	// Token search and replace arrays
	$search = array();
	$replace = array();
	$search[] = '%todays_date%';
	$replace[] = "<strong>" . $todays_date . "</strong>";
	$search[] = '%md_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%md_lastname%';
	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
	$search[] = "%salutation%";
	$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
	$search[] = '%practice%';
	$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
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
	$search[] = '%franchisee_fullname%';
	$replace[] = "<strong>" . $franchisee_name . "</strong>";
	$search[] = "%patient_fullname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
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
	$search[] = "%he/she%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
	$search[] = "%He/She%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
  $search[] = "%history%";
	$replace[] = "<strong>" . $history_disp . "</strong>";
	$search[] = "%medications%";
	$replace[] = "<strong>" . $medications_disp . "</strong>";
	$search[] = "%sleeplab_name%";
	$replace[] = "<strong>" . $sleeplab_name . "</strong>";
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
	$search[] = "%appt_date%";
	$replace[] = "<strong>" . $appt_date . "</strong>";
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
		$new_template[$key] = htmlentities($new_template[$key]);
	} else {
	  $letter[$key] = str_replace($search, $replace, $template);
 	}

	// Catch Post Send Submit Button and Send letters Here
  if ($_POST['send_letter'][$key] != null && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
  		$parent = true;
    }
    $letterid = $letterid;
 		$type = $contact['type'];
		$recipientid = $contact['id'];
		if ($_GET['backoffice'] == '1') {
			$message = $letter[$key];
			$search= array("<strong>","</strong>");
			$message = str_replace($search, "", $message);	
			deliver_letter($letterid, $message);
		} else {
	    $sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
		}

		//$letter20id = trigger_letter20($patientid);

		if ($parent) {
			?>
			<script type="text/javascript">
				window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
			</script>
			<?php
		}

    continue;
  }
	// Catch Post Delete Button and Delete letters Here
  if ($_POST['delete_letter'][$key] != null && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
  		$parent = true;
    }
 		$type = $contact['type'];
		$recipientid = $contact['id'];
    $letterid = delete_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
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
	<?php // loop through letters ?>
	<div align="right">
		<button class="addButton" onclick="Javascript: edit_letter('letter<?=$key?>');return false;" >
			Edit Letter
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="duplicate_letter[<?=$key?>]" class="addButton" value="Duplicate" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_print.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_word.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>
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
				<input type="hidden" name="new_template[<?=$key?>]" value="<?=$new_template[$key]?>" />
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

<?php
}
?>
<br><br>
</form>

		</td>
	</tr>
</table>


<?php
if($_GET['backoffice'] == '1') {
  include 'admin/includes/bottom.htm';
} else {
	include 'includes/bottom.htm';

} 
?>
