<?php

include 'includes/top.htm';
require_once('includes/patient_info.php');
if ($patient_info) {
$patid = $_GET['pid'];
if(isset($_POST['summarybtn']))
{
	$patient_name = $_POST['patient_name'];
	$patient_dob = $_POST['patient_dob'];
	$office = $_POST['osite'];
  $referral_source = $_POST['referral_source'];
	$reason_seeking_tx = $_POST['reason_seeking_tx'];
	$symptoms_osa = $_POST['symptoms_osa'];
	$bed_time_partner = $_POST['bed_time_partner'];
	$snoring = $_POST['snoring'];
	$apnea = $_POST['apnea'];
	$history_surgery = $_POST['history_surgery'];
	$tried_cpap = $_POST['tried_cpap'];
	$cpap_totalnights = $_POST['cpap_totalnights'];
	$fna = $_POST['fna'];                                   
	$cpap_date = $_POST['cpap_date'];
	$problem_cpap = $_POST['problem_cpap'];
	$max_translation_from = $_POST['max_translation_from'];
	$max_translation_to = $_POST['max_translation_to'];
	$max_translation_equal = $_POST['max_translation_equal'];
	$initial_device_titration_1 = $_POST['initial_device_titration_1'];
	$initial_device_titration_equal_h = $_POST['initial_device_titration_equal_h'];
	$initial_device_titration_equal_v = $_POST['initial_device_titration_equal_v'];
	$optimum_echovision_ver = $_POST['optimum_echovision_ver'];
	$optimum_echovision_hor = $_POST['optimum_echovision_hor'];
	$type_device = $_POST['type_device'];
	$personal = $_POST['personal'];
	$lab_name = $_POST['lab_name'];
	$sti_test_1 = $_POST['sti_test_1'];
	$sti_test_2 = $_POST['sti_test_2'];
	$sti_test_3 = $_POST['sti_test_3'];
	$sti_test_4 = $_POST['sti_test_4'];
	$sti_date_1 = $_POST['sti_date_1'];
	$sti_date_2 = $_POST['sti_date_2'];
	$sti_date_3 = $_POST['sti_date_3'];
	$sti_date_4 = $_POST['sti_date_4'];
	$sti_ahi_1 = $_POST['sti_ahi_1'];
	$sti_ahi_2 = $_POST['sti_ahi_2'];
	$sti_ahi_3 = $_POST['sti_ahi_3'];
	$sti_ahi_4 = $_POST['sti_ahi_4'];
	$sti_rdi_1 = $_POST['sti_rdi_1'];
	$sti_rdi_2 = $_POST['sti_rdi_2'];
	$sti_rdi_3 = $_POST['sti_rdi_3'];
	$sti_rdi_4 = $_POST['sti_rdi_4'];
	$sti_supine_ahi_1 = $_POST['sti_supine_ahi_1'];
	$sti_supine_ahi_2 = $_POST['sti_supine_ahi_2'];
	$sti_supine_ahi_3 = $_POST['sti_supine_ahi_3'];
	$sti_supine_ahi_4 = $_POST['sti_supine_ahi_4'];
	$sti_supine_rdi_1 = $_POST['sti_supine_rdi_1'];
	$sti_supine_rdi_2 = $_POST['sti_supine_rdi_2'];
	$sti_supine_rdi_3 = $_POST['sti_supine_rdi_3'];
	$sti_supine_rdi_4 = $_POST['sti_supine_rdi_4'];
	$sti_lsat_1 = $_POST['sti_lsat_1'];
	$sti_lsat_2 = $_POST['sti_lsat_2'];
	$sti_lsat_3 = $_POST['sti_lsat_3'];
	$sti_lsat_4 = $_POST['sti_lsat_4'];
	$sti_titration_1 = $_POST['sti_titration_1'];
	$sti_titration_2 = $_POST['sti_titration_2'];
	$sti_titration_3 = $_POST['sti_titration_3'];
	$sti_titration_4 = $_POST['sti_titration_4'];
	$sti_cpap_p_1 = $_POST['sti_cpap_p_1'];
	$sti_cpap_p_2 = $_POST['sti_cpap_p_2'];
	$sti_cpap_p_3 = $_POST['sti_cpap_p_3'];
	$sti_cpap_p_4 = $_POST['sti_cpap_p_4'];
	$sti_apnea_1 = $_POST['sti_apnea_1'];
	$sti_apnea_2 = $_POST['sti_apnea_2'];
	$sti_apnea_3 = $_POST['sti_apnea_3'];
	$sti_apnea_4 = $_POST['sti_apnea_4'];
	$ep_date_1 = $_POST['ep_date_1'];
	$ep_date_2 = $_POST['ep_date_2'];
	$ep_date_3 = $_POST['ep_date_3'];
	$ep_date_4 = $_POST['ep_date_4'];
	$ep_date_5 = $_POST['ep_date_5'];
	$dset1 = $_POST['dset1'];
	$dset2 = $_POST['dset2'];
	$dset3 = $_POST['dset3'];
	$dset4 = $_POST['dset4'];
	$dset5 = $_POST['dset5']; 
	$ep_e_1 = $_POST['ep_e_1'];
	$ep_e_2 = $_POST['ep_e_2'];
	$ep_e_3 = $_POST['ep_e_3'];
	$ep_e_4 = $_POST['ep_e_4'];
	$ep_e_5 = $_POST['ep_e_5'];
	$ep_s_1 = $_POST['ep_s_1'];
	$ep_s_2 = $_POST['ep_s_2'];
	$ep_s_3 = $_POST['ep_s_3'];
	$ep_s_4 = $_POST['ep_s_4'];
	$ep_s_5 = $_POST['ep_s_5'];
	$ep_w_1 = $_POST['ep_w_1'];
	$ep_w_2 = $_POST['ep_w_2'];
	$ep_w_3 = $_POST['ep_w_3'];
	$ep_w_4 = $_POST['ep_w_4'];
	$ep_w_5 = $_POST['ep_w_5'];
	$ep_a_1 = $_POST['ep_a_1'];
	$ep_a_2 = $_POST['ep_a_2'];
	$ep_a_3 = $_POST['ep_a_3'];
	$ep_a_4 = $_POST['ep_a_4'];
	$ep_a_5 = $_POST['ep_a_5'];
	$ep_el_1 = $_POST['ep_el_1'];
	$ep_el_2 = $_POST['ep_el_2'];
	$ep_el_3 = $_POST['ep_el_3'];
	$ep_el_4 = $_POST['ep_el_4'];
	$ep_el_5 = $_POST['ep_el_5'];
	$ep_h_1 = $_POST['ep_h_1'];
	$ep_h_2 = $_POST['ep_h_2'];
	$ep_h_3 = $_POST['ep_h_3'];
	$ep_h_4 = $_POST['ep_h_4'];
	$ep_h_5 = $_POST['ep_h_5'];
	$ep_r_1 = $_POST['ep_r_1'];
	$ep_r_2 = $_POST['ep_r_2'];
	$ep_r_3 = $_POST['ep_r_3'];
	$ep_r_4 = $_POST['ep_r_4'];
	$ep_r_5 = $_POST['ep_r_5'];
	$mini_consult = $_POST['mini_consult'];
	$exam_impressions = $_POST['exam_impressions'];
	$oa_soap = $_POST['oa_soap'];
	$fm_blue = $_POST['fm_blue'];
	$oa_check_1 = $_POST['oa_check_1'];
	$oa_check_2 = $_POST['oa_check_2'];
	$oa_check_3 = $_POST['oa_check_3'];
	$oa_check_4 = $_POST['oa_check_4'];
	$oa_check_5 = $_POST['oa_check_5'];
	$oa_check_6 = $_POST['oa_check_6'];
	$month_check_1 = $_POST['month_check_1'];
	$month_check_2 = $_POST['month_check_2'];
	$month_check_3 = $_POST['month_check_3'];
	$month_check_4 = $_POST['month_check_4'];
	$oa_psg = $_POST['oa_psg'];
	$year_check_1 = $_POST['year_check_1'];
	$year_check_2 = $_POST['year_check_2'];
	$year_check_3 = $_POST['year_check_3'];
	$year_check_4 = $_POST['year_check_4'];
	$additional_notes = $_POST['additional_notes'];
	$office = $_POST['osite'];
	$sleep_qual1 = $_POST['sleep_qual1'];
	$sleep_qual2 = $_POST['sleep_qual2'];
	$sleep_qual3 = $_POST['sleep_qual3'];
	$sleep_qual4 = $_POST['sleep_qual4'];
	$sleep_qual5 = $_POST['sleep_qual5'];
	$sleep_same_room = $_POST['sleep_same_room'];
	$currently_wearing = $_POST['currently_wearing'];
	$what_percentage = $_POST['what_percentage'];
	$how_long = $_POST['how_long'];
	$sleep_md = $_POST['sleep_md'];
	$test_type_name = $_POST['test_type_name'];
	$sti_sleep_efficiency_1 = $_POST['sti_sleep_efficiency_1'];
	$sti_sleep_efficiency_2 = $_POST['sti_sleep_efficiency_2'];
	$sti_sleep_efficiency_3 = $_POST['sti_sleep_efficiency_3'];
	$sti_sleep_efficiency_4 = $_POST['sti_sleep_efficiency_4'];
	$sti_rem_ahi_1 = $_POST['sti_rem_ahi_1'];
	$sti_rem_ahi_2 = $_POST['sti_rem_ahi_2'];
	$sti_rem_ahi_3 = $_POST['sti_rem_ahi_3'];
	$sti_rem_ahi_4 = $_POST['sti_rem_ahi_4'];
	$sti_o2_1 = $_POST['sti_o2_1'];
	$sti_o2_2 = $_POST['sti_o2_2'];
	$sti_o2_3 = $_POST['sti_o2_3'];
	$sti_o2_4 = $_POST['sti_o2_4'];
	$sti_other_1 = $_POST['sti_other_1'];
	$sti_other_2 = $_POST['sti_other_2'];
	$sti_other_3 = $_POST['sti_other_3'];
	$sti_other_4 = $_POST['sti_other_4'];
	$ep_ts_1 = $_POST['ep_ts_1'];
	$ep_ts_2 = $_POST['ep_ts_2'];
	$ep_ts_3 = $_POST['ep_ts_3'];
	$ep_ts_4 = $_POST['ep_ts_4'];
	$ep_ts_5 = $_POST['ep_ts_5'];
	$ep_tr_1 = $_POST['ep_tr_1'];
	$ep_tr_2 = $_POST['ep_tr_2'];
	$ep_tr_3 = $_POST['ep_tr_3'];
	$ep_tr_4 = $_POST['ep_tr_4'];
	$ep_tr_5 = $_POST['ep_tr_5'];
	$appt_notes_1 = $_POST['appt_notes_1'];
  $appt_notes_2 = $_POST['appt_notes_2'];
  $appt_notes_3 = $_POST['appt_notes_3'];
  $appt_notes_4 = $_POST['appt_notes_4'];
  $appt_notes_1p3 = $_POST['appt_notes_1p3'];
  $appt_notes_2p3 = $_POST['appt_notes_2p3'];
  $appt_notes_3p3 = $_POST['appt_notes_3p3'];
  $appt_notes_4p3 = $_POST['appt_notes_4p3'];
  $appt_notes_5p3 = $_POST['appt_notes_5p3'];
  $wapn1 = $_POST['wapn1'];
  $wapn2 = $_POST['wapn2'];
  $wapn3 = $_POST['wapn3'];
  $wapn4 = $_POST['wapn4'];
  $wapn5 = $_POST['wapn5'];
$r_lateral_from	= $_POST['r_lateral_from'];
$l_lateral_from = $_POST['l_lateral_from'];
$i_opening_from = $_POST['i_opening_from'];
$ir_range = $_POST['ir_range'];
$ir_min = $_POST['ir_min'];
$ir_max = $_POST['ir_max'];

$sql = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$q = mysql_query($sql);
$row = mysql_fetch_assoc($q);
$num = mysql_num_rows($q);
if($num > 0){
$ex_ed_sql = " update dental_ex_page5 set 
		protrusion_from = '".s_for($ir_min)."',
                protrusion_to = '".s_for($ir_max)."',
                protrusion_equal = '".s_for($ir_range)."',
                i_opening_from = '".s_for($i_opening_from)."',
                l_lateral_from = '".s_for($l_lateral_from)."',
                r_lateral_from = '".s_for($r_lateral_from)."'
	where ex_page5id = '".$row['ex_page5id']."'";
mysql_query($ex_ed_sql);
}else{
$ex_ins_sql = " insert dental_ex_page5 set 
                patientid = '".s_for($_GET['pid'])."',
                protrusion_from = '".s_for($ir_min)."',
                protrusion_to = '".s_for($ir_max)."',
                protrusion_equal = '".s_for($ir_range)."',
                i_opening_from = '".s_for($i_opening_from)."',
                l_lateral_from = '".s_for($l_lateral_from)."',
                r_lateral_from = '".s_for($r_lateral_from)."',
		userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                mysql_query($ex_ins_sql) or die($ex_ins_sql." | ".mysql_error());
}	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_summary set 
		patientid = '".s_for($_GET['pid'])."',
		patient_name = '".s_for($patient_name)."',
		patient_dob = '".s_for($patient_dob)."',
	  osite = '".s_for($office)."',
		referral_source = '".s_for($referral_source)."',
		reason_seeking_tx = '".s_for($reason_seeking_tx)."',
		symptoms_osa = '".s_for($symptoms_osa)."',
		bed_time_partner = '".s_for($bed_time_partner)."',
		snoring = '".s_for($snoring)."',
		apnea = '".s_for($apnea)."',
		history_surgery = '".s_for($history_surgery)."',
		tried_cpap = '".s_for($tried_cpap)."',
		cpap_totalnights = '".s_for('cpap_totalnights')."',
	  fna = '".s_for('fna')."',
		cpap_date = '".s_for($cpap_date)."',
		problem_cpap = '".s_for($problem_cpap)."',
		wearing_cpap = '".s_for($wearing_cpap)."',
		max_translation_from = '".s_for($max_translation_from)."',
		max_translation_to = '".s_for($max_translation_to)."',
		max_translation_equal = '".s_for($max_translation_equal)."',
		initial_device_titration_1 = '".s_for($initial_device_titration_1)."',
		initial_device_titration_equal_h = '".s_for($initial_device_titration_equal_h)."',
		initial_device_titration_equal_v = '".s_for($initial_device_titration_equal_v)."',
		optimum_echovision_ver = '".s_for($optimum_echovision_ver)."',
		optimum_echovision_hor = '".s_for($optimum_echovision_hor)."',
		type_device = '".s_for($type_device)."',
		personal = '".s_for($personal)."',
		lab_name = '".s_for($lab_name)."',
		sti_test_1 = '".s_for($sti_test_1)."',
		sti_test_2 = '".s_for($sti_test_2)."',
		sti_test_3 = '".s_for($sti_test_3)."',
		sti_test_4 = '".s_for($sti_test_4)."',
		sti_date_1 = '".s_for($sti_date_1)."',
		sti_date_2 = '".s_for($sti_date_2)."',
		sti_date_3 = '".s_for($sti_date_3)."',
		sti_date_4 = '".s_for($sti_date_4)."',
		sti_ahi_1 = '".s_for($sti_ahi_1)."',
		sti_ahi_2 = '".s_for($sti_ahi_2)."',
		sti_ahi_3 = '".s_for($sti_ahi_3)."',
		sti_ahi_4 = '".s_for($sti_ahi_4)."',
		sti_rdi_1 = '".s_for($sti_rdi_1)."',
		sti_rdi_2 = '".s_for($sti_rdi_2)."',
		sti_rdi_3 = '".s_for($sti_rdi_3)."',
		sti_rdi_4 = '".s_for($sti_rdi_4)."',
		sti_supine_ahi_1 = '".s_for($sti_supine_ahi_1)."',
		sti_supine_ahi_2 = '".s_for($sti_supine_ahi_2)."',
		sti_supine_ahi_3 = '".s_for($sti_supine_ahi_3)."',
		sti_supine_ahi_4 = '".s_for($sti_supine_ahi_4)."',
		sti_supine_rdi_1 = '".s_for($sti_supine_rdi_1)."',
		sti_supine_rdi_2 = '".s_for($sti_supine_rdi_2)."',
		sti_supine_rdi_3 = '".s_for($sti_supine_rdi_3)."',
		sti_supine_rdi_4 = '".s_for($sti_supine_rdi_4)."',
		sti_lsat_1 = '".s_for($sti_lsat_1)."',
		sti_lsat_2 = '".s_for($sti_lsat_2)."',
		sti_lsat_3 = '".s_for($sti_lsat_3)."',
		sti_lsat_4 = '".s_for($sti_lsat_4)."',
		sti_titration_1 = '".s_for($sti_titration_1)."',
		sti_titration_2 = '".s_for($sti_titration_2)."',
		sti_titration_3 = '".s_for($sti_titration_3)."',
		sti_titration_4 = '".s_for($sti_titration_4)."',
		sti_cpap_p_1 = '".s_for($sti_cpap_p_1)."',
		sti_cpap_p_2 = '".s_for($sti_cpap_p_2)."',
		sti_cpap_p_3 = '".s_for($sti_cpap_p_3)."',
		sti_cpap_p_4 = '".s_for($sti_cpap_p_4)."',
		sti_apnea_1 = '".s_for($sti_apnea_1)."',
		sti_apnea_2 = '".s_for($sti_apnea_2)."',
		sti_apnea_3 = '".s_for($sti_apnea_3)."',
		sti_apnea_4 = '".s_for($sti_apnea_4)."',
		ep_date_1 = '".s_for($ep_date_1)."',
		ep_date_2 = '".s_for($ep_date_2)."',
		ep_date_3 = '".s_for($ep_date_3)."',
		ep_date_4 = '".s_for($ep_date_4)."',
		ep_date_5 = '".s_for($ep_date_5)."',
		dset1 = '".s_for($dset1)."',
		dset2 = '".s_for($dset2)."',
		dset3 = '".s_for($dset3)."',
		dset4 = '".s_for($dset4)."',
		dset5 = '".s_for($dset5)."',
		ep_e_1 = '".s_for($ep_e_1)."',
		ep_e_2 = '".s_for($ep_e_2)."',
		ep_e_3 = '".s_for($ep_e_3)."',
		ep_e_4 = '".s_for($ep_e_4)."',
		ep_e_5 = '".s_for($ep_e_5)."',
		ep_s_1 = '".s_for($ep_s_1)."',
		ep_s_2 = '".s_for($ep_s_2)."',
		ep_s_3 = '".s_for($ep_s_3)."',
		ep_s_4 = '".s_for($ep_s_4)."',
		ep_s_5 = '".s_for($ep_s_5)."',
		ep_w_1 = '".s_for($ep_w_1)."',
		ep_w_2 = '".s_for($ep_w_2)."',
		ep_w_3 = '".s_for($ep_w_3)."',
		ep_w_4 = '".s_for($ep_w_4)."',
		ep_w_5 = '".s_for($ep_w_5)."',
		ep_a_1 = '".s_for($ep_a_1)."',
		ep_a_2 = '".s_for($ep_a_2)."',
		ep_a_3 = '".s_for($ep_a_3)."',
		ep_a_4 = '".s_for($ep_a_4)."',
		ep_a_5 = '".s_for($ep_a_5)."',
		ep_el_1 = '".s_for($ep_el_1)."',
		ep_el_2 = '".s_for($ep_el_2)."',
		ep_el_3 = '".s_for($ep_el_3)."',
		ep_el_4 = '".s_for($ep_el_4)."',
		ep_el_5 = '".s_for($ep_el_5)."',
		ep_h_1 = '".s_for($ep_h_1)."',
		ep_h_2 = '".s_for($ep_h_2)."',
		ep_h_3 = '".s_for($ep_h_3)."',
		ep_h_4 = '".s_for($ep_h_4)."',
		ep_h_5 = '".s_for($ep_h_5)."',
		ep_r_1 = '".s_for($ep_r_1)."',
		ep_r_2 = '".s_for($ep_r_2)."',
		ep_r_3 = '".s_for($ep_r_3)."',
		ep_r_4 = '".s_for($ep_r_4)."',
		ep_r_5 = '".s_for($ep_r_5)."',
		mini_consult = '".s_for($mini_consult)."',
		exam_impressions = '".s_for($exam_impressions)."',
		oa_soap = '".s_for($oa_soap)."',
		fm_blue = '".s_for($fm_blue)."',
		oa_check_1 = '".s_for($oa_check_1)."',
		oa_check_2 = '".s_for($oa_check_2)."',
		oa_check_3 = '".s_for($oa_check_3)."',
		oa_check_4 = '".s_for($oa_check_4)."',
		oa_check_5 = '".s_for($oa_check_5)."',
		oa_check_6 = '".s_for($oa_check_6)."',
		month_check_1 = '".s_for($month_check_1)."',
		month_check_2 = '".s_for($month_check_2)."',
		month_check_3 = '".s_for($month_check_3)."',
		month_check_4 = '".s_for($month_check_4)."',
		oa_psg = '".s_for($oa_psg)."',
		year_check_1 = '".s_for($year_check_1)."',
		year_check_2 = '".s_for($year_check_2)."',
		year_check_3 = '".s_for($year_check_3)."',
		year_check_4 = '".s_for($year_check_4)."',
		additional_notes = '".s_for($additional_notes)."',
		sleep_qual1 = '".s_for($sleep_qual1)."',
		sleep_qual2 = '".s_for($sleep_qual2)."',
		sleep_qual3 = '".s_for($sleep_qual3)."',
		sleep_qual4 = '".s_for($sleep_qual4)."',
		sleep_qual5 = '".s_for($sleep_qual5)."',
		sleep_same_room = '".s_for($sleep_same_room)."',
		currently_wearing = '".s_for($currently_wearing)."',
		what_percentage = '".s_for($what_percentage)."',
		how_long = '".s_for($how_long)."',
		sleep_md = '".s_for($sleep_md)."',
		test_type_name = '".s_for($test_type_name)."',
		sti_sleep_efficiency_1 = '".s_for($sti_sleep_efficiency_1)."',
		sti_sleep_efficiency_2 = '".s_for($sti_sleep_efficiency_2)."',
		sti_sleep_efficiency_3 = '".s_for($sti_sleep_efficiency_3)."',
		sti_sleep_efficiency_4 = '".s_for($sti_sleep_efficiency_4)."',
		sti_rem_ahi_1 = '".s_for($sti_rem_ahi_1)."',
		sti_rem_ahi_2 = '".s_for($sti_rem_ahi_2)."',
		sti_rem_ahi_3 = '".s_for($sti_rem_ahi_3)."',
		sti_rem_ahi_4 = '".s_for($sti_rem_ahi_4)."',
		sti_o2_1 = '".s_for($sti_o2_1)."',
		sti_o2_2 = '".s_for($sti_o2_2)."',
		sti_o2_3 = '".s_for($sti_o2_3)."',
		sti_o2_4 = '".s_for($sti_o2_4)."',
		sti_other_1 = '".s_for($sti_other_1)."',
		sti_other_2 = '".s_for($sti_other_2)."',
		sti_other_3 = '".s_for($sti_other_3)."',
		sti_other_4 = '".s_for($sti_other_4)."',
		ep_ts_1 = '".s_for($ep_ts_1)."',
		ep_ts_2 = '".s_for($ep_ts_2)."',
		ep_ts_3 = '".s_for($ep_ts_3)."',
		ep_ts_4 = '".s_for($ep_ts_4)."',
		ep_ts_5 = '".s_for($ep_ts_5)."',
		ep_tr_1 = '".s_for($ep_tr_1)."',
		ep_tr_2 = '".s_for($ep_tr_2)."',
		ep_tr_3 = '".s_for($ep_tr_3)."',
		ep_tr_4 = '".s_for($ep_tr_4)."',
		ep_tr_5 = '".s_for($ep_tr_5)."',
		appt_notes_1 = '".s_for($appt_notes_1)."',
    appt_notes_2 = '".s_for($appt_notes_2)."',
    appt_notes_3 = '".s_for($appt_notes_3)."',
    appt_notes_4 = '".s_for($appt_notes_4)."',
    appt_notes_1p3 = '".s_for($appt_notes_1p3)."',
    appt_notes_2p3 = '".s_for($appt_notes_2p3)."',
    appt_notes_3p3 = '".s_for($appt_notes_3p3)."',
    appt_notes_4p3 = '".s_for($appt_notes_4p3)."',
    appt_notes_5p3 = '".s_for($appt_notes_5p3)."',
    wapn1 = '".s_for($wapn1)."',
    wapn2 = '".s_for($wapn2)."',
    wapn3 = '".s_for($wapn3)."',
    wapn4 = '".s_for($wapn4)."',
    wapn5 = '".s_for($wapn5)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = "update dental_summary set 
		patient_name = '".s_for($patient_name)."',
		patient_dob = '".s_for($patient_dob)."',
	  osite = '".s_for($osite)."',
		referral_source = '".s_for($referral_source)."',
		reason_seeking_tx = '".s_for($reason_seeking_tx)."',
		symptoms_osa = '".s_for($symptoms_osa)."',
		bed_time_partner = '".s_for($bed_time_partner)."',
		snoring = '".s_for($snoring)."',
		apnea = '".s_for($apnea)."',
		history_surgery = '".s_for($history_surgery)."',
		tried_cpap = '".s_for($tried_cpap)."',
		cpap_totalnights = '".s_for($cpap_totalnights)."',
	  fna = '".s_for($fna)."',
		cpap_date = '".s_for($cpap_date)."',
		problem_cpap = '".s_for($problem_cpap)."',
		wearing_cpap = '".s_for($wearing_cpap)."',
		max_translation_from = '".s_for($max_translation_from)."',
		max_translation_to = '".s_for($max_translation_to)."',
		max_translation_equal = '".s_for($max_translation_equal)."',
		initial_device_titration_1 = '".s_for($initial_device_titration_1)."',
		initial_device_titration_equal_h = '".s_for($initial_device_titration_equal_h)."',
		initial_device_titration_equal_v = '".s_for($initial_device_titration_equal_v)."',
		optimum_echovision_ver = '".s_for($optimum_echovision_ver)."',
		optimum_echovision_hor = '".s_for($optimum_echovision_hor)."',
		type_device = '".s_for($type_device)."',
		personal = '".s_for($personal)."',
		lab_name = '".s_for($lab_name)."',
		sti_test_1 = '".s_for($sti_test_1)."',
		sti_test_2 = '".s_for($sti_test_2)."',
		sti_test_3 = '".s_for($sti_test_3)."',
		sti_test_4 = '".s_for($sti_test_4)."',
		sti_date_1 = '".s_for($sti_date_1)."',
		sti_date_2 = '".s_for($sti_date_2)."',
		sti_date_3 = '".s_for($sti_date_3)."',
		sti_date_4 = '".s_for($sti_date_4)."',
		sti_ahi_1 = '".s_for($sti_ahi_1)."',
		sti_ahi_2 = '".s_for($sti_ahi_2)."',
		sti_ahi_3 = '".s_for($sti_ahi_3)."',
		sti_ahi_4 = '".s_for($sti_ahi_4)."',
		sti_rdi_1 = '".s_for($sti_rdi_1)."',
		sti_rdi_2 = '".s_for($sti_rdi_2)."',
		sti_rdi_3 = '".s_for($sti_rdi_3)."',
		sti_rdi_4 = '".s_for($sti_rdi_4)."',
		sti_supine_ahi_1 = '".s_for($sti_supine_ahi_1)."',
		sti_supine_ahi_2 = '".s_for($sti_supine_ahi_2)."',
		sti_supine_ahi_3 = '".s_for($sti_supine_ahi_3)."',
		sti_supine_ahi_4 = '".s_for($sti_supine_ahi_4)."',
		sti_supine_rdi_1 = '".s_for($sti_supine_rdi_1)."',
		sti_supine_rdi_2 = '".s_for($sti_supine_rdi_2)."',
		sti_supine_rdi_3 = '".s_for($sti_supine_rdi_3)."',
		sti_supine_rdi_4 = '".s_for($sti_supine_rdi_4)."',
		sti_lsat_1 = '".s_for($sti_lsat_1)."',
		sti_lsat_2 = '".s_for($sti_lsat_2)."',
		sti_lsat_3 = '".s_for($sti_lsat_3)."',
		sti_lsat_4 = '".s_for($sti_lsat_4)."',
		sti_titration_1 = '".s_for($sti_titration_1)."',
		sti_titration_2 = '".s_for($sti_titration_2)."',
		sti_titration_3 = '".s_for($sti_titration_3)."',
		sti_titration_4 = '".s_for($sti_titration_4)."',
		sti_cpap_p_1 = '".s_for($sti_cpap_p_1)."',
		sti_cpap_p_2 = '".s_for($sti_cpap_p_2)."',
		sti_cpap_p_3 = '".s_for($sti_cpap_p_3)."',
		sti_cpap_p_4 = '".s_for($sti_cpap_p_4)."',
		sti_apnea_1 = '".s_for($sti_apnea_1)."',
		sti_apnea_2 = '".s_for($sti_apnea_2)."',
		sti_apnea_3 = '".s_for($sti_apnea_3)."',
		sti_apnea_4 = '".s_for($sti_apnea_4)."',
		ep_date_1 = '".s_for($ep_date_1)."',
		ep_date_2 = '".s_for($ep_date_2)."',
		ep_date_3 = '".s_for($ep_date_3)."',
		ep_date_4 = '".s_for($ep_date_4)."',
		ep_date_5 = '".s_for($ep_date_5)."',
		dset1 = '".s_for($dset1)."',
		dset2 = '".s_for($dset2)."',
		dset3 = '".s_for($dset3)."',
		dset4 = '".s_for($dset4)."',
		dset5 = '".s_for($dset5)."',
		ep_e_1 = '".s_for($ep_e_1)."',
		ep_e_2 = '".s_for($ep_e_2)."',
		ep_e_3 = '".s_for($ep_e_3)."',
		ep_e_4 = '".s_for($ep_e_4)."',
		ep_e_5 = '".s_for($ep_e_5)."',
		ep_s_1 = '".s_for($ep_s_1)."',
		ep_s_2 = '".s_for($ep_s_2)."',
		ep_s_3 = '".s_for($ep_s_3)."',
		ep_s_4 = '".s_for($ep_s_4)."',
		ep_s_5 = '".s_for($ep_s_5)."',
		ep_w_1 = '".s_for($ep_w_1)."',
		ep_w_2 = '".s_for($ep_w_2)."',
		ep_w_3 = '".s_for($ep_w_3)."',
		ep_w_4 = '".s_for($ep_w_4)."',
		ep_w_5 = '".s_for($ep_w_5)."',
		ep_a_1 = '".s_for($ep_a_1)."',
		ep_a_2 = '".s_for($ep_a_2)."',
		ep_a_3 = '".s_for($ep_a_3)."',
		ep_a_4 = '".s_for($ep_a_4)."',
		ep_a_5 = '".s_for($ep_a_5)."',
		ep_el_1 = '".s_for($ep_el_1)."',
		ep_el_2 = '".s_for($ep_el_2)."',
		ep_el_3 = '".s_for($ep_el_3)."',
		ep_el_4 = '".s_for($ep_el_4)."',
		ep_el_5 = '".s_for($ep_el_5)."',
		ep_h_1 = '".s_for($ep_h_1)."',
		ep_h_2 = '".s_for($ep_h_2)."',
		ep_h_3 = '".s_for($ep_h_3)."',
		ep_h_4 = '".s_for($ep_h_4)."',
		ep_h_5 = '".s_for($ep_h_5)."',
		ep_r_1 = '".s_for($ep_r_1)."',
		ep_r_2 = '".s_for($ep_r_2)."',
		ep_r_3 = '".s_for($ep_r_3)."',
		ep_r_4 = '".s_for($ep_r_4)."',
		ep_r_5 = '".s_for($ep_r_5)."',
		mini_consult = '".s_for($mini_consult)."',
		exam_impressions = '".s_for($exam_impressions)."',
		oa_soap = '".s_for($oa_soap)."',
		fm_blue = '".s_for($fm_blue)."',
		oa_check_1 = '".s_for($oa_check_1)."',
		oa_check_2 = '".s_for($oa_check_2)."',
		oa_check_3 = '".s_for($oa_check_3)."',
		oa_check_4 = '".s_for($oa_check_4)."',
		oa_check_5 = '".s_for($oa_check_5)."',
		oa_check_6 = '".s_for($oa_check_6)."',
		month_check_1 = '".s_for($month_check_1)."',
		month_check_2 = '".s_for($month_check_2)."',
		month_check_3 = '".s_for($month_check_3)."',
		month_check_4 = '".s_for($month_check_4)."',
		oa_psg = '".s_for($oa_psg)."',
		year_check_1 = '".s_for($year_check_1)."',
		year_check_2 = '".s_for($year_check_2)."',
		year_check_3 = '".s_for($year_check_3)."',
		year_check_4 = '".s_for($year_check_4)."',
		additional_notes = '".s_for($additional_notes)."',
		osite = '".s_for($office)."',
		sleep_qual1 = '".s_for($sleep_qual1)."',
		sleep_qual2 = '".s_for($sleep_qual2)."',
		sleep_qual3 = '".s_for($sleep_qual3)."',
		sleep_qual4 = '".s_for($sleep_qual4)."',
		sleep_qual5 = '".s_for($sleep_qual5)."',
		sleep_same_room = '".s_for($sleep_same_room)."',
		currently_wearing = '".s_for($currently_wearing)."',
		what_percentage = '".s_for($what_percentage)."',
		how_long = '".s_for($how_long)."',
		sleep_md = '".s_for($sleep_md)."',
		test_type_name = '".s_for($test_type_name)."',
		sti_sleep_efficiency_1 = '".s_for($sti_sleep_efficiency_1)."',
		sti_sleep_efficiency_2 = '".s_for($sti_sleep_efficiency_2)."',
		sti_sleep_efficiency_3 = '".s_for($sti_sleep_efficiency_3)."',
		sti_sleep_efficiency_4 = '".s_for($sti_sleep_efficiency_4)."',
		sti_rem_ahi_1 = '".s_for($sti_rem_ahi_1)."',
		sti_rem_ahi_2 = '".s_for($sti_rem_ahi_2)."',
		sti_rem_ahi_3 = '".s_for($sti_rem_ahi_3)."',
		sti_rem_ahi_4 = '".s_for($sti_rem_ahi_4)."',
		sti_o2_1 = '".s_for($sti_o2_1)."',
		sti_o2_2 = '".s_for($sti_o2_2)."',
		sti_o2_3 = '".s_for($sti_o2_3)."',
		sti_o2_4 = '".s_for($sti_o2_4)."',
		sti_other_1 = '".s_for($sti_other_1)."',
		sti_other_2 = '".s_for($sti_other_2)."',
		sti_other_3 = '".s_for($sti_other_3)."',
		sti_other_4 = '".s_for($sti_other_4)."',
		ep_ts_1 = '".s_for($ep_ts_1)."',
		ep_ts_2 = '".s_for($ep_ts_2)."',
		ep_ts_3 = '".s_for($ep_ts_3)."',
		ep_ts_4 = '".s_for($ep_ts_4)."',
		ep_ts_5 = '".s_for($ep_ts_5)."',
		ep_tr_1 = '".s_for($ep_tr_1)."',
		ep_tr_2 = '".s_for($ep_tr_2)."',
		ep_tr_3 = '".s_for($ep_tr_3)."',
		ep_tr_4 = '".s_for($ep_tr_4)."',
		ep_tr_5 = '".s_for($ep_tr_5)."',
		appt_notes_1 = '".s_for($appt_notes_1)."',
    appt_notes_2 = '".s_for($appt_notes_2)."',
    appt_notes_3 = '".s_for($appt_notes_3)."',
    appt_notes_4 = '".s_for($appt_notes_4)."',
    appt_notes_1p3 = '".s_for($appt_notes_1p3)."',
    appt_notes_2p3 = '".s_for($appt_notes_2p3)."',
    appt_notes_3p3 = '".s_for($appt_notes_3p3)."',
    appt_notes_4p3 = '".s_for($appt_notes_4p3)."',
    appt_notes_5p3 = '".s_for($appt_notes_5p3)."',
    wapn1 = '".s_for($wapn1)."',
    wapn2 = '".s_for($wapn2)."',
    wapn3 = '".s_for($wapn3)."',
    wapn4 = '".s_for($wapn4)."',
    wapn5 = '".s_for($wapn5)."' where patientid = '".s_for($_GET['pid'])."'";
		
		if(mysql_query($ed_sql)){
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
		</script>
		<?php
		}else{
      echo "Summary could not be saved";
      die($ed_sql." | ".mysql_error());
    }?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pg=2&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);

	$docpcp = st($pat_myarray['docpcp']);
	$docsleep = st($pat_myarray['docsleep']);
	$docdentist = st($pat_myarray['docdentist']);
	$docent = st($pat_myarray['docent']);
	$docmdother = st($pat_myarray['docmdother']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$q1_sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);

$main_reason = st($q1_myarray['main_reason']);
$main_reason_other = st($q1_myarray['main_reason_other']);
$complaintid = st($q1_myarray['complaintid']);
$bed_time_partner1 = st($q1_myarray['bed_time_partner']);
$sleep_same_room1 = st($q1_myarray['sleep_same_room']);
$other_complaint = st($q1_myarray['other_complaint']);
$additional_paragraph = st($q1_myarray['additional_paragraph']);
$sleep_qual1 = st($q1_myarray['sleep_qual']);
$sleep_qual2 = st($myarray['sleep_qual2']);
$sleep_qual3 = st($myarray['sleep_qual3']);
$sleep_qual4 = st($myarray['sleep_qual4']);
$sleep_qual5 = st($myarray['sleep_qual5']);
$quit_breathing = st($q1_myarray['quit_breathing']);
$hours_sleep = st($q1_myarray['hours_sleep']);
$q2_sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);

