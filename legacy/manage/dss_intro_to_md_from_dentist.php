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

$letterid = mysqli_real_escape_string($con, $_GET['lid']);

// Select Letter
$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$letterid.";";
$letter_result = $db->getRow($letter_query);
if ($letter_result){
	$templateid = $letter_result['templateid'];
	$patientid = $letter_result['patientid'];
	$topatient = $letter_result['topatient'];
	$md_list = $letter_result['md_list'];
	$md_referral_list = $letter_result['md_referral_list'];
	$mds = explode(",", $md_list);
	$md_referrals = explode(",", $md_referral_list);
}

// Get Letter Subject
$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
$template_result = $db->getRow($template_query);
$title = ($template_result) ? array_shift($template_result) : '';

// Get Franchisee Name
$franchisee_query = "SELECT name FROM dental_users WHERE userid = '".$_SESSION['docid']."';";
$franchisee_result = $db->getRow($franchisee_query);
$franchisee_name = ($franchisee_result) ? array_shift($franchisee_result) : '';?>


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
if ($topatient) {
	$contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
} else {
	$contact_info = get_contact_info('', $md_list, $md_referral_list);
}

$letter_contacts = array();
if ($contact_info['patient']) foreach ($contact_info['patient'] as $contact) {
	$letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
}
if ($contact_info['mds']) foreach ($contact_info['mds'] as $contact) {
	$letter_contacts[] = array_merge(array('type' => 'md'), $contact);
}
if ($contact_info['md_referrals']) foreach ($contact_info['md_referrals'] as $contact) {
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

<p>Dear Dr. %md_lastname%:</p>

<p>Thank you for allowing me a few minutes of your time.  My name is Dr. %franchisee_fullname%, and I am a dentist who has partnered with Dental Sleep Solutions&reg;, a company committed to maximizing successful treatment options for patients who suffer from sleep disordered breathing.    As a Dental Sleep Solutions&reg; Dentist, I have completed a \"mini residency\" training program put on by nationally known Board Certified dentists; our office adheres to practice protocols that are consistent with the highest levels of patient care.</p>
<p>We welcome your referrals for the treatment of snoring, upper airway resistance syndrome, and obstructive sleep apnea.    We evaluate patients individually and recommend treatment plans based on disease severity and patient preferences, all the while following the guidelines as laid down by the American Academy of Sleep Medicine's (AASM) position paper on the parameters  for use of oral appliances in the treatment of OSA, as appeared  in the February, 2006 issue of Sleep.   It states that oral appliances may be used as a first line of therapy for patients with mild to moderate OSA as well as for patients who are severe and have failed CPAP or who prefer them to CPAP.</p>

<p>We are working closely with physicians such as you who recognize the importance of diagnosing and treating this illness.  As awareness of the ill effects of OSA (hypertension, MI, CHF, stroke, fatigue, impotence, mood swings, and dozing accidents) increases in the public's eye, all of medicine will begin to see an increasing number of patients asking questions about snoring and sleep apnea and seeking treatment options.  We hope you'll consider referring these patients to us.</p>

<p>I have included an informational brochure as well as a simple referral form, making the referral process easy for you and the patient.</p>

<p>Again, thank you for your time, and I look forward to working with you.</p>

<p>Regards,
<br />
<br />
<br />
Dr. %franchisee_fullname%</p>";

?>
<form action="/manage/dss_intro_to_md_from_dentist.php?pid=<?php echo $patientid?>&lid=<?php echo $letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
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
		<button class="addButton" onclick="Javascript: edit_letter('letter<?php echo $key?>');return false;" >
			Edit Letter
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="duplicate_letter[<?php echo $key?>]" class="addButton" value="Duplicate" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dentist_print.php?pid=<?php echo $_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dentist_word.php?pid=<?php echo $_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
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
if($_GET['backoffice'] == '1') {
	include 'admin/includes/bottom.htm';
} else {
	include 'includes/bottom.htm';

} ?>
