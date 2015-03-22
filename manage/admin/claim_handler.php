<?php
session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');
include_once 'includes/claim_functions.php';
include_once 'includes/invoice_functions.php';
include_once '../includes/claim_functions.php';
if(!empty($_SERVER['HTTPS'])){
$path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
}else{
$path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
}


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
        //$pica1 = $_POST['pica1'];
        //$pica2 = $_POST['pica2'];
        //$pica3 = $_POST['pica3'];
        //$insurance_type = $_POST['insurance_type'];
        //$other_insurance_type = $_POST['other_insurance_type'];
	$payer_id = $_POST['payer']['id'];
	$payer_name = $_POST['payer']['id'];
        $patient_lastname = $_POST['dependent']['last_name'];
        $patient_firstname = $_POST['dependent']['first_name'];
        $patient_middle = $_POST['dependent']['middle_name'];
        $patient_dob = $_POST['dependent']['dob'];
        $patient_address = $_POST['dependent']['address']['street_line_1'];
        $patient_city = $_POST['dependent']['address']['city'];
        $patient_state = $_POST['dependent']['address']['state'];
        $patient_zip = $_POST['dependent']['address']['zip'];
        $patient_phone = $_POST['dependent']['phone_number'];
	$patient_sex = $_POST['dependent']['gender'];
        $insured_id_number = $_POST['subscriber']['id'];
        $insured_firstname = $_POST['subscriber']['first_name'];
        $insured_lastname = $_POST['subscriber']['last_name'];
        $insured_middle = $_POST['subscriber']['middle_name'];
        $patient_relation_insured = $_POST['dependent']['relationship'];
        $insured_address = $_POST['subscriber']['address']['street_line_1'];
        $insured_state = $_POST['subscriber']['address']['state'];
        $insured_city = $_POST['subscriber']['address']['city'];
        $insured_zip = $_POST['subscriber']['address']['zip'];
        $insured_phone = $_POST['subscriber']['phone_number'];
        $other_insured_firstname = $_POST['other_payers'][0]['subscriber']['first_name'];
        $other_insured_lastname = $_POST['other_payers'][0]['subscriber']['last_name'];
        $other_insured_middle = $_POST['other_payers'][0]['subscriber']['middle_name'];
        $employment = $_POST['claim']['related_to_employment'];
        $auto_accident = $_POST['claim']['auto_accident'];
        $auto_accident_place = $_POST['claim']['auto_accident_state'];
        $other_accident = $_POST['claim']['other_accident'];
        $insured_policy_group_feca = $_POST['subscriber']['group_id'];
        $other_insured_policy_group_feca = $_POST['other_payers'][0]['subscriber']['group_id'];
        $insured_dob = $_POST['subscriber']['dob'];
        $insured_sex = $_POST['subscriber']['gender'];
        $insured_insurance_plan = $_POST['subscriber']['group_name'];
        $other_insured_insurance_plan = $_POST['other_payers'][0]['subscriber']['group_name'];
        $other_payer = $_POST['other_payer'];
        if($other_payer){
            $another_plan = "YES";
        }
        else 
        {
            $another_plan = "NO";
        }
        $patient_signature = $_POST['claim']['patient_signature_on_file'];
        // NO NAME ON FIELD $patient_signed_date = $_POST['patient_signed_date'];
        $insured_signature = $_POST['claim']['direct_payment_authorized'];
        $date_current = $_POST['claim']['date'];
	$current_qual = $_POST['claim']['date_type'];
        // NO NAME ON FIELD $date_same_illness = $_POST['date_same_illness'];
        // NO NAME ON FIELD $same_illness_qual = '';
        $unable_date_from = $_POST['claim']['last_wored_date'];
        $unable_date_to = $_POST['claim']['work_return_date'];
        // SPLIT APART? $referring_provider = $_POST['referring_provider'];
        $field_17a_dd = $_POST['referring_provider']['secondary_id_type'];
        $field_17a = $_POST['referring_provider']['secondary_id'];
        $field_17b = $_POST['referring_provider']['npi'];
        $hospitalization_date_from = $_POST['claim']['admission_date'];
        $hospitalization_date_to = $_POST['claim']['discharge_date'];
        $outside_lab = $_POST['claim']['outside_lab'];
        $s_charges = $_POST['claim']['outside_lab_charges'];
        $diagnosis_a = $_POST['claim']['diagnosis_codes'][1];
        $diagnosis_b = $_POST['claim']['diagnosis_codes'][2];
        $diagnosis_c = $_POST['claim']['diagnosis_codes'][3];
        $diagnosis_d = $_POST['claim']['diagnosis_codes'][4];
        $diagnosis_e = $_POST['claim']['diagnosis_codes'][5];
        $diagnosis_f = $_POST['claim']['diagnosis_codes'][6];
        $diagnosis_g = $_POST['claim']['diagnosis_codes'][7];
        $diagnosis_h = $_POST['claim']['diagnosis_codes'][8];
        $diagnosis_i = $_POST['claim']['diagnosis_codes'][9];
        $diagnosis_j = $_POST['claim']['diagnosis_codes'][10];
        $diagnosis_k = $_POST['claim']['diagnosis_codes'][11];
        $diagnosis_l = $_POST['claim']['diagnosis_codes'][12];
        $resubmission_code = $_POST['claim']['frequency'];
        $original_ref_no = $_POST['claim']['original_ref_number'];
        $prior_authorization_number = $_POST['claim']['prior_authorization_number'];


        $service_date1_from = $_POST['claim']['service_lines'][0]['service_date_from'];
        $service_date1_to = $_POST['claim']['service_lines'][0]['service_date_to'];
        $place_of_service1 = $_POST['claim']['service_lines'][0]['place_of_service'];
        $emg1 = $_POST['claim']['service_lines'][0]['emgergency'];
        $cpt_hcpcs1 = $_POST['claim']['service_lines'][0]['procedure_code'];
        $modifier1_1 = $_POST['claim']['service_lines'][0]['procedure_modifiers'][0];
        $modifier1_2 = $_POST['claim']['service_lines'][0]['procedure_modifiers'][1];
        $modifier1_3 = $_POST['claim']['service_lines'][0]['procedure_modifiers'][2];
        $modifier1_4 = $_POST['claim']['service_lines'][0]['procedure_modifiers'][3];
        $diagnosis_pointer1 = $_POST['claim']['service_lines'][0]['diagnosis_pointers'];
        $s_charges1_1 = $_POST['claim']['service_lines'][0]['charge_amount'];
        $days_or_units1 = $_POST['claim']['service_lines'][0]['units'];
        // NO NAME  $epsdt_family_plan1 = $_POST['epsdt_family_plan1'];
        $id_qua1 = $_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id1 = $_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id'];
 	// WHAT IS THE SECOND ID


        $service_date2_from = $_POST['claim']['service_lines'][1]['service_date_from'];
        $service_date2_to = $_POST['claim']['service_lines'][1]['service_date_to'];
        $place_of_service2 = $_POST['claim']['service_lines'][1]['place_of_service'];
        $emg2 = $_POST['claim']['service_lines'][1]['emgergency'];
        $cpt_hcpcs2 = $_POST['claim']['service_lines'][1]['procedure_code'];
        $modifier2_1 = $_POST['claim']['service_lines'][1]['procedure_modifiers'][0];
        $modifier2_2 = $_POST['claim']['service_lines'][1]['procedure_modifiers'][1];
        $modifier2_3 = $_POST['claim']['service_lines'][1]['procedure_modifiers'][2];
        $modifier2_4 = $_POST['claim']['service_lines'][1]['procedure_modifiers'][3];
        $diagnosis_pointer2 = $_POST['claim']['service_lines'][1]['diagnosis_pointers'];
        $s_charges2_1 = $_POST['claim']['service_lines'][1]['charge_amount'];
        $days_or_units2 = $_POST['claim']['service_lines'][1]['units'];
        // NO NAME  $epsdt_family_plan2 = $_POST['epsdt_family_plan1'];
        $id_qua2 = $_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id2 = $_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id'];
        // WHAT IS THE SECOND ID


        $service_date3_from = $_POST['claim']['service_lines'][2]['service_date_from'];
        $service_date3_to = $_POST['claim']['service_lines'][2]['service_date_to'];
        $place_of_service3 = $_POST['claim']['service_lines'][2]['place_of_service'];
        $emg3 = $_POST['claim']['service_lines'][2]['emgergency'];
        $cpt_hcpcs3 = $_POST['claim']['service_lines'][2]['procedure_code'];
        $modifier3_1 = $_POST['claim']['service_lines'][2]['procedure_modifiers'][0];
        $modifier3_2 = $_POST['claim']['service_lines'][2]['procedure_modifiers'][1];
        $modifier3_3 = $_POST['claim']['service_lines'][2]['procedure_modifiers'][2];
        $modifier3_4 = $_POST['claim']['service_lines'][2]['procedure_modifiers'][3];
        $diagnosis_pointer3 = $_POST['claim']['service_lines'][2]['diagnosis_pointers'];
        $s_charges3_1 = $_POST['claim']['service_lines'][2]['charge_amount'];
        $days_or_units3 = $_POST['claim']['service_lines'][2]['units'];
        // NO NAME  $epsdt_family_plan3 = $_POST['epsdt_family_plan1'];
        $id_qua3 = $_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id3 = $_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id'];
        // WHAT IS THE SECOND ID


        $service_date4_from = $_POST['claim']['service_lines'][3]['service_date_from'];
        $service_date4_to = $_POST['claim']['service_lines'][3]['service_date_to'];
        $place_of_service4 = $_POST['claim']['service_lines'][3]['place_of_service'];
        $emg4 = $_POST['claim']['service_lines'][3]['emgergency'];
        $cpt_hcpcs4 = $_POST['claim']['service_lines'][3]['procedure_code'];
        $modifier4_1 = $_POST['claim']['service_lines'][3]['procedure_modifiers'][0];
        $modifier4_2 = $_POST['claim']['service_lines'][3]['procedure_modifiers'][1];
        $modifier4_3 = $_POST['claim']['service_lines'][3]['procedure_modifiers'][2];
        $modifier4_4 = $_POST['claim']['service_lines'][3]['procedure_modifiers'][3];
        $diagnosis_pointer4 = $_POST['claim']['service_lines'][3]['diagnosis_pointers'];
        $s_charges4_1 = $_POST['claim']['service_lines'][3]['charge_amount'];
        $days_or_units4 = $_POST['claim']['service_lines'][3]['units'];
        // NO NAME  $epsdt_family_plan4 = $_POST['epsdt_family_plan1'];
        $id_qua4 = $_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id4 = $_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id'];
        // WHAT IS THE SECOND ID


        $service_date5_from = $_POST['claim']['service_lines'][4]['service_date_from'];
        $service_date5_to = $_POST['claim']['service_lines'][4]['service_date_to'];
        $place_of_service5 = $_POST['claim']['service_lines'][4]['place_of_service'];
        $emg5 = $_POST['claim']['service_lines'][4]['emgergency'];
        $cpt_hcpcs5 = $_POST['claim']['service_lines'][4]['procedure_code'];
        $modifier5_1 = $_POST['claim']['service_lines'][4]['procedure_modifiers'][0];
        $modifier5_2 = $_POST['claim']['service_lines'][4]['procedure_modifiers'][1];
        $modifier5_3 = $_POST['claim']['service_lines'][4]['procedure_modifiers'][2];
        $modifier5_4 = $_POST['claim']['service_lines'][4]['procedure_modifiers'][3];
        $diagnosis_pointer5 = $_POST['claim']['service_lines'][4]['diagnosis_pointers'];
        $s_charges5_1 = $_POST['claim']['service_lines'][4]['charge_amount'];
        $days_or_units5 = $_POST['claim']['service_lines'][4]['units'];
        // NO NAME  $epsdt_family_plan5 = $_POST['epsdt_family_plan1'];
        $id_qua5 = $_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id5 = $_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id'];
        // WHAT IS THE SECOND ID


        $service_date6_from = $_POST['claim']['service_lines'][5]['service_date_from'];
        $service_date6_to = $_POST['claim']['service_lines'][5]['service_date_to'];
        $place_of_service6 = $_POST['claim']['service_lines'][5]['place_of_service'];
        $emg6 = $_POST['claim']['service_lines'][5]['emgergency'];
        $cpt_hcpcs6 = $_POST['claim']['service_lines'][5]['procedure_code'];
        $modifier6_1 = $_POST['claim']['service_lines'][5]['procedure_modifiers'][0];
        $modifier6_2 = $_POST['claim']['service_lines'][5]['procedure_modifiers'][1];
        $modifier6_3 = $_POST['claim']['service_lines'][5]['procedure_modifiers'][2];
        $modifier6_4 = $_POST['claim']['service_lines'][5]['procedure_modifiers'][3];
        $diagnosis_pointer6 = $_POST['claim']['service_lines'][5]['diagnosis_pointers'];
        $s_charges6_1 = $_POST['claim']['service_lines'][5]['charge_amount'];
        $days_or_units6 = $_POST['claim']['service_lines'][5]['units'];
        // NO NAME  $epsdt_family_plan6 = $_POST['epsdt_family_plan1'];
        $id_qua6 = $_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id_type'];
        $rendering_provider_id6 = $_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id'];
        // WHAT IS THE SECOND ID





        $federal_tax_id_number = $_POST['billing_provider']['tax_id'];
        $ssn = ($_POST['billing_provider']['tax_id_type']=="SY")?'1':'';
        $ein = ($_POST['billing_provider']['tax_id_type']=="EI")?'1':'';
        // NO NAME $patient_account_no = $_POST['patient_account_no'];
        $accept_assignment = $_POST['claim']['accept_assignment_code'];
        $total_charge = $_POST['claim']['total_charge'];
        $amount_paid = $_POST['claim']['patient_amount_paid'];
        $signature_physician = $_POST['claim']['provider_signature_on_file'];
        $physician_signed_date = (($_POST['claim']['signature_date']!=date('m/d/Y'))?$_POST['claim']['signature_date']:'');
        $service_facility_info_name = $_POST['service_facility']['name'];
        $service_facility_info_address = $_POST['service_facility']['address']['street_line_1'];
        $service_facility_info_city = $_POST['service_facility']['address']['city'];
	//SPLIT APART?
        $service_info_a = $_POST['service_facility']['npi'];
        $billing_provider_phone = $_POST['billing_provider']['phone_number'];
        $billing_provider_name = $_POST['billing_provider']['organization_name'];
        $billing_provider_address = $_POST['billing_provider']['address']['street_line_1'];
        $billing_provider_city = $_POST['billing_provider']['address']['city'];
        $billing_provider_a = $_POST['billing_provider']['npi'];
        $reject_reason = $_POST['reject_reason'];
        $insurance_type_arr = $insurance_type;


                $p_m_eligible_payer_id = $_POST['payer']['id'];
                $p_m_eligible_payer_name = $_POST['payer']['name'];

             $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
             $pat_my = mysql_query($pat_sql);
             $pat_myarray = mysql_fetch_array($pat_my);
             $p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
	     $docid = $pat_myarray['docid'];
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
               if( $patient_lastname != ''){
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
                claim_codes = '".s_for($claim_codes)."',
                other_claim_id = '".s_for($other_claim_id)."',
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
                p_m_eligible_payer_name = '".mysql_real_escape_string($p_m_eligible_payer_name)."',
                s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
                s_m_eligible_payer_name = '".mysql_real_escape_string($s_m_eligible_payer_name)."'";
                if(isset($_POST['reject_but'])){
                  $ed_sql .= ", status = '".s_for(DSS_CLAIM_REJECTED)."'";
                  $ed_sql .= ", reject_reason = '".s_for($reject_reason)."'";
                }elseif($u_status){
                  $ed_sql .= ", status = '".s_for($u_status)."'";
                }
                $ed_sql .= " where insuranceid = '".s_for($_GET['insid'])."'";

                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
            }
                // update the ledger trxns passed in with the form
                $trxn_status = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;
                update_ledger_trxns($_POST['ed'], $trxn_status);

	$pat_sql = "UPDATE dental_patients SET 
			                p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".mysql_real_escape_string($p_m_eligible_payer_name)."'
		WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
	mysql_query($pat_sql);


    $url = 'https://gds.eligibleapi.com/v1.4/claims.json';
    
      $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
      $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysql_real_escape_string($docid)."'";
      $api_key_query = mysql_query($api_key_sql);
      $api_key_result = mysql_fetch_assoc($api_key_query);
      if($api_key_result && !empty($api_key_result['eligible_api_key'])){
        if(trim($api_key_result['eligible_api_key']) != ""){
          $api_key = $api_key_result['eligible_api_key'];
        }
      }
      
    $data = array(); //Initializing parameter array

    $data['api_key'] = $api_key; //Setting your api key

    $data['eligibleToken'] = $_POST["eligibleToken"]; // Reading eligibleToken and passing to claims endpoint

    //Curl post call to claim end point
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec ($ch);

    curl_close ($ch);



