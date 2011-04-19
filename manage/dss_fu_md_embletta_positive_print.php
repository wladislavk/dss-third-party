<?php include "admin/includes/config.php";

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

$ref_sql = "select * from dental_q_recipients where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
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

$q3_sql = "select * from dental_q_page3 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
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

$q2_sql = "select * from dental_q_page2 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
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

$sum_sql = "select * from dental_summary where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$sum_my = mysql_query($sum_sql);
$sum_myarray = mysql_fetch_array($sum_my);

$sti_o2_1 = st($sum_myarray['sti_o2_1']);

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - DSS FU MD embletta positive</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); window.close();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 


<br />
<span class="admin_head">
	DSS FU MD embletta positive
</span>
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

			<p>
				<?=date('F d, Y')?>
				<br>
				<br>

				<strong>
				<?=nl2br($referring_physician);?>
				</strong><br>
				<br>

Re: 	<strong>
<?=$name?>
</strong> <br>
DOB:	<strong>
<?=st($pat_myarray['dob'])?>
</strong><br>
<br>

Dear Dr. <strong>
<?=$a_arr[0];?>
</strong>,<br>
<br>

We have a mutual patient, <strong>
<?=$name;?>
</strong>. <strong>
<?=$age;?>
</strong> year old <strong>
<?=$pat_myarray['gender']?>
</strong> who was diagnosed with <strong>
<?=confirmed_diagnosis;?> 
<?=custom_diagnosis;?>
</strong> after undergoing <strong>
<?=$type_study;?>
</strong> on <strong>
<?=date('F d, Y',strtotime($sleep_study_on))?>
</strong>, where he scored an AHI of <strong>
<?=$ahi?>
</strong> 
<? if($rdi <> '') {?>
and or RDI of <strong>
<?=$rdi?>
</strong> 
<? }?> 
.? <strong>???</strong>, and spent <strong><?=$sti_o2_1;?></strong> of the night below 90% O2.  <br />
<br />

We delivered <strong>???</strong> device  on <strong>???</strong>, and <strong><?=$s_h?></strong> has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study done with the state-of-the-art <strong>???</strong> sleep recorder.  <strong><?=$name1?>’s</strong> numbers, baseline and post appliance insertion, appear below.<br /><br />
			
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
		<td valign="top">
			***Other Summary Sheet info 
			<br />(break down into subjective and Objective)
		</td>
		<td colspan="2" valign="top">&nbsp;</td>
		<td colspan="2" valign="top">&nbsp;</td>
	</tr>
</table>
<br />

<strong><?=$name1?></strong> has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up.  As you can see by the numbers, <strong><?=$name1?>’s</strong> treatment with dental sleep therapy appears to be <strong>???</strong>  and at this point and I believe <strong><?=$s_h?></strong> has reached the maximum medical improvement afforded by dental sleep therapy. <strong>(How will they check???)</strong><br><br>

Please don’t hesitate to call if you have any questions.  I thank you again for the opportunity to participate in this patient’s treatment.<br><br>

Sincerely,<br><br><br><br>




<strong><?=$_SESSION['name']?>, DDS</strong><br><br>

CC:  <strong><?=$name;?></strong>
<br><br>

		</td>
	</tr>
</table>

<br /><br />	

	</td>
</tr>
</table>
</body>
</html>