$cpap = st($q2_myarray['cpap']);
$nights_wear_cpap = st($q2_myarray['nights_wear_cpap']);
$percent_night_cpap = st($q2_myarray['percent_night_cpap']);
$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
$other_treat_att = substr(st($q2_myarray['other']),1);
$other_treat_att = str_replace("~","\n",$other_treat_att);

$sqlex = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$myex = mysql_query($sqlex);
$myarrayex = mysql_fetch_array($myex);

$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equals = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);


$sqlex8 = "select * from dental_ex_page8 where patientid='".$_GET['pid']."'";
$myex8 = mysql_query($sqlex8);
$myarrayex8 = mysql_fetch_array($myex8);
$dental_device_used = st($myarrayex8['device']);

$sqlex9 = "select * from dental_device where deviceid='".$dental_device_used."'";
$myex9 = mysql_query($sqlex9);
$myarrayex9 = mysql_fetch_array($myex9);
$dental_device_name = st($myarrayex9['device']);



$sql = "select * from dental_summary where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);
$patientid = st($myarray['summaryid']);
$summaryid = st($myarray['summaryid']);
$patient_name = st($myarray['patient_name']);
$patient_dob = st($myarray['patient_dob']);
$patientphoto = st($myarray['patientphoto']);
//$docpcp = st($myarray['docpcp']);
//$docsmd = st($myarray['docsmd']);
//$docomd1 = st($myarray['docomd1']);
//$docomd2 = st($myarray['docomd2']);
//$docdds = st($myarray['docdds']);
$osite = st($myarray['osite']);
$referral_source = st($myarray['referral_source']);
$reason_seeking_tx = st($myarray['reason_seeking_tx']);
$symptoms_osa = st($myarray['symptoms_osa']);
$bed_time_partner = st($myarray['bed_time_partner']);
$snoring = st($myarray['snoring']);
$apnea = st($myarray['apnea']);
$history_surgery = st($myarray['history_surgery']);
$tried_cpap = st($myarray['tried_cpap']);
$cpap_totalnights = st($myarray['cpap_totalnights']);
$fna = st($myarray['fna']);
$cpap_date = st($myarray['cpap_date']);
$problem_cpap = st($myarray['problem_cpap']);
$wearing_cpap = st($myarray['wearing_cpap']);
$max_translation_from = st($myarray['max_translation_from']);
$max_translation_to = st($myarray['max_translation_to']);
$max_translation_equal = st($myarray['max_translation_equal']);
$initial_device_titration_1 = st($myarray['initial_device_titration_1']);
$initial_device_titration_equal_h = st($myarray['initial_device_titration_equal_h']);
$initial_device_titration_equal_v = st($myarray['initial_device_titration_equal_v']);
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
$dset1 = st($myarray['dset1']);
$dset2 = st($myarray['dset2']);
$dset3 = st($myarray['dset3']);
$dset4 = st($myarray['dset4']);
$dset5 = st($myarray['dset5']);
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
$office = st($myarray['osite']);
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
$appt_notes_1 = st($myarray['appt_notes_1']);
$appt_notes_2 = st($myarray['appt_notes_2']);
$appt_notes_3 = st($myarray['appt_notes_3']);
$appt_notes_4 = st($myarray['appt_notes_4']);
$appt_notes_1p3 = st($myarray['appt_notes_1p3']);
$appt_notes_2p3 = st($myarray['appt_notes_2p3']);
$appt_notes_3p3 = st($myarray['appt_notes_3p3']);
$appt_notes_4p3 = st($myarray['appt_notes_4p3']);
$appt_notes_5p3 = st($myarray['appt_notes_5p3']);
$wapn1 = st($myarray['wapn1']);
$wapn2 = st($myarray['wapn2']);
$wapn3 = st($myarray['wapn3']);
$wapn4 = st($myarray['wapn4']);
$wapn5 = st($myarray['wapn5']);


