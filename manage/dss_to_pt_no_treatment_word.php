<?php 

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=dss_to_pt_no_treatment_".date('m-d-Y').".doc");
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
	$h_h =  "Her";
	$s_h =  "She";
	$h_h1 =  "her";
	$m_s = "Mrs.";
}
else
{
	$h_h =  "His";
	$s_h =  "He";
	$h_h1 =  "him";
	$m_s = "Mr.";
}
?>
<br />
<span class="admin_head">
	DSS to pt no treatment
</span>
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

<?=date('F d, Y')?><br><br>

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

Thank you for taking the time to come in and consult with us regarding your diagnosis of <strong><?=$confirmed_diagnosis;?> <?=$custom_diagnosis;?></strong>. I hope that you found it was worth your time. We work very hard to be the best we can be.<br /><br />

I understand your concern about the cost and wanting to know what insurance will cover, but in the meantime, I am concerned that you are not treating your sleep disordered breathing problem!  <br /><br />

As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, stroke, as well as an increased risk for falling asleep while driving.  All of which can be reversed by successful treatment!  <br /><br />

I look forward to working with you to help you sleep better and feel better.<br /><br />

Sincerely,
<br><br><br><br>




<strong><?=$_SESSION['name']?>, DDS</strong><br><br>

CC:  <strong><?=$a_arr[0];?></strong>
<br><br>

		</td>
	</tr>
</table>
