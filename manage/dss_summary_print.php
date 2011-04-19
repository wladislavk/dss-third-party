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

$q1_sql = "select * from dental_q_page1 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);

$main_reason = st($q1_myarray['main_reason']);
$complaintid = st($q1_myarray['complaintid']);
$bed_time_partner1 = st($q1_myarray['bed_time_partner']);
$sleep_same_room1 = st($q1_myarray['sleep_same_room']);

$q2_sql = "select * from dental_q_page2 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);

$cpap = st($q2_myarray['cpap']);
$nights_wear_cpap = st($q2_myarray['nights_wear_cpap']);
$percent_night_cpap = st($q2_myarray['percent_night_cpap']);


$sql = "select * from dental_summary where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$summaryid = st($myarray['summaryid']);
$patient_name = st($myarray['patient_name']);
$patient_dob = st($myarray['patient_dob']);
$referral_source = st($myarray['referral_source']);
$reason_seeking_tx = st($myarray['reason_seeking_tx']);
$symptoms_osa = st($myarray['symptoms_osa']);
$bed_time_partner = st($myarray['bed_time_partner']);
$snoring = st($myarray['snoring']);
$apnea = st($myarray['apnea']);
$history_surgery = st($myarray['history_surgery']);
$tried_cpap = st($myarray['tried_cpap']);
$cpap_date = st($myarray['cpap_date']);
$problem_cpap = st($myarray['problem_cpap']);
$wearing_cpap = st($myarray['wearing_cpap']);
$max_translation_from = st($myarray['max_translation_from']);
$max_translation_to = st($myarray['max_translation_to']);
$max_translation_equal = st($myarray['max_translation_equal']);
$initial_device_titration_1 = st($myarray['initial_device_titration_1']);
$initial_device_titration_equal = st($myarray['initial_device_titration_equal']);
$optimum_echovision_ver = st($myarray['optimum_echovision_ver']);
$optimum_echovision_hor = st($myarray['optimum_echovision_hor']);
$type_device = st($myarray['type_device']);
$personal = st($myarray['personal']);
$lab_name = st($myarray['lab_name']);
$sti_test_1 = st($myarray['sti_test_1']);
$sti_test_2 = st($myarray['sti_test_2']);
$sti_test_3 = st($myarray['sti_test_3']);
$sti_test_4 = st($myarray['sti_test_4']);
$sti_date_1 = st($myarray['sti_date_1']);
$sti_date_2 = st($myarray['sti_date_2']);
$sti_date_3 = st($myarray['sti_date_3']);
$sti_date_4 = st($myarray['sti_date_4']);
$sti_ahi_1 = st($myarray['sti_ahi_1']);
$sti_ahi_2 = st($myarray['sti_ahi_2']);
$sti_ahi_3 = st($myarray['sti_ahi_3']);
$sti_ahi_4 = st($myarray['sti_ahi_4']);
$sti_rdi_1 = st($myarray['sti_rdi_1']);
$sti_rdi_2 = st($myarray['sti_rdi_2']);
$sti_rdi_3 = st($myarray['sti_rdi_3']);
$sti_rdi_4 = st($myarray['sti_rdi_4']);
$sti_supine_ahi_1 = st($myarray['sti_supine_ahi_1']);
$sti_supine_ahi_2 = st($myarray['sti_supine_ahi_2']);
$sti_supine_ahi_3 = st($myarray['sti_supine_ahi_3']);
$sti_supine_ahi_4 = st($myarray['sti_supine_ahi_4']);
$sti_supine_rdi_1 = st($myarray['sti_supine_rdi_1']);
$sti_supine_rdi_2 = st($myarray['sti_supine_rdi_2']);
$sti_supine_rdi_3 = st($myarray['sti_supine_rdi_3']);
$sti_supine_rdi_4 = st($myarray['sti_supine_rdi_4']);
$sti_lsat_1 = st($myarray['sti_lsat_1']);
$sti_lsat_2 = st($myarray['sti_lsat_2']);
$sti_lsat_3 = st($myarray['sti_lsat_3']);
$sti_lsat_4 = st($myarray['sti_lsat_4']);
$sti_titration_1 = st($myarray['sti_titration_1']);
$sti_titration_2 = st($myarray['sti_titration_2']);
$sti_titration_3 = st($myarray['sti_titration_3']);
$sti_titration_4 = st($myarray['sti_titration_4']);
$sti_cpap_p_1 = st($myarray['sti_cpap_p_1']);
$sti_cpap_p_2 = st($myarray['sti_cpap_p_2']);
$sti_cpap_p_3 = st($myarray['sti_cpap_p_3']);
$sti_cpap_p_4 = st($myarray['sti_cpap_p_4']);
$sti_apnea_1 = st($myarray['sti_apnea_1']);
$sti_apnea_2 = st($myarray['sti_apnea_2']);
$sti_apnea_3 = st($myarray['sti_apnea_3']);
$sti_apnea_4 = st($myarray['sti_apnea_4']);
$ep_date_1 = st($myarray['ep_date_1']);
$ep_date_2 = st($myarray['ep_date_2']);
$ep_date_3 = st($myarray['ep_date_3']);
$ep_date_4 = st($myarray['ep_date_4']);
$ep_date_5 = st($myarray['ep_date_5']);
$ep_e_1 = st($myarray['ep_e_1']);
$ep_e_2 = st($myarray['ep_e_2']);
$ep_e_3 = st($myarray['ep_e_3']);
$ep_e_4 = st($myarray['ep_e_4']);
$ep_e_5 = st($myarray['ep_e_5']);
$ep_s_1 = st($myarray['ep_s_1']);
$ep_s_2 = st($myarray['ep_s_2']);
$ep_s_3 = st($myarray['ep_s_3']);
$ep_s_4 = st($myarray['ep_s_4']);
$ep_s_5 = st($myarray['ep_s_5']);
$ep_w_1 = st($myarray['ep_w_1']);
$ep_w_2 = st($myarray['ep_w_2']);
$ep_w_3 = st($myarray['ep_w_3']);
$ep_w_4 = st($myarray['ep_w_4']);
$ep_w_5 = st($myarray['ep_w_5']);
$ep_a_1 = st($myarray['ep_a_1']);
$ep_a_2 = st($myarray['ep_a_2']);
$ep_a_3 = st($myarray['ep_a_3']);
$ep_a_4 = st($myarray['ep_a_4']);
$ep_a_5 = st($myarray['ep_a_5']);
$ep_el_1 = st($myarray['ep_el_1']);
$ep_el_2 = st($myarray['ep_el_2']);
$ep_el_3 = st($myarray['ep_el_3']);
$ep_el_4 = st($myarray['ep_el_4']);
$ep_el_5 = st($myarray['ep_el_5']);
$ep_h_1 = st($myarray['ep_h_1']);
$ep_h_2 = st($myarray['ep_h_2']);
$ep_h_3 = st($myarray['ep_h_3']);
$ep_h_4 = st($myarray['ep_h_4']);
$ep_h_5 = st($myarray['ep_h_5']);
$ep_r_1 = st($myarray['ep_r_1']);
$ep_r_2 = st($myarray['ep_r_2']);
$ep_r_3 = st($myarray['ep_r_3']);
$ep_r_4 = st($myarray['ep_r_4']);
$ep_r_5 = st($myarray['ep_r_5']);
$mini_consult = st($myarray['mini_consult']);
$exam_impressions = st($myarray['exam_impressions']);
$oa_soap = st($myarray['oa_soap']);
$fm_blue = st($myarray['fm_blue']);
$oa_check_1 = st($myarray['oa_check_1']);
$oa_check_2 = st($myarray['oa_check_2']);
$oa_check_3 = st($myarray['oa_check_3']);
$oa_check_4 = st($myarray['oa_check_4']);
$oa_check_5 = st($myarray['oa_check_5']);
$oa_check_6 = st($myarray['oa_check_6']);
$month_check_1 = st($myarray['month_check_1']);
$month_check_2 = st($myarray['month_check_2']);
$month_check_3 = st($myarray['month_check_3']);
$month_check_4 = st($myarray['month_check_4']);
$oa_psg = st($myarray['oa_psg']);
$year_check_1 = st($myarray['year_check_1']);
$year_check_2 = st($myarray['year_check_2']);
$year_check_3 = st($myarray['year_check_3']);
$year_check_4 = st($myarray['year_check_4']);
$additional_notes = st($myarray['additional_notes']);
$office = st($myarray['office']);
$sleep_same_room = st($myarray['sleep_same_room']);
$currently_wearing = st($myarray['currently_wearing']);
$what_percentage = st($myarray['what_percentage']);
$how_long = st($myarray['how_long']);
$sleep_md = st($myarray['sleep_md']);
$test_type_name = st($myarray['test_type_name']);
$sti_sleep_efficiency_1 = st($myarray['sti_sleep_efficiency_1']);
$sti_sleep_efficiency_2 = st($myarray['sti_sleep_efficiency_2']);
$sti_sleep_efficiency_3 = st($myarray['sti_sleep_efficiency_3']);
$sti_sleep_efficiency_4 = st($myarray['sti_sleep_efficiency_4']);
$sti_rem_ahi_1 = st($myarray['sti_rem_ahi_1']);
$sti_rem_ahi_2 = st($myarray['sti_rem_ahi_2']);
$sti_rem_ahi_3 = st($myarray['sti_rem_ahi_3']);
$sti_rem_ahi_4 = st($myarray['sti_rem_ahi_4']);
$sti_o2_1 = st($myarray['sti_o2_1']);
$sti_o2_2 = st($myarray['sti_o2_2']);
$sti_o2_3 = st($myarray['sti_o2_3']);
$sti_o2_4 = st($myarray['sti_o2_4']);
$sti_other_1 = st($myarray['sti_other_1']);
$sti_other_2 = st($myarray['sti_other_2']);
$sti_other_3 = st($myarray['sti_other_3']);
$sti_other_4 = st($myarray['sti_other_3']);
$ep_ts_1 = st($myarray['ep_ts_1']);
$ep_ts_2 = st($myarray['ep_ts_2']);
$ep_ts_3 = st($myarray['ep_ts_3']);
$ep_ts_4 = st($myarray['ep_ts_4']);
$ep_ts_5 = st($myarray['ep_ts_5']);
$ep_tr_1 = st($myarray['ep_tr_1']);
$ep_tr_2 = st($myarray['ep_tr_2']);
$ep_tr_3 = st($myarray['ep_tr_3']);
$ep_tr_4 = st($myarray['ep_tr_4']);
$ep_tr_5 = st($myarray['ep_tr_5']);


