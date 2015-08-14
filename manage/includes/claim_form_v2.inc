<?php namespace Ds3\Libraries\Legacy; ?>

  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="/manage/script/autocomplete_local.js?v=<?= time() ?>"></script>

<?php

$status_sql = "SELECT status FROM dental_insurance 
		WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'
			AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

$status_r = $db->getRow($status_sql);
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
	$db = new Db();
	$con = $GLOBALS['con'];

    $num = 0;
    $return_val = true;
    while ($num <= ($_POST['ledgercount']-1)) {
	$ledgerid = $_POST['ledgerid'.$num];
        $sql = "SELECT * "
             . "  FROM dental_ledger "
             . "WHERE "
             . " ledgerid = '".mysqli_real_escape_string($con, $ledgerid) . "'";
        $query = $db->getRow($sql);

	if(!empty($query)){
        	$row = $query;
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
    $db = new Db();
    $con = $GLOBALS['con'];

    $num = 0;
    $added_ledger_ids = array();
    while ($num <= ($_POST['ledgercount']-1)) {
        $placeofservicenum =  'placeofservice'.$num;
        $emgnum = 'emg'.$num;
	$diagnosispointernum = '[service_lines]['.$num.'][diagnosis_code_pointers][0]';
        //$diagnosispointernum = 'diagnosispointer'.$num;
        $daysorunitsnum = 'daysorunits'.$num;
        $epsdtnum = 'epsdt'.$num;
        $idqualnum = 'idqual'.$num;
        $ledgeridnum = 'ledgerid'.$num;
        $modifiercodenum = 'modifiercode'.$num;
        $modifiercode2_num = 'modifiercode2_'.$num;
        $modifiercode3_num = 'modifiercode3_'.$num;
        $modifiercode4_num = 'modifiercode4_'.$num;
        
        $placeofservice = mysqli_real_escape_string($con, $_POST[$placeofservicenum]);
        $emg = mysqli_real_escape_string($con, $_POST[$emgnum]);             
        $diagnosispointer = mysqli_real_escape_string($con, $_POST['service_lines'][$num]['diagnosis_code_pointers'][0]); 
        $daysorunits = mysqli_real_escape_string($con, $_POST[$daysorunitsnum]);
        $epsdt = mysqli_real_escape_string($con, $_POST[$epsdtnum]);
        $idqual = mysqli_real_escape_string($con, $_POST[$idqualnum]);
        $modifiercode = mysqli_real_escape_string($con, $_POST[$modifiercodenum]);
        $modifiercode2 = mysqli_real_escape_string($con, $_POST[$modifiercode2_num]);
        $modifiercode3 = mysqli_real_escape_string($con, $_POST[$modifiercode3_num]);
        $modifiercode4 = mysqli_real_escape_string($con, $_POST[$modifiercode4_num]);
        $ledgerid = mysqli_real_escape_string($con, $_POST[$ledgeridnum]);
        
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
             . "  `ledgerid` = '$ledgerid'";
        $query = $db->query($sql);
        if (!$query) {
            echo mysqli_errno($con) . ": " . mysqli_error($con). "\n";
        }
        $num++;
    }

    // Ids are already escaped
    $ledger_ids = "'" . join("', '", $added_ledger_ids) . "'";
    $upsql = "SELECT COUNT(*) as num_ledger from dental_ledger WHERE primary_claim_id='".mysqli_real_escape_string($con, $primary_claim_id)."' AND ledgerid NOT IN (".$ledger_ids.")";

    $upr = $db->getRow($upsql);
    if($upr['num_ledger']>0){
	$prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con, $primary_claim_id)."'";

        $prod_r = $db->getRow($prod_s);
        $claim_producer = $prod_r['producer'];
  	$s = "SELECT insuranceid from dental_insurance where producer = '".mysqli_real_escape_string($con,$claim_producer)."' AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
  	$q = $db->getRow($s);
  	if(!empty($q)){
          $r = $q;
          $claim_id = $r['insuranceid'];
  	}else{
          $claim_id = create_claim($_GET['pid'], $claim_producer);
  	}

	$update_sql = "UPDATE dental_ledger set primary_claim_id='".$claim_id."' WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN ('".$ledger_ids."')";
	$db->query($update_sql);

    }

}

// deleting specified claim form
if (!empty($_REQUEST["delid"]) ? $_REQUEST["delid"] : '') {
	$del_sql = "delete from dental_procedure where procedureid='" . mysqli_real_escape_string($con, $_REQUEST["delid"]) . "'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="delete_insurance.php?pid=<?php echo $_GET['pid'];?>&msg=<?php echo $msg?>&delid=<?php echo $_REQUEST['delid'];?>";
        </script>
        <?

	trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
}
$is_new_claim = ((!isset($_REQUEST['insid']) || $_REQUEST['insid'] == '') && empty($_POST['ed'])) ? true : false;
//print "\$is_new_claim: $is_new_claim";trigger_error("Exit called", E_USER_ERROR);

