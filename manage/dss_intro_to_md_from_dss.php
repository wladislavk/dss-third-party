<?php include 'includes/top.htm';

?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/edit_letter.js"></script>
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
?>


<br />
<span class="admin_head">
	DSS intro to MD from DSS
</span>
<br />
&nbsp;&nbsp;
<a href="dss_letters.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<?php
//print_r ($_POST);

$letter_query = "SELECT patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$_GET['lid'].";";
$letter_result = mysql_query($letter_query);
while ($row = mysql_fetch_assoc($letter_result)) {
  $patientid = $row['patientid'];
  $topatient = $row['topatient'];
  $md_list = $row['md_list'];
  $md_referral_list = $row['md_referral_list'];
  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
}

if ($topatient) {
  $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
} else {
  $contact_info = get_contact_info('', $md_list, $md_referral_list);
}

$todays_date = date('F d, Y');
?>
<form action="/manage/dss_intro_to_md_from_dss.php?pid=<?=$patientid?>&lid=<?=$_GET['lid']?>" method="post">
<?php
if (isset($_POST['duplicate_letter']) && !$duplicated) {
  foreach ($_POST['duplicate_letter'] as $key => $value) {
    $search = array();
    $replace = array();
    $search[] = '%todays_date%';
    $replace[] = "<strong>" . $todays_date . "</strong>";
    $search[] = '%md_fullname%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['salutation'] . " " . $contact_info['mds'][$key]['firstname'] . " " . $contact_info['mds'][$key]['lastname'] . "</strong>";
    $search[] = '%md_lastname%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['lastname'] . "</strong>";
    $search[] = '%addr1%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['add1'] . "</strong>";
    $search[] = '%addr2%';
    $replace[] = ($contact_info['mds'][$key]['add2']) ? "<strong>" . $contact_info['mds'][$key]['add2'] . "</strong><br />" : "";
    $search[] = '%city%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['city'] . "</strong>";
    $search[] = '%state%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['state'] . "</strong>";
    $search[] = '%zip%';
    $replace[] = "<strong>" . $contact_info['mds'][$key]['zip'] . "</strong>";
    $dupe_template = str_replace($replace, $search, $_POST['letter_mds'.$key]);
    $duplicated = true;
  }
}
foreach ($contact_info['mds'] as $key => $contact) {
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
	$replace[] = ($contact['add2']) ? "<strong>" . $contact['add2'] . "</strong><br />" : "";
        $search[] = '%city%';
	$replace[] = "<strong>" . $contact['city'] . "</strong>";
        $search[] = '%state%';
	$replace[] = "<strong>" . $contact['state'] . "</strong>";
        $search[] = '%zip%';
	$replace[] = "<strong>" . $contact['zip'] . "</strong>";

	$template = "%todays_date%
	<p>
	%md_fullname%<br />
	%practice%<br />
	%addr1%<br />
	%addr2%
	%city%, %state% %zip%<br />
	</p>
	<p>
	Dear Dr. %md_lastname%:
	</p>
	<p>
	Thank you for allowing us a few moments of your time.  We represent Dental Sleep Solutions Franchising, LLC, a franchise entity that recruits, trains, and provides administrative support to dentists in the area of dental sleep medicine.
	</p>
	<p>
	Our dentists receive training from Board Certified dentists in the areas of:<br /><ul>
	<li>Sleep medicine and sleep disorders</li>
	<li>Sleep Disordered Breathing (SDB)</li>
	<li>Treatment options for SDB</li>
	<ul>
	<li>Including CPAP, dental device therapy, surgery, and behavioral solutions</li>
	<li>Unique hybrid therapies that include mating CPAP to a dental device</li>
	</ul>
	</ul>
	</p>
	<p>
	We are writing to you today to invite you to partner with us in diagnosing and treating patients with sleep disordered breathing.  We promote a team healthcare approach that involves the physician and dentist working closely to provide a successful treatment modality for each and every patient.  If you feel that your patients could benefit from a sleep screening consultation, we invite you to contact us directly so that we can put you in touch with a local Dental Sleep Solutions&reg; provider.  Rest assured that when you are dealing with a Dental Sleep Solutions&reg; dentist, you are dealing with an individual who understands the issues and the treatment options.  
	</p>
	<p>
	Enclosed is a Dental Sleep Solutions&reg; brochure.  Please don't hesitate to call if you have any questions.
	We look forward to a long and prosperous relationship and thank you for your referrals in advance.
	</p>
	<p>
	Regards,
	<br />
	<br />
	<br />
	<table width=\"100%\">
	<tr>
	<td width=\"60%\">
	Richard B. Drake, DDS
	</td>
	<td width=\"40%\">
	George \"Gy\" Yatros, DMD
	</td>
	</tr>
	</table>
	</p>";
	
 	if (isset($dupe_template)) {
	  $letter[] = str_replace($search, $replace, $dupe_template);
	} else {
	  $letter[] = str_replace($search, $replace, $template);
 	}

	?>
	<?php // loop through letters ?>
	<div align="right">
		<button class="addButton" onclick="Javascript: edit_letter('letter_mds<?=$key?>');return false;" >
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
	</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<div id="letter_mds<?=$key?>">
				<?php print $letter[$key]; ?>
				</div>
			</td>
		</tr>
	</table>
	<div align="right">
		<button class="addButton">
			Reset
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton">
			Delete
		</button>
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


<? include 'includes/bottom.htm';?>