$patient_name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

$patient_dob = st($pat_myarray['dob']);

$referral_source = st($pat_myarray['referred_source']);

if(st($pat_myarray['referred_by']) != '')
{
	$referredby_sql = "select * from dental_contact where status=1 and contactid='".st($pat_myarray['referred_by'])."'";
	$referredby_my = mysql_query($referredby_sql);
	$referredby_myarray = mysql_fetch_array($referredby_my);
	
	$sleep_md = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
}

$main_arr = explode('~',$main_reason);

if(count($main_arr) <> 0)
{
	foreach($main_arr as $m_val)
	{
		if(trim($m_val) <> '')
		{
if($m_val == 'other'){
$main_disp .= $m_val." - ".$main_reason_other."
";
}else{
$main_disp .= $m_val."
";
}
		}
	}
}


$cc_sql = "select chief_complaint_text from dental_q_page1 WHERE patientid=".mysql_real_escape_string($_GET['pid']);
$cc_q = mysql_query($cc_sql);
$cc_row = mysql_fetch_assoc($cc_q);
$reason_seeking_tx = "
Main reason seeking Tx:
".$cc_row['chief_complaint_text']."
";


if($complaintid <> '')
{
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
	$reason_seeking_tx .= "
Other Complaints:
";  
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


if($other_complaint <> '')
{
$reason_seeking_tx .= $other_complaint;
}

if($additional_paragraph <> '')
{
$reason_seeking_tx .= "

Additional Paragraph:
".$additional_paragraph;
}

$bed_time_partner = $bed_time_partner1;

$sleep_same_room = $sleep_same_room1;

$tried_cpap = $cpap;

$currently_wearing = $nights_wear_cpap;

$what_percentage = $percent_night_cpap;


$rec_sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";
$rec_my = mysql_query($rec_sql);
$rec_myarray = mysql_fetch_array($rec_my);

$patient_photo = st($rec_myarray['q_file7']);

$q1_sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);

