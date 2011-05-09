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

$q2_sql = "SELECT date, sleeptesttype, ahi, diagnosis, place FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);
$sleep_study_date = st($q2_myarray['date']);
$diagnosis = st($q2_myarray['diagnosis']);
$ahi = st($q2_myarray['ahi']);
$type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);

$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";
$sleeplab_my = mysql_query($sleeplab_sql);
$sleeplab_myarray = mysql_fetch_array($sleeplab_my);

$sleeplab_name = st($sleeplab_myarray['company']);

// Appointment Date
$appt_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
$appt_result = mysql_query($appt_query);
$appt_date = date('F d, Y', strtotime(mysql_result($appt_result, 0)));

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
%practice%<br />
%addr1%<br />
%addr2%
%city%, %state% %zip%<br />
</p>
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - ACCEPTS TREATMENT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %md_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% with a PMH that includes %history%.  %His/Her% medications include %medications%.  %patient_firstname% had a %type_study% done at the %sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  %He/She% is scheduled to begin treatment on %appt_date%.</p>

<p>Thank you again for your confidence and the referral.  We will keep you updated as treatment progresses.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:  %other_mds%</p>";


?>
<form action="/manage/dss_referral_thank_you_pt_scheduled.php?pid=<?=$patientid?>&lid=<?=$letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post">
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
		$search[] = "%type_study%";
		$replace[] = "<strong>" . $type_study . "</strong>";
		$search[] = "%ahi%";
		$replace[] = "<strong>" . $ahi . "</strong>";
		$search[] = "%diagnosis%";
		$replace[] = "<strong>" . $diagnosis . "</strong>";
		$search[] = "%appt_date%";
		$replace[] = "<strong>" . $appt_date . "</strong>";
		$search[] = "%other_mds%";
		$other_mds = "";
		$count = 1;
		foreach ($letter_contacts as $index => $md) {
			if ($key != $index) {
				$other_mds .= $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
				if ($count < $numletters - 1) {
					$other_mds .= ", ";
				}	
				$count++;
			}
		}
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
	$search[] = "%type_study%";
	$replace[] = "<strong>" . $type_study . "</strong>";
	$search[] = "%ahi%";
	$replace[] = "<strong>" . $ahi . "</strong>";
	$search[] = "%diagnosis%";
	$replace[] = "<strong>" . $diagnosis . "</strong>";
	$search[] = "%appt_date%";
	$replace[] = "<strong>" . $appt_date . "</strong>";
	$search[] = "%other_mds%";
	$other_mds = "";
	$count = 1;
	foreach ($letter_contacts as $index => $md) {
		if ($key != $index) {
			$other_mds .= $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
			if ($count < $numletters - 1) {
				$other_mds .= ", ";
			}	
			$count++;
		}
	}
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
			deliver_letter($letterid);
		} else {
	    $sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
		}
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
