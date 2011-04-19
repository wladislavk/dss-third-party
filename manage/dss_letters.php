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

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

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
	DSS Letters
	-
    Patient <i><?=$name;?></i>
</span>
<br />
&nbsp;&nbsp;
<a href="manage_patient.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br />
<br>


<table width="98%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td valign="top">
			<a href="dss_appeal_letter_to_ins_com.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS Appeal letter to ins com</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_intro_to_md_from_dentist.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS intro to MD from dentist</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_intro_to_md_from_dss.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS intro to MD from DSS</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_progress_note_to_md_pt_non_compliant.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS progress note to MD pt non compliant</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_referral_thank_you_pt_scheduled.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS referral thank you - pt scheduled</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_referral_thank_you_pt_did_not_come_in.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS referral thank you pt did not come in</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_referral_thank_you_pt_not_candidate.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS referral thank you pt not candidate</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_referral_thank_you_pt_waiting_on.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS referral thank you pt waiting on</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_request_lomn_and_rx.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS request LOMN and Rx</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_soap_for_pt.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS SOAP for pt</b></a> -- PENDING
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_to_pt_no_treatment.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS to pt no treatment</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_to_pt_yearly_follow_up.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS to pt yearly follow up</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_fu_md_embletta_negative.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS FU MD embletta negative</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_fu_md_embletta_positive.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS FU MD embletta positive</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_fu_pt_embletta_negative.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS FU pt embletta negative</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="dss_fu_pt_embletta_positive.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>DSS FU pt embletta positive</b></a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<a href="manage_recipients.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
				<b>Recipients</b></a>
			<br /><br />
		</td>
	</tr>
</table>




<? include 'includes/bottom.htm';?>