$ep_s_1 = st($q1_myarray['snoring_sound']);
$ep_w_1 = st($q1_myarray['wake_night']);
$ep_el_1 = st($q1_myarray['energy_level']);
$ep_h_1 = st($q1_myarray['morning_headaches']);
$add_date = substr($q1_myarray['adddate'],0, -8);
$qs_sql = "select * from dental_q_sleep where patientid='".$_GET['pid']."'";
$qs_my = mysql_query($qs_sql);
$qs_myarray = mysql_fetch_array($qs_my);

$epworthid = st($qs_myarray['epworthid']);
$ep_total = 0;
if($epworthid <> '')
{	
	$epworth_arr1 = split('~',$epworthid);
	$ep_total = 0;
	foreach($epworth_arr1 as $i => $val)
	{
		$epworth_arr2 = explode('|',$val);
		
		$ep_total += $epworth_arr2[1];
	}
}
$ep_e_1 = $ep_total;

$ts_sql = "select * from dental_thorton where patientid='".$_GET['pid']."'";
$ts_my = mysql_query($ts_sql);
$ts_myarray = mysql_fetch_array($ts_my);

$ep_ts_1 = st($ts_myarray['snore_1']) + st($ts_myarray['snore_2']) + st($ts_myarray['snore_3']) + st($ts_myarray['snore_4']) + st($ts_myarray['snore_5']);

