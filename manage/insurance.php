<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_procedure where procedureid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>";
	</script>
	<?
	die();
}


if($_POST['insurancesub'] == 1)
{

                  $num = 0;
         
                  while($num <= ($_POST['ledgercount']-1)){
                  
                  $placeofservicenum =  'placeofservice'.$num;
                  $emgnum = 'emg'.$num;
                  $diagnosispointernum = 'diagnosispointer'.$num;
                  $daysorunitsnum = 'daysorunits'.$num;
                  $epsdtnum = 'epsdt'.$num;
                  $idqualnum = 'idqual'.$num;
                  $ledgeridnum = 'ledgerid'.$num;
                  $modifiercodenum = 'modifiercode'.$num;
                
                  $placeofservice = $_POST[$placeofservicenum];
                  $emg = $_POST[$emgnum];             
                  $diagnosispointer = $_POST[$diagnosispointernum]; 
                  $daysorunits = $_POST[$daysorunitsnum];
                  $epsdt = $_POST[$epsdtnum];
                  $idqual = $_POST[$idqualnum];
                  $modifiercode = $_POST[$modifiercodenum];
                  $ledgerid = $_POST[$ledgeridnum];
                  $insertledgermods = "UPDATE dental_ledger SET `placeofservice` = '".$placeofservice."', `emg` = '".$emg."', `diagnosispointer` = '".$diagnosispointer."', `daysorunits` = '".$daysorunits."', `epsdt` = '".$epsdt."', `idqual` = '".$idqual."', `modcode` = '".$modifiercode."' WHERE `ledgerid` = ".$ledgerid.";";
                  $queryinsert = mysql_query($insertledgermods);
                  if(!$queryinsert){
                    echo mysql_errno($queryinsert) . ": " . mysql_error($queryinsert). "\n";
                  }
                  $num++;
                  }
  
  
	$_GET['fid'] = 0;
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
	$cpt_hcpcs4 = $_POST['cpt_hcpcs4'];
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
		formid = '".s_for($_GET['fid'])."',
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
		patient_signature = '".$patient_signature."',
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
		cpt_hcpcs4 = '".s_for($cpt_hcpcs4)."',
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
		if(isset($_GET['pid'])){
		?>
     <script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='add_patient.php?pid=<?=$_GET['pid']?>&ed=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?php
    }else{
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='manage_insurance.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ed_sql = " update dental_insurance set 
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
		cpt_hcpcs4 = '".s_for($cpt_hcpcs4)."',
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
		
		//echo $ed_sql;
		$msg = "Edited Successfully";
		?>
    <script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='insurance.php?pid=<?=$_GET['pid']?>&insid=<?=$_GET['insid']?>&ed=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
		
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$insurancetype = st($pat_myarray['p_m_ins_type']);
$insured_firstname = st($pat_myarray['p_m_partyfname']);
$insured_lastname = st($pat_myarray['p_m_partymname']);
$insured_middle = st($pat_myarray['p_m_partylname']);
$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
$other_insured_lastname = st($pat_myarray['s_m_partymname']);
$other_insured_middle = st($pat_myarray['s_m_partylname']);
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
$other_insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
$insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
$other_insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
$referredby = st($pat_myarray['referred_by']); 
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
$dent_rows = mysql_num_rows($my);
$insuranceid = st($myarray['insuranceid']);
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$insurance_type = st($myarray['insurance_type']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
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
$employment = st($myarray['employment']);
$auto_accident = st($myarray['auto_accident']);
$auto_accident_place = st($myarray['auto_accident_place']);
$other_accident = st($myarray['other_accident']);
$insured_sex = st($myarray['insured_sex']);
$other_insured_sex = st($myarray['other_insured_sex']);
$insured_employer_school_name = st($myarray['insured_employer_school_name']);
$other_insured_employer_school_name = st($myarray['other_insured_employer_school_name']);
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
$cpt_hcpcs4 = st($myarray['cpt_hcpcs4']);
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

	
if($insured_sex == '')
	$insured_sex = $pat_myarray['gender'];
  $patient_sex = $pat_myarray['gender'];
  
if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];

if($patient_lastname == '')
	$patient_lastname = $pat_myarray['lastname'];

if($patient_middle == '')
	$patient_middle = $pat_myarray['middlename'];
	
if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];
	
if($patient_address == '')
	$patient_address = $pat_myarray['add1'];

if($patient_city == '')
	$patient_city = $pat_myarray['city'];

if($patient_state == '')
	$patient_state = $pat_myarray['state'];

if($patient_zip == '')
	$patient_zip = $pat_myarray['zip'];

if($patient_phone == '')
	$patient_phone = $pat_myarray['home_phone'];

if($patient_dob == '')
	$patient_dob = $pat_myarray['dob'];

if($patient_status == '')
	$patient_status = $pat_myarray['marital_status'];	

if($insured_id == '')
	$insured_id_number = $pat_myarray['p_m_ins_id'];
		
if($insured_firstname == '')
	$insured_firstname = $pat_myarray['p_d_party'];
	
if($insured_address == '')
	$insured_address = $pat_myarray['add1'];

if($insured_city == '')
	$insured_city = $pat_myarray['city'];

if($insured_state == '')
	$insured_state = $pat_myarray['state'];

if($insured_zip == '')
	$insured_zip = $pat_myarray['zip'];

if($insured_phone == '')
	$insured_phone_code = substr($pat_myarray['home_phone'], 0, 4);
	$insured_phone = substr($pat_myarray['home_phone'], 3);

if($insured_dob == '')
	$insured_dob = $pat_myarray['ins_dob'];	

if($patient_relation_insured == '')
	$patient_relation_insured = $pat_myarray['p_m_relation'];

if($insured_employer_school_name == '')
	$insured_employer_school_name = $pat_myarray['employer'];

if($insured_policy_group_feca == '')
	$insured_policy_group_feca = $pat_myarray['group_number'];

if($insured_insurance_plan == '')
	$insured_insurance_plan = $pat_myarray['plan_name'];	

$proc_sql = "select * from dental_procedure where status=1 and patientid='".s_for($_GET['pid'])."' and insuranceid = '".$insuranceid."' order by adddate";
$proc_my = mysql_query($proc_sql);

$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
if($dent_rows <= 0){
$accept_assignment = $accept_assignmentnew;
}	
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
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<script language="javascript">
 function printpage()
  {
   window.print();
  }
</script>

</head>

<body>
<?php echo $msg; ?>
<script type="text/javascript">
	function cal_tot()
	{
		var err = 0;
		var tot = 0;
		
		fa = document.insurancefrm;
		
		if(trim(fa.total_charge.value) == '' )
		{
			err = 1;
		}
		
		if( err == 0)
		{
			if(isNaN(trim(fa.total_charge.value)))
			{
				err = 1;
			}
		}
		
		if( err == 0)
		{
			if(trim(fa.amount_paid.value) == '')
			{
				err = 1;
			}
		}
		
		if( err == 0)
		{	
			if(isNaN(trim(fa.amount_paid.value)))
			{
				err = 1;
			}
		}
		
		if(err == 0)
		{
			tot = parseFloat(trim(fa.total_charge.value)) - parseFloat(trim(fa.amount_paid.value));
		}
		else
		{
			tot = 0.00;
		}
		
		fa.balance_due.value = tot;
	}
</script>
	
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<a href="manage_insurance.php?pid=<?=$_GET['pid'];?>">
	<b>&lt;&lt;Back to Manage Insurance Page</b></a>
<form name="insurancefrm" action="<?=$_SERVER['PHP_SELF'];?>?insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>" method="post">
	<input type="hidden" name="insurancesub" value="1" />
	<input type="hidden" name="ed" value="<?=$insuranceid;?>" />
	
	<div align="right">
		<input type="button" onClick="window.print()" value="Print Claim Form"/><input type="submit" name="ex_pagebtn" value="Save" />
		&nbsp;&nbsp;&nbsp;
	</div>
	
<table width="1185" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" valign="top" width="50%">
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
		<td width="50%">
		  <table>
		  		  <?php $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'"; 
      $inscoarray = mysql_query($inscoquery);
      $inscoinfo = mysql_fetch_array($inscoarray);
      ?>
		  <tr>
		      <td>
		      Ins. Co:
		      </td>
		      <td>
		       <?php echo $inscoinfo['company']; ?>
		      </td>
		  </tr>
		     <td valign="top">
		      Address:
		      </td>
		      <td valign="top">
		       <?php echo $inscoinfo['add1']; ?><br />
		   <?php echo $inscoinfo['add2']; ?>
		      </td>
		  <tr>
		      <td>
		      
		      </td>
		      <td>
		      <?php echo $inscoinfo['city']; ?>&nbsp;&nbsp;
		       <?php echo $inscoinfo['state']; ?>&nbsp;,

		       <?php echo $inscoinfo['zip']; ?><br />
		      </td>
		  </tr>
       </table>
		   <br />
		   <br />
		    
		     
		      
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
								<?php echo $insurancetype; ?>
									<input name="insurance_type[]" type="checkbox" value="Medicare" <? if($insurancetype == '1') {echo " checked";}?> />
									<span class="small_cap">(Medicare #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="MediCaID" <? if($insurancetype == '2') {echo " checked";}?> />
									<span class="small_cap">(Medicaid #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Tricare Champus" <? if($insurancetype == '3') {echo " checked";}?> />
									<span class="small_cap">(Sponsor's SSN)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Chmapva" <? if($insurance_type == '4') {echo " checked";}?> />
									<span class="small_cap">(Member ID #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Group Health Plan" <? if($insurancetype == '5') {echo " checked";}?> />
									<span class="small_cap">(SSN or ID)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Feca blklung" <? if($insurancetype == '6') {echo " checked";}?> />
									<span class="small_cap">(SSN)</span>
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
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="patient_sex" value="M" <? if($patient_sex == "M" || $patient_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F 
									<input type="radio" name="patient_sex" value="F" <? if($patient_sex == "F" || $patient_sex == "Female") echo " checked";?> />
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
							<input type="text" value="<?=$insured_middle?>" name="insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?=$insured_lastname?>" name="insured_middle" class="inbox_line3" size="3" width="30" />
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
									<input name="patient_relation_insured" type="radio" value="Self" <? if($patient_relation_insured == "Self") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Spouse</span>
									<input name="patient_relation_insured" type="radio" value="Spouse" <? if($patient_relation_insured == "Spouse") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Child</span>
									<input name="patient_relation_insured" type="radio" value="Child" <? if($patient_relation_insured == "Child") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Others</span>
									<input name="patient_relation_insured" type="radio" value="Others" <? if($patient_relation_insured == "Others") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">7.</span>
						Insured's Address 
						<span class="small_cap">(No.Street)</span>
						<br />
						<input value="<?=$insured_address?>" name="insured_address" type="text" class="inbox_line3" size="28" />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?=$patient_city?>" name="patient_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?=$patient_state?>" name="patient_state" type="text" class="inbox_line3" size="3" width="30" />
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
									<input name="patient_status[]" type="checkbox" value="Single" <? if($patient_status == "Single") { echo " checked";}?> />
								</td>
								<td width="40%" align="left" valign="top">
									<span class="small_cap">Married</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Married" <? if($patient_status == "Married") { echo " checked";}?> />
								</td>
								<td width="35%" align="left" valign="top">
									<span class="small_cap">Others</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Others" <? if($patient_status == "Life Partner") { echo " checked";}?> />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Employed</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Employed" <? if($work_status == "Employed") { echo " checked";}?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Full Time Student</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Full Time Student" <? if($work_status == "Full Time Student") { echo " checked";}?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Part Time Student</span>
									<br />
									<input name="patient_status[]" type="checkbox" value="Part Time Student" <?if($work_status == "Part Time Student") { echo " checked";}?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?=$insured_city?>" name="insured_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?=$insured_state?>" name="insured_state" type="text" class="inbox_line3" size="3" width="30" />
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
									<input value="<?=$patient_zip?>" name="patient_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?=substr($patient_phone,0,3)?>" name="patient_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?=substr($patient_phone,3)?>" name="patient_phone" class="inbox_line3" size="13"  />
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
									<input value="<?=$insured_zip?>" name="insured_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?=$insured_phone_code?>" name="insured_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?=$insured_phone?>" name="insured_phone" class="inbox_line3" size="13"  />
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
							<input type="text" value="<?=$other_insured_firstname?>" name="other_insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?=$other_insured_lastname?>" name="other_insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?=$other_insured_middle?>" name="other_insured_middle" class="inbox_line3" size="3" width="30" />
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
									<input type="radio" name="employment" value="YES" <? if($employment == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="employment" value="NO" <? if($employment == "NO") echo " checked";?> />
									NO
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">b.</span> 
									Auto Accident? 
									<br />
									<input type="radio" name="auto_accident" value="YES" <? if($auto_accident == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="auto_accident" value="NO" <? if($auto_accident == "NO") echo " checked";?> />
									NO
									&nbsp;&nbsp;
									Place<span class="small_cap">(State)</span>
									<input type="text" value="<?=$auto_accident_place?>" class="inbox_line3" size="10" name="auto_accident_place" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">c.</span> 
									Other Accident? 
									<br />
									<input type="radio" name="other_accident" value="YES" <? if($other_accident == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="other_accident" value="NO" <? if($other_accident == "NO") echo " checked";?> />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">11.</span>
						Insured's Policy Group or FECA Number
						<br />
						<input value="<?=$insured_policy_group_feca?>" name="insured_policy_group_feca" type="text" class="inbox_line3" size="28"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">a.</span>
						Other Insured's policy Or Group Number
						<br />
						<input value="<?=$other_insured_policy_group_feca?>" name="other_insured_policy_group_feca" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">a.</span> 
									Insured's Birth Date
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?=$insured_dob?>" name="insured_dob" class="inbox_line3" size="10"/>
									mm-dd-yy
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="insured_sex" value="M" <? if($insured_sex == "M" || $insured_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F 
									<input type="radio" name="insured_sex" value="F" <? if($insured_sex == "F" || $insured_sex == "Female") echo " checked";?> />
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
									<input type="text" value="<?=$other_insured_dob?>" name="other_insured_dob" class="inbox_line3" size="10"/>
									mm-dd-yy
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="other_insured_sex" value="M" <? if($other_insured_sex == "M") echo " checked";?> />
									&nbsp;&nbsp;F 
									<input type="radio" name="other_insured_sex" value="F" <? if($other_insured_sex == "F") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num_a">b.</span>
						Employer's Name or School Name
						<br />
						<input value="<?=$insured_employer_school_name?>" name="insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Employer's Name or School Name
						<br />
						<input value="<?=$other_insured_employer_school_name?>" name="other_insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Insurance Plan Name or Program Name
						<br />
						<input value="<?=$insured_insurance_plan?>" name="insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">d.</span>
						Insurance Plan Name or Program Name
						<br />
						<input value="<?=$other_insured_insurance_plan?>" name="other_insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">10d.</span>
						Reserved For local use
						<br />
						<input value="<?=$reserved_local_use?>" name="reserved_local_use" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">d.</span> 
						Is there another health benefit Plan?
						<br />
						<input type="radio" name="another_plan" value="YES" <? if($another_plan == "YES") echo " checked";?> />YES
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="another_plan" value="NO" <? if($another_plan == "NO") echo " checked";?> />NO
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
						
						<input type="checkbox" name="patient_signature" value="1" <? if($patient_signature == "1") echo " checked";?> />
						Signature
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Date:
						<input type="text" value="<?=$patient_signed_date?>" name="patient_signed_date" size="10" class="inbox_line3" />
					</td>
					<td align="left" valign="top">
						<span class="num">13.</span>
						Insured's or Authorized person's Signature
						<span class="small_cap"> I authorize payment of medical benefits to the undersigned physician or supplier for services described below</span>
						<br /><br /><br />
						
						<?php
            $patient_signature = st($myarray['patient_signature']);
            if($patient_signature == "1"){
            echo "<center><strong>SIGNATURE ON FILE</strong></center>";
            }else{
            echo "<center>Check to confirm patient signature is on file: <input type='checkbox' name='patient_signature' value='1' /></center>";
            }	
            ?>
						
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
									<input type="text" value="<?=$date_current?>" name="date_current" class="inbox_line3" size="10"/>
									mm-dd-yy
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
						<input type="text" value="<?=$date_same_illness?>" name="date_same_illness" class="inbox_line3" size="10"/>
						mm-dd-yy
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
									<input type="text" value="<?=$unable_date_from?>" name="unable_date_from" class="inbox_line3" size="10"/>
									mm-dd-yy
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$unable_date_to?>" name="unable_date_to" class="inbox_line3" size="10"/>
									mm-dd-yy
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">17.</span> 
						Name of Referring Provider or Other Source
							<?
								$referredby_sql = "select * from dental_referredby where `referredbyid` = ".$referredby." LIMIT 1;";
								$referredby_my = mysql_query($referredby_sql);
								
								$referredby_myarray = mysql_fetch_array($referredby_my);
								$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
								echo "<br /><br />".$ref_name;
									?>
								
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
											<option value="<?=st($qua_myarray['qualifierid']);?>" <? if($field_17a_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
												<?=st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
								</td>
								<td valign="top" width="80%" style="border-bottom: 1px #000000 dashed; padding-bottom:3px;">
									<input type="text" value="<?=$field_17a?>" name="field_17a" class="inbox_line3" size="30"/>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="num">17<span class="num_a">b.</span></span> 
								</td>
								<?php
                      $getuserinfo = "SELECT * FROM `dental_users` WHERE `username` = '".$_SESSION['username']."'";
                      $userquery = mysql_query($getuserinfo);
                      $userinfo = mysql_fetch_array($userquery);
                      ?>  
								<td valign="top">
									NPI
								</td>
								<td valign="top" style="padding-top:3px;">
									<input type="text" value="<?=$userinfo['npi']?>" name="field_17b" class="inbox_line3" size="30"/>
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
									<input type="text" value="<?=$hospitalization_date_from?>" name="hospitalization_date_from" class="inbox_line3" size="10"/>
									mm-dd-yy
									
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?=$hospitalization_date_to?>" name="hospitalization_date_to" class="inbox_line3" size="10"/>
									mm-dd-yy
									
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<span class="num">19.</span> 
						Reserved for Local Use<br />
						<input type="text" value="<?=$reserved_local_use1?>" name="reserved_local_use1" class="inbox_line3" size="100" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="40%">
									<span class="num">20.</span> 
									Outside Lab?
									<br />
									<input type="radio" name="outside_lab" value="YES"  <? if($outside_lab == "YES") echo " checked";?>/>
									YES
									&nbsp;&nbsp;
									<input type="radio" name="outside_lab" value="NO" <? if($outside_lab == "NO") echo " checked";?> />
									NO
								</td>
								<td valign="top" width="60%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									S Charges
									<br />
									<input type="text" value="<?=$s_charges?>" name="s_charges" class="inbox_line3" size="30" />
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
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" <? if($diagnosis_1 == st($ins_diag_myarray['ins_diagnosisid'])) echo " selected";?>>
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
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" <? if($diagnosis_3 == st($ins_diag_myarray['ins_diagnosisid'])) echo " selected";?>>
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
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" <? if($diagnosis_2 == st($ins_diag_myarray['ins_diagnosisid'])) echo " selected";?>>
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
											<option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" <? if($diagnosis_4 == st($ins_diag_myarray['ins_diagnosisid'])) echo " selected";?>>
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
						<input type="text" value="<?=$medicaid_resubmission_code?>" name="medicaid_resubmission_code" class="inbox_line3" size="30" />
						<br />
						Original Ref. No.
						<input type="text" value="<?=$original_ref_no?>" name="original_ref_no" class="inbox_line3" size="30" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">23.</span> 
						Prior Authorization Number
						<br />
						<input type="text" value="<?=$prior_authorization_number?>" name="prior_authorization_number" class="inbox_line3" size="60" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="3">
						<a name="procedure"></a>
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
								<td valign="top" align="center">
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
								<td valign="bottom" align="center">
									<span class="small_cap">
										$ CHARGES
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
							<? $p_i=1;
							$tot_charges = 0;
							while($proc_myarray = mysql_fetch_array($proc_my))
							{
							?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="center">
										<span class="num"><?=$p_i?></span>
										<br />
										<a href="Javascript:;"  onclick="Javascript: loadPopup('add_procedure.php?pid=<?=$_GET['pid']?>&insid=<?=$insuranceid?>&ed=<?=$proc_myarray["procedureid"];?>');  getElementById('popupContact').style.top = '1000px';" class="editlink" title="EDIT">
											Edit 
										</a>
										
										<a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$proc_myarray["procedureid"];?>&insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>" onClick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
											 Delete 
										</a>
									</td>
									<td valign="top">
										<?=st($proc_myarray['service_date_from']);?>
									</td>
									<td valign="top">
										<?=st($proc_myarray['service_date_to']);?>
									</td>
									<td valign="top">
										<? $place_sql = "select * from dental_place_service where place_serviceid='".$proc_myarray['place_service']."'";
										$place_my = mysql_query($place_sql);
										$place_myarray = mysql_fetch_array($place_my);
										?>
										<?=substr(st($place_myarray['place_service']),0,2);?>
									</td>
									<td valign="top" align="center">
										<? if(st($proc_myarray['emg']) == 1) {?>
											<img src="images/x-image.jpg" width="15" height="15" border="0" />
										<? }?>
									</td>
									<td valign="top">
				
										<? $cpt_sql = "select * from dental_cpt_code where cpt_codeid='".$proc_myarray['cpt_code']."'";
										$cpt_my = mysql_query($cpt_sql);
										$cpt_myarray = mysql_fetch_array($cpt_my);
										?>
										<?=substr(st($cpt_myarray['cpt_code']),0,5);?>
									</td>
									<td valign="top" width="25">
										<? $mod_sql = "select * from dental_modifier_code where modifier_codeid='".$proc_myarray['modifier_code_1']."'";
										$mod_my = mysql_query($mod_sql);
										$mod_myarray = mysql_fetch_array($mod_my);
										?>
										<?=substr(st($mod_myarray['modifier_code']),0,2);?>&nbsp;
									</td>
									<td valign="top" width="25">
										<? $mod_sql = "select * from dental_modifier_code where modifier_codeid='".$proc_myarray['modifier_code_2']."'";
										$mod_my = mysql_query($mod_sql);
										$mod_myarray = mysql_fetch_array($mod_my);
										?>
										<?=substr(st($mod_myarray['modifier_code']),0,2);?>&nbsp;
									</td>
									<td valign="top" width="25">
										<? $mod_sql = "select * from dental_modifier_code where modifier_codeid='".$proc_myarray['modifier_code_3']."'";
										$mod_my = mysql_query($mod_sql);
										$mod_myarray = mysql_fetch_array($mod_my);
										?>
										<?=substr(st($mod_myarray['modifier_code']),0,2);?>&nbsp;
									</td>
									<td valign="top" width="25">
										<? $mod_sql = "select * from dental_modifier_code where modifier_codeid='".$proc_myarray['modifier_code_4']."'";
										$mod_my = mysql_query($mod_sql);
										$mod_myarray = mysql_fetch_array($mod_my);
										?>
										<?=substr(st($mod_myarray['modifier_code']),0,2);?>&nbsp;
									</td>
									<td valign="top">
										<?=st($proc_myarray['applies_icd']);?>
									</td>
									<td valign="top">
										<?=st($proc_myarray['charge']);?>
									</td>
									<td valign="top">
										<?=st($proc_myarray['units']);?>
									</td>
									<td valign="top" align="center">
										<? if(st($proc_myarray['epsdt']) == 1) {?>
											<img src="images/x-image.jpg" width="15" height="15" border="0" />
										<? }?>
									</td>
									<td valign="top">
										<?=st($proc_myarray['npi']);?>
									</td>
									<td valign="top">
										<?=st($proc_myarray['other_id']);?>
									</td>
								</tr>
							<?
								$p_i++;
								$tot_charges += st($proc_myarray['total_charge']);
							}?>
						</table>
						
						<?php
					
            $ledgerselect = "SELECT * FROM dental_ledger WHERE `transaction_type` = 'Charge' AND `patientid` = ".$_GET['pid']." AND `status` = 1;";
            $query = mysql_query($ledgerselect);
                        
            if($query){
            
            ?>
            <input type="hidden" name="ledgercount" value="<?php echo mysql_num_rows($query); ?>">
            <?php
            $li = 0;
            while($array = mysql_fetch_array($query)){
            ?>
							<table style="margin-left:39px;">
              <tr>
              <td width="106"><?php echo $array['service_date']; ?></td>
              <td width="106"><?php echo $array['service_date']; ?></td>
              <td width="91"><input style="width:76px;" type="text" name="placeofservice<?php echo $li; ?>" value="<?php echo $array['placeofservice']; ?>"></td>
              <td width="41"><input  style="width:26px;"type="text" name="emg<?php echo $li; ?>" value="<?php echo $array['emg']; ?>"></td>
              <td width="222"><?php echo $array['transaction_code'] . " - " .$array['description'] ; ?></td>
              <td width="191">
              <?    $mod_sql = "select * from dental_modifier_code";
										$mod_my = mysql_query($mod_sql);
										echo "<select name='modifiercode".$li."' style='width:171px;'><option>Select One</option>";
										while($mod_myarray = mysql_fetch_array($mod_my)){
                    ?>
                    <option value="<?php echo $mod_myarray['modifier_code']; ?>" <?php if($array['modcode'] == $mod_myarray['modifier_code']){ echo "selected='selected'";} ?>><?php echo $mod_myarray['modifier_code']; ?></option>";
                    <?php
                    }
                    echo "</select>";
							?>
              </td>
              <td width="92"><input style="width:77px;" type="text" name="diagnosispointer<?php echo $li; ?>" value="<?php echo $array['diagnosispointer']; ?>"></td>
              <td width="100"><?php echo $array['amount']; ?></td>
              <td width="54"><input style="width:39px;" type="text" name="daysorunits<?php echo $li; ?>" value="<?php echo $array['daysorunits']; ?>"></td>
              <td width="60"><input style="width:45px;" type="text" name="epsdt<?php echo $li; ?>" value="<?php echo $array['epsdt']; ?>"></td>
              <td width="52"><input style="width:37px;" type="text" name="idqual<?php echo $li; ?>" value="<?php echo $array['idqual']; ?>"></td>
              <input type="hidden" name="ledgerid<?php echo $li; ?>" value="<?php echo $array['ledgerid']; ?>">
              <td width="122"><?=$_SESSION['username'];?></td>
              </tr>
              </table>
						<?php
						$li++;
            }
            }else{
            echo "<br /><center><font style='color:#ff0000; font-weight:bold;'>There are currently no ledger entries to be filed.</font></center><br />";
            }
            ?>
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
												<input type="text" value="<?=$federal_tax_id_number?>" name="federal_tax_id_number" size="20" class="inbox_line3" />
											</td>
											<td valign="top" width="10%" align="center">
												SSN
												<br />
												<input type="checkbox" name="ssn" value="1" <? if($ssn == "1") echo " checked";?> />
											</td>
											<td valign="top" width="10%" align="center">
												EIN
												<br />
												<input type="checkbox" name="ein" value="1" <? if($ein == "1") echo " checked";?> />
											</td>
										</tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<span class="num">26.</span> 
									Patient Account No.
									<br />
									<input type="text" value="<?=$patient_account_no?>" name="patient_account_no" class="inbox_line3" size="20" />
								</td>
								<td valign="top" width="30%">
									<span class="num">27.</span> 
									Accept Assignment?
									<br />
									<span class="small_cap">(For govt. claims, see back)</span>
									<br />
									<input type="radio" name="accept_assignment" value="Yes" <? if($accept_assignment == "Yes") echo " checked";?> />
									YES
									&nbsp;&nbsp;&nbsp;
									<input type="radio" name="accept_assignment" value="No" <? if($accept_assignment == "No") echo " checked";?> />
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
                  
                  <?php
                  $ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." AND `status` = 1";
                  $ledgerres = mysql_query($ledgerquery);
                  
                  $ledgerquery2 = "SELECT paid_amount, transaction_type FROM dental_ledger WHERE `patientid` =".$_GET['pid']." and `transaction_type`='Credit'";
                  $ledgerres2 = mysql_query($ledgerquery2);
                  if($ledgerres2 && mysql_num_rows($ledgerres2) > 0){
                  $myarray2 = mysql_fetch_array($ledgerres2);
                  while($myarray = mysql_fetch_array($ledgerres)){
                   $cur_bal += st($myarray["amount"]);
                  }
                    foreach($myarray2 as $paid) {
          						$cur_bal2 += st($paid["paid_amount"]);
          					}
                    $cur_balfinal = $cur_bal - $cur_bal2;
                    }else{
                      $cur_bal = 0;
                      $cur_bal2 = 0;
                    }
                    ?><br />
        					$ <input type="text" value="<?php echo number_format($cur_bal,2); ?>" name="total_charge" class="inbox_line3" size="15" />
        					
									Total Charge
									<br />
									
								</td>
								<td valign="top" width="33%">
									<span class="num">29.</span> 
									Amount Paid
									<br />
									$ <input type="text" value="0" name="amount_paid" class="inbox_line3" size="15" onblur="cal_tot()" />
								</td>
								<td valign="top" width="33%">
									<span class="num">30.</span> 
									Balance Due
									<br />
									<?php $balance = $cur_bal - $myarray2['paid_amount']; ?>
									$ <input type="text" value="0" class="inbox_line3" size="15" />
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
									<input type="text" value="<?=$signature_physician?>" class="inbox_line3" size="40" name="signature_physician" />
									<br /><br />
									Signed
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Date: 
									<input type="text" value="<?=$physician_signed_date?>" name="physician_signed_date" class="inbox_line3" size="10" />
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
												<input type="text" value="<?php echo $userinfo['name'];?>" name="service_facility_info_name" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Address:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" value="<?php echo $userinfo['address'];?>" name="service_facility_info_address" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">City/State/Zip:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" value="<?php echo $userinfo['city'];?>, <?php echo $userinfo['state'];?> <?php echo $userinfo['zip'];?>" name="service_facility_info_city" class="inbox_line3" size="40" />
											</td>
										</tr>
									</table>
									<span class="num_a">
										a.
									</span>
									<input type="text" value="<?=$userinfo['npi']?>" name="service_info_a" class="inbox_line3" size="15" />
									
									<span class="num_a">
										b.
									</span>
									<select name="service_info_dd" class="inbox_line3" style="width:50px;">
										<option value=""></option>
										<?
										$qua_my = mysql_query($qua_sql);
										while($qua_myarray = mysql_fetch_array($qua_my))
										{?>
											<option value="<?=st($qua_myarray['qualifierid']);?>" <? if($service_info_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
												<?=st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
									<input type="text" value="<?=$service_info_b_other?>" name="service_info_b_other" class="inbox_line3" size="15" />
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="top" >
					
					
						<span class="num">33.</span> 
						Billing Provider Info & Ph#
						<span class="style1">(
						<input type="text" value="<?php echo substr($userinfo['phone'], 0, 3);?>" name="billing_provider_phone_code" size="3" class="inbox_line3" />
						)</span>
						&nbsp;&nbsp;&nbsp;
						<input type="text" value="<?php echo substr($userinfo['phone'], 3);?>" name="billing_provider_phone" class="inbox_line3" size="13"  />
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Name:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?php echo $userinfo['name'];?>" name="billing_provider_name" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Address:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?php echo $userinfo['address'];?>" name="billing_provider_address" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">City/State/Zip:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" value="<?php echo $userinfo['city'];?>, <?php echo $userinfo['state'];?> <?php echo $userinfo['zip'];?>" name="billing_provider_city" class="inbox_line3" size="40" />
								</td>
							</tr>
						</table>
						<span class="num_a">
							a.
						</span>
						<input type="text" value="<?=$userinfo['npi']?>" name="billing_provider_a" class="inbox_line3" size="15" />
						
						<span class="num_a">
							b.
						</span>
						<select name="billing_provider_dd" class="inbox_line3" style="width:50px;">
							<option value=""></option>
							<?
							$qua_my = mysql_query($qua_sql);
							while($qua_myarray = mysql_fetch_array($qua_my))
							{?>
								<option value="<?=st($qua_myarray['qualifierid']);?>" <? if($billing_provider_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
									<?=st($qua_myarray['qualifier']);?>
								</option>
							<?
							}?>
						</select>
						<input type="text" value="<?=$billing_provider_b_other?>" name="billing_provider_b_other" class="inbox_line3" size="15" />
					</td>
				</tr>
				
				
				
				
				
			
			</table>
		</td>
	</tr>
</table>

<div align="right">
    <input type="button" value="Print Claim Form"/><input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>
<script type="text/javascript">
	cal_tot();
</script>
<br />


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
</body>
</html>