if(!empty($_POST['ex_statusbtn'])){
?>
<script type="text/javascript">
  window.location = '<?php echo  $called_from; ?>?insid=<?php echo  (!empty($_GET['insid']) ? $_GET['insid'] : ''); ?>&checkstatus=1&pid=<?php echo  $_GET['pid']; ?>';
</script>
<?php
trigger_error("Die called", E_USER_ERROR);


// process inserts/updates for claim form
}elseif (!empty($_POST['insurancesub']) && $_POST['insurancesub'] == 1 || !empty($_POST['ex_pagebtn'])) {
    if($is_sent){
            print '<script type="text/javascript">';
        //print '  window.location="' . $called_from . '?showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '  window.location="' . $called_from . '?status=0&insid='.(!empty($_GET['insid']) ? $_GET['insid'] : '').'&showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '</script>';
    }
    if(!confirm_ledger_trxns()){
	?>
	<script type="text/javascript">
		window.location = "manage_claims.php?msg=Error sending claim: Frontoffice user has altered claim. Please reload and try again.";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
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

  //we need to convert the DOB from mm-dd-yyyy to YYYY-MM-dd
	$patient_dob_raw = $_POST['patient_dob'];
  $patient_dob_pieces = explode('-', $patient_dob_raw);
  $month = $patient_dob_pieces[0];
  $day = $patient_dob_pieces[1];
  $year = $patient_dob_pieces[2];
  $patient_dob_pieces[0] = $year;
  $patient_dob_pieces[1] = $month;
  $patient_dob_pieces[2] = $day;
  $patient_dob = implode("-", $patient_dob_pieces);
	$patient_sex = $_POST['patient_sex'];
	$patient_address = $_POST['patient_address'];
	$patient_city = $_POST['patient_city'];
	$patient_state = $_POST['patient_state'];
	$patient_status = (!empty($_POST['patient_status']) ? $_POST['patient_status'] : '');
	$work_status = (!empty($_POST['work_status']) ? $_POST['work_status'] : '');
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
	$other_insured_id_number = $_POST['other_insured_id_number'];
	$other_insured_firstname = $_POST['other_insured_firstname'];
	$other_insured_lastname = $_POST['other_insured_lastname'];
	$other_insured_middle = $_POST['other_insured_middle'];
	$employment = (!empty($_POST['employment']) ? $_POST['employment'] : '');
	$auto_accident = (!empty($_POST['auto_accident']) ? $_POST['auto_accident'] : '');
	$auto_accident_place = $_POST['auto_accident_place'];
	$other_accident = (!empty($_POST['other_accident']) ? $_POST['other_accident'] : '');
	$insured_policy_group_feca = $_POST['insured_policy_group_feca'];
	$other_insured_policy_group_feca = $_POST['other_insured_policy_group_feca'];
	//we need to convert the DOB from mm-dd-yyyy to YYYY-MM-dd
  $insured_dob_raw = $_POST['insured_dob'];
  $insured_dob_pieces = explode('-', $insured_dob_raw);
  $month = $insured_dob_pieces[0];
  $day = $insured_dob_pieces[1];
  $year = $insured_dob_pieces[2];
  $insured_dob_pieces[0] = $year;
  $insured_dob_pieces[1] = $month;
  $insured_dob_pieces[2] = $day;
  $insured_dob = implode("-", $insured_dob_pieces);
	$insured_sex = $_POST['insured_sex'];
	$other_insured_dob = (!empty($_POST['other_insured_dob']) ? $_POST['other_insured_dob'] : '');
	$other_insured_sex = (!empty($_POST['other_insured_sex']) ? $_POST['other_insured_sex'] : '');
	$insured_employer_school_name = (!empty($_POST['insured_employer_school_name']) ? $_POST['insured_employer_school_name'] : '');
	$other_insured_employer_school_name = (!empty($_POST['other_insured_employer_school_name']) ? $_POST['other_insured_employer_school_name'] : '');
	$insured_insurance_plan = $_POST['insured_insurance_plan'];
	$other_insured_insurance_plan = $_POST['other_insured_insurance_plan'];
	$reserved_local_use = (!empty($_POST['reserved_local_use']) ? $_POST['reserved_local_use'] : '');
	$another_plan = $_POST['another_plan'];
	$patient_signature = $_POST['patient_signature'];
	$patient_signed_date = $_POST['patient_signed_date'];
	$insured_signature = $_POST['insured_signature'];
	$date_current = $_POST['date_current'];
	$date_same_illness = $_POST['date_same_illness'];
	$unable_date_from = $_POST['unable_date_from'];
	$unable_date_to = $_POST['unable_date_to'];
	$name_referring_provider_qualifier = $_POST['name_referring_provider_qualifier'];
	$referring_provider = $_POST['referring_provider'];
	$field_17a_dd = $_POST['field_17a_dd'];
	$field_17a = $_POST['field_17a'];
	$field_17b = $_POST['field_17b'];
	$hospitalization_date_from = $_POST['hospitalization_date_from'];
	$hospitalization_date_to = $_POST['hospitalization_date_to'];
	$reserved_local_use1 = $_POST['reserved_local_use1'];
	$outside_lab = (!empty($_POST['outside_lab']) ? $_POST['outside_lab'] : '');
	$s_charges = $_POST['s_charges'];
	$diagnosis_1 = (!empty($_POST['diagnosis_1']) ? $_POST['diagnosis_1'] : '');
	$diagnosis_2 = (!empty($_POST['diagnosis_2']) ? $_POST['diagnosis_2'] : '');
	$diagnosis_3 = (!empty($_POST['diagnosis_3']) ? $_POST['diagnosis_3'] : '');
	$diagnosis_4 = (!empty($_POST['diagnosis_4']) ? $_POST['diagnosis_4'] : '');
	$icd_ind = $_POST['icd_ind'];
	$diagnosis_a = $_POST['diagnosis_a'];
	$diagnosis_b = $_POST['diagnosis_b'];
	$diagnosis_c = $_POST['diagnosis_c'];
	$diagnosis_d = $_POST['diagnosis_d'];
	$diagnosis_e = $_POST['diagnosis_e'];
	$diagnosis_f = $_POST['diagnosis_f'];
	$diagnosis_g = $_POST['diagnosis_g'];
	$diagnosis_h = $_POST['diagnosis_h'];
	$diagnosis_i = $_POST['diagnosis_i'];
	$diagnosis_j = $_POST['diagnosis_j'];
	$diagnosis_k = $_POST['diagnosis_k'];
	$diagnosis_l = $_POST['diagnosis_l'];
	$medicaid_resubmission_code = (!empty($_POST['medicaid_resubmission_code']) ? $_POST['medicaid_resubmission_code'] : '');
    $resubmission_code_fill = $_POST['resubmission_code_fill'];
	$original_ref_no = $_POST['original_ref_no'];
	$prior_authorization_number = $_POST['prior_authorization_number'];
	$service_date1_from = (!empty($_POST['service_date1_from']) ? $_POST['service_date1_from'] : '');
	$service_date1_to = (!empty($_POST['service_date1_to']) ? $_POST['service_date1_to'] : '');
	$place_of_service1 = (!empty($_POST['place_of_service1']) ? $_POST['place_of_service1'] : '');
	$emg1 = (!empty($_POST['emg1']) ? $_POST['emg1'] : '');
	$cpt_hcpcs1 = (!empty($_POST['cpt_hcpcs1']) ? $_POST['cpt_hcpcs1'] : '');
	$modifier1_1 = (!empty($_POST['modifier1_1']) ? $_POST['modifier1_1'] : '');
	$modifier1_2 = (!empty($_POST['modifier1_2']) ? $_POST['modifier1_2'] : '');
	$modifier1_3 = (!empty($_POST['modifier1_3']) ? $_POST['modifier1_3'] : '');
	$modifier1_4 = (!empty($_POST['modifier1_4']) ? $_POST['modifier1_4'] : '');
	$diagnosis_pointer1 = (!empty($_POST['diagnosis_pointer1']) ? $_POST['diagnosis_pointer1'] : '');
	$s_charges1_1 = (!empty($_POST['s_charges1_1']) ? $_POST['s_charges1_1'] : '');
	$s_charges1_2 = (!empty($_POST['s_charges1_2']) ? $_POST['s_charges1_2'] : '');
	$days_or_units1 = (!empty($_POST['days_or_units1']) ? $_POST['days_or_units1'] : '');
	$epsdt_family_plan1 = (!empty($_POST['epsdt_family_plan1']) ? $_POST['epsdt_family_plan1'] : '');
	$id_qua1 = (!empty($_POST['id_qua1']) ? $_POST['id_qua1'] : '');
	$rendering_provider_id1 = (!empty($_POST['rendering_provider_id1']) ? $_POST['rendering_provider_id1'] : '');
	$service_date2_from = (!empty($_POST['service_date2_from']) ? $_POST['service_date2_from'] : '');
	$service_date2_to = (!empty($_POST['service_date2_to']) ? $_POST['service_date2_to'] : '');
	$place_of_service2 = (!empty($_POST['place_of_service2']) ? $_POST['place_of_service2'] : '');
	$emg2 = (!empty($_POST['emg2']) ? $_POST['emg2'] : '');
	$cpt_hcpcs2 = (!empty($_POST['cpt_hcpcs2']) ? $_POST['cpt_hcpcs2'] : '');
	$modifier2_1 = (!empty($_POST['modifier2_1']) ? $_POST['modifier2_1'] : '');
	$modifier2_2 = (!empty($_POST['modifier2_2']) ? $_POST['modifier2_2'] : '');
	$modifier2_3 = (!empty($_POST['modifier2_3']) ? $_POST['modifier2_3'] : '');
	$modifier2_4 = (!empty($_POST['modifier2_4']) ? $_POST['modifier2_4'] : '');
	$diagnosis_pointer2 = (!empty($_POST['diagnosis_pointer2']) ? $_POST['diagnosis_pointer2'] : '');
	$s_charges2_1 = (!empty($_POST['s_charges2_1']) ? $_POST['s_charges2_1'] : '');
	$s_charges2_2 = (!empty($_POST['s_charges2_2']) ? $_POST['s_charges2_2'] : '');
	$days_or_units2 = (!empty($_POST['days_or_units2']) ? $_POST['days_or_units2'] : '');
	$epsdt_family_plan2 = (!empty($_POST['epsdt_family_plan2']) ? $_POST['epsdt_family_plan2'] : '');
	$id_qua2 = (!empty($_POST['id_qua2']) ? $_POST['id_qua2'] : '');
	$rendering_provider_id2 = (!empty($_POST['rendering_provider_id2']) ? $_POST['rendering_provider_id2'] : '');
	$service_date3_from = (!empty($_POST['service_date3_from']) ? $_POST['service_date3_from'] : '');
	$service_date3_to = (!empty($_POST['service_date3_to']) ? $_POST['service_date3_to'] : '');
	$place_of_service3 = (!empty($_POST['place_of_service3']) ? $_POST['place_of_service3'] : '');
	$emg3 = (!empty($_POST['emg3']) ? $_POST['emg3'] : '');
	$cpt_hcpcs3 = (!empty($_POST['cpt_hcpcs3']) ? $_POST['cpt_hcpcs3'] : '');
	$modifier3_1 = (!empty($_POST['modifier3_1']) ? $_POST['modifier3_1'] : '');
	$modifier3_2 = (!empty($_POST['modifier3_2']) ? $_POST['modifier3_2'] : '');
	$modifier3_3 = (!empty($_POST['modifier3_3']) ? $_POST['modifier3_3'] : '');
	$modifier3_4 = (!empty($_POST['modifier3_4']) ? $_POST['modifier3_4'] : '');
	$diagnosis_pointer3 = (!empty($_POST['diagnosis_pointer3']) ? $_POST['diagnosis_pointer3'] : '');
	$s_charges3_1 = (!empty($_POST['s_charges3_1']) ? $_POST['s_charges3_1'] : '');
	$s_charges3_2 = (!empty($_POST['s_charges3_2']) ? $_POST['s_charges3_2'] : '');
	$days_or_units3 = (!empty($_POST['days_or_units3']) ? $_POST['days_or_units3'] : '');
	$epsdt_family_plan3 = (!empty($_POST['epsdt_family_plan3']) ? $_POST['epsdt_family_plan3'] : '');
	$id_qua3 = (!empty($_POST['id_qua3']) ? $_POST['id_qua3'] : '');
	$rendering_provider_id3 = (!empty($_POST['rendering_provider_id3']) ? $_POST['rendering_provider_id3'] : '');
	$service_date4_from = (!empty($_POST['service_date4_from']) ? $_POST['service_date4_from'] : '');
	$service_date4_to = (!empty($_POST['service_date4_to']) ? $_POST['service_date4_to'] : '');
	$place_of_service4 = (!empty($_POST['place_of_service4']) ? $_POST['place_of_service4'] : '');
	$emg4 = (!empty($_POST['emg4']) ? $_POST['emg4'] : '');
	$cpt_hcpcs4 = (!empty($_POST['cpt_hcpcs4']) ? $_POST['cpt_hcpcs4'] : '');
	$modifier4_1 = (!empty($_POST['modifier4_1']) ? $_POST['modifier4_1'] : '');
	$modifier4_2 = (!empty($_POST['modifier4_2']) ? $_POST['modifier4_2'] : '');
	$modifier4_3 = (!empty($_POST['modifier4_3']) ? $_POST['modifier4_3'] : '');
	$modifier4_4 = (!empty($_POST['modifier4_4']) ? $_POST['modifier4_4'] : '');
	$diagnosis_pointer4 = (!empty($_POST['diagnosis_pointer4']) ? $_POST['diagnosis_pointer4'] : '');
	$s_charges4_1 = (!empty($_POST['s_charges4_1']) ? $_POST['s_charges4_1'] : '');
	$s_charges4_2 = (!empty($_POST['s_charges4_2']) ? $_POST['s_charges4_2'] : '');
	$days_or_units4 = (!empty($_POST['days_or_units4']) ? $_POST['days_or_units4'] : '');
	$epsdt_family_plan4 = (!empty($_POST['epsdt_family_plan4']) ? $_POST['epsdt_family_plan4'] : '');
	$id_qua4 = (!empty($_POST['id_qua4']) ? $_POST['id_qua4'] : '');
	$rendering_provider_id4 = (!empty($_POST['rendering_provider_id4']) ? $_POST['rendering_provider_id4'] : '');
	$service_date5_from = (!empty($_POST['service_date5_from']) ? $_POST['service_date5_from'] : '');
	$service_date5_to = (!empty($_POST['service_date5_to']) ? $_POST['service_date5_to'] : '');
	$place_of_service5 = (!empty($_POST['place_of_service5']) ? $_POST['place_of_service5'] : '');
	$emg5 = (!empty($_POST['emg5']) ? $_POST['emg5'] : '');
	$cpt_hcpcs5 = (!empty($_POST['cpt_hcpcs5']) ? $_POST['cpt_hcpcs5'] : '');
	$modifier5_1 = (!empty($_POST['modifier5_1']) ? $_POST['modifier5_1'] : '');
	$modifier5_2 = (!empty($_POST['modifier5_2']) ? $_POST['modifier5_2'] : '');
	$modifier5_3 = (!empty($_POST['modifier5_3']) ? $_POST['modifier5_3'] : '');
	$modifier5_4 = (!empty($_POST['modifier5_4']) ? $_POST['modifier5_4'] : '');
	$diagnosis_pointer5 = (!empty($_POST['diagnosis_pointer5']) ? $_POST['diagnosis_pointer5'] : '');
	$s_charges5_1 = (!empty($_POST['s_charges5_1']) ? $_POST['s_charges5_1'] : '');
	$s_charges5_2 = (!empty($_POST['s_charges5_2']) ? $_POST['s_charges5_2'] : '');
	$days_or_units5 = (!empty($_POST['days_or_units5']) ? $_POST['days_or_units5'] : '');
	$epsdt_family_plan5 = (!empty($_POST['epsdt_family_plan5']) ? $_POST['epsdt_family_plan5'] : '');
	$id_qua5 = (!empty($_POST['id_qua5']) ? $_POST['id_qua5'] : '');
	$rendering_provider_id5 = (!empty($_POST['rendering_provider_id5']) ? $_POST['rendering_provider_id5'] : '');
	$service_date6_from = (!empty($_POST['service_date6_from']) ? $_POST['service_date6_from'] : '');
	$service_date6_to = (!empty($_POST['service_date6_to']) ? $_POST['service_date6_to'] : '');
	$place_of_service6 = (!empty($_POST['place_of_service6']) ? $_POST['place_of_service6'] : '');
	$emg6 = (!empty($_POST['emg6']) ? $_POST['emg6'] : '');
	$cpt_hcpcs6 = (!empty($_POST['cpt_hcpcs6']) ? $_POST['cpt_hcpcs6'] : '');
	$modifier6_1 = (!empty($_POST['modifier6_1']) ? $_POST['modifier6_1'] : '');
	$modifier6_2 = (!empty($_POST['modifier6_2']) ? $_POST['modifier6_2'] : '');
	$modifier6_3 = (!empty($_POST['modifier6_3']) ? $_POST['modifier6_3'] : '');
	$modifier6_4 = (!empty($_POST['modifier6_4']) ? $_POST['modifier6_4'] : '');
	$diagnosis_pointer6 = (!empty($_POST['diagnosis_pointer6']) ? $_POST['diagnosis_pointer6'] : '');
	$s_charges6_1 = (!empty($_POST['s_charges6_1']) ? $_POST['s_charges6_1'] : '');
	$s_charges6_2 = (!empty($_POST['s_charges6_2']) ? $_POST['s_charges6_2'] : '');
	$days_or_units6 = (!empty($_POST['days_or_units6']) ? $_POST['days_or_units6'] : '');
	$epsdt_family_plan6 = (!empty($_POST['epsdt_family_plan6']) ? $_POST['epsdt_family_plan6'] : '');
	$id_qua6 = (!empty($_POST['id_qua6']) ? $_POST['id_qua6'] : '');
	$rendering_provider_id6 = (!empty($_POST['rendering_provider_id6']) ? $_POST['rendering_provider_id6'] : '');
	$federal_tax_id_number = num((!empty($_POST['federal_tax_id_number']) ? $_POST['federal_tax_id_number'] : ''), false);
	$ssn = (!empty($_POST['ssnein']) && $_POST['ssnein']=="ssn")?'1':'';
	$ein = (!empty($_POST['ssnein']) && $_POST['ssnein']=="ein")?'1':'';
	$patient_account_no = $_POST['patient_account_no'];
	$accept_assignment = $_POST['accept_assignment'];
	$total_charge = $_POST['total_charge'];
	$amount_paid = $_POST['amount_paid'];
	$balance_due = (!empty($_POST['balance_due']) ? $_POST['balance_due'] : '');
	$signature_physician = $_POST['signature_physician'];
	// $physician_signed_date = (($_POST['physician_signed_date']!=date('m/d/Y'))?$_POST['physician_signed_date']:'');

    if ($_POST['physician_signed_date'] != date('m/d/Y')) {
        $dateFromPost = str_replace('/', '-', $_POST['physician_signed_date']);
        if ($physician_signed_date = date_create_from_format('m-d-y', $dateFromPost)) {
            $physician_signed_date = $physician_signed_date->format('m/d/Y');
        } elseif ($physician_signed_date = date_create_from_format('m-d-Y', $dateFromPost)) {
            $physician_signed_date = $physician_signed_date->format('m/d/Y');
        } else {
            $physician_signed_date = date('m/d/Y');
        }
    } else {
        $physician_signed_date = '';
    }

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
	$reject_reason = (!empty($_POST['reject_reason']) ? $_POST['reject_reason'] : '');
	$nucc_8a = $_POST['nucc_8a'];
	$nucc_8b = $_POST['nucc_8b'];
	$nucc_9a = (!empty($_POST['nucc_9a']) ? $_POST['nucc_9a'] : '');
	$nucc_9b = $_POST['nucc_9b'];
	$claim_codes = $_POST['claim_codes'];
	$other_claim_id = $_POST['other_claim_id'];
	$nucc_30 = $_POST['nucc_30'];
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

        if($_POST['s_m_eligible_payer']!=''){
                $s_m_eligible_payer_id = substr($_POST['s_m_eligible_payer'],0,strpos($_POST['s_m_eligible_payer'], '-'));
                $s_m_eligible_payer_name = substr($_POST['s_m_eligible_payer'],(strpos($_POST['s_m_eligible_payer'], '-')+1));
        }else{
                $s_m_eligible_payer_id = '';
                $s_m_eligible_payer_name = '';
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
		other_insured_id_number = '".s_for($other_insured_id_number)."',
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
		name_referring_provider_qualifier = '".s_for($name_referring_provider_qualifier)."',
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
		icd_ind = '".s_for($icd_ind)."',
		diagnosis_a = '".s_for($diagnosis_a)."',
		diagnosis_b = '".s_for($diagnosis_b)."',
		diagnosis_c = '".s_for($diagnosis_c)."',
		diagnosis_d = '".s_for($diagnosis_d)."',
		diagnosis_e = '".s_for($diagnosis_e)."',
		diagnosis_f = '".s_for($diagnosis_f)."',
		diagnosis_g = '".s_for($diagnosis_g)."',
		diagnosis_h = '".s_for($diagnosis_h)."',
		diagnosis_i = '".s_for($diagnosis_i)."',
		diagnosis_j = '".s_for($diagnosis_j)."',
		diagnosis_k = '".s_for($diagnosis_k)."',
		diagnosis_l = '".s_for($diagnosis_l)."',
		medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
		resubmission_code_fill = '".s_for($resubmission_code_fill)."',
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
		nucc_8a = '".s_for($nucc_8a)."',
		nucc_8b = '".s_for($nucc_8b)."',
		nucc_9a = '".s_for($nucc_9a)."',
		nucc_9b = '".s_for($nucc_9b)."',
		claim_codes = '".s_for($claim_codes)."',
		other_claim_id = '".s_for($other_claim_id)."',
		nucc_30 = '".s_for($nucc_30)."',
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
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
		s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
                s_m_eligible_payer_name = '".mysqli_real_escape_string($con,$s_m_eligible_payer_name)."',
		status = '".s_for(DSS_CLAIM_PENDING)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
			
		// get the id of the inserted claim
		$primary_claim_id = $db->getInsertId($ins_sql);
		
		// update the ledger trxns passed in with the form
		update_ledger_trxns($primary_claim_id, DSS_TRXN_PROCESSING);
	claim_history_update($primary_claim_id, $_SESSION['userid'], $_SESSION['adminuserid']);	
		$msg = "Added Successfully";
		
	    print '<script type="text/javascript">';
        print '  window.location="' . $called_from . '?pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
        print '</script>';
		
		trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
		
    // Update the claim in the dental_insurance table
	} else {
        $primary_claim_id = intval($_POST['ed']);
             $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

             $pat_myarray = $db->getRow($pat_sql);
             $p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
             $u_status = $status;
             if($status == DSS_CLAIM_SENT){
		$fdf_type="primary";
                if($p_m_ins_ass == 'No'){
                   $u_status = DSS_CLAIM_PAID_PATIENT;
                }else{
		   if(isset($_POST['ex_pagebtn_elec']) || isset($_POST['elec_save'])){
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
    other_insured_id_number = '".s_for($other_insured_id_number)."',
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
		name_referring_provider_qualifier = '".s_for($name_referring_provider_qualifier)."',
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
		icd_ind = '".s_for($icd_ind)."',
    diagnosis_a = '".s_for($diagnosis_a)."',
    diagnosis_b = '".s_for($diagnosis_b)."',
    diagnosis_c = '".s_for($diagnosis_c)."',
    diagnosis_d = '".s_for($diagnosis_d)."',
    diagnosis_e = '".s_for($diagnosis_e)."',
    diagnosis_f = '".s_for($diagnosis_f)."',
    diagnosis_g = '".s_for($diagnosis_g)."',
    diagnosis_h = '".s_for($diagnosis_h)."',
    diagnosis_i = '".s_for($diagnosis_i)."',
    diagnosis_j = '".s_for($diagnosis_j)."',
    diagnosis_k = '".s_for($diagnosis_k)."',
    diagnosis_l = '".s_for($diagnosis_l)."',
		medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
		resubmission_code_fill = '".s_for($resubmission_code_fill)."',
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
    nucc_8a = '".s_for($nucc_8a)."',
    nucc_8b = '".s_for($nucc_8b)."',
    nucc_9a = '".s_for($nucc_9a)."',
    nucc_9b = '".s_for($nucc_9b)."',
    claim_codes = '".s_for($claim_codes)."',
    other_claim_id = '".s_for($other_claim_id)."',
    nucc_30 = '".s_for($nucc_30)."',
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
    p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
    s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
    s_m_eligible_payer_name = '".mysqli_real_escape_string($con,$s_m_eligible_payer_name)."'";
		if(isset($_POST['reject_but'])){
		  $ed_sql .= ", status = '".s_for(DSS_CLAIM_REJECTED)."'";
                  $ed_sql .= ", reject_reason = '".s_for($reject_reason)."'";
		}elseif($u_status){
		  $ed_sql .= ", status = '".s_for($u_status)."'";
		}
		$ed_sql .= " where insuranceid = '$primary_claim_id'";


		$db->query($ed_sql);
		// update the ledger trxns passed in with the form
		$trxn_status = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;
		update_ledger_trxns($primary_claim_id, $trxn_status);


		if(isset($_POST['p_m_ins_payer_id'])){
		  $pat_sql = "UPDATE dental_patients SET p_m_eligible_id = '".s_for($_POST['p_m_ins_payer_id'])."' WHERE patientid='".mysqli_real_escape_string($con,$pat_myarray['patientid'])."'";
		  $db->query($pat_sql);
		}
                if(isset($_POST['s_m_ins_payer_id'])){
                  $pat_sql = "UPDATE dental_patients SET s_m_eligible_id = '".s_for($_POST['s_m_ins_payer_id'])."' WHERE patientid='".mysqli_real_escape_string($con,$pat_myarray['patientid'])."'";
                  $db->query($pat_sql);
                }


claim_history_update($primary_claim_id, $_SESSION['userid'], $_SESSION['adminuserid']);

		$msg = "Edited Successfully";
		
	    print '<script type="text/javascript">';
		if(isset($_POST['ex_pagebtn_elec'])){ 
        print '  window.location="' . $called_from . '?status=0&insid='.$_POST['ed'].'&type=primary&sendins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
		}elseif(isset($_POST['elec_save'])){ 
        print '  window.location="'.$electronic_form.'"';
		}else{
        print '  window.location="' . $called_from . '?status=0&insid='.$_POST['ed'].'&type=primary&showins=1&pid=' . $_GET['pid'] . '&msg=' . $msg . '";';
		}
        print '</script>';

		trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
	} // end claim form insert or update
} // end processing claim form
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

$pat_myarray = $db->getRow($pat_sql);
$docid = $pat_myarray['docid'];
if($is_pri_pending){
// Load patient info from dental_patients table using pid on query string
$pat_sql = "select p.*, c.exclusive from dental_patients p
	LEFT JOIN dental_users u ON u.userid=p.docid
	LEFT JOIN companies c ON c.id=u.billing_company_id
	 where p.patientid='".s_for($_GET['pid'])."'
";

$pat_myarray = $db->getRow($pat_sql);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
if($pat_myarray['exclusive']){ $p_m_dss_file = 1; }
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$insurancetype = st($pat_myarray['p_m_ins_type']);
$other_insurancetype = $pat_myarray['s_m_ins_type'];
$insured_firstname = st($pat_myarray['p_m_partyfname']);
$insured_lastname = st($pat_myarray['p_m_partylname']);
$insured_middle = st($pat_myarray['p_m_partymname']);
if ($pat_myarray['p_m_same_address'] == 1){
  $insured_address = st($pat_myarray['add1']);
  $insured_city = st($pat_myarray['city']);
  $insured_state = st($pat_myarray['state']);
  $insured_zip = st($pat_myarray['zip']);
} else {
  $insured_address = st($pat_myarray['p_m_address']);
  $insured_city = st($pat_myarray['p_m_city']);
  $insured_state = st($pat_myarray['p_m_state']);
  $insured_zip = st($pat_myarray['p_m_zip']);
}
$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
$other_insured_lastname = st($pat_myarray['s_m_partylname']);
$other_insured_middle = st($pat_myarray['s_m_partymname']);
if ($pat_myarray['s_m_same_address'] == 1){
  $insured_address = st($pat_myarray['add1']);
  $insured_city = st($pat_myarray['city']);
  $insured_state = st($pat_myarray['state']);
  $insured_zip = st($pat_myarray['zip']);
} else {
  $insured_address = st($pat_myarray['s_m_address']);
  $insured_city = st($pat_myarray['s_m_city']);
  $insured_state = st($pat_myarray['s_m_state']);
  $insured_zip = st($pat_myarray['s_m_zip']);
}
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$other_insured_id_number = st($pat_myarray['s_m_ins_id']);
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

	trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
}
}
$ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
// In the case where we have first come to this page, load the claim form
// info from dental_insurance and place them into variables.
$sql = "select * from dental_insurance where insuranceid='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."' and patientid='".$_GET['pid']."'";
$my = $db->getResults($sql);
$myarray = (!empty($my[0]) ? $my[0] : array());
$dent_rows = count($my);
$insuranceid = st((!empty($myarray['insuranceid'])) ? $myarray['insuranceid'] : '');
$orig_claim_id = (!empty($myarray['primary_claim_id']) ? $myarray['primary_claim_id'] : '');
$fdf_file = (!empty($myarray['primary_fdf']) ? $myarray['primary_fdf'] : '');
$p_m_eligible_payer_id = (!empty($myarray['p_m_eligible_payer_id']) ? $myarray['p_m_eligible_payer_id'] : '');
$p_m_eligible_payer_name = (!empty($myarray['p_m_eligible_payer_name']) ? $myarray['p_m_eligible_payer_name'] : '');
$s_m_eligible_payer_id = (!empty($myarray['s_m_eligible_payer_id']) ? $myarray['s_m_eligible_payer_id'] : '');
$s_m_eligible_payer_name = (!empty($myarray['s_m_eligible_payer_name']) ? $myarray['s_m_eligible_payer_name'] : '');
if(!$is_pri_pending){
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
if(!empty($pat_myarray['exclusive'])){ $p_m_dss_file = 1; }
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$patient_lastname = st($myarray['patient_lastname']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
if(!empty($_GET['instype']) && $_GET['instype']==2){
  $insurancetype = st($myarray['other_insurance_type']);
  $other_insurancetype = $myarray['insurance_type'];
  $other_insured_firstname = st($myarray['insured_firstname']);
  $other_insured_lastname = st($myarray['insured_lastname']);
  $other_insured_middle = st($myarray['insured_middle']);
  $other_insured_dob = st($myarray['insured_dob']);
  $other_insured_sex = st($myarray['insured_sex']);
  $other_insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $other_insured_id_number = st($myarray['insured_id_number']);
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
  $other_insured_id_number = st($myarray['other_insured_id_number']);
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
$patient_status_array = explode('~',$patient_status);
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
$name_referring_provider_qualifier = st($myarray['name_referring_provider_qualifier']);
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
$icd_ind = st($myarray['icd_ind']);
$diagnosis_a = st($myarray['diagnosis_a']);
$diagnosis_b = st($myarray['diagnosis_b']);
$diagnosis_c = st($myarray['diagnosis_c']);
$diagnosis_d = st($myarray['diagnosis_d']);
$diagnosis_e = st($myarray['diagnosis_e']);
$diagnosis_f = st($myarray['diagnosis_f']);
$diagnosis_g = st($myarray['diagnosis_g']);
$diagnosis_h = st($myarray['diagnosis_h']);
$diagnosis_i = st($myarray['diagnosis_i']);
$diagnosis_j = st($myarray['diagnosis_j']);
$diagnosis_k = st($myarray['diagnosis_k']);
$diagnosis_l = st($myarray['diagnosis_l']);
$medicaid_resubmission_code = st($myarray['medicaid_resubmission_code']);
$resubmission_code_fill = st($myarray['resubmission_code_fill']);
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
$nucc_8a = st($myarray['nucc_8a']);
$nucc_8b = st($myarray['nucc_8b']);
$nucc_9a = st($myarray['nucc_9a']);
$nucc_9b = st($myarray['nucc_9b']);
$claim_codes = st($myarray['claim_codes']);
$other_claim_id = st($myarray['other_claim_id']);
$nucc_30 = st($myarray['nucc_30']);
$signature_physician = st($myarray['signature_physician']);
// $physician_signed_date = st(($myarray['physician_signed_date']!='')?$myarray['physician_signed_date']:date('m/d/Y'));

if (!empty($myarray['physician_signed_date'])) {
    $dateFromDatabase = str_replace('/', '-', $myarray['physician_signed_date']);
    if ($physician_signed_date = date_create_from_format('m-d-y', $dateFromDatabase)) {
        $physician_signed_date = $physician_signed_date->format('m/d/Y');
    } elseif ($physician_signed_date = date_create_from_format('m-d-Y', $dateFromDatabase)) {
        $physician_signed_date = $physician_signed_date->format('m/d/Y');
    } else {
        $physician_signed_date = date('m/d/Y');
    }
} else {
    $physician_signed_date = date('m/d/Y');
}

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
if($pat_myarray['p_m_ins_type']=1 && $pat_myarray['has_s_m_ins'] == 'Yes' && $p_m_dss_file == 1 && $pat_myarray['s_m_dss_file'] ==1){
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
	$other_insured_id_number = $pat_myarray['s_m_ins_id'];
	$insured_address = (!empty($myarray['insured_address']) ? $myarray['insured_address'] : '');
	$insured_city = (!empty($myarray['insured_city']) ? $myarray['insured_city'] : '');
	$insured_state = (!empty($myarray['insured_state']) ? $myarray['insured_state'] : '');
	$insured_zip = (!empty($myarray['insured_zip']) ? $myarray['insured_zip'] : '');
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
                        ss.filename IS NOT NULL AND ss.patiendid = '".mysqli_real_escape_string($con, $_GET['pid'])."' ORDER BY id DESC LIMIT 1;";

  $d = $db->getRow($sleepstudies);
  $diagnosis_1 = (!empty($d['diagnosis']) ? $d['diagnosis'] : '');
  $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con,$diagnosis_1)."'";

     $ins_diag = $db->getRow($ins_diag_sql);
     $diagnosis_a = $ins_diag['ins_diagnosis'];

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".mysqli_real_escape_string($con, !empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC LIMIT 1;";

  $d = $db->getRow($sleepstudies);
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
         . "  patient_id = '" . mysqli_real_escape_string($con, $_GET['pid']) . "' "
         . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
         . "ORDER BY "
         . "  date_completed desc "
         . "LIMIT 1";

    $my = $db->getRow($sql);
    
    if (!empty($my)) {
        $myarray = $my;
        $prior_authorization_number = $myarray['pre_auth_num'];
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Health Insurance Claim Form</title>
<link rel="stylesheet" href="<?php echo $manage_path?>form/form.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
input{text-transform:uppercase;}
</style>
<script language="javascript" type="text/javascript" src="<?php echo $manage_path?>script/validation.js"></script>
</head>

<body>
<?php echo (!empty($msg) ? $msg : ''); ?>

<link rel="stylesheet" href="<?php echo $admin_path?>popup/popup.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $admin_path?>script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $manage_path?>3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="<?php echo $manage_path?>script/masks.js"></script>
<script src="<?php echo $admin_path?>popup/popup.js" type="text/javascript"></script>

<?php if ($is_sent || (!$is_new_claim && !$is_pending && !$is_rejected && !$is_disputed && $is_front_office)) { ?>
  <script>
	$(function() {
	  //$('.print-button').removeAttr('disabled');
	});
  </script>
<?php } ?>

<?php if (!empty($is_front_office)) { ?>
  <a href="view_claim.php?claimid=<?php echo (!empty($_GET['insid']) ? $_GET['insid'] : '');?>&pid=<?php echo $_GET['pid']?>">
	<b>&lt;&lt;Back to Manage Insurance Page</b></a>
<?php } else if ($is_back_office) { ?>
  <a href="manage_claims.php">
	<b>&lt;&lt;Back to Manage Claims Page</b></a>
<?php } ?>
<?php if(!empty($is_front_office)){ ?>
<?php if($is_secondary){ ?>
        <h4>Secondary Claim (<a href="insurance_v2.php?insid=<?php echo $orig_claim_id; ?>&pid=<?php echo $_GET['pid']; ?>">Primary is <?php echo $orig_claim_id; ?></a>)</h4>
<?php }else{
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";

  $sec_r = $db->getRow($sec_sql);
?>
        <h4>Primary Claim
        <?php if(!empty($sec_r)){ ?>
                (<a href="insurance_v2.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Secondary is <?php echo $sec_r['insuranceid']; ?></a>)
        <?php } ?>
        </h4>
<?php } ?>
<?php }else{ ?>
<?php if($is_secondary){ ?>
	<h4>Secondary Claim (<a href="insurance_claim_v2.php?insid=<?php echo $orig_claim_id; ?>&pid=<?php echo $_GET['pid']; ?>">Primary is <?php echo $orig_claim_id; ?></a>)</h4>
<?php }else{ 
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";

  $sec_r = $db->getRow($sec_sql);	
?>
        <h4>Primary Claim
	<?php if(!empty($sec_r)){ ?>
		(<a href="insurance_claim_v2.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo $_GET['pid']; ?>">Secondary is <?php echo $sec_r['insuranceid']; ?></a>)
	<?php } ?>
	</h4>
<?php } ?>
<?php } ?>
<form name="insurancefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?insid=<?php echo (!empty($_GET['insid']) ? $_GET['insid'] : '')?>&pid=<?php echo $_GET['pid']?>" method="post">
	<input type="hidden" name="insurancesub" value="1" />
	<input type="hidden" name="ed" value="<?php echo $insuranceid;?>" />
	
	<div align="right">
        <?php if ($is_sent) { ?>
            Claim has been sent
            <!-- Give user ability to print claim again and update claim history -->
            <input type="submit" class="print-button" name="ex_pagebtn" value="REPRINT Claim" title="Reprint your claim.&#013;&#013;If you make changes to the CMS 1500 form they will appear on the reprint&#013;and will be saved in claim history." />
            <?php if ($is_back_office) { ?>
                <input type="submit" class="print-button" name="ex_statusbtn" value="Check Status" />
            <?php } ?>
        <?php } else if (!empty($is_back_office)) { ?>
               <?php if($status == DSS_CLAIM_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
               <?php }else ?>
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" 
		<?php if($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED){ ?>
onclick="return confirm('This claim has been rejected. By printing this claim the status will be changed to SENT, and the rejection notification will be removed. Click OK to proceed.');"
		<?php } ?>
		value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
	  <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
        <?php } ?>

		<?php } elseif ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
               <?php if(($is_pending || $is_disputed || $is_rejected) && $p_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";

  $api_r = $db->getRow($api_sql);
  if($api_r['use_eligible_api']==1){
  if($is_pending){
?>
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
	  <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
  <?php }elseif($is_rejected || $is_disputed){
?>
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_reject_claim();" value="Resubmit Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
  <?php 
  } ?>
<?php } ?>
        <?php } ?>

               <?php }elseif(($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_REJECTED) && $s_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="file_claim();return false;" value="Electronically File Claim" />-->

        <?php } ?>

               <?php } ?>

                <?php } ?>
		<!--<input type="button" class="print-button" onClick="window.print()" value="Print Claim Form"/>-->
<?php
if (!empty($is_back_office)){
?>
		<input type="button" class="print-button" onclick="window.location='claim_notes.php?id=<?php echo  (!empty($_GET['insid']) ? $_GET['insid'] : ''); ?>&pid=<?php echo  $_GET['pid']; ?>'" value="View Notes" />
<?php
}
?>

<?php
if(!empty($is_front_office) && $is_sent && $fdf_file!=''){
?>
        <a href="display_fdf_v2.php?f=<?php echo $fdf_file;?>" class="print-button" >Print Claim Form</a>
<?php
}

?>
		&nbsp;&nbsp;&nbsp;
	</div>



<?php
  if($is_rejected){
  ?> <div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">  <?php
  $r_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."' ORDER BY adddate DESC LIMIT 1";

$r = $db->getRow($r_sql);
if($r['reference_id']){
    $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysqli_real_escape_string($con,$r['reference_id'])."' ORDER BY adddate DESC LIMIT 1";

    $w_r = $db->getRow($w_sql);
    if($w_r['response']!=''){
                          ?><h3><?php echo  $w_r['event_type']; ?> on
                <?php echo  $w_r['adddate']; ?></h3>
<?php $p = json_decode($w_r['response']); ?>
                                <p>Category: <?php echo  $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
                                Status: <?php echo  $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"status_label"}; ?>
                                </p>

                        <?php
    }
}
if(!$r['reference_id'] || !$w_r || !$w_r['response'] || $w_r['response']==''){
        ?>
                <h3>Claim Electronically filed on
                <?php echo  $r['adddate']; ?></h3>
                        <?php
                        $d = json_decode($r['response']);
                        $success = $d->{"success"};
                        if($success=="true"){
                                ?><p><strong>Success Response:</strong><br /><?php
                        }else{
                                ?><p><strong>Error Response:</strong><br /><?php
                                        $errors = $d->{"errors"};
                                        foreach($errors as $error){
                                          echo $error->{"message"}."<br />";
                                        }
                        }
                        ?>
                </p>
<?php } ?>
        </div>

<?php
}
?>

<?php
if (!empty($is_back_office) || (($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) && ($is_pending || $is_rejected) && $p_m_dss_file == '2')){ 
                $p_m_ins_payer_id = st($pat_myarray["p_m_eligible_id"]);
                if($p_m_ins_payer_id){
                  $dsql = "SELECT name, payer_id FROM dental_ins_payer
                        WHERE id=".mysqli_real_escape_string($con,$p_m_ins_payer_id);

                  $d = $db->getRow($dsql);
                  $p_m_ins_payer_name = $d['payer_id']." - ".$d['name'];
                }else{
                  $p_m_ins_payer_name = "";
                }	
?>

<?php
        $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";

        $prod_r = $db->getRow($prod_s);
        $claim_producer = $prod_r['producer'];
                      $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
                      $userinfo = $db->getRow($getuserinfo);
                      if(!empty($userinfo)){
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

                      $docinfo = $db->getRow($getdocinfo);
                        if(empty($phone)){ $phone = $docinfo['phone']; }
                        if(empty($practice)){ $practice = $docinfo['practice']; }
                        if(empty($address)){ $address = $docinfo['address']; }
                        if(empty($city)){ $city = $docinfo['city']; }
                        if(empty($state)){ $state = $docinfo['state']; }
                        if(empty($zip)){ $zip = $docinfo['zip']; }
                        if(empty($npi)){ $npi = $docinfo['npi']; }
                        if(empty($medicare_npi)){ $medicare_npi = $docinfo['medicare_npi']; }

?>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'p_m_eligible_payer', '', 'https://eligibleapi.com/resources/payers/claims/medical.json', null, null, null, true, '<?php echo  $npi; ?>', '<?php echo  ($is_front_office)?1:2; ?>');
});
</script>
<input type="hidden" name="p_m_eligible_payer" id="p_m_eligible_payer" value="<?php echo $p_m_eligible_payer_id."-".$p_m_eligible_payer_name;?>" />



<?php } ?>

<?php
if (!empty($is_back_office) || (($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) && (!empty($is_sec_pending) || !empty($is_sec_rejected)) && $p_m_dss_file == '2')){ 
                $p_m_ins_payer_id = st(!empty($pat_myarray["s_m_eligible_id"]) ? $pat_myarray["s_m_eligible_id"] : '');
                if($p_m_ins_payer_id){
                  $dsql = "SELECT name, payer_id FROM dental_ins_payer
                        WHERE id='".mysqli_real_escape_string($con,$s_m_ins_payer_id)."'";

                  $d = $db->getRow($dsql);
                  $s_m_ins_payer_name = $d['payer_id']." - ".$d['name'];
                }else{
                  $s_m_ins_payer_name = "";
                }	
?>

<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete_local('s_m_ins_payer_name', 's_m_ins_payer_hints', 's_m_eligible_payer', '', 'https://eligibleapi.com/resources/payers/claims/medical.json', null, null, null, true, '<?php echo  $npi; ?>', '<?php echo  ($is_front_office)?1:2; ?>');
});
</script>
<input type="hidden" name="s_m_eligible_payer" id="s_m_eligible_payer" value="<?php echo $s_m_eligible_payer_id."-".$s_m_eligible_payer_name;?>" />