$q2_sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);


$other_therapy_att = st($q2_myarray['other_therapy']);
$other_therapy_att = str_replace("~","\n",$other_therapy_att);


$sleep_sql = "select * from dental_sleeplab where sleeplabid='".$q2_myarray['sleep_center_name']."'";
$sleep_my = mysql_query($sleep_sql);
$sleep_myarray = mysql_fetch_array($sleep_my);

$test_type_name = st($sleep_myarray['company']);
$sti_test_1 = st($q2_myarray['type_study']);
$sti_date_1 = st($q2_myarray['sleep_study_on']);
$sti_ahi_1 = st($q2_myarray['ahi']);
$sti_rdi_1 = st($q2_myarray['rdi']);
$intolerance = st($q2_myarray['intolerance']);


$nights_wear_cpap = st($q2_myarray['nights_wear_cpap']);
$hours_night_cpap = st($q2_myarray['percent_night_cpap']);
$tried_quit_tried = st($q2_myarray['triedquittried']);
$timesovertime = st($q2_myarray['timesovertime']);


$other_intolerance = st($q2_myarray['other_intolerance']);

if($intolerance <> '')
{	
	$intolerance_arr1 = split('~',$intolerance);
	$problem_cpap = '';
	foreach($intolerance_arr1 as $val)
	{
		$intolerance_sql = "select * from dental_intolerance where status=1 and intoleranceid='".$val."'";
		$intolerance_my = mysql_query($intolerance_sql);
		$intolerance_myarray =  mysql_fetch_array($intolerance_my);
		
		if(st($intolerance_myarray['intolerance']) <> '')
		{
$problem_cpap .= "
".st($intolerance_myarray['intolerance']);
		}
	}
  $problem_cpap .= "\n\n";
}

