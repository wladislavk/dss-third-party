<?php namespace Ds3\Libraries\Legacy; ?><?php 
if($_GET['backoffice'] == '1') {
  include 'admin/includes/top.htm';
} else {
  include 'includes/top.htm';
}

?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js?v=20160404"></script>
<?php
$letterid = mysqli_real_escape_string($con, !empty($_GET['lid']) ? $_GET['lid'] : '');

// Select Letter
$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$letterid.";";
$letter_result = $db->getRow($letter_query);
if ($letter_result) {
  $templateid = $letter_result['templateid'];
  $patientid = $letter_result['patientid'];
  $topatient = $letter_result['topatient'];
  $md_list = $letter_result['md_list'];
  $md_referral_list = $letter_result['md_referral_list'];
  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
}

// Pending and Sent Contacts
$othermd_query = "SELECT md_list, md_referral_list FROM dental_letters where letterid = '".$letterid."' OR parentid = '".$letterid."' ORDER BY letterid ASC;";
$othermd_result = $db->getResults($othermd_query);
$md_array = array();
$md_referral_array = array();
if ($othermd_result) foreach ($othermd_result as $row) {
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
if ($contacts['mds']) foreach ($contacts['mds'] as $contact) {
	$md_contacts[] = array_merge(array('type' => 'md'), $contact);
}
if (!empty($contacts['md_referrals'])) foreach ($contacts['md_referrals'] as $contact) {
	$md_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
}

// Get Letter Subject
$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
$template_result = $db->getRow($template_query);
$title = ($template_result) ? array_shift($template_result) : '';

// Get Franchisee Name
$franchisee_query = "SELECT name FROM dental_users WHERE userid = '".$_SESSION['docid']."';";
$franchisee_result = $db->getRow($franchisee_query);
$franchisee_name = ($franchisee_result) ? array_shift($franchisee_result) : '';

// Get Patient Information
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob FROM dental_patients WHERE patientid = '".$patientid."';";
$patient_result = $db->getRow($patient_query);
if ($patient_result) {
	$patient_info = array_merge($patient_result, array('age'=> floor((time() - strtotime($patient_result['dob']))/31556926) ));
}

// Get Medical Information
$q3_sql = "SELECT history, medications from dental_q_page3_pivot WHERE patientid = '".$patientid."';";
$q3_myarray = $db->getRow($q3_sql);

$history = $q3_myarray['history'];
$medications = $q3_myarray['medications'];

$history_arr = explode('~',$history);
$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val){
	if(trim($val) <> ""){
		$his_sql = "select history from dental_history where historyid='".trim($val)."' and status=1;";
		$his_myarray = $db->getRow($his_sql);
		
		if($his_myarray['history'] <> ''){
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
foreach($medications_arr as $key => $val){
	if(trim($val) <> ""){
		$medications_sql = "select medications from dental_medications where medicationsid='".trim($val)."' and status=1;";
		$medications_myarray = $db->getRow($medications_sql);
		
		if($medications_myarray['medications'] <> ''){
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

$q2_sql = "SELECT date, sleeptesttype, ahi, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
$q2_myarray = $db->getRow($q2_sql);
$sleep_study_date = st($q2_myarray['date']);
$diagnosis = st($q2_myarray['diagnosis']);
$ahi = st($q2_myarray['ahi']);
$type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);
$dentaldevice = st($q2_myarray['dentaldevice']);

$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";
$sleeplab_myarray = $db->getRow($sleeplab_sql);

$sleeplab_name = st($sleeplab_myarray['company']);

// Appointment Date
$appt_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
$appt_result = $db->getRow($appt_query);
$date_scheduled = ($appt_result) ? array_shift($appt_result) : 0;
$appt_date = date('F d, Y', strtotime($date_scheduled));

// Device Delivery Date
$device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";
$device_result = $db->getRow($device_query);
$date_completed = ($device_result) ? array_shift($device_result) : 0;
$delivery_date = date('F d, Y', strtotime($date_completed));

// Non Compliance Reason and Description
$reason_query = "SELECT noncomp_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 9 AND letterid = '".$letterid."';";
$reason_result = $db->getRow($reason_query);
if ($reason_result) {
	$noncomp = $reason_result;
	$noncomp['description'] = str_replace(".", "", strtolower($noncomp['description']));
}?>


<br />
<span class="admin_head">
	<?php print $title; ?>
</span>
<br />
&nbsp;&nbsp;
<a href="<?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
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
if (!empty($contact_info['patient'])) foreach ($contact_info['patient'] as $contact) {
	$letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
}
if (!empty($contact_info['mds'])) foreach ($contact_info['mds'] as $contact) {
	$letter_contacts[] = array_merge(array('type' => 'md'), $contact);
}
if (!empty($contact_info['md_referrals'])) foreach ($contact_info['md_referrals'] as $contact) {
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
		<td>%patient_fullname% - PATIENT NO LONGER DENTAL DEVICE COMPLIANT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear %salutation% %md_lastname%:</p>

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% with a PMH that includes %history%.  %His/Her% medications include %medications%.  %patient_firstname% had a %type_study% done at the %sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>We delivered a %dental_device% dental device on %delivery_date%.</p>

<p>I regret to inform you that %he/she% has become non compliant with dental device therapy due to %noncomp_reason%.</p>

<p>I am referring her back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in %patient_firstname%'s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:  %other_mds%<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%ccpatient_fullname%</p>";


?>
<form action="/manage/dss_progress_note_to_md_pt_non_compliant.php?pid=<?php echo $patientid?>&lid=<?php echo $letterid?><?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post">
<input type="hidden" name="numletters" value="<?php echo $numletters?>" />
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
		$search[] = "%type_study%";
		$replace[] = "<strong>" . $type_study . "</strong>";
		$search[] = "%ahi%";
		$replace[] = "<strong>" . $ahi . "</strong>";
		$search[] = "%diagnosis%";
		$replace[] = "<strong>" . $diagnosis . "</strong>";
		$search[] = "%appt_date%";
		$replace[] = "<strong>" . $appt_date . "</strong>";
		$search[] = "%delivery_date%";
		$replace[] = "<strong>" . $delivery_date . "</strong>";
		$search[] = "%dental_device%";
		$replace[] = "<strong>" . $dentaldevice . "</strong>";
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
				$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
				break;
			default:
				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
		}

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
	$search = array();
	$replace = array();
	$search[] = '%todays_date%';
	$replace[] = "<strong>" . $todays_date . "</strong>";
	$search[] = '%md_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%md_lastname%';
	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
	$search[] = '%practice%';
	$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
	$search[] = "%salutation%";
	$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
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
	$search[] = "%type_study%";
	$replace[] = "<strong>" . $type_study . "</strong>";
	$search[] = "%ahi%";
	$replace[] = "<strong>" . $ahi . "</strong>";
	$search[] = "%diagnosis%";
	$replace[] = "<strong>" . $diagnosis . "</strong>";
	$search[] = "%appt_date%";
	$replace[] = "<strong>" . $appt_date . "</strong>";
	$search[] = "%delivery_date%";
	$replace[] = "<strong>" . $delivery_date . "</strong>";
	$search[] = "%dental_device%";
	$replace[] = "<strong>" . $dentaldevice . "</strong>";
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
			$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
			break;
		default:
			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
	}


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
		if ($parent) {?>
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
		if ($parent) {?>
			<script type="text/javascript">
				window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
			</script>
			<?php
		}
    continue;
	}?>
	<?php // loop through letters ?>
	<div align="right">
		<button class="addButton" onclick="edit_letter('letter<?php echo $key?>');return false;" >
			Edit Letter
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="duplicate_letter[<?php echo $key?>]" class="addButton" value="Duplicate" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_print.php?pid=<?php echo $_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_word.php?pid=<?php echo $_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="send_letter[<?php echo $key?>]" class="addButton" value="Send Letter" />
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<div id="letter<?php echo $key?>">
				<?php print $letter[$key]; ?>
				</div>
				<input type="hidden" name="new_template[<?php echo $key?>]" value="<?php echo $new_template[$key]?>" />
			</td>
		</tr>
	</table>
	<div align="right">
		<input type="submit" name="reset_letter[<?php echo $key?>]" class="addButton" value="Reset" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="delete_letter[<?php echo $key?>]" class="addButton" value="Delete" />
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<hr width="90%" />

<?php
}?>
<br><br>
</form>

		</td>
	</tr>
</table>


<?php
if(!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
	include 'admin/includes/bottom.htm';
} else {
	include 'includes/bottom.htm';
} ?> 
