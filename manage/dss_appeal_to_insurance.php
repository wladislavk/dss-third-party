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
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob, email FROM dental_patients WHERE patientid = '".$patientid."';";
$patient_result = mysql_query($patient_query);
$patient_info = array();
while ($row = mysql_fetch_assoc($patient_result)) {
	$patient_info = $row;
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
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - DENIAL OF COVERAGE</td>
	</tr>
	<tr>
		<td width=\50px\">ID:</td>
		<td>%insurance_id%</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>


<p>Dear Sir or Madam:</p>

<p>I received your denial of coverage for the Mandibular Repositioning Device that has been prescribed for %patient_fullname% by Dr. %franchisee_fullname% and I am writing on behalf of our patient to appeal that decision.  You have based your decision on [(INSERT REASON WHY THEY ARE DENYING HERE)].</p>

<p>%patient_lastname% has been prescribed a Mandibular Repositioning Device by Dr. %franchisee_fullname% to treat %his/her% documented sleep apnea.  This is neither an oral splint or appliance, nor a dental splint or dental brace.  It is a Mandibular Repositioning Device, specifically considered as Durable Medical Equipment, and specifically coded as a MEDICAL treatment for a MEDICAL diagnosis.  While these appliances are intraoral, they are not meant to treat the teeth.  Instead, they reposition the jaw and tongue to open up the airway. Because the treatment is used to treat a medical condition it cannot be considered \"dental.\"</p>

<p>It is gross negligence to deny payment for a Mandibular Repositioning Device under these circumstances.</p>

<p>The American Academy of Sleep Medicine recently published a Practice Parameters paper (Sleep, February, 2006) on the use of oral appliances to treat sleep apnea.  This paper stated that the abundance of evidence-based research on oral appliance therapy has shown Mandibular Repositioners to be successful enough that they are now recommend as a first line of therapy for mild to moderate sleep apnea, as well as for patients with more severe apnea who prefer the appliance to CPAP or cannot tolerate CPAP.</p>

<p>This letter should explain why treatment for %patient_lastname% should be covered under \"medical reimbursement.\"   I look forward to the opportunity to discuss this appeal and this case with you over the telephone.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%</p>";

?>
<form action="/manage/dss_appeal_to_insurance.php?pid=<?=$patientid?>&lid=<?=$letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
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
		$search[] = '%contact_fullname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . " " . $letter_contacts[$key]['firstname'] . " " . $letter_contacts[$key]['lastname'] . "</strong>";
		$search[] = '%contact_firstname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['firstname'] . "</strong>";
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
		$search[] = "%franchisee_lastname%";
		$replace[] = "<strong>" . end(explode(" ", $franchisee_name)) . "</strong>";
		$search[] = "%patient_fullname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_dob%";
		$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
		$search[] = "%patient_firstname%";
		$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
		$search[] = "%patient_lastname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_age%";
		$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
		$search[] = "%patient_email%";
		$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
		$search[] = "%his/her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";

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
	$search[] = '%contact_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%contact_firstname%';
	$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
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
	$search[] = "%franchisee_lastname%";
	$replace[] = "<strong>" . end(explode(" ", $franchisee_name)) . "</strong>";
	$search[] = "%patient_fullname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_dob%";
	$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
	$search[] = "%patient_firstname%";
	$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
	$search[] = "%patient_lastname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_age%";
	$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
	$search[] = "%patient_email%";
	$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
	$search[] = "%his/her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
	
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