if(other_intolerance <> '')
{
$problem_cpap .= "Other Items
".$other_intolerance;
}

$ep_date_1 = st($q2_myarray['sleep_study_on']);
?>
<br />
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>
<!--
<span class="admin_head">
	<button onclick="Javascript: window.open('dss_summary_print.php?pid=<?=$_GET['pid']?>','Summary_print','width=800,height=600,scrollbars=1');">
		Print
	</button>
</span>
<br />
&nbsp;&nbsp;
-->	
	<?php 
	
	$pid = $_GET['pid'];
  $itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid;
  $itype_my = mysql_query($itype_sql);
  while($image = mysql_fetch_array($itype_my)){
   echo "<center><img src='q_file/".$image['image_file']."' height='150' /></center>";
  }
 ?>
 	
	

<div align="right" style="margin-right:23px;">

    <input type="button" class="summary_but <?= ($_GET['pg']!=2)?'active':''; ?>" onClick="$('.summary_but').addClass('active');$('.data_but').removeClass('active');document.getElementById('hideshow1').style.display='block';document.getElementById('hideshow2').style.display='none';document.getElementById('hideshow3').style.display='none';" value="Summary" id="button1s">
    <input type="button" class="data_but <?= ($_GET['pg']==2)?'active':''; ?>" onClick="$('.summary_but').removeClass('active');$('.data_but').addClass('active');document.getElementById('hideshow1').style.display='none';document.getElementById('hideshow2').style.display='block';document.getElementById('hideshow3').style.display='none';" value="Data" id="button1s">
