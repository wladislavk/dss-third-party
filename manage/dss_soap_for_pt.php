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

$q1_sql = "select * from dental_q_page1 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);



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

if(st($pat_myarray['gender']) == 'Female')
{
	$h_h =  "her";
	$s_h =  "she";
	$h_h1 =  "her";
	$m_s = "Mrs.";
}
else
{
	$h_h =  "his";
	$s_h =  "he";
	$h_h1 =  "him";
	$m_s = "Mr.";
}
?>
<br />
<span class="admin_head">
	DSS SOAP for pt
</span>
<br />
&nbsp;&nbsp;
<a href="dss_letters.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

<?=date('F d, Y')?><br><br>

Re: 	<strong><?=$name?></strong> <br>
DOB:	<strong><?=st($pat_myarray['dob'])?></strong><br><br>


<strong><?=$name?></strong> is a <strong><?=$age;?></strong> year old <strong><?=$pat_myarray['gender']?></strong> with a prior medical history that includes <strong><?=$history_disp;?></strong>.<br /><br />

Subjective:  <strong><?=$name?></strong> presents with chief complaint(s) of (populate from chief complaints).//all info pages 1, sleep test (results),  3 and4 questionnaire<br /><br />

Objective:  <strong><?=$name?></strong> underwent <strong>sleep test <?=$type_study;?></strong> monitor on <strong><?=date('F d, Y',strtotime($sleep_study_on))?></strong> date.  <?=ucwords($s_h);?> was diagnosed with <strong><?=$confirmed_diagnosis;?> <?=$custom_diagnosis;?></strong>.  <?=ucwords($s_h);?> had an AHI/RDI of <strong>???</strong>.  On his back, his AHI was <strong><?=$ahi?></strong>; during REM sleep his AHI was <strong>???</strong>.  He had a low O2 level of <strong>???</strong>;  and he spent <strong>???</strong>% of the night below 90% O2.//all of page 3 including CPAP<br /><br />

The temporalis muscles are tender to palpation.  The teeth are in a Class I occlusion.  Range of motion is XX mm protrusive; XX mm to the Left; and XX mm to the right.  He can open XX mm.  The tongue is XX.  //all of page 4 then 5 then pages 1-3<br /><br />

Assessment:  <strong><?=$name1?></strong> was diagnosed with <strong>???</strong>.  He  intolerant of CPAP//if the box is checked.  Otherwise, he is a good candidate for dental device therapy.//all of page 6<br /><br />

Plan:  ****See My notes from DW on device placed**.Recommend XX.//all of page 7<br /><br />



		</td>
	</tr>
</table>


<? include 'includes/bottom.htm';?>