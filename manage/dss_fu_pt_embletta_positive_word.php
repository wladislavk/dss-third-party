<?php 

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=dss_fu_pt_embletta_positive_".date('m-d-Y').".doc");
header("Pragma: no-cache");
header("Expires: 0");

include "admin/includes/main_include.php";

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

$ref_sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";
$ref_my = mysql_query($ref_sql);
$ref_myarray = mysql_fetch_array($ref_my);

$referring_physician = st($ref_myarray['referring_physician']);

$a_arr = explode('
',$referring_physician);

if(st($pat_myarray['dob']) <> '' )
{
	$dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
	$cur_y = date('Y');
	$age = $cur_y - $dob_y;
}
else
{
	$age = 'N/A';
}

$q3_sql = "select * from dental_q_page3 where patientid='".$_GET['pid']."'";
$q3_my = mysql_query($q3_sql);
$q3_myarray = mysql_fetch_array($q3_my);

$history = st($q3_myarray['history']);
$medications = st($q3_myarray['medications']);

$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val)
{
	if(trim($val) <> "")
	{
		$his_sql = "select * from dental_history where historyid='".trim($val)."' and status=1 ";
		$his_my = mysql_query($his_sql);
		$his_myarray = mysql_fetch_array($his_my);
		
		if(st($his_myarray['history']) <> '')
		{
			if($history_disp <> '')
				$history_disp .= ' and ';
				
			$history_disp .= st($his_myarray['history']);
		}
	}
}

$medications_arr = explode('~',$medications);
$medications_disp = '';
foreach($medications_arr as $val)
{
	if(trim($val) <> "")
	{
		$medications_sql = "select * from dental_medications where medicationsid='".trim($val)."' and status=1 ";
		$medications_my = mysql_query($medications_sql);
		$medications_myarray = mysql_fetch_array($medications_my);
		
		if(st($medications_myarray['medications']) <> '')
		{
			if($medications_disp <> '')
				$medications_disp .= ', ';
				
			$medications_disp .= st($medications_myarray['medications']);
		}
	}
}

$q2_sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);

$polysomnographic = st($q2_myarray['polysomnographic']);
$sleep_center_name = st($q2_myarray['sleep_center_name']);
$sleep_study_on = st($q2_myarray['sleep_study_on']);
$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
$rdi = st($q2_myarray['rdi']);
$ahi = st($q2_myarray['ahi']);
$type_study = st($q2_myarray['type_study']);
$custom_diagnosis = st($q2_myarray['custom_diagnosis']);


if(st($pat_myarray['gender']) == 'Female')
{
	$h_h =  "her";
	$s_h =  "she";
	$h_h1 =  "her";
	$m_m = "Mrs.";
}
else
{
	$h_h =  "his";
	$s_h =  "he";
	$h_h1 =  "him";
	$m_m = "Mr.";
}
?>
<br />
<span class="admin_head">
	DSS FU pt embletta postive
</span>
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">
<?=date('F d, Y')?>
<br><br>

<strong>
<?=$name;?>
<? if(st($pat_myarray['add1']) <> '') {?>
	<br />
	
	<?=st($pat_myarray['add1']);?>	
<? }?>

<? if(st($pat_myarray['add2']) <> '') {?>
	<br />
	
	<?=st($pat_myarray['add2']);?>	
<? }?>

&nbsp;
<?=st($pat_myarray['city']);?>	

&nbsp;
<?=st($pat_myarray['state']);?>	

&nbsp;
<?=st($pat_myarray['zip']);?>	
</strong>
<br><br>


Dear <strong><?=st($pat_myarray['firstname']);?></strong>,<br><br>

Thank you for taking the time to undergo the overnight sleep study utilizing the <strong>???</strong> sleep recorder.   I have summarized the results in the table below.  The “Before” column refers to your last sleep study, while the “After” column is with your dental sleep device in place. <br /><br />
			
<table width="98%" border="1" cellspacing="0" cellpadding="6">
	<tr>
		<td width="214" valign="top">&nbsp;</td>
		<td width="85" valign="top" align="center">Before</td>
		<td width="85" valign="top" align="center">8-22-06</td>
		<td width="93" valign="top" align="center">After</td>
		<td width="93" valign="top" align="center">12-2-06</td>
	</tr>
	<tr>
		<td valign="top">RDI / AHI</td>
		<td colspan="2" valign="top" align="center">24.7 (REM 33)</td>
		<td colspan="2" valign="top" align="center">4.3</td>
	</tr>
	<tr>
		<td valign="top">Low O2</td>
		<td colspan="2" valign="top" align="center">80%</td>
		<td colspan="2" valign="top" align="center">86%</td>
	</tr>
	<tr>
		<td valign="top">T O2 &le; 90%</td>
		<td colspan="2" valign="top">&nbsp;</td>
		<td colspan="2" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">ESS</td>
		<td colspan="2" valign="top">&nbsp;</td>
		<td colspan="2" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">Snoring</td>
		<td colspan="2" valign="top">&nbsp;</td>
		<td colspan="2" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;
			
		</td>
		<td colspan="2" valign="top">&nbsp;</td>
		<td colspan="2" valign="top">&nbsp;</td>
	</tr>
</table>
<br />


As you can see, the results of this study show that with your <strong>???</strong> device in place at the current setting, your overall AHI  has improved from <strong>???</strong> to <strong>???</strong>; your Low O2 has gone from <strong>???</strong>% to <strong>???</strong>%; your time below 90% from <strong>???</strong>% to <strong>???</strong>% your ESS from <strong>???</strong> to <strong>???</strong>.    Congratulations!  <br /><br />

I would also like to send a progress note to your physician(s) with your permission.  Remember that the treatment of OSA often requires a team healthcare approach.  Please give me a call if you have any questions.  Also, I am recommending that your primary care physician (PCP) make a determination on the need for a follow up PSG (attended sleep study) to confirm our findings.  Please proceed with their recommendations in this regard.   <br /><br />

At this point, unless you have any other concerns, we are finished with your Dental Sleep Therapy.  We would like to see you on an annual basis for continued evaluation of treatment.  Of course we are happy to see you prior to then if you have any problems or concerns. Thank you again for the opportunity to work with you.  Please don’t hesitate to call if you have any questions.  <br /><br />

Sincerely,<br><br><br><br>




<strong><?=$_SESSION['name']?>, DDS</strong><br><br>

CC:  <strong><?=$name;?></strong>
<br><br>

		</td>
	</tr>
</table>