</font>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


</div>


<style>
#contentMain input, textarea, select{
background:#cccccc;
}
#contentMain input[disabled]{
background:#eee;
color:#000;
font-weight:bold;
}
#contentMain input.active{
  background: #5C8DB8;
}
</style>
<div>
<table width="980" cellpadding="0" cellspacing="0" border="0" align="center">


<div>
<table width="90%" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0" style="margin:0 auto; <?= ($_GET['pg']==2)?'display:none;':''; ?>" id="hideshow1">
  <tr valign="top">
    <td width="15%" height="3">Name</td>
    <td colspan="1">
      <label>
        <strong><?php echo $patient_name; ?></strong>
<?php
$sql = "SELECT imageid FROM dental_q_image WHERE patientid='".$_GET['pid']."' AND imagetypeid=4";
$p = mysql_query($sql);
$num_face = mysql_num_rows($p);
?>
<span align="right">
<?php if($num_face==0){ ?>
        <button onclick="Javascript: loadPopup('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&it=4');" class="addButton">
                Add Patient Photo
        </button>
<?php }else{ ?>
        <button onclick="Javascript: window.location='q_image.php?pid=<?= $_GET['pid']; ?>&addtopat=1'" class="addButton">
                Add/Update Patient Photo
        </button>
 
<?php } ?>
        &nbsp;&nbsp;
</span>

      </label>
      <br />
    </td>
    <td colspan="5" rowspan="4">
<strong><h3 style="margin-top:-5px;">Medical Caregivers:</h3></strong>
<div style="margin-left:20px;">

    <?php

	$d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
		ON c.contactid=p.docsleep WHERE p.patientid=".$patid;
	$d_q = mysql_query($d_sql);
	if($d = mysql_fetch_assoc($d_q)){
		echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Sleep MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
	}
	



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docpcp WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Primary Care:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docdentist WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Dentist:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docent WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>ENT:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docmdother WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Other MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



?>
</div>    
    
    
    </td>
    
  </tr>
  <tr valign="top">
    <td width="15%" height="4">DOB</td>
    <td colspan="1">
      <?php echo $patient_dob; ?>
      <br />
    </td>

  </tr>
  <tr valign="top">
    <td width="15%" height="5">Referred By</td>
    <td colspan="1">
    
    
    
    <?php 

if(st($pat_myarray['referred_by']) <> '')
{
  $referredby_sql = "select * from dental_contact where referrer=1 and status=1 and contactid='".st($pat_myarray['referred_by'])."'";
	$referredby_my = mysql_query($referredby_sql);
	$referredby_myarray = mysql_fetch_array($referredby_my);
	
	$referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
  echo $referredbythis;
  }else{
echo "Not Set, Please set through patient info.";
}
    ?>
    
      <br />
    </td>
    
  </tr>

  <tr valign="top">
    <td width="15%" height="5">Office Site</td>
    <td colspan="1">
      <?php include("dss_osite.php"); ?>
      <br />
    </td>
  </tr>
  <tr valign="top">
    <td width="15%" height="5">Reason seeking tx</td>
    <td colspan="6">
      <label>
        <textarea name="reason_seeking_tx" id="textarea" cols="68" rows="7"><?=$reason_seeking_tx;?></textarea>
      </label>
      
      </td>
  </tr>
  <tr valign="top">
   <td width="15%" height="5">CPAP</td>
    <td colspan="6">
    <div style="width:80%;"> 
  
      
    <label>
       
    
      
      <span>On average how many nights per week do you wear your CPAP?
							<input type="text" style="width: 50px;" maxlength="50" value="<?php echo $nights_wear_cpap; ?>" class="field text addr tbox" name="nights_wear_cpap" id="nights_wear_cpap">
							<br>
						</span>
      
      
      
      <span>
							On average how many hours each night do you wear your CPAP?
							<input type="text" style="width: 50px;" maxlength="50" value="<?php echo $percent_night_cpap; ?>" class="field text addr tbox" name="percent_night_cpap" id="percent_night_cpap">
							<br>
						</span>
      
      
      <span>
							How many times have you tried CPAP for a period of time, quit and then tried CPAP again?
              <input type="text" style="width: 50px;" maxlength="50" value="<?php echo $tried_quit_tried; ?>" class="field text addr tbox" name="triedquittried" id="triedquittried">
							<br>
						</span>
      
      
      <span>
							On average how long of time period did you try the CPAP during each of these time periods?
              <input type="text" style="width: 50px;" maxlength="50" value="<?php echo $timesovertime; ?>" class="field text addr tbox" name="timesovertime" id="timesovertime">
							<br>
						</span>
    
    <div style="height:10px;"></div>
    
    
    
    <span style="font-weight:bold;">Problems w/ CPAP</span><br />
        <textarea name="textarea8" id="textarea" cols="68" rows="5"><?=$problem_cpap;?></textarea>
      </label>
      
      
      
      
      
      
    
      
      
     </div> 
    </td>
      
      
      
      
      
  </tr>

  <tr valign="top">
    <td width="18%" height="6">Bed Partner:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $bed_time_partner ?></strong><br />
			&nbsp;&nbsp;
			<br /><br />
      Same room:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $sleep_same_room; ?></strong><br /> 