if($patient_name == '' )
{
	$patient_name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
}

if($patient_dob == "")
{
	$patient_dob = st($pat_myarray['dob']);
}

if($referral_source == "")
{
	$referral_source = st($pat_myarray['referred_source']);
}

if($reason_seeking_tx == "")
{
	$main_arr = explode('~',$main_reason);
	
	if(count($main_arr) <> 0)
	{
		foreach($main_arr as $m_val)
		{
			if(trim($m_val) <> '')
			{
$main_disp .= $m_val."
";
			}
		}
	}
	$reason_seeking_tx = $main_disp;
	
	if($complaintid <> '')
	{
		if($reason_seeking_tx != "")
		{
			$reason_seeking_tx .= "
Chief Complaints:
";
			//$reason_seeking_tx .= $complaintid;
			
			//echo $complaintid."<br>"	;
			
			$chief_arr = explode('~',$complaintid);
			
			if(count($chief_arr) <> 0)
			{
				$c_count = 0;
				foreach($chief_arr as $c_val)
				{
					if(trim($c_val) <> '')
					{
						$c_s = explode('|',$c_val);
						
						$c_id[$c_count] = $c_s[0];
						$c_seq[$c_count] = $c_s[1];
						
						$c_count++;
					}
				}
			}
			
			asort($c_seq );
			foreach($c_seq as $i=>$val)
			{
				//echo $c_id[$i]."<br>";
				$comp_sql = "select * from dental_complaint where status=1 and complaintid='".$c_id[$i]."'";
				$comp_my = mysql_query($comp_sql);
				$comp_myarray = mysql_fetch_array($comp_my);
				
				//echo $c_id[$i]." => ".st($comp_myarray['complaint'])."<br>";
				
				$reason_seeking_tx .= st($comp_myarray['complaint'])."\n";
			}
			
		}
	}
}

