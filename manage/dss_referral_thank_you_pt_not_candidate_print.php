<?php namespace Ds3\Legacy; ?><?php include "admin/includes/main_include.php";

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == ''){?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?php
	die();
}

$ref_sql = "select * from dental_q_recipients where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$ref_myarray = $db->getRow($ref_sql);

$referring_physician = st($ref_myarray['referring_physician']);

$a_arr = explode('
',$referring_physician);

if(st($pat_myarray['dob']) <> '' ){
	$dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
	$cur_y = date('Y');
	$age = $cur_y - $dob_y;
}else{
	$age = 'N/A';
}

$q3_sql = "select * from dental_q_page3 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$q3_myarray = $db->getRow($q3_sql);

$history = st($q3_myarray['history']);
$medications = st($q3_myarray['medications']);

$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val){
	if(trim($val) <> ""){
		$his_sql = "select * from dental_history where historyid='".trim($val)."' and status=1 ";
		$his_myarray = $db->getRow($his_sql);
		
		if(st($his_myarray['history']) <> ''){
			if($history_disp <> '')
				$history_disp .= ' and ';
			$history_disp .= st($his_myarray['history']);
		}
	}
}

$medications_arr = explode('~',$medications);
$medications_disp = '';
foreach($medications_arr as $val){
	if(trim($val) <> ""){
		$medications_sql = "select * from dental_medications where medicationsid='".trim($val)."' and status=1 ";
		$medications_myarray = $db->getRow($medications_sql);
		
		if(st($medications_myarray['medications']) <> ''){
			if($medications_disp <> '')
				$medications_disp .= ', ';
			$medications_disp .= st($medications_myarray['medications']);
		}
	}
}

$q2_sql = "select * from dental_q_page2 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$q2_myarray = $db->getRow($q2_sql);

$polysomnographic = st($q2_myarray['polysomnographic']);
$sleep_center_name = st($q2_myarray['sleep_center_name']);
$sleep_study_on = st($q2_myarray['sleep_study_on']);
$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
$rdi = st($q2_myarray['rdi']);
$ahi = st($q2_myarray['ahi']);
$type_study = st($q2_myarray['type_study']);
$custom_diagnosis = st($q2_myarray['custom_diagnosis']);

$sleeplab_sql = "select * from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."'";
$sleeplab_myarray = $db->getRow($sleeplab_sql);

$sleeplab_name = st($sleeplab_myarray['company']);

$sum_sql = "select * from dental_summary where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$sum_myarray = $db->getRow($sum_sql);

$sti_o2_1 = st($sum_myarray['sti_o2_1']);

if(st($pat_myarray['gender']) == 'Female'){
	$h_h =  "Her";
	$s_h =  "She";
	$h_h1 =  "her";
	$m_s = "Mrs.";
}else{
	$h_h =  "His";
	$s_h =  "He";
	$h_h1 =  "him";
	$m_s = "Mr.";
}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="d<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
<title>d<?php echo $sitename;?> | d<?php echo $name;?> - DSS referral thank you pt not candidate</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); window.close();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 
<br />
<span class="admin_head">
	DSS referral thank you pt not candidate
</span>
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

d<?php echo date('F d, Y')?><br><br>

<strong>
d<?php echo nl2br($referring_physician);?>
</strong><br><br>

Re: 	<strong>d<?php echo $name?></strong> <br>
DOB:	<strong>d<?php echo st($pat_myarray['dob'])?></strong><br><br>

Dear Dr. <strong>d<?php echo $a_arr[0];?></strong>,<br><br>

I write regarding our mutual Patient, <strong>d<?php echo $name;?></strong>.  As you recall, <strong>d<?php echo $name1?></strong> is a <strong>d<?php echo $age;?></strong> year old <strong>d<?php echo $pat_myarray['gender']?></strong> with a PMH that includes <strong>d<?php echo $history_disp;?></strong>.  <strong>d<?php echo $h_h;?></strong> medications include <strong>d<?php echo $medications_disp?></strong>.  <strong>d<?php echo $name1?></strong> had a <strong>sleep test d<?php echo $type_study;?></strong> done at the <strong>d<?php echo $sleeplab_name?></strong> on <strong>d<?php echo date('F d, Y',strtotime($sleep_study_on))?></strong> which showed an AHI of <strong>d<?php echo $ahi?></strong> <? if($rdi <> '') {?>, RDI of <strong>d<?php echo $rdi?></strong> <? }?> and low O2 of <strong>d<?php echo $sti_o2_1;?></strong>; <strong>d<?php echo $s_h;?></strong> was diagnosed with <strong>d<?php echo $confirmed_diagnosis;?> d<?php echo $custom_diagnosis;?></strong>.  You referred <strong>d<?php echo $h_h1;?></strong> to me for treatment with a Dental Sleep Device.<br><br>

I appreciate your confidence and the referral, but I regret to inform you that <strong>d<?php echo $name1?></strong> is not a candidate for dental device therapy.  I have counseled her to return to your office to discuss other treatment options.<br><br />

Sincerely,
<br><br><br><br>

<strong>d<?php echo $_SESSION['name']?>, DDS</strong><br><br>

CC:  <strong>d<?php echo $name?></strong>
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
