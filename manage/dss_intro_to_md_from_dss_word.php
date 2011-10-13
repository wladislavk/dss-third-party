<?php 

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=dss_intro_to_md_from_dss_".date('m-d-Y').".doc");
header("Pragma: no-cache");
header("Expires: 0");

include "admin/includes/config.php";

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
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