if($bed_time_partner == "")
{
	$bed_time_partner = $bed_time_partner1;
}

if($sleep_same_room == "")
{
	$sleep_same_room = $sleep_same_room1;
}

if($tried_cpap == "")
{
	$tried_cpap = $cpap;
}

if($currently_wearing == "")
{
	$currently_wearing = $nights_wear_cpap;
}

if($what_percentage == "")
{
	$what_percentage = $percent_night_cpap;
}

$rec_sql = "select * from dental_q_recipients where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$rec_my = mysql_query($rec_sql);
$rec_myarray = mysql_fetch_array($rec_my);

$patient_photo = st($rec_myarray['q_file7']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - Ledger Card</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); //window.close();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 
	
<span class="admin_head">
	DSS SUMMARY SHEET
</span>
<br /><br>

<form name="summaryfrm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post" >
<input type="hidden" name="summarysub" value="1" />
<input type="hidden" name="ed" value="<?=$summaryid;?>" />

<table width="98%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">
			<? if($patient_photo <> '') {?>
				<div align="right">
					<img src="q_file/<?=$patient_photo?>" width="150" border="0" />
					&nbsp;&nbsp;&nbsp;
					<br />&nbsp;
				</div>
			<? }?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td valign="top" width="50%">
						<strong>Patient Name:</strong>
						&nbsp;&nbsp;
						<input type="text" name="patient_name" value="<?=$patient_name;?>" class="tbox" style="width:250px;" />
					</td>
					
					<td valign="top" width="20%">
						<strong>D.O.B.</strong>
						&nbsp;&nbsp;
						<input type="text" name="patient_dob" value="<?=$patient_dob;?>" class="tbox" style="width:100px;" />
					</td>
					
					<td valign="top" width="30%">
						&nbsp;&nbsp;
						<strong>Office</strong>
						&nbsp;&nbsp;
						<input type="text" name="office" value="<?=$office;?>" class="tbox" style="width:150px;" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Referral Source:</strong>
			&nbsp;&nbsp;
			<input type="text" name="referral_source" value="<?=$referral_source;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Reason for seeking Tx:</strong>
			<br />
			<textarea name="reason_seeking_tx" class="tbox" style="width:700px; height:250px;"><?=$reason_seeking_tx;?></textarea>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Symptoms of OSA:</strong>
			&nbsp;&nbsp;
			<input type="text" name="symptoms_osa" value="<?=$symptoms_osa;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Bed Time Partner:</strong>
			&nbsp;&nbsp;
			<input type="radio" name="bed_time_partner" value="Yes" <? if($bed_time_partner == 'Yes') echo " checked";?> />
			Yes
			
			&nbsp;&nbsp;
			<input type="radio" name="bed_time_partner" value="No" <? if($bed_time_partner == 'No') echo " checked";?> />
			No
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>Snoring:</strong>
			&nbsp;&nbsp;
			<input type="text" name="snoring" value="<?=$snoring;?>" class="tbox" style="width:100px;" />
			<!--<input type="radio" name="snoring" value="Yes" <? if($snoring == 'Yes') echo " checked";?> />
			Yes
			
			&nbsp;&nbsp;
			<input type="radio" name="snoring" value="No" <? if($snoring == 'No') echo " checked";?> />
			No -->
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>Apnea:</strong>
			&nbsp;&nbsp;
			<input type="text" name="apnea" value="<?=$apnea;?>" class="tbox" style="width:100px;" />
			<!--<input type="radio" name="apnea" value="Yes" <? if($apnea == 'Yes') echo " checked";?> />
			Yes
			
			&nbsp;&nbsp;
			<input type="radio" name="apnea" value="No" <? if($apnea == 'No') echo " checked";?> />
			No -->
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br />
			<strong>Sleep in Same room?</strong>
			&nbsp;&nbsp;
			<input type="radio" name="sleep_same_room" value="Yes" <? if($sleep_same_room == 'Yes') echo " checked";?> />
			Yes
			
			&nbsp;&nbsp;
			<input type="radio" name="sleep_same_room" value="No" <? if($sleep_same_room == 'No') echo " checked";?> />
			No
			
			&nbsp;&nbsp;
			<input type="radio" name="sleep_same_room" value="Sometimes" <? if($sleep_same_room == 'Sometimes') echo " checked";?> />
			Sometimes
		</td> 
	</tr>
	
	<tr>
		<td valign="top">
			<strong>History of Surgery:</strong>
			<br />
			<textarea name="history_surgery" class="tbox" style="width:700px; height:50px;"><?=$history_surgery;?></textarea>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Tried C-PAP</strong>
			&nbsp;&nbsp;
			<input type="radio" name="tried_cpap" value="Yes" <? if($tried_cpap == 'Yes') echo " checked";?> />
			Yes
			
			&nbsp;&nbsp;
			<input type="radio" name="tried_cpap" value="No" <? if($tried_cpap == 'No') echo " checked";?> />
			No
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>Date</strong>
			&nbsp;&nbsp;
			<input type="text" name="cpap_date" value="<?=$cpap_date;?>" class="tbox" style="width:80px;" />
			
			<!--&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>Problems Associated w/CPAP:</strong>
			&nbsp;&nbsp;
			<input type="text" name="problem_cpap" value="<?=$problem_cpap;?>" class="tbox"  style="width:200px;" /> -->
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>Currently Wearing</strong>
			&nbsp;&nbsp;
			<input type="text" name="currently_wearing" value="<?=$currently_wearing;?>" class="tbox" style="width:200px;" />, 
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<strong>What Percentage</strong>
			&nbsp;&nbsp;
			<input type="text" name="what_percentage" value="<?=$what_percentage;?>" class="tbox" style="width:200px;"  />
			
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Not Currently Wearing - How long not been wearing?</strong>
			&nbsp;&nbsp;
			<input type="text" name="how_long" value="<?=$how_long;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Problems Associated w/CPAP:</strong>
			<br />
			<textarea name="problem_cpap" class="tbox" style="width:700px; height:50px;"><?=$problem_cpap;?></textarea>
		</td>
	</tr>
	
	<!--<tr>
		<td valign="top">
			<strong>How much was the patient wearing CPAP:</strong>
			&nbsp;&nbsp;
			<input type="text" name="wearing_cpap" value="<?=$wearing_cpap;?>" class="tbox" />
		</td>
	</tr> -->
	
	<tr>
		<td valign="top">
			<strong>Sleep MD:</strong>
			<br />
			<textarea name="sleep_md" class="tbox" style="width:700px; height:50px;"><?=$sleep_md;?></textarea>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Personal:</strong>
			<br />
			<textarea name="personal" class="tbox" style="width:700px; height:50px;"><?=$personal;?></textarea>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Max Translation:</strong>
			&nbsp;&nbsp;
			<input type="text" name="max_translation_from" value="<?=$max_translation_from;?>" class="tbox" style="width:100px;" />
			&nbsp;
			to
			&nbsp;
			<input type="text" name="max_translation_to" value="<?=$max_translation_to;?>" class="tbox" style="width:100px;" />
			&nbsp;
			=
			&nbsp;
			<input type="text" name="max_translation_equal" value="<?=$max_translation_equal;?>" class="tbox" style="width:100px;" />
			mm
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Initial Device Titration:</strong>
			&nbsp;&nbsp;
			<input type="text" name="initial_device_titration_1" value="<?=$initial_device_titration_1;?>" class="tbox" style="width:100px;" />
			mm
			
			&nbsp;
			=
			&nbsp;
			<input type="text" name="initial_device_titration_equal" value="<?=$initial_device_titration_equal;?>" class="tbox" style="width:100px;" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Optimum Ecovision:</strong>
			&nbsp;&nbsp;
			<input type="text" name="optimum_echovision_ver" value="<?=$optimum_echovision_ver;?>" class="tbox" style="width:100px;" />
			vertical
			
			&nbsp;
			=
			&nbsp;
			<input type="text" name="optimum_echovision_hor" value="<?=$optimum_echovision_hor;?>" class="tbox" style="width:100px;" />
			horizontal
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Type of Device:</strong>
			&nbsp;&nbsp;
			<input type="text" name="type_device" value="<?=$type_device;?>" class="tbox" />
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<!--<strong>Personal:</strong>
			&nbsp;&nbsp;
			<input type="text" name="personal" value="<?=$personal;?>" class="tbox" /> -->
			<br />&nbsp;
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Sleep Test Information </strong>
			&nbsp;&nbsp;&nbsp;
			Test Type/name:
			<input type="text" name="test_type_name" value="<?=$test_type_name;?>" class="tbox" />
			<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>LAB NAME:</strong>
			&nbsp;&nbsp;
			<input type="text" name="lab_name" value="<?=$lab_name;?>" class="tbox" /> -->
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="3" cellspacing="1" border="0">
				<tr>
					<td valign="top" width="20%">
						Test
					</td>
					<td valign="top">
						<input type="text" name="sti_test_1" value="<?=$sti_test_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_test_2" value="<?=$sti_test_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_test_3" value="<?=$sti_test_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_test_4" value="<?=$sti_test_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Date
					</td>
					<td valign="top">
						<input type="text" name="sti_date_1" value="<?=$sti_date_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_date_2" value="<?=$sti_date_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_date_3" value="<?=$sti_date_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_date_4" value="<?=$sti_date_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Sleep efficiency
					</td>
					<td valign="top">
						<input type="text" name="sti_sleep_efficiency_1" value="<?=$sti_sleep_efficiency_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_sleep_efficiency_2" value="<?=$sti_sleep_efficiency_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_sleep_efficiency_3" value="<?=$sti_sleep_efficiency_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_sleep_efficiency_4" value="<?=$sti_sleep_efficiency_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						AHI
					</td>
					<td valign="top">
						<input type="text" name="sti_ahi_1" value="<?=$sti_ahi_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_ahi_2" value="<?=$sti_ahi_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_ahi_3" value="<?=$sti_ahi_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_ahi_4" value="<?=$sti_ahi_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						RDI
					</td>
					<td valign="top">
						<input type="text" name="sti_rdi_1" value="<?=$sti_rdi_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rdi_2" value="<?=$sti_rdi_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rdi_3" value="<?=$sti_rdi_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rdi_4" value="<?=$sti_rdi_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Supine AHI
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_ahi_1" value="<?=$sti_supine_ahi_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_ahi_2" value="<?=$sti_supine_ahi_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_ahi_3" value="<?=$sti_supine_ahi_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_ahi_4" value="<?=$sti_supine_ahi_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Supine RDI
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_rdi_1" value="<?=$sti_supine_rdi_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_rdi_2" value="<?=$sti_supine_rdi_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_rdi_3" value="<?=$sti_supine_rdi_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_supine_rdi_4" value="<?=$sti_supine_rdi_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						REM AHI
					</td>
					<td valign="top">
						<input type="text" name="sti_rem_ahi_1" value="<?=$sti_rem_ahi_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rem_ahi_2" value="<?=$sti_rem_ahi_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rem_ahi_3" value="<?=$sti_rem_ahi_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_rem_ahi_4" value="<?=$sti_rem_ahi_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						LSAT
					</td>
					<td valign="top">
						<input type="text" name="sti_lsat_1" value="<?=$sti_lsat_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_lsat_2" value="<?=$sti_lsat_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_lsat_3" value="<?=$sti_lsat_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_lsat_4" value="<?=$sti_lsat_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						% O2 Below 90%
					</td>
					<td valign="top">
						<input type="text" name="sti_o2_1" value="<?=$sti_o2_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_o2_2" value="<?=$sti_o2_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_o2_3" value="<?=$sti_o2_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_o2_4" value="<?=$sti_o2_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Titration
					</td>
					<td valign="top">
						<input type="text" name="sti_titration_1" value="<?=$sti_titration_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_titration_2" value="<?=$sti_titration_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_titration_3" value="<?=$sti_titration_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_titration_4" value="<?=$sti_titration_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Other
					</td>
					<td valign="top">
						<input type="text" name="sti_other_1" value="<?=$sti_other_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_other_2" value="<?=$sti_other_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_other_3" value="<?=$sti_other_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_other_4" value="<?=$sti_other_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top">
						CPAP Pressure Level
					</td>
					<td valign="top">
						<input type="text" name="sti_cpap_p_1" value="<?=$sti_cpap_p_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_cpap_p_2" value="<?=$sti_cpap_p_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_cpap_p_3" value="<?=$sti_cpap_p_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_cpap_p_4" value="<?=$sti_cpap_p_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						Apnea Diagnosis
					</td>
					<td valign="top">
						<input type="text" name="sti_apnea_1" value="<?=$sti_apnea_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_apnea_2" value="<?=$sti_apnea_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_apnea_3" value="<?=$sti_apnea_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top">
						<input type="text" name="sti_apnea_4" value="<?=$sti_apnea_4;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="3" cellspacing="1" border="0" align="left">
				<tr>
					<td valign="top" width="28%" align="right">
						DATE
						&nbsp;
						<input type="text" name="ep_date_1" value="<?=$ep_date_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" width="18%" align="right">
						<input type="text" name="ep_date_2" value="<?=$ep_date_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" width="18%" align="right">
						<input type="text" name="ep_date_3" value="<?=$ep_date_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" width="18%" align="right">
						<input type="text" name="ep_date_4" value="<?=$ep_date_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" width="18%" align="right">
						<input type="text" name="ep_date_5" value="<?=$ep_date_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>Ess</strong>
						&nbsp;
						<input type="text" name="ep_e_1" value="<?=$ep_e_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>E</strong>
						&nbsp;
						<input type="text" name="ep_e_2" value="<?=$ep_e_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>E</strong>
						&nbsp;
						<input type="text" name="ep_e_3" value="<?=$ep_e_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>E</strong>
						&nbsp;
						<input type="text" name="ep_e_4" value="<?=$ep_e_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>E</strong>
						&nbsp;
						<input type="text" name="ep_e_5" value="<?=$ep_e_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>S</strong>
						&nbsp;
						<input type="text" name="ep_s_1" value="<?=$ep_s_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>S</strong>
						&nbsp;
						<input type="text" name="ep_s_2" value="<?=$ep_s_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>S</strong>
						&nbsp;
						<input type="text" name="ep_s_3" value="<?=$ep_s_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>S</strong>
						&nbsp;
						<input type="text" name="ep_s_4" value="<?=$ep_s_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>S</strong>
						&nbsp;
						<input type="text" name="ep_s_5" value="<?=$ep_s_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>TS</strong>
						&nbsp;
						<input type="text" name="ep_ts_1" value="<?=$ep_ts_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TS</strong>
						&nbsp;
						<input type="text" name="ep_ts_2" value="<?=$ep_ts_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TS</strong>
						&nbsp;
						<input type="text" name="ep_ts_3" value="<?=$ep_ts_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TS</strong>
						&nbsp;
						<input type="text" name="ep_ts_4" value="<?=$ep_ts_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TS</strong>
						&nbsp;
						<input type="text" name="ep_ts_5" value="<?=$ep_ts_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>W</strong>
						&nbsp;
						<input type="text" name="ep_w_1" value="<?=$ep_w_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>W</strong>
						&nbsp;
						<input type="text" name="ep_w_2" value="<?=$ep_w_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>W</strong>
						&nbsp;
						<input type="text" name="ep_w_3" value="<?=$ep_w_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>W</strong>
						&nbsp;
						<input type="text" name="ep_w_4" value="<?=$ep_w_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>W</strong>
						&nbsp;
						<input type="text" name="ep_w_5" value="<?=$ep_w_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>A</strong>
						&nbsp;
						<input type="text" name="ep_a_1" value="<?=$ep_a_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>A</strong>
						&nbsp;
						<input type="text" name="ep_a_2" value="<?=$ep_a_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>A</strong>
						&nbsp;
						<input type="text" name="ep_a_3" value="<?=$ep_a_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>A</strong>
						&nbsp;
						<input type="text" name="ep_a_4" value="<?=$ep_a_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>A</strong>
						&nbsp;
						<input type="text" name="ep_a_5" value="<?=$ep_a_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>EL</strong>
						&nbsp;
						<input type="text" name="ep_el_1" value="<?=$ep_el_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>EL</strong>
						&nbsp;
						<input type="text" name="ep_el_2" value="<?=$ep_el_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>EL</strong>
						&nbsp;
						<input type="text" name="ep_el_3" value="<?=$ep_el_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>EL</strong>
						&nbsp;
						<input type="text" name="ep_el_4" value="<?=$ep_el_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>EL</strong>
						&nbsp;
						<input type="text" name="ep_el_5" value="<?=$ep_el_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>H</strong>
						&nbsp;
						<input type="text" name="ep_h_1" value="<?=$ep_h_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>H</strong>
						&nbsp;
						<input type="text" name="ep_h_2" value="<?=$ep_h_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>H</strong>
						&nbsp;
						<input type="text" name="ep_h_3" value="<?=$ep_h_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>H</strong>
						&nbsp;
						<input type="text" name="ep_h_4" value="<?=$ep_h_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>H</strong>
						&nbsp;
						<input type="text" name="ep_h_5" value="<?=$ep_h_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>R</strong>
						&nbsp;
						<input type="text" name="ep_r_1" value="<?=$ep_r_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>R</strong>
						&nbsp;
						<input type="text" name="ep_r_2" value="<?=$ep_r_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>R</strong>
						&nbsp;
						<input type="text" name="ep_r_3" value="<?=$ep_r_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>R</strong>
						&nbsp;
						<input type="text" name="ep_r_4" value="<?=$ep_r_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>R</strong>
						&nbsp;
						<input type="text" name="ep_r_5" value="<?=$ep_r_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="right">
						<strong>TR</strong>
						&nbsp;
						<input type="text" name="ep_tr_1" value="<?=$ep_tr_1;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TR</strong>
						&nbsp;
						<input type="text" name="ep_tr_2" value="<?=$ep_tr_2;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TR</strong>
						&nbsp;
						<input type="text" name="ep_tr_3" value="<?=$ep_tr_3;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TR</strong>
						&nbsp;
						<input type="text" name="ep_tr_4" value="<?=$ep_tr_4;?>" class="tbox" style="width:100px;" />
					</td>
					<td valign="top" align="right">
						<strong>TR</strong>
						&nbsp;
						<input type="text" name="ep_tr_5" value="<?=$ep_tr_5;?>" class="tbox" style="width:100px;" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" align="left" colspan="5" style="padding-left:100px;">
						*E = Epworth (0-24) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*S = Snore (0-10) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*W = Wake per night &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*A = Apneas <br />
						*EL = Energy Level (0-10) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*H = Headaches (x per week) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*R = Recording Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						*TS =Thorton scale <br />   
						*TR = Titration
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	
	<!--<tr>
		<td valign="top">
			<strong>Dental Device Appointments</strong>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Mini Consult:</strong>
			&nbsp;&nbsp;
			<input type="text" name="mini_consult" value="<?=$mini_consult;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>New Patient Exam/Impressions:</strong>
			&nbsp;&nbsp;
			<input type="text" name="exam_impressions" value="<?=$exam_impressions;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>Deliver OA /SOAP to Referring Dr’s:</strong>
			&nbsp;&nbsp;
			<input type="text" name="oa_soap" value="<?=$oa_soap;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>FMX & Blue Folder Given to Patient:</strong>
			&nbsp;&nbsp;
			<input type="text" name="fm_blue" value="<?=$fm_blue;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>OA Check:</strong>
			&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_1" value="<?=$oa_check_1;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_2" value="<?=$oa_check_2;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_3" value="<?=$oa_check_3;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_4" value="<?=$oa_check_4;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_5" value="<?=$oa_check_5;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oa_check_6" value="<?=$oa_check_6;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<br />
			<strong>1-3 Month Check:</strong>
			&nbsp;&nbsp;
			<input type="text" name="month_check_1" value="<?=$month_check_1;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="month_check_2" value="<?=$month_check_2;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="month_check_3" value="<?=$month_check_3;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="month_check_4" value="<?=$month_check_4;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>OA PSG Follow up sleep study:</strong>
			&nbsp;&nbsp;
			<input type="text" name="oa_psg" value="<?=$oa_psg;?>" class="tbox" />
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<br />
			<strong>One Year Check:</strong>
			&nbsp;&nbsp;&nbsp;
			<input type="text" name="year_check_1" value="<?=$year_check_1;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="year_check_2" value="<?=$year_check_2;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="year_check_3" value="<?=$year_check_3;?>" class="tbox" />
			<br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="year_check_4" value="<?=$year_check_4;?>" class="tbox" />
		</td>
	</tr> -->
	
	<tr>
		<td valign="top">
			<strong>Additional Notes:</strong>
			<br />
			<textarea name="additional_notes" class="tbox" style="width:700px; height:50px;"><?=$additional_notes;?></textarea>
		</td>
	</tr>
</table>
</form>

<br /><br />	

	</td>
</tr>
</table>
</body>
</html>