$json_response = json_decode($result);
$ref_id = $json_response->{"reference_id"};
$success = $json_response->{"success"};
$up_sql = "INSERT INTO dental_claim_electronic SET 
        claimid='".mysql_real_escape_string($_GET['insid'])."',
        reference_id = '".mysql_real_escape_string($ref_id)."',
        response='".mysql_real_escape_string($result)."',
        adddate=now(),
        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
        ";
mysql_query($up_sql);
  claim_status_history_update($_GET['insid'], DSS_CLAIM_SENT, DSS_CLAIM_PENDING, '', $_SESSION['adminuserid']);
claim_history_update($_GET['insid'], '', $_SESSION['adminuserid']);
$dce_id = mysql_insert_id();
invoice_add_efile('2', $_SESSION['admincompanyid'], $dce_id);
invoice_add_claim('1', $docid, $_GET['insid']);
echo $result;
if(!$success){
  $up_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_REJECTED."' WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
  mysql_query($up_sql);
claim_history_update($_GET['insid'], '', $_SESSION['adminuserid']);
  claim_status_history_update($_GET['insid'], '', DSS_CLAIM_REJECTED, '', $_SESSION['adminuserid']);

  $confirm = "Submission failed. ";
  $errors = $json_response->{"errors"}->{"messages"};
                                        foreach($errors as $error){
                                          $confirm .= mysql_real_escape_string($error).", ";
                                        }
?>
<script type="text/javascript">
   alert('RESPONSE: <?= $confirm; ?>');
   window.location = "manage_claims.php?status=0&insid=<?= $_GET['insid']; ?>"; 
</script>
<?php
}elseif($result == "Invalid JSON"){
  $confirm = "Submission failed. Invalid JSON";
?>
<script type="text/javascript">
   alert('RESPONSE: <?= $confirm; ?>');
   window.location = "manage_claims.php?status=0&insid=<?= $_GET['insid']; ?>"; 
</script>
<?php
}else{
?>
<script type="text/javascript">
  c = confirm('RESPONSE: <?= $result; ?> Do you want to mark the claim sent?');
  if(c){
   window.location = "manage_claims.php?insid=<?= $_GET['insid']; ?>&upstatus=<?= DSS_CLAIM_SENT; ?>"; 
  }
</script>
<?php
}



?>
