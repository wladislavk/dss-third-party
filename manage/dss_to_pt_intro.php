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

<p>%patient_fullname%<br />
%addr1%<br />
%addr2%
%city%, %state% %zip%</p>

<p>Dear %patient_firstname%:</p>

<p>Are you tired at times when you don't want to be?  Do you find it difficult to get out of bed in the morning?  Do you feel fatigued and irritable?  Is your bed partner complaining more and more about your snoring?</p>

<p>You may be suffering from Obstructive Sleep Apnea (OSA).  Repeated closure of the upper airway during sleep leads to many unwanted outcomes including the following:
<ul>
  <li>loud snoring</li>
  <li>stopped breathing episodes</li>
  <li>poor, unrefreshing sleep</li>
  <li>excessive daytime sleepiness</li>
  <li>impotence</li>
  <li>weight gain</li>
  <li>increased risks for hypertension and heart attack</li>
  <li>diabetes</li>
  <li>congestive heart failure</li>
  <li>stroke</li>
  <li>increased risk for falling asleep while driving.</li>
</ul> 

<p>The good news is that we can do something about these problems!</p>

<p>[Franchisee Practice Name] has joined with Dental Sleep Solutions&reg; to undergo specific training on how to treat snoring and sleep apnea utilizing state of the art, FDA approved dental sleep devices.</p>

<p>If you or someone you know is suffering with snoring or sleep apnea and would like more information about how we can help by using dental sleep therapy please call our office and we will be happy to schedule a complimentary consultation.  We also invite you to visit our website at www.dentalsleepsolutions.com for more information.</p>

<p>We look forward to helping you or someone you know to get a better night's sleep!</p>

<p>Sincerely,</p>
<br />
<br />

<p>Dr. %franchisee_fullname%</p>";

?>
<form action="/manage/dss_to_pt_intro.php?pid=<?=$patientid?>&lid=<?=$letterid?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post">
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
		$search[] = '%patient_fullname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . " " . $letter_contacts[$key]['firstname'] . " " . $letter_contacts[$key]['lastname'] . "</strong>";
		$search[] = '%patient_lastname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['lastname'] . "</strong>";
		$search[] = '%patient_firstname%';
		$replace[] = "<strong>" . $letter_contacts[$key]['firstname'] . "</strong>";
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
		$search[] = "%franchisee_fullname%</p>";
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


//print_r($new_template);


foreach ($letter_contacts as $key => $contact) {
	// Token search and replace arrays
	$search = array();
	$replace = array();
	$search[] = '%todays_date%';
	$replace[] = "<strong>" . $todays_date . "</strong>";
	$search[] = '%patient_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%patient_lastname%';
	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
	$search[] = '%patient_firstname%';
	$replace[] = "<strong>" . $letter_contacts[$key]['firstname'] . "</strong>";
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
