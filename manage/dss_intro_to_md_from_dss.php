<?php include 'includes/top.htm';

$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
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
}


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

<div align="right">
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

<strong><?=date('F d, Y')?></strong><br><br><br>


<strong>???</strong><br><br>

Dear Dr. ??:<br><br>

Thank you for allowing us a few moments of your time.  We represent Dental Sleep Solutions, LLC, a franchise entity that recruits, trains, and helps administrate dentists in the area of dental sleep medicine.<br><br>

Our dentists receive training from Board Certified dentists in the areas of sleep, sleep disorders in general, sleep and breathing disorders in particular, treatment options for SDB patients to include PAP therapy, dental device therapy, hybrid PAP/device therapy, as well as surgical options.<br><br>

We promote an overall healthcare team approach that involves the physician and dentist working closely to provide a successful treatment modality for each and every patient.  Dental Sleep Therapy is managed by utilizing portable sleep monitors during the titration phase of treatment.  Research has found this treatment approach to be nearly as effective as CPAP even in severe sleep apneics.  <br><br>

Rest assured that when you are dealing with a Dental Sleep Solutions dentist, you are dealing with an individual who understands the disease and its treatment options.  <br><br>

We look forward to a long and prosperous relationship and thank you for your referrals in advance.<br><br>

Regards,<br><br><br>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="50%">
			Richard B. Drake, DDS<br>
			Diplomate, ABDSM
		</td>
		<td valign="top" width="50%">
			Gy Yatros, DMD<br>
			Diplomate, ABDSM
		</td>
	</tr>
</table>
<br><br>

		</td>
	</tr>
</table>


<? include 'includes/bottom.htm';?>