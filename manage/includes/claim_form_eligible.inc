  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="/manage/script/autocomplete_local.js"></script>

<?php
$status_sql = "SELECT status FROM dental_insurance 
		WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'
			AND patientid='".mysql_real_escape_string($_GET['pid'])."'";
$status_q = mysql_query($status_sql);
$status_r = mysql_fetch_assoc($status_q);
$status = $status_r['status'];
$is_sent = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? true : false;
$is_pending = ($status == DSS_CLAIM_PENDING || $status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_pri_pending = ($status == DSS_CLAIM_PENDING) ? true : false;
$is_sec_pending = ($status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_disputed = ($status == DSS_CLAIM_DISPUTE || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_PATIENT_DISPUTE || $status == DSS_CLAIM_SEC_PATIENT_DISPUTE) ? true : false;
$is_rejected = ($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED) ? true : false; 
$is_secondary = ($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_SENT || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_SEC_REJECTED); 

//confirm ledger transactions and make sure they haven't changed.
function confirm_ledger_trxns(){
    $num = 0;
    $return_val = true;
    while ($num <= ($_POST['ledgercount']-1)) {
	$ledgerid = $_POST['ledgerid'.$num];
        $sql = "SELECT * "
             . "  FROM dental_ledger "
             . "WHERE "
             . " ledgerid = ".$ledgerid;
        $query = mysql_query($sql);
	$c = mysql_num_rows($query);
	if($c){
        	$row = mysql_fetch_assoc($query);
		if($row['entry_date'] != $_POST['entry_date'.$num] ||
			$row['service_date'] != $_POST['service_date'.$num] ||
			$row['transaction_code'] != $_POST['transaction_code'.$num] ||
			$row['amount'] != $_POST['amount'.$num] ||
			$row['status'] == DSS_TRXN_NA
		){
			$return_val = false;
		}
	}else{
	  $return_val = false;
	}
	$num++;
    }
    return $return_val;
}


// update and changes to ledger trxns
// (updating associated claim id and status later w/ claim form insert and update)
function update_ledger_trxns($primary_claim_id, $trxn_status) {
    $num = 0;
    $added_ledger_ids = array();
    while ($num <= ($_POST['ledgercount']-1)) {
        $placeofservicenum =  'placeofservice'.$num;
        $emgnum = 'emg'.$num;
        $diagnosispointernum = 'diagnosispointer'.$num;
        $daysorunitsnum = 'daysorunits'.$num;
        $epsdtnum = 'epsdt'.$num;
        $idqualnum = 'idqual'.$num;
        $ledgeridnum = 'ledgerid'.$num;
        $modifiercodenum = 'modifiercode'.$num;
        $modifiercode2_num = 'modifiercode2_'.$num;
        $modifiercode3_num = 'modifiercode3_'.$num;
        $modifiercode4_num = 'modifiercode4_'.$num;
        
        $placeofservice = $_POST[$placeofservicenum];
        $emg = $_POST[$emgnum];             
        $diagnosispointer = $_POST[$diagnosispointernum]; 
        $daysorunits = $_POST[$daysorunitsnum];
        $epsdt = $_POST[$epsdtnum];
        $idqual = $_POST[$idqualnum];
        $modifiercode = $_POST[$modifiercodenum];
        $modifiercode2 = $_POST[$modifiercode2_num];
        $modifiercode3 = $_POST[$modifiercode3_num];
        $modifiercode4 = $_POST[$modifiercode4_num];
        $ledgerid = $_POST[$ledgeridnum];
        array_push($added_ledger_ids, $ledgerid);

        $sql = "UPDATE "
             . "  dental_ledger "
             . "SET "
             . "  `placeofservice` = '$placeofservice', "
             . "  `emg` = '$emg', "
             . "  `diagnosispointer` = '$diagnosispointer', "
             . "  `daysorunits` = '$daysorunits', "
             . "  `epsdt` = '$epsdt', "
             . "  `idqual` = '$idqual', "
             . "  `modcode` = '$modifiercode', "
             . "  `modcode2` = '$modifiercode2', "
             . "  `modcode3` = '$modifiercode3', "
             . "  `modcode4` = '$modifiercode4', "
             . "  `status` = '$trxn_status', "
             . "  `primary_claim_id` = '$primary_claim_id' "
             . "WHERE "
             . "  `ledgerid` = $ledgerid";
        $query = mysql_query($sql);
        if (!$query) {
            echo mysql_errno() . ": " . mysql_error(). "\n";
        }
        $num++;
    }

    $ledger_ids = implode(',', $added_ledger_ids);
    $upsql = "SELECT COUNT(*) as num_ledger from dental_ledger WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN (".$ledger_ids.")";
    $upq = mysql_query($upsql);
    $upr = mysql_fetch_assoc($upq);
    if($upr['num_ledger']>0){
	$prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".$primary_claim_id."'";
        $prod_q = mysql_query($prod_s);
        $prod_r = mysql_fetch_assoc($prod_q);
        $claim_producer = $prod_r['producer'];
  	$s = "SELECT insuranceid from dental_insurance where producer = '".mysql_real_escape_string($claim_producer)." AND patientid='".mysql_real_escape_string($_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
  	$q = mysql_query($s);
  	$n = mysql_num_rows($q);
  	if($n > 0){
          $r = mysql_fetch_assoc($q);
          $claim_id = $r['insuranceid'];
  	}else{
          $claim_id = create_claim($_GET['pid'], $claim_producer);
  	}

	$update_sql = "UPDATE dental_ledger set primary_claim_id='".$claim_id."' WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN (".$ledger_ids.")";
	mysql_query($update_sql);

    }

}

// deleting specified claim form
if ($_REQUEST["delid"] != "") {
	$del_sql = "delete from dental_procedure where procedureid='" . $_REQUEST["delid"] . "'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="delete_insurance.php?pid=<?=$_GET['pid'];?>&msg=<?=$msg?>&delid=<?=$_REQUEST['delid'];?>";
        </script>
        <?

	die(); // already did a javascript redirect...just die
}
$is_new_claim = ((!isset($_REQUEST['insid']) || $_REQUEST['insid'] == '') && $_POST['ed'] == '') ? true : false;
//print "\$is_new_claim: $is_new_claim";exit;

if($_POST['ex_statusbtn']){
?>
<script type="text/javascript">
  window.location = '<?= $called_from; ?>?insid=<?= $_GET['insid']; ?>&checkstatus=1&pid=<?= $_GET['pid']; ?>';
</script>
<?php
die();


// process inserts/updates for claim form
}elseif ($_POST['insurancesub'] == 1 || $_POST['ex_pagebtn']) {
    if($is_sent){
            print '<script type="text/javascript">';
        //print '  window.location="' . $called_from . '?showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '  window.location="' . $called_from . '?status=0&insid='.$_GET['insid'].'&showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '</script>';
    }
    if(!confirm_ledger_trxns()){
	?>
	<script type="text/javascript">
		window.location = "manage_claims.php?msg=Error sending claim: Frontoffice user has altered claim. Please reload and try again.";
	</script>
	<?php
	die();
    }
    // Put POST values into variables
	$pica1 = $_POST['pica1'];
	$pica2 = $_POST['pica2'];
	$pica3 = $_POST['pica3'];
	$insurance_type = $_POST['insurance_type'];
	$other_insurance_type = $_POST['other_insurance_type'];
	$patient_lastname = $_POST['patient_lastname'];
	$patient_firstname = $_POST['patient_firstname'];
	$patient_middle = $_POST['patient_middle'];
	$patient_dob = $_POST['patient_dob'];
	$patient_sex = $_POST['patient_sex'];
	$patient_address = $_POST['patient_address'];
	$patient_city = $_POST['patient_city'];
	$patient_state = $_POST['patient_state'];
	$patient_status = $_POST['patient_status'];
	$work_status = $_POST['work_status'];
	$patient_zip = $_POST['patient_zip'];
	$patient_phone_code = num($_POST['patient_phone_code']);
	$patient_phone = num($_POST['patient_phone'], false);
	$insured_id_number = $_POST['insured_id_number'];
	$insured_firstname = $_POST['insured_firstname'];
	$insured_lastname = $_POST['insured_lastname'];
	$insured_middle = $_POST['insured_middle'];
	$patient_relation_insured = $_POST['patient_relation_insured'];
	$insured_address = $_POST['insured_address'];
	$insured_state = $_POST['insured_state'];
	$insured_city = $_POST['insured_city'];
	$insured_zip = $_POST['insured_zip'];
	$insured_phone_code = num($_POST['insured_phone_code']);
	$insured_phone = num($_POST['insured_phone'], false);
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
	$federal_tax_id_number = num($_POST['federal_tax_id_number'], false);
	$ssn = ($_POST['ssnein']=="ssn")?'1':'';
	$ein = ($_POST['ssnein']=="ein")?'1':'';
	$patient_account_no = $_POST['patient_account_no'];
	$accept_assignment = $_POST['accept_assignment'];
	$total_charge = $_POST['total_charge'];
	$amount_paid = $_POST['amount_paid'];
	$balance_due = $_POST['balance_due'];
	$signature_physician = $_POST['signature_physician'];
	$physician_signed_date = (($_POST['physician_signed_date']!=date('m/d/Y'))?$_POST['physician_signed_date']:'');
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
	$reject_reason = $_POST['reject_reason'];
	if(isset($_POST['reject_but'])){
		$status = DSS_CLAIM_REJECTED;
	}else{
		$status = $_POST['status'];
	}
	$insurance_type_arr = $insurance_type;
	
	if($insurance_type_arr != '') {
		$insurance_type_arr = '~'.$insurance_type_arr.'~';
    }

	$patient_status_arr = '~'.$patient_status.'~'.$work_status.'~';

        if($_POST['p_m_eligible_payer']!=''){
                $p_m_eligible_payer_id = substr($_POST['p_m_eligible_payer'],0,strpos($_POST['p_m_eligible_payer'], '-'));
                $p_m_eligible_payer_name = substr($_POST['p_m_eligible_payer'],(strpos($_POST['p_m_eligible_payer'], '-')+1));
        }else{
                $p_m_eligible_payer_id = '';
                $p_m_eligible_payer_name = '';
        }
	
	// Insert new claim into dental_insurance table
	if ($is_new_claim) {
		$ins_sql = " insert into dental_insurance set 
		patientid = '".s_for($_GET['pid'])."',
		pica1 = '".s_for($pica1)."',
		pica2 = '".s_for($pica2)."',
		pica3 = '".s_for($pica3)."',
		insurance_type = '".s_for($insurance_type)."',
		other_insurance_type = '".s_for($other_insurance_type)."',
		insured_id_number = '".s_for($insured_id_number)."',
		patient_lastname = '".s_for($patient_lastname)."',
		patient_firstname = '".s_for($patient_firstname)."',
		patient_middle = '".s_for($patient_middle)."',
		patient_dob = '".s_for($patient_dob)."',
		patient_sex = '".s_for($patient_sex)."',
		insured_firstname = '".s_for($insured_firstname)."',
		insured_lastname = '".s_for($insured_lastname)."',
		insured_middle = '".s_for($insured_middle)."',
		patient_address = '".s_for($patient_address)."',
		patient_relation_insured = '".s_for($patient_relation_insured)."',
		patient_city = '".s_for($patient_city)."',
		patient_state = '".s_for($patient_state)."',
		patient_status = '".s_for($patient_status_arr)."',
		patient_zip = '".s_for($patient_zip)."',
		patient_phone_code = '".s_for($patient_phone_code)."',
		patient_phone = '".s_for($patient_phone)."',
		insured_address = '".s_for($insured_address)."',
		insured_city = '".s_for($insured_city)."',
		insured_state = '".s_for($insured_state)."',
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
		p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".$p_m_eligible_payer_name."',
		status = '".s_for(DSS_CLAIM_PENDING)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		// get the id of the inserted claim
		$primary_claim_id = mysql_insert_id();
		
		// update the ledger trxns passed in with the form
		update_ledger_trxns($primary_claim_id, DSS_TRXN_PROCESSING);
		
		$msg = "Added Successfully";
		
	    print '<script type="text/javascript">';
        print '  window.location="' . $called_from . '?pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '</script>';
		
		die(); // already did a javascript redirect...just die
		
    // Update the claim in the dental_insurance table
	} else {
             $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
             $pat_my = mysql_query($pat_sql);
             $pat_myarray = mysql_fetch_array($pat_my);
             $p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
             $u_status = $status;
             if($status == DSS_CLAIM_SENT){
		$fdf_type="primary";
                if($p_m_ins_ass == 'No'){
                   $u_status = DSS_CLAIM_PAID_PATIENT;
                }else{
		   if(isset($_POST['ex_pagebtn_elec'])){
		     $u_status = false;	
		   }else{
                     $u_status = DSS_CLAIM_SENT;
		   }
                }
             }elseif($status == DSS_CLAIM_SEC_SENT){
		$fdf_type="secondary";
                if($s_m_ins_ass == 'No'){
                  $u_status = DSS_CLAIM_PAID_PATIENT;
                }else{
                  $u_status = DSS_CLAIM_SEC_SENT;
                }
             }else{
		$fdf_type="primary";
               $u_status = false;
             }
		$ed_sql = " update dental_insurance set 
		pica2 = '".s_for($pica2)."',
		pica3 = '".s_for($pica3)."',
		patient_lastname = '".s_for($patient_lastname)."',
		patient_firstname = '".s_for($patient_firstname)."',
		patient_middle = '".s_for($patient_middle)."',
		patient_dob = '".s_for($patient_dob)."',
		patient_sex = '".s_for($patient_sex)."',
		patient_address = '".s_for($patient_address)."',
		patient_state = '".s_for($patient_state)."',
		patient_status = '".s_for($patient_status_arr)."',
		patient_city = '".s_for($patient_city)."',
		patient_zip = '".s_for($patient_zip)."',
		patient_phone_code = '".s_for($patient_phone_code)."',
		patient_phone = '".s_for($patient_phone)."',
		employment = '".s_for($employment)."',
		auto_accident = '".s_for($auto_accident)."',
		auto_accident_place = '".s_for($auto_accident_place)."',
		other_accident = '".s_for($other_accident)."',
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
		billing_provider_b_other = '".s_for($billing_provider_b_other)."',
                p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".$p_m_eligible_payer_name."'";
		if(isset($_POST['reject_but'])){
		  $ed_sql .= ", status = '".s_for(DSS_CLAIM_REJECTED)."'";
                  $ed_sql .= ", reject_reason = '".s_for($reject_reason)."'";
		}elseif($u_status){
		  $ed_sql .= ", status = '".s_for($u_status)."'";
		}
		$ed_sql .= " where insuranceid = '".s_for($_POST['ed'])."'";
		
/*
	//TAKE OUT INSURANCE FIELDS SO THEY KEEP ORIGINAL VALUES
		patient_relation_insured = '".s_for($patient_relation_insured)."',
                insurance_type = '".s_for($insurance_type)."',
                insured_id_number = '".s_for($insured_id_number)."',
                insured_firstname = '".s_for($insured_firstname)."',
                insured_lastname = '".s_for($insured_lastname)."',
                insured_middle = '".s_for($insured_middle)."',
                insured_address = '".s_for($insured_address)."',
                insured_city = '".s_for($insured_city)."',
                insured_state = '".s_for($insured_state)."',
                insured_zip = '".s_for($insured_zip)."',
                insured_phone_code = '".s_for($insured_phone_code)."',
                insured_phone = '".s_for($insured_phone)."',
                other_insured_firstname = '".s_for($other_insured_firstname)."',
                other_insured_lastname = '".s_for($other_insured_lastname)."',
                other_insured_middle = '".s_for($other_insured_middle)."',
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
*/



		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		// update the ledger trxns passed in with the form
		$trxn_status = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;
		update_ledger_trxns($_POST['ed'], $trxn_status);


		if(isset($_POST['p_m_ins_payer_id'])){
		  $pat_sql = "UPDATE dental_patients SET p_m_eligible_id = '".s_for($_POST['p_m_ins_payer_id'])."' WHERE patientid='".mysql_real_escape_string($pat_myarray['patientid'])."'";
		  mysql_query($pat_sql);
		}


		$msg = "Edited Successfully";
		
	    print '<script type="text/javascript">';
		if(isset($_POST['ex_pagebtn_elec'])){ 
        print '  window.location="' . $called_from . '?status=0&insid='.$_POST['ed'].'&type='.$fdf_type.'&sendins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
		}else{
        print '  window.location="' . $called_from . '?status=0&insid='.$_POST['ed'].'&type='.$fdf_type.'&showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
		}
        print '</script>';

		die(); // already did a javascript redirect...just die
	} // end claim form insert or update
} // end processing claim form
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$docid = $pat_myarray['docid'];
if($is_pri_pending){
// Load patient info from dental_patients table using pid on query string
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$insurancetype = st($pat_myarray['p_m_ins_type']);
$other_insurancetype = $pat_myarray['s_m_ins_type'];
$insured_firstname = st($pat_myarray['p_m_partyfname']);
$insured_lastname = st($pat_myarray['p_m_partylname']);
$insured_middle = st($pat_myarray['p_m_partymname']);
$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
$other_insured_lastname = st($pat_myarray['s_m_partylname']);
$other_insured_middle = st($pat_myarray['s_m_partymname']);
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
$other_insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
$insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
$other_insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
$referredby = st($pat_myarray['referred_by']); 
$referred_source = st($pat_myarray['referred_source']);
$docid = $pat_myarray['docid'];
// if patient does not have an id, redirect to manage_patient.php to address the issue
if ($pat_myarray['patientid'] == '') {
    print '<script type="text/javascript">';
    print '  window.location="manage_patient.php";';
    print '</script>';

	die(); // already did a javascript redirect...just die
}
}
$ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
// In the case where we have first come to this page, load the claim form
// info from dental_insurance and place them into variables.
$sql = "select * from dental_insurance where insuranceid='".$_GET['insid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);
$dent_rows = mysql_num_rows($my);
$insuranceid = st($myarray['insuranceid']);
$p_m_eligible_payer_id = $myarray['p_m_eligible_payer_id'];
$p_m_eligible_payer_name = $myarray['p_m_eligible_payer_name'];
if(!$is_pri_pending){
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$patient_lastname = st($myarray['patient_lastname']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
if($_GET['instype']==2){
  $insurancetype = st($myarray['other_insurance_type']);
  $other_insurancetype = $myarray['insurance_type'];
  $other_insured_firstname = st($myarray['insured_firstname']);
  $other_insured_lastname = st($myarray['insured_lastname']);
  $other_insured_middle = st($myarray['insured_middle']);
  $other_insured_dob = st($myarray['insured_dob']);
  $other_insured_sex = st($myarray['insured_sex']);
  $other_insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $insured_id_number = st($myarray['other_insured_id_number']);
  $insured_firstname = st($myarray['other_insured_firstname']);
  $insured_middle = st($myarray['other_insured_middle']);
  $insured_lastname = st($myarray['other_insured_lastname']);
  $insured_dob = st($myarray['other_insured_dob']);
  $insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $insured_address = st($myarray['other_insured_address']);
  $insured_city = st($myarray['other_insured_city']);
  $insured_state = st($myarray['other_insured_state']);
  $insured_zip = st($myarray['other_insured_zip']);
  $insured_phone_code = st($myarray['insured_phone_code']);
  $insured_phone = st($myarray['insured_phone']);
  $insured_sex = st($myarray['other_insured_sex']);
  $patient_relation_insured = st($myarray['patient_relation_other_insured']);
}else{
  $insurancetype = st($myarray['insurance_type']);
  $other_insurancetype = $myarray['other_insurance_type'];
  $other_insured_firstname = st($myarray['other_insured_firstname']);
  $other_insured_lastname = st($myarray['other_insured_lastname']);
  $other_insured_middle = st($myarray['other_insured_middle']);
  $other_insured_dob = st($myarray['other_insured_dob']);
  $other_insured_sex = st($myarray['other_insured_sex']);
  $other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $insured_id_number = st($myarray['insured_id_number']);
  $insured_firstname = st($myarray['insured_firstname']);
  $insured_middle = st($myarray['insured_middle']);
  $insured_lastname = st($myarray['insured_lastname']);
  $insured_dob = st($myarray['insured_dob']);
  $insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $insured_address = st($myarray['insured_address']);
  $insured_city = st($myarray['insured_city']);
  $insured_state = st($myarray['insured_state']);
  $insured_zip = st($myarray['insured_zip']);
  $insured_phone_code = st($myarray['insured_phone_code']);
  $insured_phone = st($myarray['insured_phone']);
  $insured_sex = st($myarray['insured_sex']);
  $patient_relation_insured = st($myarray['patient_relation_insured']);
}
$patient_address = st($myarray['patient_address']);
$patient_city = st($myarray['patient_city']);
$patient_state = st($myarray['patient_state']);
$patient_status = st($myarray['patient_status']);
$patient_status_array = split('~',$patient_status);
$patient_zip = st($myarray['patient_zip']);
$patient_phone_code = st($myarray['patient_phone_code']);
$patient_phone = st($myarray['patient_phone']);
$employment = st($myarray['employment']);
$auto_accident = st($myarray['auto_accident']);
$auto_accident_place = st($myarray['auto_accident_place']);
$other_accident = st($myarray['other_accident']);
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
$diagnosising_npi = st($myarray['field_17b']);
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
$physician_signed_date = st(($myarray['physician_signed_date']!='')?$myarray['physician_signed_date']:date('m/d/Y'));
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
$reject_reason = st($myarray['reject_reason']);
$status = st($myarray['status']);
}
if($pat_myarray['p_m_ins_type']!=1 && $pat_myarray['has_s_m_ins'] == 'Yes' && $pat_myarray['p_m_dss_file'] == 1 && $pat_myarray['s_m_dss_file'] ==1){
  $another_plan = 'YES';
}else{
  $another_plan = 'NO';
}
if($is_pri_pending){
  $insured_sex = $pat_myarray['p_m_gender'];
  $other_insured_sex = $pat_myarray['s_m_gender'];
  $patient_sex = $pat_myarray['gender'];
  $patient_firstname = $pat_myarray['firstname'];
	$patient_lastname = $pat_myarray['lastname'];
	$patient_middle = $pat_myarray['middlename'];
	$patient_firstname = $pat_myarray['firstname'];
	$patient_address = $pat_myarray['add1'];
	$patient_city = $pat_myarray['city'];
	$patient_state = $pat_myarray['state'];
	$patient_zip = $pat_myarray['zip'];
	$patient_dob = $pat_myarray['dob'];
	if($pat_myarray['p_m_ins_ass']=='Yes'){
	  $insured_signature = 1;
	}
	$patient_signature = 1;
	$signature_physician = "Signature on File";
	$patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
        $physician_signed_date = date('m/d/Y');	
	$patient_phone_code = split_phone($pat_myarray['home_phone'], true);
	$patient_phone = split_phone($pat_myarray['home_phone'], false);
	$insured_phone_code = split_phone($pat_myarray['home_phone'], true);
	$insured_phone = split_phone($pat_myarray['home_phone'], false);
	$patient_status = $pat_myarray['marital_status'];	
	$insured_id_number = $pat_myarray['p_m_ins_id'];
	$insured_address = $myarray['insured_address'];
	$insured_city = $myarray['insured_city'];
	$insured_state = $myarray['insured_state'];
	$insured_zip = $myarray['insured_zip'];
	$insured_dob = $pat_myarray['ins_dob'];	
	$patient_relation_insured = $pat_myarray['p_m_relation'];
	$insured_employer_school_name = $pat_myarray['employer'];
	if($pat_myarray['p_m_ins_type']==1){
	  $insured_policy_group_feca = "NONE";
          $insured_insurance_plan = '';
	  $insured_employer_school_name = '';
	}else{
	  $insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
	  $insured_insurance_plan = $pat_myarray['p_m_ins_plan'];	
	}
$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."' ORDER BY id DESC LIMIT 1;";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis_1 = $d['diagnosis'];

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."' ORDER BY id DESC LIMIT 1;";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $referring_provider = $d['diagnosising_doc'];
  $diagnosising_npi = $d['diagnosising_npi'];
if($insurancetype!=1){
  $referring_provider = '';
  $diagnosising_npi = '';

}

$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
//if ($dent_rows <= 0) {
    $accept_assignment = $accept_assignmentnew;
//}
}
// If claim doesn't yet have a preauth number, try to load it
// from the patient's most recently completed preauth.
if (empty($prior_authorization_number)) {
    $sql = "SELECT "
         . "  * "
         . "FROM "
         . "  dental_insurance_preauth "
         . "WHERE "
         . "  patient_id = '" . $_GET['pid'] . "' "
         . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
         . "ORDER BY "
         . "  date_completed desc "
         . "LIMIT 1";
    $my = mysql_query($sql);
    $num_rows = mysql_num_rows($my);
    
    if ($num_rows > 0) {
        $myarray = mysql_fetch_array($my);
        $prior_authorization_number = $myarray['pre_auth_num'];
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Health Insurance Claim Form</title>
<link rel="stylesheet" href="<?=$manage_path?>form/form.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
input{text-transform:uppercase;}
</style>
<script language="javascript" type="text/javascript" src="<?=$manage_path?>script/validation.js"></script>
</head>

<body>
<?php echo $msg; ?>

<link rel="stylesheet" href="<?=$admin_path?>popup/popup.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?=$admin_path?>script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?=$manage_path?>3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="<?=$manage_path?>script/masks.js"></script>
<script src="<?=$admin_path?>popup/popup.js" type="text/javascript"></script>

<?php if ($is_sent || (!$is_new_claim && !$is_pending && !$is_rejected && !$is_disputed && $is_front_office)) { ?>
  <script>
	$(function() {
	  $('input, select, textarea').attr('disabled', 'true');
	  $('.print-button').removeAttr('disabled');
	});
  </script>
<?php } ?>

<?php if ($is_front_office) { ?>
  <a href="manage_insurance.php?pid=<?=$_REQUEST['pid']?>">
	<b>&lt;&lt;Back to Manage Insurance Page</b></a>
<?php } else if ($is_back_office) { ?>
  <a href="manage_claims.php?status=0&pid=<?=$_REQUEST['pid_filter']?>">
	<b>&lt;&lt;Back to Manage Claims Page</b></a>
<?php } ?>


<?php
  if($is_rejected){
  ?> <div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">  <?php
  $r_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysql_real_escape_string($_GET['insid'])."' ORDER BY adddate DESC LIMIT 1";
$r_my = mysql_query($r_sql);
$r = mysql_fetch_assoc($r_my);
if($r['reference_id']){
    $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysql_real_escape_string($r['reference_id'])."' ORDER BY adddate DESC LIMIT 1";
    $w_q = mysql_query($w_sql);
    $w_r = mysql_fetch_assoc($w_q);
    if($w_r['response']!=''){
                          ?><h3><?= $w_r['event_type']; ?> on
                <?= $w_r['adddate']; ?></h3>
<?php $p = json_decode($w_r['response']); ?>
                                <p>Category: <?= $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
                                Status: <?= $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"status_label"}; ?>
                                </p>

                                <p><?= $w_r['response']; ?></p>
                        <?php
    }
}
if(!$r['reference_id'] || !$w_r['response']){
 	?>
                <h3>Claim Electronically filed on
                <?= $r['adddate']; ?></h3>
                        <?php
                        $d = json_decode($r['response']);
                        $success = $d->{"success"};
                        if($success=="true"){
                                ?><p><strong>Success Response:</strong><br /><?php
                        }else{
                                ?><p><strong>Error Response:</strong><br /><?php
                                        $errors = $d->{"errors"}->{"messages"};
                                        foreach($errors as $error){
                                          echo $error."<br />";
                                        }
                        }
                        ?>
                <?= $r['response'];?></p>
<?php } ?>
        </div>

<?php
}


 $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
        $prod_q = mysql_query($prod_s);
        $prod_r = mysql_fetch_assoc($prod_q);
        $claim_producer = $prod_r['producer'];

                      $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
                      $userquery = mysql_query($getuserinfo);
                      if($userinfo = mysql_fetch_array($userquery)){
                        $phone = $userinfo['phone'];
                        $practice = $userinfo['practice'];
                        $address = $userinfo['address'];
                        $city = $userinfo['city'];
                        $state = $userinfo['state'];
                        $zip = $userinfo['zip'];
                        $npi = $userinfo['npi'];
                        $medicare_npi = $userinfo['medicare_npi'];
                      }
                      $getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
                      $docquery = mysql_query($getdocinfo);
                      $docinfo = mysql_fetch_array($docquery);
                        if($phone == ""){ $phone = $docinfo['phone']; }
                        if($practice == ""){ $practice = $docinfo['practice']; }
                        if($address == ""){ $address = $docinfo['address']; }
                        if($city == ""){ $city = $docinfo['city']; }
                        if($state == ""){ $state = $docinfo['state']; }
                        if($zip == ""){ $zip = $docinfo['zip']; }
                        if($npi == ""){ $npi = $docinfo['npi']; }
                        if($medicare_npi == ""){ $medicare_npi = $docinfo['medicare_npi']; }

                        if($docinfo['use_service_npi']==1){
                          $service_npi = $docinfo['service_npi'];
                          $service_practice = $docinfo['service_name'];
                          $service_address = $docinfo['service_address'];
                          $service_city = $docinfo['service_city'];
                          $service_state = $docinfo['service_state'];
                          $service_zip = $docinfo['service_zip'];
                          $service_medicare_npi = $docinfo['service_medicare_npi'];
                        }else{
                          $service_npi = $npi;
                          $service_practice = $practice;
                          $service_address = $address;
                          $service_city = $city;
                          $service_state = $state;
                          $service_zip = $zip;
                          $service_medicare_npi = $medicare_npi;
                        }





?>

<form name="insurancefrm" action="<?=$_SERVER['PHP_SELF'];?>?insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>" method="post">
	<input type="hidden" name="insurancesub" value="1" />
	<input type="hidden" name="ed" value="<?=$insuranceid;?>" />
	
	<div align="right">
        <?php if ($is_sent) { ?>
          Claim has been sent
		<?php if($is_back_office){ ?>
			<input type="submit" class="print-button" name="ex_pagebtn" value="Print Claim" />
			<input type="submit" class="print-button" name="ex_statusbtn" value="Check Status" />
		<?php } ?>
	    <?php } else if ($is_back_office) { ?>
               <?php if($status == DSS_CLAIM_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?=DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SEC_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?=DSS_CLAIM_SEC_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?=DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?=DSS_CLAIM_SEC_SENT?>" />
               <?php }else ?>
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" 
		<?php if($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED){ ?>
onclick="return confirm('This claim has been rejected. By printing this claim the status will be changed to SENT, and the rejection notification will be removed. Click OK to proceed.');"
		<?php } ?>
		value="Print Claim" />
          <input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />

        <?php } ?>

		<?php } elseif ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
               <?php if(($is_pending || $is_disputed || $is_rejected) && $p_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?=DSS_CLAIM_SENT?>" />
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1){
  if($is_pending){
?>
          <input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />
  <?php }elseif($is_rejected){
?>
          <input type="submit" name="ex_pagebtn_elec" onclick="return file_reject_claim();" value="Resubmit Claim" />
  <?php 
  } ?>
<?php } ?>
        <?php } ?>

               <?php }elseif(($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_REJECTED) && $s_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?=DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?=DSS_CLAIM_SEC_SENT?>" />
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="file_claim();return false;" value="Electronically File Claim" />-->

        <?php } ?>

               <?php } ?>

                <?php } ?>
		<!--<input type="button" class="print-button" onClick="window.print()" value="Print Claim Form"/>-->

		&nbsp;&nbsp;&nbsp;
	</div>
<?php
if ($is_back_office || (($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) && ($is_pending || $is_rejected) && $p_m_dss_file == '2')){ 
                $p_m_ins_payer_id = st($pat_myarray["p_m_eligible_id"]);
                if($p_m_ins_payer_id){
                  $dsql = "SELECT name, payer_id FROM dental_ins_payer
                        WHERE id=".mysql_real_escape_string($p_m_ins_payer_id);
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $p_m_ins_payer_name = $d['payer_id']." - ".$d['name'];
                }else{
                  $p_m_ins_payer_name = "";
                }	
?>

 Insurance Co.
                                        <input type="text" id="ins_payer_name" onclick="updateval_local(this)" autocomplete="off" name="ins_payer_name" value="<?= ($p_m_eligible_payer_id!='')?$p_m_eligible_payer_id.' - '.$p_m_eligible_payer_name:'Type insurance payer name'; ?>" style="width:300px;" />
<br />
        <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                <ul id="ins_payer_list" class="search_list">
                        <li class="template" style="display:none"></li>
                </ul>
        </div>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'p_m_eligible_payer', '', 'https://eligibleapi.com/resources/payers/claims/medical.json', null, null, null, true);
});
</script>
<input type="hidden" name="p_m_eligible_payer" id="p_m_eligible_payer" value="<?=$p_m_eligible_payer_id."-".$p_m_eligible_payer_name;?>" />



