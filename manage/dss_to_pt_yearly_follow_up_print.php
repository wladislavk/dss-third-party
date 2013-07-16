<?php include "admin/includes/main_include.php";

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - DSS to pt no treatment</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); window.close();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 


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

Can you believe it was a year ago that we fabricated your <strong>???</strong> dental sleep device?  We hope that you are continuing to do well. 

Please take time to contact our office and schedule your yearly recall.  It is important that we evaluate your device for proper fit and discuss your continued treatment regimen.

As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, stroke, as well as an increased risk for falling asleep while driving.  All of which can be reversed by successful treatment!  

We look forward to seeing you soon.
<br /><br />

Sincerely,
<br><br><br><br>




<strong><?=$_SESSION['name']?>, DDS</strong><br><br>
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