<?php } ?>
<table width="1185" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" valign="top" width="50%">
			<span><div class="box_bg">1500</div></span>
			<span class="heading1">Health Insurance Claim Form</span><br />
			<span>Approved By National Uniform Claim Committee 08/05</span><br /><br />
			<span>
				<input value="<?php echo (!empty($pica1) ? $pica1 : '');?>" name="pica1" type="text"  class="inbox_line1" maxlength="1"/>
				<input value="<?php echo (!empty($pica2) ? $pica2 : '');?>" name="pica2" type="text"  class="inbox_line1" maxlength="1"/>
				<input value="<?php echo (!empty($pica1) ? $pica1 : '');?>" name="pica3" type="text"  class="inbox_line1" maxlength="1"/>
				PICA
			</span>
		</td>
		<td width="50%">
		  <table>
		  		  <?php 
	if(isset($_GET['instype']) && $_GET['instype']==2 || $is_secondary){
	  $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['s_m_ins_co'])."'"; 
	}else{
	  $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'"; 
	}

        $inscoinfo = $db->getRow($inscoquery);
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
                                                                        <input name="insurance_type" type="radio" value="1" <?php if($insurancetype == '1') {echo " checked";}?> />
                                                                        <span class="small_cap">(Medicare #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="2" <?php if($insurancetype == '2') {echo " checked";}?> />
                                                                        <span class="small_cap">(Medicaid #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="3" <?php if($insurancetype == '3') {echo " checked";}?> />
                                                                        <span class="small_cap">(Sponsor's SSN)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="4" <?php if($insurancetype == '4') {echo " checked";}?> />
                                                                        <span class="small_cap">(Member ID #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="5" <?php if($insurancetype == '5') {echo " checked";}?> />
                                                                        <span class="small_cap">(SSN or ID)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="6" <?php if($insurancetype == '6') {echo " checked";}?> />
                                                                        <span class="small_cap">(SSN)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="7" <?php if($insurancetype == '7') {echo " checked";}?> />
                                                                        <span class="small_cap">(ID)</span>
                                                                </td>  


									<!--Payer		

									<input type="text" name="payer_id" style="width:120px" />
									<input type="text" name="payer_name" />
									<input type="text" name="payer_add1" />
									<input type="text" name="payer_add2" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<input type="text" name="payer_city" />
									<input type="text" name="payer_state" />
									<input type="text" name="payer_zip" />
                                                                </td>								
									-->
							</tr>	
						</table>
						<input type="hidden" name="other_insurance_type" value="<?php echo  $other_insurancetype; ?>" />
					</td>
					<td width="448" align="left" valign="top">
						<span class="num_a">1a.</span>
						Insured's ID Number 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="small_cap">(For Program in item 1)</span>
						<br />
						<input type="text" value="<?php echo $insured_id_number?>" name="insured_id_number" size="60" />
						<input type="hidden" value="<?php echo $other_insured_id_number?>" name="other_insured_id_number" value="" size="60" />
					</td>
				</tr>
				<tr>
					<td width="429" align="left" valign="top">
						<span class="num">2.</span>
						Patient Name 
						<span class="small_cap">(Last Name, First Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?php echo $patient_lastname?>" name="patient_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?php echo $patient_firstname?>" name="patient_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $patient_middle?>" name="patient_middle" class="inbox_line3" size="3" width="30" />
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
									<?php if($patient_dob!=''){$patient_dob = date('m-d-Y', strtotime($patient_dob));
                  } ?>
									<input type="text" value="<?php echo $patient_dob?>" name="patient_dob" class="inbox_line3 datealtfullmask" size="10"/>
									mm-dd-yyyy
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="patient_sex" value="M" <?php if($patient_sex == "M" || $patient_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F 
									<input type="radio" name="patient_sex" value="F" <?php if($patient_sex == "F" || $patient_sex == "Female") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">4.</span> 
						Insured's Name &nbsp;
						<span class="small_cap">(Last Name, First Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
                                                        <input type="text" value="<?php echo $insured_lastname?>" name="insured_lastname" class="inbox_line3" size="18" width="60" />
                                                        &nbsp;
							<input type="text" value="<?php echo $insured_firstname?>" name="insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $insured_middle?>" name="insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">5.</span> 
						Patient's Address 
						<span class="small_cap">(No. Street)</span>
						<br />
						<input type="text" value="<?php echo $patient_address?>" name="patient_address" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num">6.</span> 
						Patient Relationship To Insured
						<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Self</span>
									<input name="patient_relation_insured" type="radio" value="Self" <?php if($patient_relation_insured == "Self" || $patient_relation_insured=="") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Spouse</span>
									<input name="patient_relation_insured" type="radio" value="Spouse" <?php if($patient_relation_insured == "Spouse") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Child</span>
									<input name="patient_relation_insured" type="radio" value="Child" <?php if($patient_relation_insured == "Child") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Others</span>
									<input name="patient_relation_insured" type="radio" value="Other" <?php if($patient_relation_insured == "Other") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">7.</span>
						Insured's Address 
						<span class="small_cap">(No. Street)</span>
						<br />
						<input value="<?php echo $insured_address?>" name="insured_address" type="text" class="inbox_line3" size="28" />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?php echo $patient_city?>" name="patient_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?php echo $patient_state?>" name="patient_state" type="text" class="inbox_line3" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
					<td rowspan="2" align="left" valign="top">
						<span class="num">8.</span> 
						Reserved for NUCC Use<br />
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<input name="nucc_8a" value="<?php echo  (!empty($nucc_8a) ? $nucc_8a : ''); ?>" type="text" />
									<input name="nucc_8b" value="<?php echo  (!empty($nucc_8b) ? $nucc_8b : ''); ?>" type="text" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?php echo $insured_city?>" name="insured_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?php echo $insured_state?>" name="insured_state" type="text" class="inbox_line3" size="3" width="30" />
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
									<input value="<?php echo $patient_zip?>" name="patient_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?php echo  $patient_phone_code; ?>" name="patient_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?php echo $patient_phone?>" name="patient_phone" class="inbox_line3" size="13"  />
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
									<input value="<?php echo $insured_zip?>" name="insured_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" value="<?php echo $insured_phone_code?>" name="insured_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?php echo $insured_phone?>" name="insured_phone" class="inbox_line3" size="13"  />
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
							<input type="text" value="<?php echo $other_insured_lastname?>" name="other_insured_lastname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $other_insured_firstname?>" name="other_insured_firstname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?php echo $other_insured_middle?>" name="other_insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
					<td rowspan="4" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top" style="line-height:33px;">
									<span class="num">10.</span>
									Is patient's Condition Related To :
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">a.</span> 
									Employment? 
									<span class="small_cap">(current Or Previous)</span>
									<br />
									<input type="radio" name="employment" value="YES" <?php if(!empty($employment) && $employment == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="employment" value="NO" <?php if(!empty($employment) && $employment == "NO") echo " checked";?> />
									NO
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">b.</span> 
									Auto Accident? 
									<br />
									<input type="radio" name="auto_accident" value="YES" <?php if(!empty($auto_accident) && $auto_accident == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="auto_accident" value="NO" <?php if(!empty($auto_accident) && $auto_accident == "NO") echo " checked";?> />
									NO
									&nbsp;&nbsp;
									Place<span class="small_cap">(State)</span>
									<input type="text" value="<?php echo (!empty($auto_accident_place) ? $auto_accident_place : '')?>" class="inbox_line3" size="10" name="auto_accident_place" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">c.</span> 
									Other Accident? 
									<br />
									<input type="radio" name="other_accident" value="YES" <?php if(!empty($other_accident) && $other_accident == "YES") echo " checked";?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="other_accident" value="NO" <?php if(!empty($other_accident) && $other_accident == "NO") echo " checked";?> />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">11.</span>
						Insured's Policy Group or FECA Number
						<br />
						<input value="<?php echo $insured_policy_group_feca?>" name="insured_policy_group_feca" type="text" class="inbox_line3" size="28"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">a.</span>
						Other Insured's policy Or Group Number
						<br />
						<input value="<?php echo $other_insured_policy_group_feca?>" name="other_insured_policy_group_feca" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">a.</span> 
									Insured's Birth Date
									<br />
									&nbsp;&nbsp;
									<?php if(isset($insured_dob)){$insured_dob = date('m-d-Y', strtotime($insured_dob)); 
                  } ?>
									<input type="text" value="<?php echo $insured_dob?>" name="insured_dob" class="inbox_line3 datealtfullmask" size="10"/>
									mm-dd-yyyy
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M 
									<input type="radio" name="insured_sex" value="M" <?php if($insured_sex == "M" || $insured_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F 
									<input type="radio" name="insured_sex" value="F" <?php if($insured_sex == "F" || $insured_sex == "Female") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top">
									<span class="num_a">b.</span> 
									Reserved for NUCC Use
									<br />
									<input type="text" name="nucc_9b" value="<?php echo  (!empty($nucc_9b) ? $nucc_9b : ''); ?>" class="inbox_line3" size="28"/>
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num_a">b.</span>
						Other Claim ID (Designated by NUCC)	
						<br />
						<input name="other_claim_id" value="<?php echo  (!empty($other_claim_id) ? $other_claim_id : ''); ?>" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Reserved for NUCC Use
						<br />
						<input name="nucc_9c" value="<?php echo  (!empty($nucc_9c) ? $nucc_9c : ''); ?>" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Insurance Plan Name or Program Name
						<br />
						<input value="<?php echo $insured_insurance_plan?>" name="insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">d.</span>
						Insurance Plan Name or Program Name
						<br />
						<input value="<?php echo $other_insured_insurance_plan?>" name="other_insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">10d.</span>
						Claim Codes (Designated by NUCC)
						<br />
						<input value="<?php echo (!empty($claim_codes) ? $claim_codes : ''); ?>" name="claim_codes" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">d.</span> 
						Is there another health benefit Plan?
						<br />
						<input type="radio" name="another_plan" value="YES" <?php if($another_plan == "YES") echo " checked";?> />YES
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="another_plan" value="NO" <?php if($another_plan == "NO") echo " checked";?> />NO
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
						
						<input type="checkbox" name="patient_signature" value="1" <?php if($patient_signature == "1" || $patient_signature == "Y") echo " checked";?> />
						Signature on File
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;
						Date:
						<input type="text" value="<?php echo  $patient_signed_date?>" name="patient_signed_date" size="10" class="inbox_line3 datealtoptfullmask" />
					</td>
					<td align="left" valign="top">
						<span class="num">13.</span>
						Insured's or Authorized person's Signature
						<span class="small_cap"> I authorize payment of medical benefits to the undersigned physician or supplier for services described below</span>
						<br /><br /><br />
						
						<?php
            $patient_signature = st(!empty($myarray['patient_signature']) ? $myarray['patient_signature'] : '');
            echo "<center>SIGNATURE ON FILE: <input type='checkbox' name='insured_signature' value='1' ";
            if($insured_signature){ echo "checked"; }
	    echo " /></center>";
            ?>
						
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">14.</span> 
DATE OF CURRENT ILLNESS, INJURY, or PREGNANCY (LMP)`
									<br />
									&nbsp;&nbsp;
									<input type="text" value="<?php echo (!empty($date_current) ? $date_current : ''); ?>" name="date_current" class="inbox_line3 datealtmask" size="10"/>
									mm-dd-yy
									<span class="small_cap"> QUAL. </span>
									<input type="text" name="qual" class="inbox_line3" size="10"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">15.</span> 
						Other Date
						<br />
						<span class="small_cap">QUAL.</span>
									<input type="text" name="qual_2" class="inbox_line3" size="10"/>
						&nbsp;&nbsp;
						<input type="text" value="<?php echo (!empty($date_same_illness) ? $date_same_illness : ''); ?>" name="date_same_illness" class="inbox_line3 datealtmask" size="10"/>
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
									<input type="text" value="<?php echo (!empty($unable_date_from) ? $unable_date_from : ''); ?>" name="unable_date_from" class="inbox_line3 datealtmask" size="10"/>
									mm-dd-yy
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?php echo (!empty($unable_date_to) ? $unable_date_to : ''); ?>" name="unable_date_to" class="inbox_line3 datealtmask" size="10"/>
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
				<select name="name_referring_provider_qualifier">
                    <option value=""></option>
                    <option value="DN" <?= ($name_referring_provider_qualifier=="DN" || $insurancetype == '1' )?'selected="selected"':''; ?>>DN - Referring Provider</option>
                    <option value="DK" <?php echo  (!empty($name_referring_provider_qualifier) && $name_referring_provider_qualifier=="DK")?'selected="selected"':''; ?>>DK - Ordering Provider</option>
					<option value="DQ" <?php echo  (!empty($name_referring_provider_qualifier) && $name_referring_provider_qualifier=="DQ")?'selected="selected"':''; ?>>DQ - Supervising Provider</option>
				</select>
								<input type="text" value="<?php echo  $referring_provider; ?>" name="referring_provider" class="inbox_line3" size="20" />
								
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
										<?php
										if (!isset($qua_sql)) {
											$qua_sql = '';
										}

										$qua_my = $db->getResults($qua_sql);
										if (!empty($qua_my)) foreach ($qua_my as $qua_myarray)
										{?>
											<option value="<?php echo st($qua_myarray['qualifierid']);?>" <?php if($field_17a_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
												<?php echo st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
								</td>
								<td valign="top" width="80%" style="border-bottom: 1px #000000 dashed; padding-bottom:3px;">
									<input type="text" value="<?php echo (!empty($field_17a) ? $field_17a : ''); ?>" name="field_17a" class="inbox_line3" size="30"/>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="num">17<span class="num_a">b.</span></span> 
								<?php
        $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
        $prod_r = $db->getRow($prod_s);

        $claim_producer = (!empty($prod_r['producer']) ? $prod_r['producer'] : '');

		      $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
                      $userinfo = $db->getRow($getuserinfo);
                      if(!empty($userinfo)){
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

                      $docinfo = $db->getRow($getdocinfo);
			if(empty($phone)){ $phone = $docinfo['phone']; }
			if(empty($practice)){ $practice = $docinfo['practice']; }
                        if(empty($address)){ $address = $docinfo['address']; }
                        if(empty($city)){ $city = $docinfo['city']; }
                        if(empty($state)){ $state = $docinfo['state']; }
                        if(empty($zip)){ $zip = $docinfo['zip']; }
			if(empty($npi)){ $npi = $docinfo['npi']; }
			if(empty($medicare_npi)){ $medicare_npi = $docinfo['medicare_npi']; }

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

			if($insurancetype == 1){
                          $service_npi = "";
                          $service_practice = "";
                          $service_address = "";
                          $service_city = "";
                          $service_state = "";
                          $service_zip = "";
                          $service_medicare_npi = "";
			}

                      ?> 

		      
								<td valign="top">
									NPI
								</td>
								<td valign="top" style="padding-top:3px;">
									<input type="text" value="<?php echo  $diagnosising_npi; ?>" name="field_17b" class="inbox_line3" size="30"/>
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
									<input type="text" value="<?php echo (!empty($hospitalization_date_from) ? $hospitalization_date_from : ''); ?>" name="hospitalization_date_from" class="inbox_line3 datealtmask" size="10"/>
									mm-dd-yy
									
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
									<input type="text" value="<?php echo (!empty($hospitalization_date_to) ? $hospitalization_date_to : ''); ?>" name="hospitalization_date_to" class="inbox_line3 datealtmask" size="10"/>
									mm-dd-yy
									
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<span class="num">19.</span> 
						Additional Claim Information (DESIGNATED BY NUCC)<br />
						<input type="text" value="<?php echo (!empty($reserved_local_use1) ? $reserved_local_use1 : '')?>" name="reserved_local_use1" class="inbox_line3" size="100" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="40%">
									<span class="num">20.</span> 
									Outside Lab?
									<br />
									<input type="radio" name="outside_lab" value="YES"  <?php if(!empty($outside_lab) && $outside_lab == "YES") echo " checked";?>/>
									YES
									&nbsp;&nbsp;
									<input type="radio" name="outside_lab" value="NO" <?php if(!empty($outside_lab) && $outside_lab == "NO") echo " checked";?> />
									NO
								</td>
								<td valign="top" width="60%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									S Charges
									<br />
									<input type="text" value="<?php echo (!empty($s_charges) ? $s_charges : ''); ?>" name="s_charges" class="inbox_line3" size="30" />
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
							(Relate A-L to service line below (24E))
						</span>
                                ICD IND. <select name="icd_ind">
                                        <option value="9" <?php echo  (!empty($icd_ind) && $icd_ind=="9")?'selected="selected"':''; ?>>ICD-9-CM - 9</option>
                                        <option value="0" <?php echo  (!empty($icd_ind) && $icd_ind=="0")?'selected="selected"':''; ?>>ICD-10-CM - 0</option>
                                </select>

						
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="23%">
									<b>A.</b>
									<input type="text" name="diagnosis_a" class="inbox_line3" size="20" value="<?php echo  $diagnosis_a; ?>" />
								</td>
								<td valign="top" width="23%">
									<b>B.</b>
                                                                        <input type="text" name="diagnosis_b" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_b) ? $diagnosis_b : ''); ?>" />
								</td>
                                                                <td valign="top" width="23%">
                                                                        <b>C.</b>
                                                                        <input type="text" name="diagnosis_c" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_c) ? $diagnosis_c : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>D.</b>
                                                                        <input type="text" name="diagnosis_d" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_d) ? $diagnosis_d : ''); ?>" />
                                                                </td>

							</tr>
                                                        <tr>
                                                                <td valign="top" width="23%">
                                                                        <b>E.</b>
                                                                        <input type="text" name="diagnosis_e" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_e) ? $diagnosis_e : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>F.</b>
                                                                        <input type="text" name="diagnosis_f" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_f) ? $diagnosis_f : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>G.</b>
                                                                        <input type="text" name="diagnosis_g" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_g) ? $diagnosis_g : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>H.</b>
                                                                        <input type="text" name="diagnosis_h" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_h) ? $diagnosis_h : ''); ?>" />
                                                                </td>

                                                        </tr>
                                                        <tr>
                                                                <td valign="top" width="23%">
                                                                        <b>I.</b>
                                                                        <input type="text" name="diagnosis_i" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_i) ? $diagnosis_i : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>J.</b>
                                                                        <input type="text" name="diagnosis_j" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_j) ? $diagnosis_j : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>K.</b>
                                                                        <input type="text" name="diagnosis_k" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_k) ? $diagnosis_k : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>L.</b>
                                                                        <input type="text" name="diagnosis_l" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_l) ? $diagnosis_l : ''); ?>" />
                                                                </td>

                                                        </tr>

						</table>
					</td>
					<td valign="top">
						<span class="num">22.</span> 
						Resubmission Code
                                <select name="resubmission_code_fill">
                                    <option value="" <?php echo $resubmission_code_fill==""?'selected="selected"':''; ?>>New Claim</option>
                                    <option value="7" <?php echo $resubmission_code_fill=="7"?'selected="selected"':''; ?>>Resubmitted Claim</option>
                                    <option value="8" <?php echo $resubmission_code_fill=="8"?'selected="selected"':''; ?>>Void/Cancel Prior Claim</option>
                                </select>
						<br />
						Original Ref. No.
						<input type="text" value="<?php echo (!empty($original_ref_no) ? $original_ref_no : '')?>" name="original_ref_no" class="inbox_line3" size="30" />
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">23.</span> 
						Prior Authorization Number
						<br />
						<input type="text" value="<?php echo $prior_authorization_number?>" name="prior_authorization_number" class="inbox_line3" size="60" />
					</td>
				</tr>
<!-- START BOX 24 -->				
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
						</table>
<!-- START LEDGER TRXNS -->
<?php
// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";
$mod_my = $db->getResults($mod_sql);
$mod_array = array();
if ($mod_my) foreach ($mod_my as $mod_row) {
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
       . "  AND ledger.patientid = '" . $_GET['pid'] . "'"
       . "  AND ledger.docid = '" . $docid . "'"
       . "  AND trxn_code.docid = '" . $docid . "'"
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
} else {
  $sql = "SELECT "
       . "  ledger.*, ";
if($is_pending || $is_rejected){
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
       . "  (ledger.primary_claim_id = '" . $insuranceid . "'"
       . "  OR ledger.secondary_claim_id = '" . $insuranceid . "')"
       . "  AND ledger.patientid = '" . mysqli_real_escape_string($con, $_GET['pid']) . "'"
       . "  AND ledger.docid = '" . $docid . "'"
       . "  AND trxn_code.docid = '" . $docid . "'"
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
}
$query = $db->getResults($sql);
// Display ledger trxns
if (empty($query)) {
  print "<br /><center><font style='color:#ff0000; font-weight:bold;'>There was a database error when selecting ledger transactions.</font><br/><br/>" . mysqli_errno($con) . ": " . mysqli_error($con) . "</center><br />";
} else if (count($query) == 0) {
  print "<br /><center><font style='color:#ff0000; font-weight:bold;'>There are currently no ledger entries to be submitted.</font></center><br />";
} else {
?>
  <?php $li = 0; $realTotalAmount = 0; ?>
  <input type="hidden" name="ledgercount" value="<?php echo count($query); ?>">
  <?php foreach ($query as $array) {
        $realTotalAmount += $array['amount']; ?>
    <table style="margin-left:39px;">
      <tr>
        <td width="106"><?php echo date('m-d-Y', strtotime($array['service_date'])); ?></td>
        <td width="106"><?php echo date('m-d-Y', strtotime($array['service_date'])); ?></td>
        <td width="91">
<?php echo  (!empty($pos) ? $pos : ''); ?>
		<select style="width:76px" name="placeofservice<?php echo $li;?>">
			<option value=''>Select One</option>
			<?php 
				$pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place'];
  				$dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1; 

				$sql = "SELECT * FROM dental_place_service ps WHERE status=1";
				$q = $db->getResults($sql);
				if (!empty($q)) foreach ($q as $psr){
				?><option value="<?php echo  $psr['place_service']; ?>" <?php echo  ($pos==$psr['place_service'])?'selected="selected"':''; ?>><?php echo  $psr['place_service']." ".$psr['description']; ?></option>
			<?php
				}
			?>
	</td>
        <td width="41"><input  style="width:26px;"type="text" name="emg<?php echo $li;?>" value="<?php echo $array['emg']; ?>"></td>
        <td width="222"><?php echo $array['transaction_code'] . " - " .$array['description'] ; ?></td>
        <td width="191">
          <select name="modifiercode<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($mod_array); $i++) { ?>
              <?php $selected = ($array['modcode'] == $mod_array[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $mod_array[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $mod_array[$i]['modifier_code']." ".$mod_array[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode2_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($mod_array); $i++) { ?>
              <?php $selected = ($array['modcode2'] == $mod_array[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $mod_array[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $mod_array[$i]['modifier_code']." ".$mod_array[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode3_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($mod_array); $i++) { ?>
              <?php $selected = ($array['modcode3'] == $mod_array[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $mod_array[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $mod_array[$i]['modifier_code']." ".$mod_array[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode4_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($mod_array); $i++) { ?>
              <?php $selected = ($array['modcode4'] == $mod_array[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $mod_array[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $mod_array[$i]['modifier_code']." ".$mod_array[$i]['description']?></option>
            <?php } ?>
          </select>


        </td>
        <td width="92">
		<!--diagnosispointer<?php echo $li;?>-->
<table class="eligibleapi claim"><tbody><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="1" <?php echo  ($dp=="1")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">A</td>
<td class="input-center-hint checkbox-container"><input class="input" value="2" <?php echo  ($dp=="2")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">B</td>
<td class="input-center-hint checkbox-container"><input class="input" value="3" <?php echo  ($dp=="3")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">C</td>
<td class="input-center-hint checkbox-container"><input class="input" value="4" <?php echo  ($dp=="4")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">D</td></tr><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="5" <?php echo  ($dp=="5")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">E</td>
<td class="input-center-hint checkbox-container"><input class="input" value="6" <?php echo  ($dp=="6")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">F</td>
<td class="input-center-hint checkbox-container"><input class="input" value="7" <?php echo  ($dp=="7")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">G</td>
<td class="input-center-hint checkbox-container"><input class="input" value="8" <?php echo  ($dp=="8")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">H</td></tr><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="9" <?php echo  ($dp=="9")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">I</td>
<td class="input-center-hint checkbox-container"><input class="input" value="10" <?php echo  ($dp=="10")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">J</td>
<td class="input-center-hint checkbox-container"><input class="input" value="11" <?php echo  ($dp=="11")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">K</td>
<td class="input-center-hint checkbox-container"><input class="input" value="12" <?php echo  ($dp=="12")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][]" type="checkbox"></td><td class="input-side-hint">L</td>
</tr></tbody></table>
	</td>
        <td width="100" align="right" style="padding-right:15px;">$<?php echo  number_format($array['amount'], 2); ?></td>
        <td width="54"><input style="width:39px;" type="text" name="daysorunits<?php echo $li;?>" value="<?php echo $array['daysorunits']; ?>"></td>
        <td width="60"><input style="width:45px;" type="text" name="epsdt<?php echo $li;?>" value="<?php echo $array['epsdt']; ?>"></td>
        <td width="52"><input style="width:37px;" type="text" name="idqual<?php echo $li;?>" value="<?php echo $array['idqual']; ?>"></td>
        <input type="hidden" name="ledgerid<?php echo $li;?>" value="<?php echo $array['ledgerid']; ?>">
	<input type="hidden" name="service_date<?php echo $li;?>" value="<?php echo $array['service_date']; ?>">
	<input type="hidden" name="entry_date<?php echo $li;?>" value="<?php echo $array['entry_date']; ?>">
	<input type="hidden" name="transaction_code<?php echo $li;?>" value="<?php echo $array['transaction_code']; ?>">
	<input type="hidden" name="amount<?php echo $li;?>" value="<?php echo $array['amount']; ?>">
        <td width="122"><?php echo $array['provider_id']?></td>
      </tr>
    </table>
    <?php $li++; ?>
  <?php } ?>
<?php } ?>
<!-- /END LEDGER TRXNS -->

					</td>
				</tr>
<!-- /END BOX 24 -->
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
												<?php
												  
												  if($userinfo['tax_id_or_ssn'] != ''){
													$tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
												  }else{
                                                                                                        $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
												  }
												  
												?>
												<input disabled="disabled" type="text" value="<?php echo $tax_id_or_ssn;?>" name="federal_tax_id_number" size="20" class="inbox_line3" />
											</td>
											<td valign="top" width="10%" align="center">
												SSN
												<br />
                                                                                                <?php
                                                                                                  if($userinfo['ssn'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ssn = $userinfo['ssn'];
                                                                                                  }else{
                                                                                                        $ssn = $docinfo['ssn'];
                                                                                                  }
                                                                                                ?>
												<input type="radio" disabled="disabled" name="ssnein" value="ssn" <?php if($ssn == "1") echo " checked";?> />
											</td>
											<td valign="top" width="10%" align="center">
												EIN
												<br />
                                                                                                <?php
                                                                                                  if($userinfo['ein'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ein = $userinfo['ein'];
                                                                                                  }else{                                                                                          
                                                                                                        $ein = $docinfo['ein'];
                                                                                                  }
                                                                                                ?>
												<input type="radio" disabled="disabled" name="ssnein" value="ein" <?php if($ein == "1") echo " checked";?> />
											</td>
										</tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<span class="num">26.</span> 
									Patient Account No.
									<br />
									<input type="text" value="<?php echo (!empty($patient_account_no) ? $patient_account_no : ''); ?>" name="patient_account_no" class="inbox_line3" size="20" />
								</td>
								<td valign="top" width="30%">
									<span class="num">27.</span> 
									Accept Assignment?
									<br />
									<span class="small_cap">(For govt. claims, see back)</span>
									<br />
									<input type="radio" name="accept_assignment" value="Yes" <?php if($accept_assignment == "Yes" || $accept_assignment == "A") echo " checked";?> />
									YES
									&nbsp;&nbsp;&nbsp;
									<input type="radio" name="accept_assignment" value="No" <?php if($accept_assignment == "No" || $accept_assignment == "C") echo " checked";?> />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" colspan="2">
					
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
       . "  ledger.status = '" . DSS_TRXN_PENDING . "' "
       . "  AND ledger.patientid = '" . mysqli_real_escape_string($con, $_GET['pid']) . "' "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = $db->getRow($sql);
    if (!empty($charge_my)) {
      $charge_row = $charge_my;
      $total_charge = $charge_row['total_charge'];
    }
  }
  if($is_sec_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.primary_claim_id = '" . $orig_claim_id . "' "
       . "  AND ledger.patientid = '" . mysqli_real_escape_string($con, $_GET['pid']) . "' "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = $db->getRow($sql);
    if (!empty($charge_my)) {
      $charge_row = $charge_my;
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
       . "  ledger.status = '" . DSS_TRXN_PENDING . "' "
       . "  AND ledger.patientid = '" . mysqli_real_escape_string($con, $_GET['pid']) . "' "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type IN ('" . DSS_TRXN_TYPE_PATIENT . "','" . DSS_TRXN_TYPE_INS . "','" . DSS_TRXN_TYPE_ADJ . "') "
       . "ORDER BY "
       . "  ledger.service_date ASC";
  if($status == DSS_CLAIM_SEC_PENDING){
    $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docid."' and dl.patientid='".s_for($_GET['pid'])."' 
                        AND primary_claim_id='".$orig_claim_id."'
                        AND dlp.amount != 0
			AND dlp.payer = 0
	";
  }
  $paid_my = $db->getRow($sql);
  if (!empty($paid_my)) {
    $paid_row = $paid_my;
    $amount_paid = $paid_row['amount_paid'];
  }
 
  // re-calculate balance due
  $balance_due = $total_charge - $amount_paid;

  // Override value from faulty sql queries
  if ($is_pending) {
      $total_charge = $realTotalAmount;
  }

  // format calculations
  $total_charge = number_format($total_charge, 2, '.','');
  $amount_paid = number_format($amount_paid, 2, '.','');
  $balance_due = number_format($balance_due, 2, '.','');

}
?>

<!-- START DOLLAR BOXES 28,29,30 -->
<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
  <tr bgcolor="#FFFFFF">
    <td valign="top" width="33%">
      <span class="num">28.</span> Total Charge<br/>
      $ <input type="text" value="<?php echo $total_charge;?>" name="total_charge" class="inbox_line3 number_field" size="15" />
    </td>
    <td valign="top" width="33%">
      <span class="num">29.</span> Amount Paid<br/>
      $ <input type="text" value="<?php echo $amount_paid;?>" name="amount_paid" class="inbox_line3 number_field" size="15"/>
    </td>
    <td valign="top" width="33%">
      <span class="num">30.</span> RSVD for NUCC Use<br/>
      <input type="text" name="nucc_30" value="<?php echo  (!empty($nucc_30) ? $nucc_30 : ''); ?>" class="inbox_line3 " size="15" />
      <br/>
      <span class="small_cap">&nbsp;</span>
    </td>
  </tr>
</table>
<!-- END DOLLAR BOXES 28,29,30 -->

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
									<input type="text" class="inbox_line3" size="40" name="signature_physician" />
									<br /><br />
									Signed
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Date: 
                                    <div style="text-align: right">
									   <input type="text" value="<?php echo $physician_signed_date?>" name="physician_signed_date" class="inbox_line3 datealtoptfullmask" size="10" />
                                    </div>
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
                                                <input type="text" value="<?php echo ($service_facility_info_name && $service_facility_info_name != "")?$service_facility_info_name:$service_practice;?>" name="service_facility_info_name" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Address:</span>		
											</td>
											<td valign="top" width="90%">
                                                <input type="text" value="<?php echo ($service_facility_info_address && $service_facility_info_address != '')?$service_facility_info_address:$service_address;?>" name="service_facility_info_address" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">City/State/Zip:</span>		
											</td>
											<td valign="top" width="90%">
                                                <input type="text" value="<?php echo ($service_facility_info_city && $service_facility_info_city != "")?$service_facility_info_city:($service_city.', '.$service_state.' '.$service_zip);?>" name="service_facility_info_city" class="inbox_line3" size="40" />
											</td>
										</tr>
									</table>
									<span class="num_a">
										a.
									</span>
                                    <input type="text" value="<?= ($service_info_a && $service_info_a != '')?$service_info_a:(($insurancetype == '1')?$service_medicare_npi:$service_npi); ?>" name="service_info_a" class="inbox_line3" size="15" />
									
									<span class="num_a">
										b.
									</span>
									<select name="service_info_dd" class="inbox_line3" style="width:50px;">
										<option value=""></option>
										<?
										$qua_sql = "select * from dental_qualifier where status=1 order by sortby";
										$qua_my = $db->getResults($qua_sql);
										if (!empty($qua_my)) foreach ($qua_my as $qua_myarray)
										{?>
											<option value="<?php echo st(!empty($qua_myarray['qualifierid']) ? $qua_myarray['qualifierid'] : '');?>" <?php if(!empty($service_info_dd) && $service_info_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
												<?php echo st($qua_myarray['qualifier']);?>
											</option>
										<?
										}?>
									</select>
									<input type="text" value="<?php echo (!empty($service_info_b_other) ? $service_info_b_other : '')?>" name="service_info_b_other" class="inbox_line3" size="15" />
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="top" >
					
					
						<span class="num">33.</span> 
						Billing Provider Info & Ph#
						<?php 
							if(empty($billing_provider_phone_code))
								$billing_provider_phone_code = split_phone($phone, true);

                                                        if(empty($billing_provider_phone))
                                                                $billing_provider_phone = split_phone($phone, false);

						?>
						<span class="style1">(
						<input type="text" value="<?php echo  $billing_provider_phone_code; ?>" name="billing_provider_phone_code" size="3" class="inbox_line3" />
						)</span>
						&nbsp;&nbsp;&nbsp;
						<input type="text" value="<?php echo  $billing_provider_phone; ?>" name="billing_provider_phone" class="inbox_line3" size="13"  />
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Name:</span>		
								</td>
								<td valign="top" width="90%">
                                    <input type="text" value="<?php echo ($billing_provider_name && $billing_provider_name != '')?$billing_provider_name:$practice;?>" name="billing_provider_name" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Address:</span>		
								</td>
								<td valign="top" width="90%">
                                    <input type="text" value="<?php echo $billing_provider_address;?>" name="billing_provider_address" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">City/State/Zip:</span>		
								</td>
								<td valign="top" width="90%">
                                    <input type="text" value="<?php echo ($billing_provider_city && $billing_provider_city != '')?$billing_provider_city:$city.', '.$state.' '.$zip;?>" name="billing_provider_city" class="inbox_line3" size="40" />
								</td>
							</tr>
						</table>
						<span class="num_a">
							a.
						</span>
                        <input type="text" value="<?= ($billing_provider_a != '')?$billing_provider_a:(($insurancetype == '1')?$medicare_npi:$npi); ?>" name="billing_provider_a" class="inbox_line3" size="15" />
						
						<span class="num_a">
							b.
						</span>
						<select name="billing_provider_dd" class="inbox_line3" style="width:50px;">
							<option value=""></option>
							<?
							$qua_sql = "select * from dental_qualifier where status=1 order by sortby";
							$qua_my = $db->getResults($qua_sql);
							if (!empty($qua_my)) foreach ($qua_my as $qua_myarray)
							{?>
								<option value="<?php echo st($qua_myarray['qualifierid']);?>" <?php if(!empty($billing_provider_dd) && $billing_provider_dd == st($qua_myarray['qualifierid'])) echo " selected";?>>
									<?php echo st($qua_myarray['qualifier']);?>
								</option>
							<?
							}?>
						</select>
						<input type="text" value="<?php echo (!empty($billing_provider_b_other) ? $billing_provider_b_other : '')?>" name="billing_provider_b_other" class="inbox_line3" size="15" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
                                <?php if($status==DSS_CLAIM_PENDING || $status==DSS_CLAIM_REJECTED){ ?>
			<?php if($_SERVER['PHP_SELF'] == "/manage/admin/insurance_claim.php"){ ?>
				<?php if( $_SESSION['admin_access']==1){ ?>
                    <a href="manage_claims.php?delid=<?php echo $insuranceid;?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" style="float:right; color:#f00; font-decoration:none;" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
				<?php } ?> 
			<!--
			<a href="#" onclick="$('#reject_reason_div').show(); return false;" style="color:#f00; font-decoration:none;" class="editdel dellink" title="REJECT">Reject</a>
			<div id="reject_reason_div" <?php echo  ($myarray['status']==DSS_CLAIM_REJECTED)?'':'style="display:none;"'; ?> >
				<label>VOB will be REJECTED and franchisee will be notified.  Please list the reasons for rejection.</label><br /><textarea id="reject_reason" name="reject_reason"><?php echo  $reject_reason; ?></textarea>
				<input type="submit" name="reject_but" onclick="return ($('#reject_reason').val()!='');" value="Submit rejection" />
			</div>
			-->
			<?php }else{ ?>
                    <a href="manage_insurance.php?delid=<?php echo $insuranceid;?>&pid=<?php echo $_GET['pid']; ?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" style="float:left; color:#f00; font-decoration:none;" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>


		<div style="float:right;">

        <?php if (
            !$is_sent &&
            !in_array($status, [DSS_CLAIM_PENDING, DSS_CLAIM_SEC_PENDING, DSS_CLAIM_REJECTED, DSS_CLAIM_SEC_REJECTED])
        ) { // Based on "else if" blocks from above ?>
          <input type="submit" name="ex_pagebtn"
                <?php if($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED){ ?>
onclick="return confirm('This claim has been rejected. By printing this claim the status will be changed to SENT, and the rejection notification will be removed. Click OK to proceed.');"
                <?php } ?>
                value="Print Claim" />
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
          <input type="submit" name="elec_save" id="elec_save" style="display:none;" />

                <?php } elseif ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
               <?php if(($is_pending || $is_disputed || $is_rejected) && $p_m_dss_file == '2'){ ?>
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";

  $api_r = $db->getRow($api_sql);
  if($api_r['use_eligible_api']==1){
  if($is_pending){
?>
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
          <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
  <?php }elseif($is_rejected || $is_disputed){
?>
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
  <?php
  } ?>
<?php } ?>

        <?php } ?>

               <?php }elseif(($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_REJECTED) && $s_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
        <?php if (!$is_sent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="file_claim();return false;" value="Electronically File Claim" />-->

        <?php } ?>

               <?php } ?>
		</div>
        </div>











			<?php } ?>
                                <?php } ?>
</form>
<br /><br /><br /><br /><br /><br />


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
</body>
</html>

<script type="text/javascript">

$(".date_field").keydown(function(e){
var key = e.charCode || e.keyCode || 0;

            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
		key == 189 ||
		key == 191 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
});
$(".number_field").keydown(function(e){
var key = e.charCode || e.keyCode || 0;

            // allow backspace, tab, delete, numbers and keypad numbers ONLY
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
		key == 110 ||
		key == 190 ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
});

function file_reject_claim(){
  if($('#p_m_ins_payer_id').val()==""){
    alert('Insurance payer must be selected to electronically file claim.');
    return false;
  }
  c = confirm('You are about to resubmit a rejected claim. Please make sure you have corrected all errors, then click OK to resend the claim.');
  return c;
}
function file_claim(){
  if($('#p_m_ins_payer_id').val()==""){
    alert('Insurance payer must be selected to electronically file claim.');
    return false;
  }
  c = confirm('You are about to electronically submit this claim, are you sure?');
  return c;
}

function change_form(){
  if(form_changed){
    if(confirm('Your changes to this claim will be lost if you change to electronic submission. Click \'Ok\' to proceed or \'Cancel\' to return to paper form.')){
      window.location = "<?php echo  $electronic_form; ?>";
    } 
  }else{
    window.location = "<?php echo  $electronic_form; ?>";
  }
  return false;
}


  form_changed=false;
$('input, select').bind('change', function(){
  form_changed=true; 
});

</script>