</td>
    <td colspan="6">
    History of Surgery or other Treatment Attempts:<br />
      <textarea name="history_surgery" id="textarea3" cols="45" rows="5"><?=$other_therapy_att;?></textarea>
      <br />
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="7">Notes/Personal:
      
      
       <?php include("dss_notes.php"); ?>
            

      </td>
  </tr>

</table>
</div>


































<div id="hideshow2" style=" <?= ($_GET['pg']!=2)?'display:none;':''; ?>">
<form id="form1" name="form1" method="post" action="" style="width:90%;margin:0 auto;">
  <table width="100%" align="center" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0">
  <tr valign="top">
    <td width="17%" height="4">ROM:&nbsp;&nbsp;</td>
    <td colspan="2">
    Vertical&nbsp;<input type="text" name="i_opening_from" id="textfield11" size="5" value="<?php echo $i_opening_from; ?>" /> mm&nbsp;&nbsp;&nbsp;&nbsp; Right <input type="text" name="r_lateral_from" id="textfield12" size="5" value="<?php echo $r_lateral_from; ?>" />mm&nbsp;&nbsp;&nbsp;&nbsp;  Left <input type="text" name="l_lateral_from" id="textfield13" size="5" value="<?php echo $l_lateral_from; ?>"/>mm 
    </td>
    
  </tr>
  
  <tr>
  <td width="17%" height="4">Incisal Edge Range:&nbsp;&nbsp;</td>
  <td colspan="2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input disabled="disabled" type="text" name="ir_range" id="ir_range" size="5" value="<?php echo $protrusion_to-($protrusion_from); ?>" /> mm   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incisal Range (minimum):&nbsp;&nbsp; <input type="text" name="ir_min" id="ir_min" size="5" value="<?php echo $protrusion_from; ?>" onchange="checkIncisal()" /> (maximum) <input type="text" name="ir_max" id="ir_max" size="5" value="<?php echo $protrusion_to; ?>" onchange="checkIncisal()"  />

  </td>
  </tr>
  <script type="text/javascript">
	function checkIncisal(){
		min = Number($('#ir_min').val());
		max = Number($('#ir_max').val());
		range = (max-min);
		$('#ir_range').val(range);
		pos = Number($('#i_pos').val());
		dist = Math.abs(pos-min); 
		perc = (dist/range)
		$('#initial_device_titration_equal_h').val(Math.round(dist));
		$('#i_perc').val(Math.round(perc*100));
		if(min != '' && max != ''){
			if((range)<0){
				alert('Minimum must be less than maximum');
				$('#ir_min').focus();
				return false;
			}
		 	if(pos<min || pos>max){
				alert('Incisal Position value must be between minimum and maximum range.');
				$('#i_pos').focus();
				return false;
			}
		}
	 	return true;
	}
	$('document').ready( function(){
		checkIncisal();
	})
  </script>
  <tr>
  <td width="17%" height="4">Best Eccovision&nbsp;&nbsp;</td>
  <td colspan="2">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horizontal<input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?php echo $optimum_echovision_hor; ?>" />mm  Vertical<input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?php echo $optimum_echovision_ver; ?>" />mm
  </td>
  </tr>
  
  <tr>
  <td width="17%" height="4">Initial Device Setting&nbsp;&nbsp;</td>
  <td colspan="2">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Incisal Position <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?php echo $initial_device_titration_1; ?>" />mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
Vertical <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?php echo $initial_device_titration_equal_v; ?>" />mm
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Distance from minimum range<input disabled="disabled" type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" size="5" value="<?php echo $initial_device_titration_equal_h; ?>" />mm  
(<input type="text" name="i_perc" id="i_perc" size="2" disabled="disabled" value="<?php echo $initialdevsettingp; ?>" />%)
  </td>
  </tr>
  
  </table>
  <br />
  
<div align="right">
<input type="hidden" name="summarysub" value="1" />
<input type="hidden" name="ed" value="<?=$summaryid;?>" />
    <input type="submit" name="summarybtn" onclick="return checkIncisal();" value="Save" />
</div>
</form>  

<div style="height:20px;"></div>  
<!-- SLEEP LAB SECTION START -->  
<table width="97%" align="center" style="float:left;margin-left:15px;">
<tr>
<td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;">
Sleep Studies:
</td>
</tr>
</table>  
<div style="height:20px;"></div>  
<!-- SLEEP LAB SECTION START -->  
<style type="text/css">
  .sleeplabstable tr{ height: 28px; }
  .odd{ background: #F9FFDF; }
  .even{ background: #e4ffcf; }
</style>
<table class="sleeplabstable" width="108" align="center" style="float:left; margin: 0 0 0 15px;line-height:22px;">


	<tr>
		<td valign="top" class="odd">
		Date	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		Sleep Test Type	
		</td>
</tr>
  <tr>
                <td valign="top" class="odd">
                Needed
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Date Scheduled
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                Completed
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Interpretation
                </td>
        </tr>
  <tr>		
		<td valign="top" class="odd">
		Place	
		</td>
	</tr>
  <tr>
                <td valign="top" class="even">
                Diagnosis
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                Copy Requested
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Request From
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                File
                </td>
        </tr>
  <tr>	
		<td valign="top" class="even">
		Apnea	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		Hypopnia
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		AHI	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		AHI Supine
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		RDI	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		RDI Supine	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		O<sub>2</sub> Nadir	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		T &le; 90% O<sub>2</sub>
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		Sleep Efficiency	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		CPAP Level	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		Dental Device
		</td>
  </tr>
  <tr>		
		<td valign="top" class="odd">
		Device Setting	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		Notes
		</td>
	</tr>
  </table>
  
  
  
  
	<div style="border: medium none; width: 800px;float: left; margin-bottom: 20px; height: 799px;">
		    
		    <iframe height="792" width="100%" style="border: medium none; overflow-y: hidden;overflow-x: scroll;" src="add_sleep_study.php?pid=<?php echo $_GET['pid']; ?>">Iframes must be enabled to view this area.</iframe>

	</div>
<!-- SLEEP LAB SECTION END -->




<!-- FOLLOW UP SECTION START -->

<div style="height:20px;"></div>

<table width="97%" align="center">
<tr>
<td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;" colspan="15">
Subjective Findings:
</td>
</tr>
</table>


<!--
	hideshow2section2
	The wrapper div keeps everything in a scrollable area
-->	

<style>
	#hideshow2section2 input 	{ width:20px; }
	.followup-datatable			{ margin: 0; padding: 0; border: 0; }
	.followup-datatable tr 		{ height: 25px; }
	.followup-datatable tr td 	{ padding: 0 4px; }
	
	.followup-keytable 			{ margin: 0; padding: 0; border: 0; }
	.followup-keytable tr 		{ height: 25px; }
	.followup-keytable tr td 	{ text-align: right; padding-right: 4px; font-weight: normal; }
	
	
</style>
	
<div id="hideshow2section2" style="width: 97%; margin: 0 auto; display: table;">
	<!--The sumadd script generates divs and tabular data from a db-->
	<?php include("dss_summADD.php"); ?>

</div>

<!--end hideshow2section2 wrapper div-->

  
</form>
</div>

</table>
</div>
<!--</form>-->
<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>

<? include 'includes/bottom.htm';?>
