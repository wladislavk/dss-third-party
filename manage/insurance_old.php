<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");

if($_POST['insurancesub'] == 1)
{
	$pica1 = $_POST['pica1'];
	$pica2 = $_POST['pica2'];
	$pica3 = $_POST['pica3'];
	$insurance_type = $_POST['insurance_type'];
	$insured_id_number = $_POST['insured_id_number'];
	$patient_firstname = $_POST['patient_firstname'];
	$patient_middle = $_POST['patient_middle'];
	$patient_dob = $_POST['patient_dob'];
	$patient_sex = $_POST['patient_sex'];
	$insured_firstname = $_POST['insured_firstname'];
	$insured_lastname = $_POST['insured_lastname'];
	$insured_middle = $_POST['insured_middle'];
	$patient_address = $_POST['patient_address'];
	$patient_relation_insured = $_POST['patient_relation_insured'];
	$insured_address = $_POST['insured_address'];
	$patient_city = $_POST['patient_city'];
	$patient_state = $_POST['patient_state'];
	$patient_status = $_POST['patient_status'];
	$insured_city = $_POST['insured_city'];
	$insured_state = $_POST['insured_state'];
	$patient_zip = $_POST['patient_zip'];
	$patient_phone_code = $_POST['patient_phone_code'];
	$patient_phone = $_POST['patient_phone'];
	$insured_zip = $_POST['insured_zip'];
	$insured_phone_code = $_POST['insured_phone_code'];
	$insured_phone = $_POST['insured_phone'];
	$other_insured_firstname = $_POST['other_insured_firstname'];
	$other_insured_lastname = $_POST['other_insured_lastname'];
	$other_insured_middle = $_POST['other_insured_middle'];
	$employment = $_POST['employment'];
	$auto_accident = $_POST['auto_accident'];
	$auto_accident_place = $_POST['auto_accident_place'];
	$other_accident = $_POST['other_accident'];
	$insured_policy_group_feca = $_POST['insured_policy_group_feca'];
	$other_insured_policy_group_feca = $_POST['other_insured_policy_group_feca'];
	$insured_dob = $_POST['insured_dob'];
	$insured_sex = $_POST['insured_sex'];
	$other_insured_dob = $_POST['other_insured_dob'];
	$other_insured_sex = $_POST['other_insured_sex'];
	$insured_employer_school_name = $_POST['insured_employer_school_name'];
	$other_insured_employer_school_name = $_POST['other_insured_employer_school_name'];
	$insured_insurance_plan = $_POST['insured_insurance_plan'];
	$other_insured_insurance_plan = $_POST['other_insured_insurance_plan'];
	$reserved_local_use = $_POST['reserved_local_use'];
	$another_plan = $_POST['another_plan'];
	$patient_signature = $_POST['patient_signature'];
	$patient_signed_date = $_POST['patient_signed_date'];
	$insured_signature = $_POST['insured_signature'];
	$date_current = $_POST['date_current'];
	$date_same_illness = $_POST['date_same_illness'];
	$unable_date_from = $_POST['unable_date_from'];
	$unable_date_to = $_POST['unable_date_to'];
	$referring_provider = $_POST['referring_provider'];
	$field_17a_dd = $_POST['field_17a_dd'];
	$field_17a = $_POST['field_17a'];
	$field_17b = $_POST['field_17b'];
	$hospitalization_date_from = $_POST['hospitalization_date_from'];
	$hospitalization_date_to = $_POST['hospitalization_date_to'];
	$reserved_local_use1 = $_POST['reserved_local_use1'];
	$outside_lab = $_POST['outside_lab'];
	$s_charges = $_POST['s_charges'];
	$diagnosis_1 = $_POST['diagnosis_1'];
	$diagnosis_2 = $_POST['diagnosis_2'];
	$diagnosis_3 = $_POST['diagnosis_3'];
	$diagnosis_4 = $_POST['diagnosis_4'];
	$medicaid_resubmission_code = $_POST['medicaid_resubmission_code'];
	$original_ref_no = $_POST['original_ref_no'];
	$prior_authorization_number = $_POST['prior_authorization_number'];
	$service_date1_from = $_POST['service_date1_from'];
	$service_date1_to = $_POST['service_date1_to'];
	$place_of_service1 = $_POST['place_of_service1'];
	$emg1 = $_POST['emg1'];
	$cpt_hcpcs1 = $_POST['cpt_hcpcs1'];
	$modifier1_1 = $_POST['modifier1_1'];
	$modifier1_2 = $_POST['modifier1_2'];
	$modifier1_3 = $_POST['modifier1_3'];
	$modifier1_4 = $_POST['modifier1_4'];
	$diagnosis_pointer1 = $_POST['diagnosis_pointer1'];
	$s_charges1_1 = $_POST['s_charges1_1'];
	$s_charges1_2 = $_POST['s_charges1_2'];
	$days_or_units1 = $_POST['days_or_units1'];
	$epsdt_family_plan1 = $_POST['epsdt_family_plan1'];
	$id_qua1 = $_POST['id_qua1'];
	$rendering_provider_id1 = $_POST['rendering_provider_id1'];
	$service_date2_from = $_POST['service_date2_from'];
	$service_date2_to = $_POST['service_date2_to'];
	$place_of_service2 = $_POST['place_of_service2'];
	$emg2 = $_POST['emg2'];
	$cpt_hcpcs2 = $_POST['cpt_hcpcs2'];
	$modifier2_1 = $_POST['modifier2_1'];
	$modifier2_2 = $_POST['modifier2_2'];
	$modifier2_3 = $_POST['modifier2_3'];
	$modifier2_4 = $_POST['modifier2_4'];
	$diagnosis_pointer2 = $_POST['diagnosis_pointer2'];
	$s_charges2_1 = $_POST['s_charges2_1'];
	$s_charges2_2 = $_POST['s_charges2_2'];
	$days_or_units2 = $_POST['days_or_units2'];
	$epsdt_family_plan2 = $_POST['epsdt_family_plan2'];
	$id_qua2 = $_POST['id_qua2'];
	$rendering_provider_id2 = $_POST['rendering_provider_id2'];
	$service_date3_from = $_POST['service_date3_from'];
	$service_date3_to = $_POST['service_date3_to'];
	$place_of_service3 = $_POST['place_of_service3'];
	$emg3 = $_POST['emg3'];
	$cpt_hcpcs3 = $_POST['cpt_hcpcs3'];
	$modifier3_1 = $_POST['modifier3_1'];
	$modifier3_2 = $_POST['modifier3_2'];
	$modifier3_3 = $_POST['modifier3_3'];
	$modifier3_4 = $_POST['modifier3_4'];
	$diagnosis_pointer3 = $_POST['diagnosis_pointer3'];
	$s_charges3_1 = $_POST['s_charges3_1'];
	$s_charges3_2 = $_POST['s_charges3_2'];
	$days_or_units3 = $_POST['days_or_units3'];
	$epsdt_family_plan3 = $_POST['epsdt_family_plan3'];
	$id_qua3 = $_POST['id_qua3'];
	$rendering_provider_id3 = $_POST['rendering_provider_id3'];
	$service_date4_from = $_POST['service_date4_from'];
	$service_date4_to = $_POST['service_date4_to'];
	$place_of_service4 = $_POST['place_of_service4'];
	$emg4 = $_POST['emg4'];
	$cpt_hcpcs1 = $_POST['cpt_hcpcs4'];
	$modifier4_1 = $_POST['modifier4_1'];
	$modifier4_2 = $_POST['modifier4_2'];
	$modifier4_3 = $_POST['modifier4_3'];
	$modifier4_4 = $_POST['modifier4_4'];
	$diagnosis_pointer4 = $_POST['diagnosis_pointer4'];
	$s_charges4_1 = $_POST['s_charges4_1'];
	$s_charges4_2 = $_POST['s_charges4_2'];
	$days_or_units4 = $_POST['days_or_units4'];
	$epsdt_family_plan4 = $_POST['epsdt_family_plan4'];
	$id_qua4 = $_POST['id_qua4'];
	$rendering_provider_id4 = $_POST['rendering_provider_id4'];
	$service_date5_from = $_POST['service_date5_from'];
	$service_date5_to = $_POST['service_date5_to'];
	$place_of_service5 = $_POST['place_of_service5'];
	$emg5 = $_POST['emg5'];
	$cpt_hcpcs5 = $_POST['cpt_hcpcs5'];
	$modifier5_1 = $_POST['modifier5_1'];
	$modifier5_2 = $_POST['modifier5_2'];
	$modifier5_3 = $_POST['modifier5_3'];
	$modifier5_4 = $_POST['modifier5_4'];
	$diagnosis_pointer5 = $_POST['diagnosis_pointer5'];
	$s_charges5_1 = $_POST['s_charges5_1'];
	$s_charges5_2 = $_POST['s_charges5_2'];
	$days_or_units5 = $_POST['days_or_units5'];
	$epsdt_family_plan5 = $_POST['epsdt_family_plan5'];
	$id_qua5 = $_POST['id_qua5'];
	$rendering_provider_id5 = $_POST['rendering_provider_id5'];
	$service_date6_from = $_POST['service_date6_from'];
	$service_date6_to = $_POST['service_date6_to'];
	$place_of_service6 = $_POST['place_of_service6'];
	$emg6 = $_POST['emg6'];
	$cpt_hcpcs6 = $_POST['cpt_hcpcs6'];
	$modifier6_1 = $_POST['modifier6_1'];
	$modifier6_2 = $_POST['modifier6_2'];
	$modifier6_3 = $_POST['modifier6_3'];
	$modifier6_4 = $_POST['modifier6_4'];
	$diagnosis_pointer6 = $_POST['diagnosis_pointer6'];
	$s_charges6_1 = $_POST['s_charges6_1'];
	$s_charges6_2 = $_POST['s_charges6_2'];
	$days_or_units6 = $_POST['days_or_units6'];
	$epsdt_family_plan6 = $_POST['epsdt_family_plan6'];
	$id_qua6 = $_POST['id_qua6'];
	$rendering_provider_id6 = $_POST['rendering_provider_id6'];
	$federal_tax_id_number = $_POST['federal_tax_id_number'];
	$ssn = $_POST['ssn'];
	$ein = $_POST['ein'];
	$patient_account_no = $_POST['patient_account_no'];
	$accept_assignment = $_POST['accept_assignment'];
	$total_charge = $_POST['total_charge'];
	$amount_paid = $_POST['amount_paid'];
	$balance_due = $_POST['balance_due'];
	$signature_physician = $_POST['signature_physician'];
	$physician_signed_date = $_POST['physician_signed_date'];
	$service_facility_info_name = $_POST['service_facility_info_name'];
	$service_facility_info_address = $_POST['service_facility_info_address'];
	$service_facility_info_city = $_POST['service_facility_info_city'];
	$service_info_a = $_POST['service_info_a'];
	$service_info_dd = $_POST['service_info_dd'];
	$service_info_b_other = $_POST['service_info_b_other'];
	$billing_provider_phone_code = $_POST['billing_provider_phone_code'];
	$billing_provider_phone = $_POST['billing_provider_phone'];
	$billing_provider_name = $_POST['billing_provider_name'];
	$billing_provider_address = $_POST['billing_provider_address'];
	$billing_provider_city = $_POST['billing_provider_city'];
	$billing_provider_a = $_POST['billing_provider_a'];
	$billing_provider_dd = $_POST['billing_provider_dd'];
	$billing_provider_b_other = $_POST['billing_provider_b_other'];
	
	$insurance_type_arr = '';
	if(is_array($insurance_type))
	{
		foreach($insurance_type as $val)
		{
			if(trim($val) <> '')
				$insurance_type_arr .= trim($val).'~';
		}
	}
	
	if($insurance_type_arr != '')
		$insurance_type_arr = '~'.$insurance_type_arr;
		
	
	$patient_status_arr = '';
	if(is_array($patient_status))
	{
		foreach($patient_status as $val)
		{
			if(trim($val) <> '')
				$patient_status_arr .= trim($val).'~';
		}
	}
	
	if($patient_status_arr != '')
		$patient_status_arr = '~'.$patient_status_arr;
		
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_insurance set 
		patientid = '".s_for($_GET['pid'])."',
		pica1 = '".s_for($pica1)."',
		pica2 = '".s_for($pica2)."',
		pica3 = '".s_for($pica3)."',
		insurance_type = '".s_for($insurance_type_arr)."',
		insured_id_number = '".s_for($insured_id_number)."',
		patient_firstname = '".s_for($patient_firstname)."',
		patient_middle = '".s_for($patient_middle)."',
		patient_dob = '".s_for($patient_dob)."',
		patient_sex = '".s_for($patient_sex)."',
		insured_firstname = '".s_for($insured_firstname)."',
		insured_lastname = '".s_for($insured_lastname)."',
		insured_middle = '".s_for($insured_middle)."',
		patient_address = '".s_for($patient_address)."',
		patient_relation_insured = '".s_for($patient_relation_insured)."',
		insured_address = '".s_for($insured_address)."',
		patient_city = '".s_for($patient_city)."',
		patient_state = '".s_for($patient_state)."',
		patient_status = '".s_for($patient_status_arr)."',
		insured_city = '".s_for($insured_city)."',
		insured_state = '".s_for($insured_state)."',
		patient_zip = '".s_for($patient_zip)."',
		patient_phone_code = '".s_for($patient_phone_code)."',
		patient_phone = '".s_for($patient_phone)."',
		insured_zip = '".s_for($insured_zip)."',
		insured_phone_code = '".s_for($insured_phone_code)."',
		insured_phone = '".s_for($insured_phone)."',
		other_insured_firstname = '".s_for($other_insured_firstname)."',
		other_insured_lastname = '".s_for($other_insured_lastname)."',
		other_insured_middle = '".s_for($other_insured_middle)."',
		employment = '".s_for($employment)."',
		auto_accident = '".s_for($auto_accident)."',
		auto_accident_place = '".s_for($auto_accident_place)."',
		other_accident = '".s_for($other_accident)."',
		insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
		other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
		insured_dob = '".s_for($insured_dob)."',
		insured_sex = '".s_for($insured_sex)."',
		other_insured_dob = '".s_for($other_insured_dob)."',
		other_insured_sex = '".s_for($other_insured_sex)."',
		insured_employer_school_name = '".s_for($insured_employer_school_name)."',
		other_insured_employer_school_name = '".s_for($other_insured_employer_school_name)."',
		insured_insurance_plan = '".s_for($insured_insurance_plan)."',
		other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
		reserved_local_use = '".s_for($reserved_local_use)."',
		another_plan = '".s_for($another_plan)."',
		patient_signature = '".s_for($patient_signature)."',
		patient_signed_date = '".s_for($patient_signed_date)."',
		insured_signature = '".s_for($insured_signature)."',
		date_current = '".s_for($date_current)."',
		date_same_illness = '".s_for($date_same_illness)."',
		unable_date_from = '".s_for($unable_date_from)."',
		unable_date_to = '".s_for($unable_date_to)."',
		referring_provider = '".s_for($referring_provider)."',
		field_17a_dd = '".s_for($field_17a_dd)."',
		field_17a = '".s_for($field_17a)."',
		field_17b = '".s_for($field_17b)."',
		hospitalization_date_from = '".s_for($hospitalization_date_from)."',
		hospitalization_date_to = '".s_for($hospitalization_date_to)."',
		reserved_local_use1 = '".s_for($reserved_local_use1)."',
		outside_lab = '".s_for($outside_lab)."',
		s_charges = '".s_for($s_charges)."',
		diagnosis_1 = '".s_for($diagnosis_1)."',
		diagnosis_2 = '".s_for($diagnosis_2)."',
		diagnosis_3 = '".s_for($diagnosis_3)."',
		diagnosis_4 = '".s_for($diagnosis_4)."',
		medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
		original_ref_no = '".s_for($original_ref_no)."',
		prior_authorization_number = '".s_for($prior_authorization_number)."',
		service_date1_from = '".s_for($service_date1_from)."',
		service_date1_to = '".s_for($service_date1_to)."',
		place_of_service1 = '".s_for($place_of_service1)."',
		emg1 = '".s_for($emg1)."',
		cpt_hcpcs1 = '".s_for($cpt_hcpcs1)."',
		modifier1_1 = '".s_for($modifier1_1)."',
		modifier1_2 = '".s_for($modifier1_2)."',
		modifier1_3 = '".s_for($modifier1_3)."',
		modifier1_4 = '".s_for($modifier1_4)."',
		diagnosis_pointer1 = '".s_for($diagnosis_pointer1)."',
		s_charges1_1 = '".s_for($s_charges1_1)."',
		s_charges1_2 = '".s_for($s_charges1_2)."',
		days_or_units1 = '".s_for($days_or_units1)."',
		epsdt_family_plan1 = '".s_for($epsdt_family_plan1)."',
		id_qua1 = '".s_for($id_qua1)."',
		rendering_provider_id1 = '".s_for($rendering_provider_id1)."',
		service_date2_from = '".s_for($service_date2_from)."',
		service_date2_to = '".s_for($service_date2_to)."',
		place_of_service2 = '".s_for($place_of_service2)."',
		emg2 = '".s_for($emg2)."',
		cpt_hcpcs2 = '".s_for($cpt_hcpcs2)."',
		modifier2_1 = '".s_for($modifier2_1)."',
		modifier2_2 = '".s_for($modifier2_2)."',
		modifier2_3 = '".s_for($modifier2_3)."',
		modifier2_4 = '".s_for($modifier2_4)."',
		diagnosis_pointer2 = '".s_for($diagnosis_pointer2)."',
		s_charges2_1 = '".s_for($s_charges2_1)."',
		s_charges2_2 = '".s_for($s_charges2_2)."',
		days_or_units2 = '".s_for($days_or_units2)."',
		epsdt_family_plan2 = '".s_for($epsdt_family_plan2)."',
		id_qua2 = '".s_for($id_qua2)."',
		rendering_provider_id2 = '".s_for($rendering_provider_id2)."',
		service_date3_from = '".s_for($service_date3_from)."',
		service_date3_to = '".s_for($service_date3_to)."',
		place_of_service3 = '".s_for($place_of_service3)."',
		emg3 = '".s_for($emg3)."',
		cpt_hcpcs3 = '".s_for($cpt_hcpcs3)."',
		modifier3_1 = '".s_for($modifier3_1)."',
		modifier3_2 = '".s_for($modifier3_2)."',
		modifier3_3 = '".s_for($modifier3_3)."',
		modifier3_4 = '".s_for($modifier3_4)."',
		diagnosis_pointer3 = '".s_for($diagnosis_pointer3)."',
		s_charges3_1 = '".s_for($s_charges3_1)."',
		s_charges3_2 = '".s_for($s_charges3_2)."',
		days_or_units3 = '".s_for($days_or_units3)."',
		epsdt_family_plan3 = '".s_for($epsdt_family_plan3)."',
		id_qua3 = '".s_for($id_qua3)."',
		rendering_provider_id3 = '".s_for($rendering_provider_id3)."',
		service_date4_from = '".s_for($service_date4_from)."',
		service_date4_to = '".s_for($service_date4_to)."',
		place_of_service4 = '".s_for($place_of_service4)."',
		emg4 = '".s_for($emg4)."',
		cpt_hcpcs1 = '".s_for($cpt_hcpcs4)."',
		modifier4_1 = '".s_for($modifier4_1)."',
		modifier4_2 = '".s_for($modifier4_2)."',
		modifier4_3 = '".s_for($modifier4_3)."',
		modifier4_4 = '".s_for($modifier4_4)."',
		diagnosis_pointer4 = '".s_for($diagnosis_pointer4)."',
		s_charges4_1 = '".s_for($s_charges4_1)."',
		s_charges4_2 = '".s_for($s_charges4_2)."',
		days_or_units4 = '".s_for($days_or_units4)."',
		epsdt_family_plan4 = '".s_for($epsdt_family_plan4)."',
		id_qua4 = '".s_for($id_qua4)."',
		rendering_provider_id4 = '".s_for($rendering_provider_id4)."',
		service_date5_from = '".s_for($service_date5_from)."',
		service_date5_to = '".s_for($service_date5_to)."',
		place_of_service5 = '".s_for($place_of_service5)."',
		emg5 = '".s_for($emg5)."',
		cpt_hcpcs5 = '".s_for($cpt_hcpcs5)."',
		modifier5_1 = '".s_for($modifier5_1)."',
		modifier5_2 = '".s_for($modifier5_2)."',
		modifier5_3 = '".s_for($modifier5_3)."',
		modifier5_4 = '".s_for($modifier5_4)."',
		diagnosis_pointer5 = '".s_for($diagnosis_pointer5)."',
		s_charges5_1 = '".s_for($s_charges5_1)."',
		s_charges5_2 = '".s_for($s_charges5_2)."',
		days_or_units5 = '".s_for($days_or_units5)."',
		epsdt_family_plan5 = '".s_for($epsdt_family_plan5)."',
		id_qua5 = '".s_for($id_qua5)."',
		rendering_provider_id5 = '".s_for($rendering_provider_id5)."',
		service_date6_from = '".s_for($service_date6_from)."',
		service_date6_to = '".s_for($service_date6_to)."',
		place_of_service6 = '".s_for($place_of_service6)."',
		emg6 = '".s_for($emg6)."',
		cpt_hcpcs6 = '".s_for($cpt_hcpcs6)."',
		modifier6_1 = '".s_for($modifier6_1)."',
		modifier6_2 = '".s_for($modifier6_2)."',
		modifier6_3 = '".s_for($modifier6_3)."',
		modifier6_4 = '".s_for($modifier6_4)."',
		diagnosis_pointer6 = '".s_for($diagnosis_pointer6)."',
		s_charges6_1 = '".s_for($s_charges6_1)."',
		s_charges6_2 = '".s_for($s_charges6_2)."',
		days_or_units6 = '".s_for($days_or_units6)."',
		epsdt_family_plan6 = '".s_for($epsdt_family_plan6)."',
		id_qua6 = '".s_for($id_qua6)."',
		rendering_provider_id6 = '".s_for($rendering_provider_id6)."',
		federal_tax_id_number = '".s_for($federal_tax_id_number)."',
		ssn = '".s_for($ssn)."',
		ein = '".s_for($ein)."',
		patient_account_no = '".s_for($patient_account_no)."',
		accept_assignment = '".s_for($accept_assignment)."',
		total_charge = '".s_for($total_charge)."',
		amount_paid = '".s_for($amount_paid)."',
		balance_due = '".s_for($balance_due)."',
		signature_physician = '".s_for($signature_physician)."',
		physician_signed_date = '".s_for($physician_signed_date)."',
		service_facility_info_name = '".s_for($service_facility_info_name)."',
		service_facility_info_address = '".s_for($service_facility_info_address)."',
		service_facility_info_city = '".s_for($service_facility_info_city)."',
		service_info_a = '".s_for($service_info_a)."',
		service_info_dd = '".s_for($service_info_dd)."',
		service_info_b_other = '".s_for($service_info_b_other)."',
		billing_provider_phone_code = '".s_for($billing_provider_phone_code)."',
		billing_provider_phone = '".s_for($billing_provider_phone)."',
		billing_provider_name = '".s_for($billing_provider_name)."',
		billing_provider_address = '".s_for($billing_provider_address)."',
		billing_provider_city = '".s_for($billing_provider_city)."',
		billing_provider_a = '".s_for($billing_provider_a)."',
		billing_provider_dd = '".s_for($billing_provider_dd)."',
		billing_provider_b_other = '".s_for($billing_provider_b_other)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='manage_insurance.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_insurance set 
		pica2 = '".s_for($pica2)."',
		pica3 = '".s_for($pica3)."',
		insurance_type = '".s_for($insurance_type)."',
		insured_id_number = '".s_for($insured_id_number)."',
		patient_firstname = '".s_for($patient_firstname)."',
		patient_middle = '".s_for($patient_middle)."',
		patient_dob = '".s_for($patient_dob)."',
		patient_sex = '".s_for($patient_sex)."',
		insured_firstname = '".s_for($insured_firstname)."',
		insured_lastname = '".s_for($insured_lastname)."',
		insured_middle = '".s_for($insured_middle)."',
		patient_address = '".s_for($patient_address)."',
		patient_relation_insured = '".s_for($patient_relation_insured)."',
		insured_address = '".s_for($insured_address)."',
		patient_city = '".s_for($patient_city)."',
		patient_state = '".s_for($patient_state)."',
		patient_status = '".s_for($patient_status_arr)."',
		insured_city = '".s_for($insured_city)."',
		insured_state = '".s_for($insured_state)."',
		patient_zip = '".s_for($patient_zip)."',
		patient_phone_code = '".s_for($patient_phone_code)."',
		patient_phone = '".s_for($patient_phone)."',
		insured_zip = '".s_for($insured_zip)."',
		insured_phone_code = '".s_for($insured_phone_code)."',
		insured_phone = '".s_for($insured_phone)."',
		other_insured_firstname = '".s_for($other_insured_firstname)."',
		other_insured_lastname = '".s_for($other_insured_lastname)."',
		other_insured_middle = '".s_for($other_insured_middle)."',
		employment = '".s_for($employment)."',
		auto_accident = '".s_for($auto_accident)."',
		auto_accident_place = '".s_for($auto_accident_place)."',
		other_accident = '".s_for($other_accident)."',
		insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
		other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
		insured_dob = '".s_for($insured_dob)."',
		insured_sex = '".s_for($insured_sex)."',
		other_insured_dob = '".s_for($other_insured_dob)."',
		other_insured_sex = '".s_for($other_insured_sex)."',
		insured_employer_school_name = '".s_for($insured_employer_school_name)."',
		other_insured_employer_school_name = '".s_for($other_insured_employer_school_name)."',
		insured_insurance_plan = '".s_for($insured_insurance_plan)."',
		other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
		reserved_local_use = '".s_for($reserved_local_use)."',
		another_plan = '".s_for($another_plan)."',
		patient_signature = '".s_for($patient_signature)."',
		patient_signed_date = '".s_for($patient_signed_date)."',
		insured_signature = '".s_for($insured_signature)."',
		date_current = '".s_for($date_current)."',
		date_same_illness = '".s_for($date_same_illness)."',
		unable_date_from = '".s_for($unable_date_from)."',
		unable_date_to = '".s_for($unable_date_to)."',
		referring_provider = '".s_for($referring_provider)."',
		field_17a_dd = '".s_for($field_17a_dd)."',
		field_17a = '".s_for($field_17a)."',
		field_17b = '".s_for($field_17b)."',
		hospitalization_date_from = '".s_for($hospitalization_date_from)."',
		hospitalization_date_to = '".s_for($hospitalization_date_to)."',
		reserved_local_use1 = '".s_for($reserved_local_use1)."',
		outside_lab = '".s_for($outside_lab)."',
		s_charges = '".s_for($s_charges)."',
		diagnosis_1 = '".s_for($diagnosis_1)."',
		diagnosis_2 = '".s_for($diagnosis_2)."',
		diagnosis_3 = '".s_for($diagnosis_3)."',
		diagnosis_4 = '".s_for($diagnosis_4)."',
		medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
		original_ref_no = '".s_for($original_ref_no)."',
		prior_authorization_number = '".s_for($prior_authorization_number)."',
		service_date1_from = '".s_for($service_date1_from)."',
		service_date1_to = '".s_for($service_date1_to)."',
		place_of_service1 = '".s_for($place_of_service1)."',
		emg1 = '".s_for($emg1)."',
		cpt_hcpcs1 = '".s_for($cpt_hcpcs1)."',
		modifier1_1 = '".s_for($modifier1_1)."',
		modifier1_2 = '".s_for($modifier1_2)."',
		modifier1_3 = '".s_for($modifier1_3)."',
		modifier1_4 = '".s_for($modifier1_4)."',
		diagnosis_pointer1 = '".s_for($diagnosis_pointer1)."',
		s_charges1_1 = '".s_for($s_charges1_1)."',
		s_charges1_2 = '".s_for($s_charges1_2)."',
		days_or_units1 = '".s_for($days_or_units1)."',
		epsdt_family_plan1 = '".s_for($epsdt_family_plan1)."',
		id_qua1 = '".s_for($id_qua1)."',
		rendering_provider_id1 = '".s_for($rendering_provider_id1)."',
		service_date2_from = '".s_for($service_date2_from)."',
		service_date2_to = '".s_for($service_date2_to)."',
		place_of_service2 = '".s_for($place_of_service2)."',
		emg2 = '".s_for($emg2)."',
		cpt_hcpcs2 = '".s_for($cpt_hcpcs2)."',
		modifier2_1 = '".s_for($modifier2_1)."',
		modifier2_2 = '".s_for($modifier2_2)."',
		modifier2_3 = '".s_for($modifier2_3)."',
		modifier2_4 = '".s_for($modifier2_4)."',
		diagnosis_pointer2 = '".s_for($diagnosis_pointer2)."',
		s_charges2_1 = '".s_for($s_charges2_1)."',
		s_charges2_2 = '".s_for($s_charges2_2)."',
		days_or_units2 = '".s_for($days_or_units2)."',
		epsdt_family_plan2 = '".s_for($epsdt_family_plan2)."',
		id_qua2 = '".s_for($id_qua2)."',
		rendering_provider_id2 = '".s_for($rendering_provider_id2)."',
		service_date3_from = '".s_for($service_date3_from)."',
		service_date3_to = '".s_for($service_date3_to)."',
		place_of_service3 = '".s_for($place_of_service3)."',
		emg3 = '".s_for($emg3)."',
		cpt_hcpcs3 = '".s_for($cpt_hcpcs3)."',
		modifier3_1 = '".s_for($modifier3_1)."',
		modifier3_2 = '".s_for($modifier3_2)."',
		modifier3_3 = '".s_for($modifier3_3)."',
		modifier3_4 = '".s_for($modifier3_4)."',
		diagnosis_pointer3 = '".s_for($diagnosis_pointer3)."',
		s_charges3_1 = '".s_for($s_charges3_1)."',
		s_charges3_2 = '".s_for($s_charges3_2)."',
		days_or_units3 = '".s_for($days_or_units3)."',
		epsdt_family_plan3 = '".s_for($epsdt_family_plan3)."',
		id_qua3 = '".s_for($id_qua3)."',
		rendering_provider_id3 = '".s_for($rendering_provider_id3)."',
		service_date4_from = '".s_for($service_date4_from)."',
		service_date4_to = '".s_for($service_date4_to)."',
		place_of_service4 = '".s_for($place_of_service4)."',
		emg4 = '".s_for($emg4)."',
		cpt_hcpcs1 = '".s_for($cpt_hcpcs4)."',
		modifier4_1 = '".s_for($modifier4_1)."',
		modifier4_2 = '".s_for($modifier4_2)."',
		modifier4_3 = '".s_for($modifier4_3)."',
		modifier4_4 = '".s_for($modifier4_4)."',
		diagnosis_pointer4 = '".s_for($diagnosis_pointer4)."',
		s_charges4_1 = '".s_for($s_charges4_1)."',
		s_charges4_2 = '".s_for($s_charges4_2)."',
		days_or_units4 = '".s_for($days_or_units4)."',
		epsdt_family_plan4 = '".s_for($epsdt_family_plan4)."',
		id_qua4 = '".s_for($id_qua4)."',
		rendering_provider_id4 = '".s_for($rendering_provider_id4)."',
		service_date5_from = '".s_for($service_date5_from)."',
		service_date5_to = '".s_for($service_date5_to)."',
		place_of_service5 = '".s_for($place_of_service5)."',
		emg5 = '".s_for($emg5)."',
		cpt_hcpcs5 = '".s_for($cpt_hcpcs5)."',
		modifier5_1 = '".s_for($modifier5_1)."',
		modifier5_2 = '".s_for($modifier5_2)."',
		modifier5_3 = '".s_for($modifier5_3)."',
		modifier5_4 = '".s_for($modifier5_4)."',
		diagnosis_pointer5 = '".s_for($diagnosis_pointer5)."',
		s_charges5_1 = '".s_for($s_charges5_1)."',
		s_charges5_2 = '".s_for($s_charges5_2)."',
		days_or_units5 = '".s_for($days_or_units5)."',
		epsdt_family_plan5 = '".s_for($epsdt_family_plan5)."',
		id_qua5 = '".s_for($id_qua5)."',
		rendering_provider_id5 = '".s_for($rendering_provider_id5)."',
		service_date6_from = '".s_for($service_date6_from)."',
		service_date6_to = '".s_for($service_date6_to)."',
		place_of_service6 = '".s_for($place_of_service6)."',
		emg6 = '".s_for($emg6)."',
		cpt_hcpcs6 = '".s_for($cpt_hcpcs6)."',
		modifier6_1 = '".s_for($modifier6_1)."',
		modifier6_2 = '".s_for($modifier6_2)."',
		modifier6_3 = '".s_for($modifier6_3)."',
		modifier6_4 = '".s_for($modifier6_4)."',
		diagnosis_pointer6 = '".s_for($diagnosis_pointer6)."',
		s_charges6_1 = '".s_for($s_charges6_1)."',
		s_charges6_2 = '".s_for($s_charges6_2)."',
		days_or_units6 = '".s_for($days_or_units6)."',
		epsdt_family_plan6 = '".s_for($epsdt_family_plan6)."',
		id_qua6 = '".s_for($id_qua6)."',
		rendering_provider_id6 = '".s_for($rendering_provider_id6)."',
		federal_tax_id_number = '".s_for($federal_tax_id_number)."',
		ssn = '".s_for($ssn)."',
		ein = '".s_for($ein)."',
		patient_account_no = '".s_for($patient_account_no)."',
		accept_assignment = '".s_for($accept_assignment)."',
		total_charge = '".s_for($total_charge)."',
		amount_paid = '".s_for($amount_paid)."',
		balance_due = '".s_for($balance_due)."',
		signature_physician = '".s_for($signature_physician)."',
		physician_signed_date = '".s_for($physician_signed_date)."',
		service_facility_info_name = '".s_for($service_facility_info_name)."',
		service_facility_info_address = '".s_for($service_facility_info_address)."',
		service_facility_info_city = '".s_for($service_facility_info_city)."',
		service_info_a = '".s_for($service_info_a)."',
		service_info_dd = '".s_for($service_info_dd)."',
		service_info_b_other = '".s_for($service_info_b_other)."',
		billing_provider_phone_code = '".s_for($billing_provider_phone_code)."',
		billing_provider_phone = '".s_for($billing_provider_phone)."',
		billing_provider_name = '".s_for($billing_provider_name)."',
		billing_provider_address = '".s_for($billing_provider_address)."',
		billing_provider_city = '".s_for($billing_provider_city)."',
		billing_provider_a = '".s_for($billing_provider_a)."',
		billing_provider_dd = '".s_for($billing_provider_dd)."',
		billing_provider_b_other = '".s_for($billing_provider_b_other)."'
		where insuranceid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
		
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
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

$qua_sql = "select * from dental_qualifier where status=1 order by sortby";
$ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";


$sql = "select * from dental_insurance where insuranceid='".$_GET['insid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$insuranceid = st($myarray['insuranceid']);
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$insurance_type = st($myarray['insurance_type']);
$insured_id_number = st($myarray['insured_id_number']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
$insured_firstname = st($myarray['insured_firstname']);
$insured_lastname = st($myarray['insured_lastname']);
$insured_middle = st($myarray['insured_middle']);
$patient_address = st($myarray['patient_address']);
$patient_relation_insured = st($myarray['patient_relation_insured']);
$insured_address = st($myarray['insured_address']);
$patient_city = st($myarray['patient_city']);
$patient_state = st($myarray['patient_state']);
$patient_status = st($myarray['patient_status']);
$insured_city = st($myarray['insured_city']);
$insured_state = st($myarray['insured_state']);
$patient_zip = st($myarray['patient_zip']);
$patient_phone_code = st($myarray['patient_phone_code']);
$patient_phone = st($myarray['patient_phone']);
$insured_zip = st($myarray['insured_zip']);
$insured_phone_code = st($myarray['insured_phone_code']);
$insured_phone = st($myarray['insured_phone']);
$other_insured_firstname = st($myarray['other_insured_firstname']);
$other_insured_lastname = st($myarray['other_insured_lastname']);
$other_insured_middle = st($myarray['other_insured_middle']);
$employment = st($myarray['employment']);
$auto_accident = st($myarray['auto_accident']);
$auto_accident_place = st($myarray['auto_accident_place']);
$other_accident = st($myarray['other_accident']);
$insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
$other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
$insured_dob = st($myarray['insured_dob']);
$insured_sex = st($myarray['insured_sex']);
$other_insured_dob = st($myarray['other_insured_dob']);
$other_insured_sex = st($myarray['other_insured_sex']);
$insured_employer_school_name = st($myarray['insured_employer_school_name']);
$other_insured_employer_school_name = st($myarray['other_insured_employer_school_name']);
$insured_insurance_plan = st($myarray['insured_insurance_plan']);
$other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
$reserved_local_use = st($myarray['reserved_local_use']);
$another_plan = st($myarray['another_plan']);
$patient_signature = st($myarray['patient_signature']);
$patient_signed_date = st($myarray['patient_signed_date']);
$insured_signature = st($myarray['insured_signature']);
$date_current = st($myarray['date_current']);
$date_same_illness = st($myarray['date_same_illness']);
$unable_date_from = st($myarray['unable_date_from']);
$unable_date_to = st($myarray['unable_date_to']);
$referring_provider = st($myarray['referring_provider']);
$field_17a_dd = st($myarray['field_17a_dd']);
$field_17a = st($myarray['field_17a']);
$field_17b = st($myarray['field_17b']);
$hospitalization_date_from = st($myarray['hospitalization_date_from']);
$hospitalization_date_to = st($myarray['hospitalization_date_to']);
$reserved_local_use1 = st($myarray['reserved_local_use1']);
$outside_lab = st($myarray['outside_lab']);
$s_charges = st($myarray['s_charges']);
$diagnosis_1 = st($myarray['diagnosis_1']);
$diagnosis_2 = st($myarray['diagnosis_2']);
$diagnosis_3 = st($myarray['diagnosis_3']);
$diagnosis_4 = st($myarray['diagnosis_4']);
$medicaid_resubmission_code = st($myarray['medicaid_resubmission_code']);
$original_ref_no = st($myarray['original_ref_no']);
$prior_authorization_number = st($myarray['prior_authorization_number']);
$service_date1_from = st($myarray['service_date1_from']);
$service_date1_to = st($myarray['service_date1_to']);
$place_of_service1 = st($myarray['place_of_service1']);
$emg1 = st($myarray['emg1']);
$cpt_hcpcs1 = st($myarray['cpt_hcpcs1']);
$modifier1_1 = st($myarray['modifier1_1']);
$modifier1_2 = st($myarray['modifier1_2']);
$modifier1_3 = st($myarray['modifier1_3']);
$modifier1_4 = st($myarray['modifier1_4']);
$diagnosis_pointer1 = st($myarray['diagnosis_pointer1']);
$s_charges1_1 = st($myarray['s_charges1_1']);
$s_charges1_2 = st($myarray['s_charges1_2']);
$days_or_units1 = st($myarray['days_or_units1']);
$epsdt_family_plan1 = st($myarray['epsdt_family_plan1']);
$id_qua1 = st($myarray['id_qua1']);
$rendering_provider_id1 = st($myarray['rendering_provider_id1']);
$service_date2_from = st($myarray['service_date2_from']);
$service_date2_to = st($myarray['service_date2_to']);
$place_of_service2 = st($myarray['place_of_service2']);
$emg2 = st($myarray['emg2']);
$cpt_hcpcs2 = st($myarray['cpt_hcpcs2']);
$modifier2_1 = st($myarray['modifier2_1']);
$modifier2_2 = st($myarray['modifier2_2']);
$modifier2_3 = st($myarray['modifier2_3']);
$modifier2_4 = st($myarray['modifier2_4']);
$diagnosis_pointer2 = st($myarray['diagnosis_pointer2']);
$s_charges2_1 = st($myarray['s_charges2_1']);
$s_charges2_2 = st($myarray['s_charges2_2']);
$days_or_units2 = st($myarray['days_or_units2']);
$epsdt_family_plan2 = st($myarray['epsdt_family_plan2']);
$id_qua2 = st($myarray['id_qua2']);
$rendering_provider_id2 = st($myarray['rendering_provider_id2']);
$service_date3_from = st($myarray['service_date3_from']);
$service_date3_to = st($myarray['service_date3_to']);
$place_of_service3 = st($myarray['place_of_service3']);
$emg3 = st($myarray['emg3']);
$cpt_hcpcs3 = st($myarray['cpt_hcpcs3']);
$modifier3_1 = st($myarray['modifier3_1']);
$modifier3_2 = st($myarray['modifier3_2']);
$modifier3_3 = st($myarray['modifier3_3']);
$modifier3_4 = st($myarray['modifier3_4']);
$diagnosis_pointer3 = st($myarray['diagnosis_pointer3']);
$s_charges3_1 = st($myarray['s_charges3_1']);
$s_charges3_2 = st($myarray['s_charges3_2']);
$days_or_units3 = st($myarray['days_or_units3']);
$epsdt_family_plan3 = st($myarray['epsdt_family_plan3']);
$id_qua3 = st($myarray['id_qua3']);
$rendering_provider_id3 = st($myarray['rendering_provider_id3']);
$service_date4_from = st($myarray['service_date4_from']);
$service_date4_to = st($myarray['service_date4_to']);
$place_of_service4 = st($myarray['place_of_service4']);
$emg4 = st($myarray['emg4']);
$cpt_hcpcs1 = st($myarray['cpt_hcpcs4']);
$modifier4_1 = st($myarray['modifier4_1']);
$modifier4_2 = st($myarray['modifier4_2']);
$modifier4_3 = st($myarray['modifier4_3']);
$modifier4_4 = st($myarray['modifier4_4']);
$diagnosis_pointer4 = st($myarray['diagnosis_pointer4']);
$s_charges4_1 = st($myarray['s_charges4_1']);
$s_charges4_2 = st($myarray['s_charges4_2']);
$days_or_units4 = st($myarray['days_or_units4']);
$epsdt_family_plan4 = st($myarray['epsdt_family_plan4']);
$id_qua4 = st($myarray['id_qua4']);
$rendering_provider_id4 = st($myarray['rendering_provider_id4']);
$service_date5_from = st($myarray['service_date5_from']);
$service_date5_to = st($myarray['service_date5_to']);
$place_of_service5 = st($myarray['place_of_service5']);
$emg5 = st($myarray['emg5']);
$cpt_hcpcs5 = st($myarray['cpt_hcpcs5']);
$modifier5_1 = st($myarray['modifier5_1']);
$modifier5_2 = st($myarray['modifier5_2']);
$modifier5_3 = st($myarray['modifier5_3']);
$modifier5_4 = st($myarray['modifier5_4']);
$diagnosis_pointer5 = st($myarray['diagnosis_pointer5']);
$s_charges5_1 = st($myarray['s_charges5_1']);
$s_charges5_2 = st($myarray['s_charges5_2']);
$days_or_units5 = st($myarray['days_or_units5']);
$epsdt_family_plan5 = st($myarray['epsdt_family_plan5']);
$id_qua5 = st($myarray['id_qua5']);
$rendering_provider_id5 = st($myarray['rendering_provider_id5']);
$service_date6_from = st($myarray['service_date6_from']);
$service_date6_to = st($myarray['service_date6_to']);
$place_of_service6 = st($myarray['place_of_service6']);
$emg6 = st($myarray['emg6']);
$cpt_hcpcs6 = st($myarray['cpt_hcpcs6']);
$modifier6_1 = st($myarray['modifier6_1']);
$modifier6_2 = st($myarray['modifier6_2']);
$modifier6_3 = st($myarray['modifier6_3']);
$modifier6_4 = st($myarray['modifier6_4']);
$diagnosis_pointer6 = st($myarray['diagnosis_pointer6']);
$s_charges6_1 = st($myarray['s_charges6_1']);
$s_charges6_2 = st($myarray['s_charges6_2']);
$days_or_units6 = st($myarray['days_or_units6']);
$epsdt_family_plan6 = st($myarray['epsdt_family_plan6']);
$id_qua6 = st($myarray['id_qua6']);
$rendering_provider_id6 = st($myarray['rendering_provider_id6']);
$federal_tax_id_number = st($myarray['federal_tax_id_number']);
$ssn = st($myarray['ssn']);
$ein = st($myarray['ein']);
$patient_account_no = st($myarray['patient_account_no']);
$accept_assignment = st($myarray['accept_assignment']);
$total_charge = st($myarray['total_charge']);
$amount_paid = st($myarray['amount_paid']);
$balance_due = st($myarray['balance_due']);
$signature_physician = st($myarray['signature_physician']);
$physician_signed_date = st($myarray['physician_signed_date']);
$service_facility_info_name = st($myarray['service_facility_info_name']);
$service_facility_info_address = st($myarray['service_facility_info_address']);
$service_facility_info_city = st($myarray['service_facility_info_city']);
$service_info_a = st($myarray['service_info_a']);
$service_info_dd = st($myarray['service_info_dd']);
$service_info_b_other = st($myarray['service_info_b_other']);
$billing_provider_phone_code = st($myarray['billing_provider_phone_code']);
$billing_provider_phone = st($myarray['billing_provider_phone']);
$billing_provider_name = st($myarray['billing_provider_name']);
$billing_provider_address = st($myarray['billing_provider_address']);
$billing_provider_city = st($myarray['billing_provider_city']);
$billing_provider_a = st($myarray['billing_provider_a']);
$billing_provider_dd = st($myarray['billing_provider_dd']);
$billing_provider_b_other = st($myarray['billing_provider_b_other']);


if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];

if($patient_lastname == '')
	$patient_lastname = $pat_myarray['lastname'];

if($patient_middle == '')
	$patient_middle = $pat_myarray['middle'];
	
if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];

if($patient_city == '')
	$patient_city = $pat_myarray['city'];

if($patient_state == '')
	$patient_state = $pat_myarray['state'];

if($patient_zip == '')
	$patient_state = $pat_myarray['state'];

if($patient_phone == '')
	$patient_phone = $pat_myarray['home_phone'];

if($patient_dob == '')
	$patient_dob = $pat_myarray['dob'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Health Insurance Claim Form</title>
<link rel="stylesheet" href="form/form.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
</style>
</head>

<body>

<a href="manage_insurance.php?pid=<?=$_GET['pid'];?>">
	<b>&lt;&lt;Back to Manage Insurance Page</b></a>
<form name="insurancefrm" action="<?=$_SERVER['PHP_SELF'];?>?insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>" method="post">
	<input type="hidden" name="insurancesub" value="1" />
	<input type="hidden" name="ed" value="<?=$insuranceid;?>" />
	
	<div align="right">
		<input type="submit" name="ex_pagebtn" value="Save" />
		&nbsp;&nbsp;&nbsp;
	</div>
	
<table width="1185" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" valign="top">
			<span><div class="box_bg">1500</div></span>
			<span class="heading1">Health Insurance Claim Form</span><br />
			<span>Approved By National Uniform Claim Committee 08/05</span><br /><br />
			<span>
				<input value="<?=$pica1;?>" name="pica1" type="text"  class="inbox_line1" maxlength="1"/>
				<input value="<?=$pica2;?>" name="pica2" type="text"  class="inbox_line1" maxlength="1"/>
				<input value="<?=$pica1;?>" name="pica3" type="text"  class="inbox_line1" maxlength="1"/>
				PICA
			</span>
		</td>
		<td align="left" valign="top">
			<span></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top">
			<table width="1185" border="1" cellspacing="0" cellpadding="2" bordercolor="#333333">
				<tr>
					<td colspan="2" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<span class="num">1.</span> 
									Medicare
								</td>
								<td align="center" valign="top">
									MediCaID
								</td>
								<td align="center" valign="top">
									Tricare Champus
								</td>
								<td align="center" valign="top">
									Chmapva
								</td>
								<td align="center" valign="top">
									Group Health Plan
								</td>
								<td align="center" valign="top">
									Feca blklung
								</td>
								<td align="center" valign="top">
									Other 
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Medicare" />
									<span class="small_cap">(Medicare #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="MediCaID" />
									<span class="small_cap">(Medicaid #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Tricare Champus" />
									<span class="small_cap">(Sponsor's SSN)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Chmapva" />
									<span class="small_cap">(Member ID #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Group Health Plan" />
									<span class="small_cap">(SSN or ID)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Feca blklung" />
									<span class="small_cap">(SSN)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Other" />
									<span class="small_cap">(ID)</span>
								</td>
							</tr>
						</table>
					</td>
					<td width="448" align="left" valign="top">
						<span class="num_a">1a.</span>
						Insured's ID Number 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="small_cap">(For Program in item 1)</span>
						<br />
						<input type="text" value="<?=$insured_id_number?>" name="insured_id_number" value="" size="60" />
					</td>
				</tr>
				<tr>
					<td width="429" align="left" valign="top">
						<span class="num">2.</span>
						Patient Name 
						<span class="small_cap">(Last Name, first Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?=$patient_firstname?>" name="patient_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?=$patient_lastname?>" name="patient_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?=$patient_middle?>" name="patient_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
					<td width="300" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">3.</span> 
									Patient's Birth Date
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?=$patient_dob?>" name="patient_dob" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="patient_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="patient_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="patient_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="patient_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="patient_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">4.</span> 
						Insured's Name &nbsp;
						<span class="small_cap">(Fisrt Name, Last Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?=$insured_firstname?>" name="insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?=$insured_lastname?>" name="insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?=$insured_middle?>" name="insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">5.</span> 
						Patient's Address 
						<span class="small_cap">(No Street)</span>
						<br />
						<input type="text" value="<?=$patient_address?>" name="patient_address" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num">6.</span> 
						Patient Relationship To Insured
						<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Self</span>
									<input name="patient_relation_insured" type="radio" value="Self" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Spouse</span>
									<input name="patient_relation_insured" type="radio" value="Spouse" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Child</span>
									<input name="patient_relation_insured" type="radio" value="Child" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Others</span>
									<input name="patient_relation_insured" type="radio" value="Others" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">7.</span>
						Insured's Address 
						<span class="small_cap">(No.Street)</span>
						<br />
						<input name="insured_address" type="text" class="inbox_line3" size="28" />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input name="patient_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input name="patient_state" type="text" class="inbox_line3" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
					<td rowspan="2" align="left" valign="top">
						<span class="num">8.</span> 
						Patient Status<br />
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="25%" align="left" valign="top">
									<span class="small_cap">Single</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Single" />
								</td>
								<td width="40%" align="left" valign="top">
									<span class="small_cap">Married</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Married" />
								</td>
								<td width="35%" align="left" valign="top">
									<span class="small_cap">Others</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Others" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Employed</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Employed" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Full Time Student</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Full Time Student" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Part Time Student</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Part Time Student" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input name="insured_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input name="insured_state" type="text" class="inbox_line3" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input name="patient_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?=$?>" name="patient_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="patient_phone" class="inbox_line3" size="13"  />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input name="insured_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?=$?>" name="insured_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="insured_phone" class="inbox_line3" size="13"  />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">9.</span>
						Other Insured's Name 
						<span class="small_cap">(Last Name, first, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?=$?>" name="other_insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?=$?>" name="other_insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?=$?>" name="other_insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
					<td rowspan="4" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top" style="line-height:33px;">
									<span class="num">10.</span>
									Is paitients Condition Related To :
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">a.</span> 
									Employment? 
									<span class="small_cap">(current Or Previous)</span>
									<br />
									<input type="radio" name="employment" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="employment" value="NO" />
									NO
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">b.</span> 
									Auto Accident? 
									<br />
									<input type="radio" name="auto_accident" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="auto_accident" value="NO" />
									NO
									&nbsp;&nbsp;
									Place<span class="small_cap">(State)</span>
									<input type="text" value="<?=$?>" class="inbox_line3" size="10" name="auto_accident_place" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">c.</span> 
									Other Accident? 
									<br />
									<input type="radio" name="other_accident" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="other_accident" value="NO" />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">11.</span>
						Insured's Policy Group or FECA Number
						<br />
						<input name="insured_policy_group_feca" type="text" class="inbox_line3" size="28"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">a.</span>
						Other Insured's policy Or Group Number
						<br />
						<input name="other_insured_policy_group_feca" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">a.</span> 
									Insured's Birth Date
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="insured_dob" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="insured_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="insured_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="insured_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="insured_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="insured_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">b.</span> 
									Other Insured's Birth Date
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="other_insured_dob" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="other_insured_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="other_insured_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="other_insured_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="other_insured_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="other_insured_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num_a">b.</span>
						Employer's Name or School Name
						<br />
						<input name="insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Employer's Name or School Name
						<br />
						<input name="other_insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Insurance Plan Name or Program Name
						<br />
						<input name="insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">d.</span>
						Insurance Plan Name or Program Name
						<br />
						<input name="other_insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">10d.</span>
						Reserved For local use
						<br />
						<input name="reserved_local_use" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">d.</span> 
						Is there another helth benefit Plan?
						<br />
						<input type="radio" name="another_plan" value="YES" />YES
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="another_plan" value="NO" />NO
						&nbsp;&nbsp;
						<span class="small_cap"><i>if yes, return to and complete item 9 a-d</i></span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" valign="top">
						<center style="text-align:center; font-weight:bold">
							Read Back of Form Before Completing & Signing This Form
						</center>
						<span class="num">12.</span>
						Patient's or Authorized Person's Signature
						<span class="small_cap"> I authorize the release of any medical or other information neccessary to process this claim. I also reuest payment of government benefits either to myself or th the party who accepts assignment below.</span>
						<br /><br /><br />
						
						<input type="checkbox" name="patient_signature" value="1" />
						Signature
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Date:
						<input type="text" value="<?=$?>" name="patient_signed_date" size="10" class="inbox_line3" />
					</td>
					<td align="left" valign="top">
						<span class="num">13.</span>
						Insured's or Authorized person's Signature
						<span class="small_cap"> I authorize payment of medical benefits to the undersigned physician or supplier for services described below</span>
						<br /><br /><br />
						
						<input type="checkbox" name="insured_signature" value="1" />
						Signature
						
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">14.</span> 
									Date of Current
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="date_current" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="date_current_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="date_current_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="date_current_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td width="2%" align="left" valign="top">
									<font size="7"><b>&lt;</b></font>
								</td>
								<td width="40%" align="left" valign="middle">
									Illness
									<span class="small_cap"> (First sympton)</span>
									OR
									<br />
									Injury
									<span class="small_cap"> (Accident)</span>
									OR
									<br />
									Pregnancy
									<span class="small_cap"> (LMP)</span>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">15.</span> 
						If Patient has had same or similar Illness. Give First Date
						<br />
						&nbsp;&nbsp;
						<input type="text" value="<?=$?>" name="date_same_illness" class="inbox_line3" size="10"/>
						mm-dd-yy
						<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">MM</td>
								<td rowspan="2" align="left" valign="top" class="dot_line"></td>
								<td align="center" valign="top">DD</td>
								<td rowspan="2" align="left" valign="top" class="dot_line"></td>
								<td align="center" valign="top">YY</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<input type="text" value="<?=$?>" name="same_illness_m" class="inbox_line3" size="3"/>
								</td>
								<td align="center" valign="top">
									<input type="text" value="<?=$?>" name="same_illness_d" class="inbox_line3" size="3"/>
								</td>
								<td align="center" valign="top">
									<input type="text" value="<?=$?>" name="same_illness_y" class="inbox_line3" size="3"/>
								</td>
							</tr>
						</table> -->
					</td>
					<td valign="top">
						<span class="num">16.</span> 
						Dates Patient unable to work in Current Occupation
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From 
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="unable_date_from" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_from_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_from_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_from_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="unable_date_to" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_to_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_to_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="unable_date_to_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">17.</span> 
						Name of Referring Provider or Other Source
						<input type="text" value="<?=$?>" name="referring_provider" class="inbox_line3" size="40" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">
									<span class="num">17<span class="num_a">a.</span></span> 
								</td>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">
									<select name="field_17a_dd" class="inbox_line3" style="width:40px;">
										<option value=""></option>
										<?
										$qua_my = mysql_query($qua_sql);
										while($qua_myarray = mysql_fetch_array($qua_my))
										{?>
											<option value="<?=st($qua_myarray['qualifierid']);?>">
												<?=st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
								</td>
								<td valign="top" width="80%" style="border-bottom: 1px #000000 dashed; padding-bottom:3px;">
									<input type="text" value="<?=$?>" name="field_17a" class="inbox_line3" size="30"/>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="num">17<span class="num_a">b.</span></span> 
								</td>
								<td valign="top">
									NPI
								</td>
								<td valign="top" style="padding-top:3px;">
									<input type="text" value="<?=$?>" name="field_17b" class="inbox_line3" size="30"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">18.</span> 
						Hospitalization Dates Related to Current Services
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From 
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="hospitalization_date_from" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_from_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_from_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_from_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$?>" name="hospitalization_date_to" class="inbox_line3" size="10"/>
									mm-dd-yy
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_to_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_to_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="hospitalization_date_to_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table> -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<span class="num">19.</span> 
						Reserved for Local Use<br />
						<input type="text" value="<?=$?>" name="reserved_local_use1" class="inbox_line3" size="100" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="40%">
									<span class="num">20.</span> 
									Outside Lab?
									<br />
									<input type="radio" name="outside_lab" value="YES" />
									YES
									&nbsp;&nbsp;
									<input type="radio" name="outside_lab" value="NO" />
									NO
								</td>
								<td valign="top" width="60%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									S Charges
									<br />
									<input type="text" value="<?=$?>" name="s_charges" class="inbox_line3" size="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" rowspan="2">
						<span class="num">21.</span> 
						Diagnosis or Nature of Illness or Injury 
						<span class="small_cap">
							(Relate Items 1, 2, 3, 4 to Item 24E by line)
						</span>
						
						<table width="100%" cellpadding="3" cellspacing="5" border="0">
							<tr>
								<td valign="top" width="50%">
									<b>1.</b>
									<select name="diagnosis_1" style="width:300px;" >
										<option value=""></option>
										<? 
										$ins_diag_my = mysql_query($ins_diag_sql);
										
										while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
										{
										?>
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>">
												<?=st($ins_diag_myarray['ins_diagnosis'])?>
											</option>
										<?
										}?>
									</select>
								</td>
								<td valign="top" width="50%">
									<b>3.</b>
									<select name="diagnosis_3" style="width:300px;" >
										<option value=""></option>
										<? 
										$ins_diag_my = mysql_query($ins_diag_sql);
										
										while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
										{
										?>
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>">
												<?=st($ins_diag_myarray['ins_diagnosis'])?>
											</option>
										<?
										}?>
									</select>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<b>2.</b>
									<select name="diagnosis_2" style="width:300px;" >
										<option value=""></option>
										<? 
										$ins_diag_my = mysql_query($ins_diag_sql);
										
										while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
										{
										?>
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>">
												<?=st($ins_diag_myarray['ins_diagnosis'])?>
											</option>
										<?
										}?>
									</select>
								</td>
								<td valign="top">
									<b>4.</b>
									<select name="diagnosis_4" style="width:300px;" >
										<option value=""></option>
										<? 
										$ins_diag_my = mysql_query($ins_diag_sql);
										
										while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
										{
										?>
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>">
												<?=st($ins_diag_myarray['ins_diagnosis'])?>
											</option>
										<?
										}?>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">22.</span> 
						Medicaid Resubmission Code
						<input type="text" value="<?=$?>" name="medicaid_resubmission_code" class="inbox_line3" size="30" />
						<br />
						Original Ref. No.
						<input type="text" value="<?=$?>" name="original_ref_no" class="inbox_line3" size="30" />
						
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">23.</span> 
						Prior Authorization Number
						<br />
						<input type="text" value="<?=$?>" name="prior_authorization_number" class="inbox_line3" size="60" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="3">
						<span class="num">24.</span> 
						<table width="100%" cellpadding="3" cellspacing="1" border="0" bgcolor="#000000" >
							<tr bgcolor="#FFFFFF">
								<td valign="top" rowspan="2" align="center">&nbsp;
									
								</td>
								<td valign="top" colspan="2" align="center">
									<span class="num_a">A.</span> 
									Date(s) of service
								</td>
								<td valign="top" align="center">
									<span class="num_a">B.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">C.</span>
								</td>
								<td valign="top" colspan="5" align="center">
									<span class="num_a">D.</span>
									Procedures, Services or Supplies
									<br /> 
									<span class="small_cap">
										(Explain Unusual Circumstances)
									</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">E.</span>
								</td>
								<td valign="top" colspan="2" align="center">
									<span class="num_a">F.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">G.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">H.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">I.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">J.</span>
								</td>
							</tr>
							
							<tr bgcolor="#FFFFFF">
								<td valign="bottom" align="center">
									<span class="small_cap">
										From
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										To
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										PLACE OF <br />SERVICE
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EMG
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										CPT/HCPCS
									</span>
								</td>
								<td valign="bottom" align="center" colspan="4">
									<span class="small_cap">
										MODIFIER
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										DIAGNOSIS <br />POINTER
									</span>
								</td>
								<td valign="bottom" align="center" colspan="2">
									<span class="small_cap">
										S CHARGES
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										DAYS <br />OR <br />UNITS
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EPSDT <br />Family <br />Plan
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										ID. <br />QUAL.
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										RENDERING <br />PROVIDER ID. #
									</span>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">1</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date1_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date1_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date1_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg1" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs1" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier1_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier1_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier1_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier1_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges1_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges1_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units1" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id1" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">2</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date2_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date2_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date2_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service2" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg2" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs2" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier2_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier2_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier2_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier2_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer2" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges2_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges2_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units2" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id2" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">3</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date3_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date3_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date3_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service3" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg3" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs3" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier3_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier3_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier3_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier3_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer3" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges3_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges3_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units3" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id3" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">4</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date4_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date4_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date4_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service4" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg4" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs4" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier4_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier4_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier4_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier4_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer4" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges4_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges4_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units4" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id4" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">5</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date5_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date5_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date5_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service5" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg5" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs5" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier5_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier5_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier5_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier5_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer5" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges5_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges5_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units5" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan5" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua5" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id5" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">6</span>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date6_from" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="service_date6_to" class="inbox_line3" size="10"/>
									<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" value="<?=$?>" name="service_date6_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table> -->
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="place_of_service6" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="emg6" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="cpt_hcpcs6" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier6_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier6_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier6_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="modifier6_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="diagnosis_pointer6" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges6_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="s_charges6_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="days_or_units6" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="epsdt_family_plan6" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="id_qua6" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" value="<?=$?>" name="rendering_provider_id6" class="inbox_line3" size="15"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="2">
					
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="40%">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td valign="top" width="80%">
												<span class="num">25.</span> 
												Federal Tax I.D.Number
												<br />
												<input type="text" value="<?=$?>" name="federal_tax_id_number" size="20" class="inbox_line3" />
											</td>
											<td valign="top" width="10%" align="center">
												SSN
												<br />
												<input type="checkbox" name="ssn" value="1" />
											</td>
											<td valign="top" width="10%" align="center">
												EIN
												<br />
												<input type="checkbox" name="ein" value="1" />
											</td>
										</tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<span class="num">26.</span> 
									Patient Account No.
									<br />
									<input type="text" value="<?=$?>" name="patient_account_no" class="inbox_line3" size="20" />
								</td>
								<td valign="top" width="30%">
									<span class="num">27.</span> 
									Accept Assignment?
									<br />
									<span class="small_cap">(For govt. claims, see back)</span>
									<br />
									<input type="radio" name="accept_assignment" value="YES" />
									YES
									&nbsp;&nbsp;&nbsp;
									<input type="radio" name="accept_assignment" value="NO" />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" colspan="2">
					
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="33%">
									<span class="num">28.</span> 
									Total Charge
									<br />
									$ <input type="text" value="<?=$?>" name="total_charge" class="inbox_line3" size="15" />
								</td>
								<td valign="top" width="33%">
									<span class="num">29.</span> 
									Amount Paid
									<br />
									$ <input type="text" value="<?=$?>" name="amount_paid" class="inbox_line3" size="15" />
								</td>
								<td valign="top" width="33%">
									<span class="num">30.</span> 
									Balance Due
									<br />
									$ <input type="text" value="<?=$?>" name="balance_due" class="inbox_line3" size="15" />
									<br />
									<span class="small_cap">&nbsp;</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="50%">
									<span class="num">31.</span> 
									Signature of Physician or Supplier Including Degrees or Credentals
									<span class="small_cap">
										(I certify that the statements on the reverse apply to this bill and are made a part thereof.)
									</span>
									<br />
									<input type="text" value="<?=$?>" class="inbox_line3" size="40" name="signature_physician" />
									<br /><br />
									Signed
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Date: 
									<input type="text" value="<?=$?>" name="physician_signed_date" class="inbox_line3" size="10" />
								</td>
								<td valign="top" width="50%">
									<span class="num">32.</span> 
									Service Facility Location Information
									<table width="100%" cellpadding="1" cellspacing="1" border="0">
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Name:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" value="<?=$?>" name="service_facility_info_name" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Address:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" value="<?=$?>" name="service_facility_info_address" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">City/State/Zip:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" value="<?=$?>" name="service_facility_info_city" class="inbox_line3" size="40" />
											</td>
										</tr>
									</table>
									<span class="num_a">
										a.
									</span>
									<input type="text" value="<?=$?>" name="service_info_a" class="inbox_line3" size="15" />
									
									<span class="num_a">
										b.
									</span>
									<select name="service_info_dd" class="inbox_line3" style="width:50px;">
										<option value=""></option>
										<?
										$qua_my = mysql_query($qua_sql);
										while($qua_myarray = mysql_fetch_array($qua_my))
										{?>
											<option value="<?=st($qua_myarray['qualifierid']);?>">
												<?=st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
									<input type="text" value="<?=$?>" name="service_info_b_other" class="inbox_line3" size="15" />
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="top" >
						<span class="num">33.</span> 
						Billing Provider Info & Ph#
						<span class="style1">(
						<input type="text" value="<?=$?>" name="billing_provider_phone_code" size="3" class="inbox_line3" />
						)</span>
						&nbsp;&nbsp;&nbsp;
						<input type="text" value="<?=$?>" name="billing_provider_phone" class="inbox_line3" size="13"  />
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Name:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?=$?>" name="billing_provider_name" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Address:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?=$?>" name="billing_provider_address" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">City/State/Zip:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?=$?>" name="billing_provider_city" class="inbox_line3" size="40" />
								</td>
							</tr>
						</table>
						<span class="num_a">
							a.
						</span>
						<input type="text" value="<?=$?>" name="billing_provider_a" class="inbox_line3" size="15" />
						
						<span class="num_a">
							b.
						</span>
						<select name="billing_provider_dd" class="inbox_line3" style="width:50px;">
							<option value=""></option>
							<?
							$qua_my = mysql_query($qua_sql);
							while($qua_myarray = mysql_fetch_array($qua_my))
							{?>
								<option value="<?=st($qua_myarray['qualifierid']);?>">
									<?=st($qua_myarray['qualifier']);?>
								</option>
							<?
							}?>
						</select>
						<input type="text" value="<?=$?>" name="billing_provider_b_other" class="inbox_line3" size="15" />
					</td>
				</tr>
				
				
				
				
				
			
			</table>
		</td>
	</tr>
</table>

<div align="right">
    <input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<br /><br />
</body>
</html>