<?php } ?>





        <!-- Jquery -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <!-- Jquery UI-->

        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src="https://eligibleapi.com/js/eligible-claim-1500-2014.min.js"></script>

        <link href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css" rel="stylesheet">

        <script type="text/javascript"> window.eligiblePublicKey="-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-"</script>

    </head>

    <body>

    <form action="claim_handler.php" method="POST">

        <div id="eligibleapi-claim-1500-form"></div>

    </form>


<script type="text/javascript">
  $(document).ready( function(){

    $('input[name="subscriber[id]"]').val("<?= $insured_id_number;?>");

    $('input[name="dependent[last_name]"]').val("<?= $patient_lastname;?>");
    $('input[name="dependent[first_name]"]').val("<?= $patient_firstname;?>");
    $('input[name="dependent[middle_name]"]').val("<?= $patient_middle;?>");
    $('input[name="dependent[dob]"]').val("<?= $patient_dob;?>");
    $('input[name="dependent[gender]"][value="<?= $patient_sex; ?>"]').attr("checked", "checked");
    $('input[name="dependent[address][street_line_1]"]').val("<?= $patient_address;?>");
    $('input[name="dependent[address][city]"]').val("<?= $patient_city;?>");
    $('input[name="dependent[address][state]"]').val("<?= $patient_state;?>");
    $('input[name="dependent[address][zip]"]').val("<?= $patient_zip;?>");
    $('input[name="dependent[phone_number]"]').val("<?= $patient_phone;?>");

    $('input[name="subscriber[last_name]"]').val("<?= $insured_lastname;?>");
    $('input[name="subscriber[first_name]"]').val("<?= $insured_firstname;?>");
    $('input[name="subscriber[middle_name]"]').val("<?= $insured_middle;?>");
    $('input[name="subscriber[dob]"]').val("<?= $insured_dob;?>");
    $('input[name="subscriber[gender]"][value="<?= $insured_sex; ?>"]').attr("checked", "checked");
    $('input[name="subscriber[address][street_line_1]"]').val("<?= $insured_address;?>");
    $('input[name="subscriber[address][city]"]').val("<?= $insured_city;?>");
    $('input[name="subscriber[address][state]"]').val("<?= $insured_state;?>");
    $('input[name="subscriber[address][zip]"]').val("<?= $insured_zip;?>");
    $('input[name="subscriber[phone_number]"]').val("<?= $insured_phone;?>");
    $('input[name="subscriber[group_id]"]').val("<?= $insured_policy_group_feca;?>");
    $('input[name="subscriber[group_name]"]').val("<?= $insured_insurance_plan;?>");

    $('input[name="other_payers[0][subscriber][last_name]"]').val("<?= $other_insured_lastname;?>");
    $('input[name="other_payers[0][subscriber][first_name]"]').val("<?= $other_insured_firstname;?>");
    $('input[name="other_payers[0][subscriber][middle_name]"]').val("<?= $other_insured_middle;?>");
    $('input[name="other_payers[0][subscriber][group_id]"]').val("<?= $other_insured_policy_group_feca;?>");
    $('input[name="other_payers[0][subscriber][group_name]"]').val("<?= $other_insured_insurance_plan;?>");

    <?php if($employment == "YES"){ ?>
      $('input[name="claim[related_to_employment]"][value="true"]').attr("checked", "checked");
    <?php }elseif($employment == "NO"){ ?>
      $('input[name="claim[related_to_employment]"][value="false"]').attr("checked", "checked");
    <?php } ?>
    <?php if($auto_accident == "YES"){ ?>
      $('input[name="claim[auto_accident]"][value="true"]').attr("checked", "checked");
    <?php }elseif($auto_accident == "NO"){ ?>
      $('input[name="claim[auto_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>
    <?php if($other_accident == "YES"){ ?>
      $('input[name="claim[other_accident]"][value="true"]').attr("checked", "checked");
    <?php }elseif($other_accident == "NO"){ ?>
      $('input[name="claim[other_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    <?php if($another_plan == "YES"){ ?>
      $('input[name="claim[other_payer]"][value="true"]').attr("checked", "checked");
    <?php }elseif($another_plan == "NO"){ ?>
      $('input[name="claim[other_payer]"][value="false"]').attr("checked", "checked");
    <?php } ?>



    $('input[name="claim[last_worked_date]"]').val("<?= $unable_date_from; ?>");
    $('input[name="claim[work_return_date]"]').val("<?= $unable_date_to; ?>");
    $('input[name="claim[admission_date]"]').val("<?= $hospitalization_date_from; ?>");
    $('input[name="claim[discharge_date]"]').val("<?= $hospitalization_date_to; ?>");

    $('input[name="referring_provider[secondary_id]"]').val("<?= $field_17a; ?>");

    <?php if($outside_lab == "YES"){ ?>
      $('input[name="claim[outside_lab]"][value="true"]').attr("checked", "checked");
    <?php }elseif($outside_lab == "NO"){ ?>
      $('input[name="claim[outside_lab]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    $('input[name="claim[frequency]"]').val("<?= $medicaid_resubmission_code; ?>");
    $('input[name="claim[original_ref_number]"]').val("<?= $original_ref_no; ?>");
    $('input[name="claim[prior_authorization_number]"]').val("<?= $prior_authorization_number; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_1)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][1]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_2)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][2]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_3)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][3]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_4)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][4]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");



<?php
// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";
$mod_my = mysql_query($mod_sql);
$mod_array = array();
while ($mod_row = mysql_fetch_array($mod_my)) {
  $mod_array[] = $mod_row;
}

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "";
if ($is_new_claim) {
  $sql = "SELECT "
       . "  ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_1 as modcode2, trxn_code.days_units as daysorunits, ";
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= " as 'provider_id', ps.place_service as 'place' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
} else {
  $sql = "SELECT "
       . "  ledger.*, ";
if($is_pending){
  $sql .= "trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits, ";
}
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= "  as 'provider_id', ps.place_service as 'place', ps2.description AS place_description "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "  LEFT JOIN dental_place_service ps2 ON ledger.placeofservice = ps2.place_service "
       . "WHERE "
       . "  ledger.primary_claim_id = " . $insuranceid . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
}
$query = mysql_query($sql);
// Display ledger trxns
?>
  <?php $li = 0; ?>
  <?php while ($array = mysql_fetch_array($query)) { ?>
  <?php  $pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place']; ?>
  <?php $dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1; ?>
    $('input[name="claim[service_lines][<?=$li;?>][service_date_from]"]').val("<?= date('Y-m-d', strtotime($array['service_date'])); ?>");
    $('input[name="claim[service_lines][<?=$li;?>][service_date_to]"]').val("<?= date('Y-m-d', strtotime($array['service_date'])) ?>");
    $('select[name="claim[service_lines][<?=$li;?>][place_of_service]"]').val("<?= $pos; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][emergency]"]').val("<?= $x; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_code]"]').val("<?php echo $array['transaction_code']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][0]"]').val("<?= $array['modcode']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][1]"]').val("<?= $array['modcode2']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][2]"]').val("<?= $array['modcode3']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][3]"]').val("<?= $array['modcode4']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][diagnosis_code_pointers][<?=$dp-1; ?>]"]').attr("checked","checked");
    $('input[name="claim[service_lines][<?=$li;?>][charge_amount]"]').val("<?= number_format($array['amount'], 2); ?>");
    $('input[name="claim[service_lines][<?=$li;?>][units]"]').val("<?= $array['daysorunits']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][rendering_provider][npi]"]').val("<?= $array['provider_id']; ?>");
	


    <?php $li++; ?>
  <?php } 

                                                                                                  if($userinfo['tax_id_or_ssn'] != ''){
                                                                                                        $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
                                                                                                  }else{
                                                                                                        $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
                                                                                                  }
                                                                                                  if($userinfo['ssn'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ssn = $userinfo['ssn'];
                                                                                                  }else{
                                                                                                        $ssn = $docinfo['ssn'];
                                                                                                  }
                                                                                                  if($userinfo['ein'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ein = $userinfo['ein'];
                                                                                                  }else{         
                                                                                                        $ein = $docinfo['ein'];
                                                                                                  }

	?>

    $('input[name="billing_provider[tax_id]"]').val("<?= $tax_id_or_ssn; ?>"); 
    <? if($ssn=="1"){ ?>
    $('input[name="billing_provider[tax_id_type]"][value="SY"]').attr("checked", "checked"); 
    <?php }elseif($ein=="1"){ ?>
    $('input[name="billing_provider[tax_id_type]"][value="EI"]').attr("checked", "checked"); 
    <?php } ?>
    $('input[name="service_facility[name]"]').val("<?= $service_practice; ?>");
    $('input[name="service_facility[address][street_line_1]"]').val("<?= $service_address; ?>");
    $('input[name="service_facility[address][city]"]').val("<?= $service_city; ?>");
    $('input[name="service_facility[address][state]"]').val("<?= $service_state; ?>");
    $('input[name="service_facility[address][zip]"]').val("<?= $service_zip; ?>");
    $('input[name="service_facility[npi]"]').val("<?= ($insurancetype == '1')?$service_medicare_npi:$service_npi; ?>");
 
    $('input[name="billing_provider[phone_number]"]').val("<?= $phone; ?>");
    $('input[name="billing_provider[organization_name]"]').val("<?= $practice; ?>");
    $('input[name="billing_provider[address][street_line_1]"]').val("<?= $address; ?>");
    $('input[name="billing_provider[address][city]"]').val("<?= $city; ?>");
    $('input[name="billing_provider[address][state]"]').val("<?= $state; ?>");
    $('input[name="billing_provider[address][zip]"]').val("<?= $zip; ?>");
    $('input[name="billing_provider[npi]"]').val("<?= ($insurancetype == '1')?$medicare_npi:$npi; ?>"); 


<?php
$total_charge = (empty($total_charge)) ? 0.00 : $total_charge;
$amount_paid = (empty($amount_paid)) ? 0.00 : number_format($amount_paid, 2);
$balance_due = (empty($balance_due)) ? 0.00 : number_format($balance_due,2);

// We only calculate the dollar amounts when a new claim is created because
// right now we aren't appending any trxns to an existing claim.
if ($is_pending) {

  // get total_charge
  if($is_pri_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysql_query($sql);
    if ($charge_my && (mysql_num_rows($charge_my) > 0)) {
      $charge_row = mysql_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }
  // get amount paid
  $sql = "SELECT "
       . "  SUM(ledger.paid_amount) as 'amount_paid' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
       . "ORDER BY "
       . "  ledger.service_date ASC";
  if($_GET['instype']==2 && $status == DSS_CLAIM_SEC_PENDING){
    $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl
                LEFT JOIN dental_users p ON dl.producerid=p.userid
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docid."' and dl.patientid='".s_for($_GET['pid'])."'
                        AND primary_claim_id=".$_GET['insid']."
                        AND dlp.amount != 0
                        AND dlp.payer = 0
        ";
  }
  $paid_my = mysql_query($sql);
  if ($paid_my && (mysql_num_rows($paid_my) > 0)) {
    $paid_row = mysql_fetch_array($paid_my);
    $amount_paid = $paid_row['amount_paid'];
  }

  // re-calculate balance due
  $balance_due = $total_charge - $amount_paid;
  // format calculations
  $total_charge = number_format($total_charge, 2, '.','');
  $amount_paid = number_format($amount_paid, 2, '.','');
  $balance_due = number_format($balance_due, 2, '.','');

}
?>


    $('input[name="claim[total_charge]"]').val("<?= $total_charge; ?>");
    $('input[name="claim[patient_amount_paid]"]').val("<?= $amount_paid; ?>");

  });

</script>



