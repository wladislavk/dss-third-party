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

$sleeplab_sql = "select * from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."'";
$sleeplab_my = mysql_query($sleeplab_sql);
$sleeplab_myarray = mysql_fetch_array($sleeplab_my);

$sleeplab_name = st($sleeplab_myarray['company']);

$sum_sql = "select * from dental_summary where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$sum_my = mysql_query($sum_sql);
$sum_myarray = mysql_fetch_array($sum_my);

$sti_o2_1 = st($sum_myarray['sti_o2_1']);

if(st($pat_myarray['gender']) == 'Female')
{
	$h_h =  "Her";
	$s_h =  "She";
	$h_h1 =  "her";
}
else
{
	$h_h =  "His";
	$s_h =  "He";
	$h_h1 =  "him";
}
?>
<br />
<span class="admin_head">
	DSS progress note to MD pt non compliant
</span>
<br />
&nbsp;&nbsp;
<a href="dss_letters.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<div align="right">
	<button class="addButton" onclick="Javascript: window.open('dss_progress_note_to_md_pt_non_compliant_print.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
		Print Letter 
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<button class="addButton" onclick="Javascript: window.open('dss_progress_note_to_md_pt_non_compliant_word.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
		Word Document
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

<?=date('F d, Y')?><br><br>

<strong>
<?=nl2br($referring_physician);?>
</strong><br><br>

Re: 	<strong><?=$name?></strong> <br>
DOB:	<strong><?=st($pat_myarray['dob'])?></strong><br><br>

Dear Dr. <strong><?=$a_arr[0];?></strong>,<br><br>

I write regarding our mutual Patient, <strong><?=$name;?></strong>.  As you recall, Patient is a <strong><?=$age;?></strong> year old <strong><?=$pat_myarray['gender']?></strong> with a PMH that includes <strong><?=$history_disp;?></strong>.  <strong><?=$h_h;?></strong> medications include <strong><?=$medications_disp?></strong>.  Patient had a <strong>sleep test <?=$type_study;?></strong> done at the <strong><?=$sleeplab_name?></strong> on <strong><?=date('F d, Y',strtotime($sleep_study_on))?></strong> which showed an AHI of <strong><?=$ahi?></strong> <? if($rdi <> '') {?>, RDI of <strong><?=$rdi?></strong> <? }?> and low O2 of <strong><?=$sti_o2_1;?></strong>; <strong><?=$s_h;?></strong> was diagnosed with <strong><?=$confirmed_diagnosis;?> <?=$custom_diagnosis;?></strong>.  You referred <strong><?=$h_h1;?></strong> to me for treatment with a dental sleep device.<br><br>

We delivered a <strong>???</strong> dental device on <strong>???</strong>.  <br><br>

I regret to inform you that she has become non compliant with dental device therapy due to <strong>???</strong>.<br><br>

I am referring <?=$h_h1?> back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in Patient’s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.<br><br>

Sincerely,<br><br><br><br>




<strong><?=$_SESSION['name']?>, DDS</strong><br><br>

CC:  <strong><?=$name;?></strong>
<br><br>

		</td>
	</tr>
</table>


<? include 'includes/bottom.htm';?>