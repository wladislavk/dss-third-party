<?php
    include_once('includes/constants.inc');
    include_once('admin/includes/main_include.php');
    include_once 'admin/includes/claim_functions.php';
    include_once 'admin/includes/invoice_functions.php';

    if(!empty($_SERVER['HTTPS'])) {
        $path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
    } else {
        $path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
    }

    $status_sql = "SELECT status FROM dental_insurance
                    WHERE insuranceid='".mysqli_real_escape_string($con, !empty($_GET['insid']) ? $_GET['insid'] : '')."'
                    AND patientid='".mysqli_real_escape_string($con, !empty($_GET['pid']) ? $_GET['pid'] : '')."'";

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
        $con = $GLOBALS['con'];
        $db = new Db();

        $num = 0;
        $return_val = true;

        $ledgercount = (!empty($_POST['ledgercount']) ? $_POST['ledgercount'] : 0);

        while ($num <= ($ledgercount-1)) {
            $ledgerid = $_POST['ledgerid'.$num];
            $sql = "SELECT * "
                 . "  FROM dental_ledger "
                 . "WHERE "
                 . " ledgerid = ".$ledgerid;

            $query = $db->getResults($sql);
            $c = count($query);
            if($c){
                $row = $query[0];
                if($row['entry_date'] != $_POST['entry_date'.$num] ||
                    $row['service_date'] != $_POST['service_date'.$num] ||
                    $row['transaction_code'] != $_POST['transaction_code'.$num] ||
                    $row['amount'] != $_POST['amount'.$num] ||
                    $row['status'] == DSS_TRXN_NA
                ){
                    $return_val = false;
                }
            } else {
              $return_val = false;
            }
            $num++;
        }
        return $return_val;
    }

    // update and changes to ledger trxns
    // (updating associated claim id and status later w/ claim form insert and update)
    function update_ledger_trxns($primary_claim_id, $trxn_status) {
        $con = $GLOBALS['con'];
        $db = new Db();

        $num = 0;
        $added_ledger_ids = array();

        $ledgercount = (!empty($_POST['ledgercount']) ? $_POST['ledgercount'] : '');

        while ($num <= ($ledgercount - 1)) {
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

            $query = $db->query($sql);
            $num++;
        }

        $ledger_ids = implode(',', $added_ledger_ids);

        $upsql = "SELECT COUNT(*) as num_ledger from dental_ledger WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN (".$ledger_ids.")";

        if(!empty($upr['num_ledger']) && $upr['num_ledger'] > 0){
            $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".$primary_claim_id."'";

            $prod_r = $db->getRow($prod_s);
            $claim_producer = $prod_r['producer'];
            $s = "SELECT insuranceid from dental_insurance where producer = '".mysqli_real_escape_string($con, $claim_producer)." AND patientid='".mysqli_real_escape_string($con, $_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
            
            $q = $db->getResults($s);
            $n = count($q);
            if($n > 0){
              $r = $q[0];
              $claim_id = $r['insuranceid'];
            }else{
              $claim_id = create_claim($_GET['pid'], $claim_producer);
            }

            $update_sql = "UPDATE dental_ledger set primary_claim_id='".$claim_id."' WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN (".$ledger_ids.")";
            
            $db->query($update_sql);
        }

    }

    if($is_sent){
        print '<script type="text/javascript">';
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
	$payer_id = (!empty($_POST['payer']['id']) ? $_POST['payer']['id'] : '');
	$payer_name = (!empty($_POST['payer']['id']) ? $_POST['payer']['id'] : '');
    $patient_lastname = (!empty($_POST['dependent']['last_name']) ? $_POST['dependent']['last_name'] : '');
    $patient_firstname = (!empty($_POST['dependent']['first_name']) ? $_POST['dependent']['first_name'] : '');
    $patient_middle = (!empty($_POST['dependent']['middle_name']) ? $_POST['dependent']['middle_name'] : '');
    $patient_dob = (!empty($_POST['dependent']['dob']) ? $_POST['dependent']['dob'] : '');
    $patient_address = (!empty($_POST['dependent']['address']['street_line_1']) ? $_POST['dependent']['address']['street_line_1'] : '');
    $patient_city = (!empty($_POST['dependent']['address']['city']) ? $_POST['dependent']['address']['city'] : '');
    $patient_state = (!empty($_POST['dependent']['address']['state']) ? $_POST['dependent']['address']['state'] : '');
    $patient_zip = (!empty($_POST['dependent']['address']['zip']) ? $_POST['dependent']['address']['zip'] : '');
    $patient_phone = (!empty($_POST['dependent']['phone_number']) ? $_POST['dependent']['phone_number'] : '');
	$patient_sex = (!empty($_POST['dependent']['gender']) ? $_POST['dependent']['gender'] : '');
    $insured_id_number = (!empty($_POST['subscriber']['id']) ? $_POST['subscriber']['id'] : '');
    $insured_firstname = (!empty($_POST['subscriber']['first_name']) ? $_POST['subscriber']['first_name'] : '');
    $insured_lastname = (!empty($_POST['subscriber']['last_name']) ? $_POST['subscriber']['last_name'] : '');
    $insured_middle = (!empty($_POST['subscriber']['middle_name']) ? $_POST['subscriber']['middle_name'] : '');
    $patient_relation_insured_tmp = (!empty($_POST['dependent']['relationship']) ? $_POST['dependent']['relationship'] : '');
    if ($patient_relation_insured_tmp == '01') {
        $patient_relation_insured = "Spouse";
    } else if($patient_relation_insured_tmp == '19') {
        $patient_relation_insured = "Child";
    } else if($patient_relation_insured_tmp == 'G8') {
        $patient_relation_insured = "Other";
    } else {
        $patient_relation_insured = "Self";
    }
    $insured_address = (!empty($_POST['subscriber']['address']['street_line_1']) ? $_POST['subscriber']['address']['street_line_1'] : '');
    $insured_state = (!empty($_POST['subscriber']['address']['state']) ? $_POST['subscriber']['address']['state'] : '');
    $insured_city = (!empty($_POST['subscriber']['address']['city']) ? $_POST['subscriber']['address']['city'] : '');
    $insured_zip = (!empty($_POST['subscriber']['address']['zip']) ? $_POST['subscriber']['address']['zip'] : '');
    $insured_phone = (!empty($_POST['subscriber']['phone_number']) ? $_POST['subscriber']['phone_number'] : '');
    $other_insured_firstname = (!empty($_POST['other_payers'][0]['subscriber']['first_name']) ? $_POST['other_payers'][0]['subscriber']['first_name'] : '');
    $other_insured_lastname = (!empty($_POST['other_payers'][0]['subscriber']['last_name']) ? $_POST['other_payers'][0]['subscriber']['last_name'] : '');
    $other_insured_middle = (!empty($_POST['other_payers'][0]['subscriber']['middle_name']) ? $_POST['other_payers'][0]['subscriber']['middle_name'] : '');
    $employment = (!empty($_POST['claim']['related_to_employment']) ? $_POST['claim']['related_to_employment'] : '');
    $auto_accident = (!empty($_POST['claim']['auto_accident']) ? $_POST['claim']['auto_accident'] : '');
    $auto_accident_place = (!empty($_POST['claim']['auto_accident_state']) ? $_POST['claim']['auto_accident_state'] : '');
    $other_accident = (!empty($_POST['claim']['other_accident']) ? $_POST['claim']['other_accident'] : '');
    $insured_policy_group_feca = (!empty($_POST['subscriber']['group_id']) ? $_POST['subscriber']['group_id'] : '');
    $other_insured_policy_group_feca = (!empty($_POST['other_payers'][0]['subscriber']['group_id']) ? $_POST['other_payers'][0]['subscriber']['group_id'] : '');
    $insured_dob = (!empty($_POST['subscriber']['dob']) ? $_POST['subscriber']['dob'] : '');
    $insured_sex = (!empty($_POST['subscriber']['gender']) ? $_POST['subscriber']['gender'] : '');
    $insured_insurance_plan = (!empty($_POST['subscriber']['group_name']) ? $_POST['subscriber']['group_name'] : '');
    $other_insured_insurance_plan = (!empty($_POST['other_payers'][0]['name']) ? $_POST['other_payers'][0]['name'] : '');
    $other_payer = (!empty($_POST['other_payer']) ? $_POST['other_payer'] : '');
    $responsibility_sequence = (!empty($_POST['other_payers'][0]['responsibility_sequence']) ? $_POST['other_payers'][0]['responsibility_sequence'] : '');
    if ($other_payer == "true") {
        $another_plan = "YES";
    } else {
        $another_plan = "NO";
    }
    $patient_signature = (!empty($_POST['claim']['patient_signature_on_file']) ? $_POST['claim']['patient_signature_on_file'] : '');
    // NO NAME ON FIELD $patient_signed_date = $_POST['patient_signed_date'];
    $insured_signature = (!empty($_POST['claim']['direct_payment_authorized']) ? $_POST['claim']['direct_payment_authorized'] : '');
    $date_current = (!empty($_POST['claim']['date']) ? $_POST['claim']['date'] : '');
    $current_qual = (!empty($_POST['claim']['date_type']) ? $_POST['claim']['date_type'] : '');
    // NO NAME ON FIELD $date_same_illness = $_POST['date_same_illness'];
    // NO NAME ON FIELD $same_illness_qual = '';
    $unable_date_from = (!empty($_POST['claim']['last_wored_date']) ? $_POST['claim']['last_wored_date'] : '');
    $unable_date_to = (!empty($_POST['claim']['work_return_date']) ? $_POST['claim']['work_return_date'] : '');
    // SPLIT APART? $referring_provider = $_POST['referring_provider'];
    $field_17a_dd = (!empty($_POST['referring_provider']['secondary_id_type']) ? $_POSTi['referring_provider']['secondary_id_type'] : '');
    $field_17a = (!empty($_POST['referring_provider']['secondary_id']) ? $_POST['referring_provider']['secondary_id'] : '');
    $field_17b = (!empty($_POST['referring_provider']['npi']) ? $_POST['referring_provider']['npi'] : '');
    $hospitalization_date_from = (!empty($_POST['claim']['admission_date']) ? $_POST['claim']['admission_date'] : '');
    $hospitalization_date_to = (!empty($_POST['claim']['discharge_date']) ? $_POST['claim']['discharge_date'] : '');
    $outside_lab = (!empty($_POST['claim']['outside_lab']) ? $_POST['claim']['outside_lab'] : '');
    $s_charges = (!empty($_POST['claim']['outside_lab_charges']) ? $_POST['claim']['outside_lab_charges'] : '');
    $diagnosis_a = (!empty($_POST['claim']['diagnosis_codes'][1]) ? $_POST['claim']['diagnosis_codes'][1] : '');
    $diagnosis_b = (!empty($_POST['claim']['diagnosis_codes'][2]) ? $_POST['claim']['diagnosis_codes'][2] : '');
    $diagnosis_c = (!empty($_POST['claim']['diagnosis_codes'][3]) ? $_POST['claim']['diagnosis_codes'][3] : '');
    $diagnosis_d = (!empty($_POST['claim']['diagnosis_codes'][4]) ? $_POST['claim']['diagnosis_codes'][4] : '');
    $diagnosis_e = (!empty($_POST['claim']['diagnosis_codes'][5]) ? $_POST['claim']['diagnosis_codes'][5] : '');
    $diagnosis_f = (!empty($_POST['claim']['diagnosis_codes'][6]) ? $_POST['claim']['diagnosis_codes'][6] : '');
    $diagnosis_g = (!empty($_POST['claim']['diagnosis_codes'][7]) ? $_POST['claim']['diagnosis_codes'][7] : '');
    $diagnosis_h = (!empty($_POST['claim']['diagnosis_codes'][8]) ? $_POST['claim']['diagnosis_codes'][8] : '');
    $diagnosis_i = (!empty($_POST['claim']['diagnosis_codes'][9]) ? $_POST['claim']['diagnosis_codes'][9] : '');
    $diagnosis_j = (!empty($_POST['claim']['diagnosis_codes'][10]) ? $_POST['claim']['diagnosis_codes'][10] : '');
    $diagnosis_k = (!empty($_POST['claim']['diagnosis_codes'][11]) ? $_POST['claim']['diagnosis_codes'][11] : '');
    $diagnosis_l = (!empty($_POST['claim']['diagnosis_codes'][12]) ? $_POST['claim']['diagnosis_codes'][12] : '');
    $resubmission_code = (!empty($_POST['claim']['frequency']) ? $_POST['claim']['frequency'] : '');
    $original_ref_no = (!empty($_POST['claim']['original_ref_number']) ? $_POST['claim']['original_ref_number'] : '');
    $prior_authorization_number = (!empty($_POST['claim']['prior_authorization_number']) ? $_POST['claim']['prior_authorization_number'] : '');
    $service_date1_from = (!empty($_POST['claim']['service_lines'][0]['service_date_from']) ? $_POST['claim']['service_lines'][0]['service_date_from'] : '');
    $service_date1_to = (!empty($_POST['claim']['service_lines'][0]['service_date_to']) ? $_POST['claim']['service_lines'][0]['service_date_to'] : '');
    $place_of_service1 = (!empty($_POST['claim']['service_lines'][0]['place_of_service']) ? $_POST['claim']['service_lines'][0]['place_of_service'] : '');
    $emg1 = (!empty($_POST['claim']['service_lines'][0]['emgergency']) ? $_POST['claim']['service_lines'][0]['emgergency'] : '');
    $cpt_hcpcs1 = (!empty($_POST['claim']['service_lines'][0]['procedure_code']) ? $_POST['claim']['service_lines'][0]['procedure_code'] : '');
    $modifier1_1 = (!empty($_POST['claim']['service_lines'][0]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][0]['procedure_modifiers'][0] : '');
    $modifier1_2 = (!empty($_POST['claim']['service_lines'][0]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][0]['procedure_modifiers'][1] : '');
    $modifier1_3 = (!empty($_POST['claim']['service_lines'][0]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][0]['procedure_modifiers'][2] : '');
    $modifier1_4 = (!empty($_POST['claim']['service_lines'][0]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][0]['procedure_modifiers'][3] : '');
    $diagnosis_pointer1 = (!empty($_POST['claim']['service_lines'][0]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][0]['diagnosis_pointers'] : '');
    $s_charges1_1 = (!empty($_POST['claim']['service_lines'][0]['charge_amount']) ? $_POST['claim']['service_lines'][0]['charge_amount'] : '');
    $days_or_units1 = (!empty($_POST['claim']['service_lines'][0]['units']) ? $_POST['claim']['service_lines'][0]['units'] : '');
    // NO NAME  $epsdt_family_plan1 = $_POST['epsdt_family_plan1'];
    $id_qua1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['secondary_id'] : '');
 	// WHAT IS THE SECOND ID
    $rendering_provider_entity_1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_1 = (!epmty($_POST['claim']['service_lines'][0]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_1 = (!empty($_POST['claim']['service_lines'][0]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][0]['rendering_provider']['npi'] : '');

    $service_date2_from = (!empty($_POST['claim']['service_lines'][1]['service_date_from']) ? $_POST['claim']['service_lines'][1]['service_date_from'] : '');
    $service_date2_to = (!empty($_POST['claim']['service_lines'][1]['service_date_to']) ? $_POST['claim']['service_lines'][1]['service_date_to'] : '');
    $place_of_service2 = (!empty($_POST['claim']['service_lines'][1]['place_of_service']) ? $_POST['claim']['service_lines'][1]['place_of_service'] : '');
    $emg2 = (!empty($_POST['claim']['service_lines'][1]['emgergency']) ? $_POST['claim']['service_lines'][1]['emgergency'] : '');
    $cpt_hcpcs2 = (!empty($_POST['claim']['service_lines'][1]['procedure_code']) ? $_POST['claim']['service_lines'][1]['procedure_code'] : '');
    $modifier2_1 = (!empty($_POST['claim']['service_lines'][1]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][1]['procedure_modifiers'][0] : '');
    $modifier2_2 = (!empty($_POST['claim']['service_lines'][1]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][1]['procedure_modifiers'][1] : '');
    $modifier2_3 = (!empty($_POST['claim']['service_lines'][1]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][1]['procedure_modifiers'][2] : '');
    $modifier2_4 = (!empty($_POST['claim']['service_lines'][1]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][1]['procedure_modifiers'][3] : '');
    $diagnosis_pointer2 = (!empty($_POST['claim']['service_lines'][1]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][1]['diagnosis_pointers'] : '');
    $s_charges2_1 = (!empty($_POST['claim']['service_lines'][1]['charge_amount']) ? $_POST['claim']['service_lines'][1]['charge_amount'] : '');
    $days_or_units2 = (!empty($_POST['claim']['service_lines'][1]['units']) ? $_POST['claim']['service_lines'][1]['units'] : '');
    // NO NAME  $epsdt_family_plan2 = $_POST['epsdt_family_plan1'];
    $id_qua2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['secondary_id'] : '');
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_2 = (!empty($_POST['claim']['service_lines'][1]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][1]['rendering_provider']['npi'] : '');

    $service_date3_from = (!empty($_POST['claim']['service_lines'][2]['service_date_from']) ? $_POST['claim']['service_lines'][2]['service_date_from'] : '');
    $service_date3_to = (!empty($_POST['claim']['service_lines'][2]['service_date_to']) ? $_POST['claim']['service_lines'][2]['service_date_to'] : '');
    $place_of_service3 = (!empty($_POST['claim']['service_lines'][2]['place_of_service']) ? $_POST['claim']['service_lines'][2]['place_of_service'] : '');
    $emg3 = (!empty($_POST['claim']['service_lines'][2]['emgergency']) ? $_POST['claim']['service_lines'][2]['emgergency'] : '');
    $cpt_hcpcs3 = (!empty($_POST['claim']['service_lines'][2]['procedure_code']) ? $_POST['claim']['service_lines'][2]['procedure_code'] : '');
    $modifier3_1 = (!empty($_POST['claim']['service_lines'][2]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][2]['procedure_modifiers'][0] : '');
    $modifier3_2 = (!empty($_POST['claim']['service_lines'][2]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][2]['procedure_modifiers'][1] : '');
    $modifier3_3 = (!empty($_POST['claim']['service_lines'][2]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][2]['procedure_modifiers'][2] : '');
    $modifier3_4 = (!empty($_POST['claim']['service_lines'][2]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][2]['procedure_modifiers'][3] : '');
    $diagnosis_pointer3 = (!empty($_POST['claim']['service_lines'][2]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][2]['diagnosis_pointers'] : '');
    $s_charges3_1 = (!empty($_POST['claim']['service_lines'][2]['charge_amount']) ? $_POST['claim']['service_lines'][2]['charge_amount'] : '');
    $days_or_units3 = (!empty($_POST['claim']['service_lines'][2]['units']) ? $_POST['claim']['service_lines'][2]['units'] : '');
    // NO NAME  $epsdt_family_plan3 = $_POST['epsdt_family_plan1'];
    $id_qua3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['secondary_id'] : '');
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_3 = (!empty($_POST['claim']['service_lines'][2]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][2]['rendering_provider']['npi'] : '');

    $service_date4_from = (!empty($_POST['claim']['service_lines'][3]['service_date_from']) ? $_POST['claim']['service_lines'][3]['service_date_from'] : '');
    $service_date4_to = (!empty($_POST['claim']['service_lines'][3]['service_date_to']) ? $_POST['claim']['service_lines'][3]['service_date_to'] : '');
    $place_of_service4 = (!empty($_POST['claim']['service_lines'][3]['place_of_service']) ? $_POST['claim']['service_lines'][3]['place_of_service'] : '');
    $emg4 = (!empty($_POST['claim']['service_lines'][3]['emgergency']) ? $_POST['claim']['service_lines'][3]['emgergency'] : '');
    $cpt_hcpcs4 = (!empty($_POST['claim']['service_lines'][3]['procedure_code']) ? $_POST['claim']['service_lines'][3]['procedure_code'] : '');
    $modifier4_1 = (!empty($_POST['claim']['service_lines'][3]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][3]['procedure_modifiers'][0] : '');
    $modifier4_2 = (!empty($_POST['claim']['service_lines'][3]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][3]['procedure_modifiers'][1] : '');
    $modifier4_3 = (!empty($_POST['claim']['service_lines'][3]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][3]['procedure_modifiers'][2] : '');
    $modifier4_4 = (!empty($_POST['claim']['service_lines'][3]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][3]['procedure_modifiers'][3] : '');
    $diagnosis_pointer4 = (!empty($_POST['claim']['service_lines'][3]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][3]['diagnosis_pointers'] : '');
    $s_charges4_1 = (!empty($_POST['claim']['service_lines'][3]['charge_amount']) ? $_POST['claim']['service_lines'][3]['charge_amount'] : '');
    $days_or_units4 = (!empty($_POST['claim']['service_lines'][3]['units']) ? $_POST['claim']['service_lines'][3]['units'] : '');
    // NO NAME  $epsdt_family_plan4 = $_POST['epsdt_family_plan1'];
    $id_qua4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['secondary_id'] : '');
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_4 = (!empty($_POST['claim']['service_lines'][3]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][3]['rendering_provider']['npi'] : '');

    $service_date5_from = (!empty($_POST['claim']['service_lines'][4]['service_date_from']) ? $_POST['claim']['service_lines'][4]['service_date_from'] : '');
    $service_date5_to = (!empty($_POST['claim']['service_lines'][4]['service_date_to']) ? $_POST['claim']['service_lines'][4]['service_date_to'] : '');
    $place_of_service5 = (!empty($_POST['claim']['service_lines'][4]['place_of_service']) ? $_POST['claim']['service_lines'][4]['place_of_service'] : '');
    $emg5 = (!empty($_POST['claim']['service_lines'][4]['emgergency']) ? $_POST['claim']['service_lines'][4]['emgergency'] : '');
    $cpt_hcpcs5 = (!empty($_POST['claim']['service_lines'][4]['procedure_code']) ? $_POST['claim']['service_lines'][4]['procedure_code'] : '');
    $modifier5_1 = (!empty($_POST['claim']['service_lines'][4]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][4]['procedure_modifiers'][0] : '');
    $modifier5_2 = (!empty($_POST['claim']['service_lines'][4]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][4]['procedure_modifiers'][1] : '');
    $modifier5_3 = (!empty($_POST['claim']['service_lines'][4]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][4]['procedure_modifiers'][2] : '');
    $modifier5_4 = (!empty($_POST['claim']['service_lines'][4]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][4]['procedure_modifiers'][3] : '');
    $diagnosis_pointer5 = (!empty($_POST['claim']['service_lines'][4]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][4]['diagnosis_pointers'] : '');
    $s_charges5_1 = (!empty($_POST['claim']['service_lines'][4]['charge_amount']) ? $_POST['claim']['service_lines'][4]['charge_amount'] : '');
    $days_or_units5 = (!empty($_POST['claim']['service_lines'][4]['units']) ? $_POST['claim']['service_lines'][4]['units'] : '');
    // NO NAME  $epsdt_family_plan5 = $_POST['epsdt_family_plan1'];
    $id_qua5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['secondary_id'] : '');
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_5 = (!empty($_POST['claim']['service_lines'][4]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][4]['rendering_provider']['npi'] : '');

    $service_date6_from = (!empty($_POST['claim']['service_lines'][5]['service_date_from']) ? $_POST['claim']['service_lines'][5]['service_date_from'] : '');
    $service_date6_to = (!empty($_POST['claim']['service_lines'][5]['service_date_to']) ? $_POST['claim']['service_lines'][5]['service_date_to'] : '');
    $place_of_service6 = (!empty($_POST['claim']['service_lines'][5]['place_of_service']) ? $_POST['claim']['service_lines'][5]['place_of_service'] : '');
    $emg6 = (!empty($_POST['claim']['service_lines'][5]['emgergency']) ? $_POST['claim']['service_lines'][5]['emgergency'] : '');
    $cpt_hcpcs6 = (!empty($_POST['claim']['service_lines'][5]['procedure_code']) ? $_POST['claim']['service_lines'][5]['procedure_code'] : '');
    $modifier6_1 = (!empty($_POST['claim']['service_lines'][5]['procedure_modifiers'][0]) ? $_POST['claim']['service_lines'][5]['procedure_modifiers'][0] : '');
    $modifier6_2 = (!empty($_POST['claim']['service_lines'][5]['procedure_modifiers'][1]) ? $_POST['claim']['service_lines'][5]['procedure_modifiers'][1] : '');
    $modifier6_3 = (!empty($_POST['claim']['service_lines'][5]['procedure_modifiers'][2]) ? $_POST['claim']['service_lines'][5]['procedure_modifiers'][2] : '');
    $modifier6_4 = (!empty($_POST['claim']['service_lines'][5]['procedure_modifiers'][3]) ? $_POST['claim']['service_lines'][5]['procedure_modifiers'][3] : '');
    $diagnosis_pointer6 = (!empty($_POST['claim']['service_lines'][5]['diagnosis_pointers']) ? $_POST['claim']['service_lines'][5]['diagnosis_pointers'] : '');
    $s_charges6_1 = (!empty($_POST['claim']['service_lines'][5]['charge_amount']) ? $_POST['claim']['service_lines'][5]['charge_amount'] : '');
    $days_or_units6 = (!empty($_POST['claim']['service_lines'][5]['units']) ? $_POST['claim']['service_lines'][5]['units'] : '');
    // NO NAME  $epsdt_family_plan6 = $_POST['epsdt_family_plan1'];
    $id_qua6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id_type']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id_type'] : '');
    $rendering_provider_id6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['secondary_id'] : '');
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['entity']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['entity'] : '');
    $rendering_provider_first_name_6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['first_name']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['first_name'] : '');
    $rendering_provider_last_name_6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['last_name']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['last_name'] : '');
    $rendering_provider_org_6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['organization_name']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['organization_name'] : '');
    $rendering_provider_npi_6 = (!empty($_POST['claim']['service_lines'][5]['rendering_provider']['npi']) ? $_POST['claim']['service_lines'][5]['rendering_provider']['npi'] : '');

    $federal_tax_id_number = (!empty($_POST['billing_provider']['tax_id']) ? $_POST['billing_provider']['tax_id'] : '');
    $ssn = (!empty($_POST['billing_provider']['tax_id_type']) && $_POST['billing_provider']['tax_id_type']=="SY")?'1':'';
    $ein = (!empty($_POST['billing_provider']['tax_id_type']) && $_POST['billing_provider']['tax_id_type']=="EI")?'1':'';
    // NO NAME $patient_account_no = $_POST['patient_account_no'];
    $accept_assignment = (!empty($_POST['claim']['accept_assignment_code']) ? $_POST['claim']['accept_assignment_code'] : '');
    $total_charge = (!empty($_POST['claim']['total_charge']) ? $_POST['claim']['total_charge'] : '');
    $amount_paid = (!empty($_POST['claim']['patient_amount_paid']) ? $_POST['claim']['patient_amount_paid'] : '');
    $signature_physician = (!empty($_POST['claim']['provider_signature_on_file']) ? $_POST['claim']['provider_signature_on_file'] : '');
    $physician_signed_date = (($_POST['claim']['signature_date'] != date('m/d/Y')) ? $_POST['claim']['signature_date'] : '');
    $service_facility_info_name = (!empty($_POST['service_facility']['name']) ? $_POST['service_facility']['name'] : '');
    $service_facility_info_address = (!empty($_POST['service_facility']['address']['street_line_1']) ? $_POST['service_facility']['address']['street_line_1'] : '');
    $service_facility_info_city = (!empty($_POST['service_facility']['address']['city']) ? $_POST['service_facility']['address']['city'] : '');
	//SPLIT APART?
    $service_info_a = (!empty($_POST['service_facility']['npi']) ? $_POST['service_facility']['npi'] : '');
    $billing_provider_phone = (!empty($_POST['billing_provider']['phone_number']) ? $_POST['billing_provider']['phone_number'] : '');
    $billing_provider_name = (!empty($_POST['billing_provider']['organization_name']) ? $_POST['billing_provider']['organization_name'] : '');
    $billing_provider_address = (!empty($_POST['billing_provider']['address']['street_line_1']) ? $_POST['billing_provider']['address']['street_line_1'] : '');
    $billing_provider_city = (!empty($_POST['billing_provider']['address']['city']) ? $_POST['billing_provider']['address']['city'] : '');
    $billing_provider_a = (!empty($_POST['billing_provider']['npi']) ? $_POST['billing_provider']['npi'] : '');
    $reject_reason = (!empty($_POST['reject_reason']) ? $_POST['reject_reason'] : '');
    $insurance_type_arr = (!empty($insurance_type) ? $insurance_type : '');
    $p_m_eligible_payer_id = (!empty($_POST['payer']['id']) ? $_POST['payer']['id'] : '');
    $p_m_eligible_payer_name = (!empty($_POST['payer']['name']) ? $_POST['payer']['name'] : '');

    $pat_sql = "select * from dental_patients where patientid='".s_for(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

    $pat_myarray = $db->getRow($pat_sql);
    $p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
    $docid = $pat_myarray['docid'];
    $u_status = $status;
    if($status == DSS_CLAIM_SENT) {
        $fdf_type = "primary";
        if($p_m_ins_ass == 'No') {
            $u_status = DSS_CLAIM_PAID_PATIENT;
        } else {
            if(isset($_POST['ex_pagebtn_elec'])) {
                $u_status = false;
            } else {
                $u_status = DSS_CLAIM_SENT;
            }
        }
    } elseif($status == DSS_CLAIM_SEC_SENT) {
        $fdf_type = "secondary";
        if($s_m_ins_ass == 'No'){
            $u_status = DSS_CLAIM_PAID_PATIENT;
        } else {
            $u_status = DSS_CLAIM_SEC_SENT;
        }
    } else {
        $fdf_type = "primary";
        $u_status = false;
    }

    if( $patient_lastname != '') {
        $ed_sql = " update dental_insurance set
                pica2 = '" . s_for($pica2) . "',
                pica3 = '" . s_for($pica3) . "',
                patient_lastname = '" . s_for($patient_lastname) . "',
                patient_firstname = '" . s_for($patient_firstname) . "',
                patient_middle = '" . s_for($patient_middle) . "',
                patient_dob = '" . s_for($patient_dob) . "',
                patient_sex = '" . s_for($patient_sex) . "',
                patient_address = '" . s_for($patient_address) . "',
                patient_state = '" . s_for($patient_state) . "',
                patient_status = '" . s_for(!empty($patient_status_arr) ? $patient_status_arr : '') . "',
                patient_city = '" . s_for($patient_city) . "',
                patient_zip = '" . s_for($patient_zip) . "',
                patient_phone_code = '" . s_for(!empty($patient_phone_code) ? $patient_phone_code : '') . "',
                patient_phone = '" . s_for($patient_phone) . "',
                patient_relation_insured = '" . s_for($patient_relation_insured) . "',
                insurance_type = '" . s_for(!empty($insurance_type) ? $insurance_type : '') . "',
                insured_id_number = '" . s_for($insured_id_number) . "',
                insured_firstname = '" . s_for($insured_firstname) . "',
                insured_lastname = '" . s_for($insured_lastname) . "',
                insured_middle = '" . s_for($insured_middle) . "',
                insured_address = '" . s_for($insured_address) . "',
                insured_city = '" . s_for($insured_city) . "',
                insured_state = '" . s_for($insured_state) . "',
                insured_zip = '" . s_for($insured_zip) . "',
                insured_phone_code = '" . s_for(!empty($insured_phone_code) ? $insured_phone_code : '') . "',
                insured_phone = '" . s_for($insured_phone) . "',
                other_insured_id_number = '" . s_for($other_insured_id_number) . "',
                other_insured_firstname = '" . s_for($other_insured_firstname) . "',
                other_insured_lastname = '" . s_for($other_insured_lastname) . "',
                other_insured_middle = '" . s_for($other_insured_middle) . "',
                other_insured_address = '" . s_for($other_insured_address) . "',
                other_insured_city = '" . s_for($other_insured_city) . "',
                other_insured_state = '" . s_for($other_insured_state) . "',
                other_insured_zip = '" . s_for($other_insured_zip) . "',
                insured_policy_group_feca = '" . s_for($insured_policy_group_feca) . "',
                other_insured_policy_group_feca = '" . s_for($other_insured_policy_group_feca) . "',
                insured_dob = '" . s_for($insured_dob) . "',
                insured_sex = '" . s_for($insured_sex) . "',
                other_insured_dob = '" . s_for(!empty($other_insured_dob) ? $other_insured_dob : '') . "',
                other_insured_sex = '" . s_for(!empty($other_insured_sex) ? $other_insured_sex : '') . "',
                insured_employer_school_name = '" . s_for(!empty($insured_employer_school_name) ? $insured_employer_school_name : '') . "',
                other_insured_employer_school_name = '" . s_for(!empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : '') . "',
                insured_insurance_plan = '" . s_for($insured_insurance_plan) . "',
                other_insured_insurance_plan = '" . s_for($other_insured_insurance_plan) . "',
                employment = '" . s_for($employment) . "',
                auto_accident = '" . s_for($auto_accident) . "',
                auto_accident_place = '" . s_for($auto_accident_place) . "',
                other_accident = '" . s_for($other_accident) . "',
                reserved_local_use = '" . s_for(!empty($reserved_local_use) ? $reserved_local_use : '') . "',
                another_plan = '" . s_for($another_plan) . "',
                patient_signature = '" . s_for($patient_signature) . "',
                patient_signed_date = '" . s_for(!empty($patient_signed_date) ? $patient_signed_date : '') . "',
                insured_signature = '" . s_for($insured_signature) . "',
                date_current = '" . s_for($date_current) . "',
                date_same_illness = '" . s_for(!empty($date_same_illness) ? $date_same_illness : '') . "',
                unable_date_from = '" . s_for($unable_date_from) . "',
                unable_date_to = '" . s_for($unable_date_to) . "',
                name_referring_provider_qualifier = '" . s_for($name_referring_provider_qualifier) . "',
                referring_provider = '" . s_for(!empty($referring_provider) ? $referring_provider : '') . "',
                field_17a_dd = '" . s_for($field_17a_dd) . "',
                field_17a = '" . s_for($field_17a) . "',
                field_17b = '" . s_for($field_17b) . "',
                hospitalization_date_from = '" . s_for($hospitalization_date_from) . "',
                hospitalization_date_to = '" . s_for($hospitalization_date_to) . "',
                reserved_local_use1 = '" . s_for(!empty($reserved_local_use1) ? $reserved_local_use1 : '') . "',
                outside_lab = '" . s_for($outside_lab) . "',
                s_charges = '" . s_for($s_charges) . "',
                diagnosis_1 = '" . s_for(!empty($diagnosis_1) ? $diagnosis_1 : '') . "',
                diagnosis_2 = '" . s_for(!empty($diagnosis_2) ? $diagnosis_2 : '') . "',
                diagnosis_3 = '" . s_for(!empty($diagnosis_3) ? $diagnosis_3 : '') . "',
                diagnosis_4 = '" . s_for(!empty($diagnosis_4) ? $diagnosis_4 : '') . "',
                icd_ind = '" . s_for($icd_ind) . "',
                diagnosis_a = '" . s_for($diagnosis_a) . "',
                diagnosis_b = '" . s_for($diagnosis_b) . "',
                diagnosis_c = '" . s_for($diagnosis_c) . "',
                diagnosis_d = '" . s_for($diagnosis_d) . "',
                diagnosis_e = '" . s_for($diagnosis_e) . "',
                diagnosis_f = '" . s_for($diagnosis_f) . "',
                diagnosis_g = '" . s_for($diagnosis_g) . "',
                diagnosis_h = '" . s_for($diagnosis_h) . "',
                diagnosis_i = '" . s_for($diagnosis_i) . "',
                diagnosis_j = '" . s_for($diagnosis_j) . "',
                diagnosis_k = '" . s_for($diagnosis_k) . "',
                diagnosis_l = '" . s_for($diagnosis_l) . "',
                medicaid_resubmission_code = '" . s_for(!empty($medicaid_resubmission_code) ? $medicaid_resubmission_code : '') . "',
                original_ref_no = '" . s_for($original_ref_no) . "',
                prior_authorization_number = '" . s_for($prior_authorization_number) . "',
                service_date1_from = '" . s_for($service_date1_from) . "',
                service_date1_to = '" . s_for($service_date1_to) . "',
                place_of_service1 = '" . s_for($place_of_service1) . "',
                emg1 = '" . s_for($emg1) . "',
                cpt_hcpcs1 = '" . s_for($cpt_hcpcs1) . "',
                modifier1_1 = '" . s_for($modifier1_1) . "',
                modifier1_2 = '" . s_for($modifier1_2) . "',
                modifier1_3 = '" . s_for($modifier1_3) . "',
                modifier1_4 = '" . s_for($modifier1_4) . "',
                diagnosis_pointer1 = '" . s_for($diagnosis_pointer1) . "',
                s_charges1_1 = '" . s_for($s_charges1_1) . "',
                s_charges1_2 = '" . s_for(!empty($s_charges1_2) ? $s_charges1_2 : '') . "',
                days_or_units1 = '" . s_for($days_or_units1) . "',
                epsdt_family_plan1 = '" . s_for(!empty($epsdt_family_plan1) ? $epsdt_family_plan1 : '') . "',
                id_qua1 = '" . s_for($id_qua1) . "',
                rendering_provider_id1 = '" . s_for($rendering_provider_id1) . "',
                service_date2_from = '" . s_for($service_date2_from) . "',
                service_date2_to = '" . s_for($service_date2_to) . "',
                place_of_service2 = '" . s_for($place_of_service2) . "',
                emg2 = '" . s_for($emg2) . "',
                cpt_hcpcs2 = '" . s_for($cpt_hcpcs2) . "',
                modifier2_1 = '" . s_for($modifier2_1) . "',
                modifier2_2 = '" . s_for($modifier2_2) . "',
                modifier2_3 = '" . s_for($modifier2_3) . "',
                modifier2_4 = '" . s_for($modifier2_4) . "',
                diagnosis_pointer2 = '" . s_for($diagnosis_pointer2) . "',
                s_charges2_1 = '" . s_for($s_charges2_1) . "',
                s_charges2_2 = '" . s_for(!empty($s_charges2_2) ? $s_charges2_2 : '') . "',
                days_or_units2 = '" . s_for($days_or_units2) . "',
                epsdt_family_plan2 = '" . s_for(!empty($epsdt_family_plan2) ? $epsdt_family_plan2 : '') . "',
                id_qua2 = '" . s_for($id_qua2) . "',
                rendering_provider_id2 = '" . s_for($rendering_provider_id2) . "',
                service_date3_from = '" . s_for($service_date3_from) . "',
                service_date3_to = '" . s_for($service_date3_to) . "',
                place_of_service3 = '" . s_for($place_of_service3) . "',
                emg3 = '" . s_for($emg3) . "',
                cpt_hcpcs3 = '" . s_for($cpt_hcpcs3) . "',
                modifier3_1 = '" . s_for($modifier3_1) . "',
                modifier3_2 = '" . s_for($modifier3_2) . "',
                modifier3_3 = '" . s_for($modifier3_3) . "',
                modifier3_4 = '" . s_for($modifier3_4) . "',
                diagnosis_pointer3 = '" . s_for($diagnosis_pointer3) . "',
                s_charges3_1 = '" . s_for($s_charges3_1) . "',
                s_charges3_2 = '" . s_for(!empty($s_charges3_2) ? $s_charges3_2 : '') . "',
                days_or_units3 = '" . s_for($days_or_units3) . "',
                epsdt_family_plan3 = '" . s_for(!empty($epsdt_family_plan3) ? $epsdt_family_plan3 : '') . "',
                id_qua3 = '" . s_for($id_qua3) . "',
                rendering_provider_id3 = '" . s_for($rendering_provider_id3) . "',
                service_date4_from = '" . s_for($service_date4_from) . "',
                service_date4_to = '" . s_for($service_date4_to) . "',
                place_of_service4 = '" . s_for($place_of_service4) . "',
                emg4 = '" . s_for($emg4) . "',
                cpt_hcpcs4 = '" . s_for($cpt_hcpcs4) . "',
                modifier4_1 = '" . s_for($modifier4_1) . "',
                modifier4_2 = '" . s_for($modifier4_2) . "',
                modifier4_3 = '" . s_for($modifier4_3) . "',
                modifier4_4 = '" . s_for($modifier4_4) . "',
                diagnosis_pointer4 = '" . s_for($diagnosis_pointer4) . "',
                s_charges4_1 = '" . s_for($s_charges4_1) . "',
                s_charges4_2 = '" . s_for(!empty($s_charges4_2) ? $s_charges4_2 : '') . "',
                days_or_units4 = '" . s_for($days_or_units4) . "',
                epsdt_family_plan4 = '" . s_for(!empty($epsdt_family_plan4) ? $epsdt_family_plan4 : '') . "',
                id_qua4 = '" . s_for($id_qua4) . "',
                rendering_provider_id4 = '" . s_for($rendering_provider_id4) . "',
                service_date5_from = '" . s_for($service_date5_from) . "',
                service_date5_to = '" . s_for($service_date5_to) . "',
                place_of_service5 = '" . s_for($place_of_service5) . "',
                emg5 = '" . s_for($emg5) . "',
                cpt_hcpcs5 = '" . s_for($cpt_hcpcs5) . "',
                modifier5_1 = '" . s_for($modifier5_1) . "',
                modifier5_2 = '" . s_for($modifier5_2) . "',
                modifier5_3 = '" . s_for($modifier5_3) . "',
                modifier5_4 = '" . s_for($modifier5_4) . "',
                diagnosis_pointer5 = '" . s_for($diagnosis_pointer5) . "',
                s_charges5_1 = '" . s_for($s_charges5_1) . "',
                s_charges5_2 = '" . s_for(!empty($s_charges5_2) ? $s_charges5_2 : '') . "',
                days_or_units5 = '" . s_for($days_or_units5) . "',
                epsdt_family_plan5 = '" . s_for(!empty($epsdt_family_plan5) ? $epsdt_family_plan5 : '') . "',
                id_qua5 = '" . s_for($id_qua5) . "',
                rendering_provider_id5 = '" . s_for($rendering_provider_id5) . "',
                service_date6_from = '" . s_for($service_date6_from) . "',
                service_date6_to = '" . s_for($service_date6_to) . "',
                place_of_service6 = '" . s_for($place_of_service6) . "',
                emg6 = '" . s_for($emg6) . "',
                cpt_hcpcs6 = '" . s_for($cpt_hcpcs6) . "',
                modifier6_1 = '" . s_for($modifier6_1) . "',
                modifier6_2 = '" . s_for($modifier6_2) . "',
                modifier6_3 = '" . s_for($modifier6_3) . "',
                modifier6_4 = '" . s_for($modifier6_4) . "',
                diagnosis_pointer6 = '" . s_for($diagnosis_pointer6) . "',
                s_charges6_1 = '" . s_for($s_charges6_1) . "',
                s_charges6_2 = '" . s_for(!empty($s_charges6_2) ? $s_charges6_2 : '') . "',
                days_or_units6 = '" . s_for($days_or_units6) . "',
                epsdt_family_plan6 = '" . s_for(!empty($epsdt_family_plan6) ? $epsdt_family_plan6 : '') . "',
                id_qua6 = '" . s_for($id_qua6) . "',
                rendering_provider_id6 = '" . s_for($rendering_provider_id6) . "',
                federal_tax_id_number = '" . s_for($federal_tax_id_number) . "',
                ssn = '" . s_for($ssn) . "',
                ein = '" . s_for($ein) . "',
                patient_account_no = '" . s_for(!empty($patient_account_no) ? $patient_account_no : '') . "',
                accept_assignment = '" . s_for($accept_assignment) . "',
                total_charge = '" . s_for($total_charge) . "',
                amount_paid = '" . s_for($amount_paid) . "',
                balance_due = '" . s_for(!empty($balance_due) ? $balance_due : '') . "',
                claim_codes = '" . s_for($claim_codes) . "',
                other_claim_id = '" . s_for($other_claim_id) . "',
                signature_physician = '" . s_for($signature_physician) . "',
                physician_signed_date = '" . s_for(!empty($physician_signed_date) ? $physician_signed_date : '') . "',
                service_facility_info_name = '" . s_for($service_facility_info_name) . "',
                service_facility_info_address = '" . s_for($service_facility_info_address) . "',
                service_facility_info_city = '" . s_for($service_facility_info_city) . "',
                service_info_a = '" . s_for($service_info_a) . "',
                service_info_dd = '" . s_for(!empty($service_info_dd) ? $service_info_dd : '') . "',
                service_info_b_other = '" . s_for(!empty($service_info_b_other) ? $service_info_b_other : '') . "',
                billing_provider_phone_code = '" . s_for(!empty($billing_provider_phone_code) ? $billing_provider_phone_code : '') . "',
                billing_provider_phone = '" . s_for($billing_provider_phone) . "',
                billing_provider_name = '" . s_for($billing_provider_name) . "',
                billing_provider_address = '" . s_for($billing_provider_address) . "',
                billing_provider_city = '" . s_for($billing_provider_city) . "',
                billing_provider_a = '" . s_for($billing_provider_a) . "',
                billing_provider_dd = '" . s_for(!empty($billing_provider_dd) ? $billing_provider_dd : '') . "',
                billing_provider_b_other = '" . s_for(!empty($billing_provider_b_other) ? $billing_provider_b_other : '') . "',
                p_m_eligible_payer_id = '" . $p_m_eligible_payer_id . "',
                p_m_eligible_payer_name = '" . mysql_real_escape_string($p_m_eligible_payer_name) . "',
                s_m_eligible_payer_id = '" . mysql_real_escape_string($s_m_eligible_payer_id) . "',
                s_m_eligible_payer_name = '" . mysql_real_escape_string($s_m_eligible_payer_name) . "',
                rendering_provider_entity_1  = '" . mysql_real_escape_string($rendering_provider_entity_1) . "',
                rendering_provider_first_name_1  = '" . mysql_real_escape_string($rendering_provider_first_name_1) . "',
                rendering_provider_last_name_1  = '" . mysql_real_escape_string($rendering_provider_last_name_1) . "',
                rendering_provider_org_1  = '" . mysql_real_escape_string($rendering_provider_org_1) . "',
                rendering_provider_npi_1  = '" . mysql_real_escape_string($rendering_provider_npi_1) . "',
                rendering_provider_entity_2  = '" . mysql_real_escape_string($rendering_provider_entity_2) . "',
                rendering_provider_first_name_2  = '" . mysql_real_escape_string($rendering_provider_first_name_2) . "',
                rendering_provider_last_name_2  = '" . mysql_real_escape_string($rendering_provider_last_name_2) . "',
                rendering_provider_org_2  = '" . mysql_real_escape_string($rendering_provider_org_2) . "',
                rendering_provider_npi_2  = '" . mysql_real_escape_string($rendering_provider_npi_2) . "',
                rendering_provider_entity_3  = '" . mysql_real_escape_string($rendering_provider_entity_3) . "',
                rendering_provider_first_name_3  = '" . mysql_real_escape_string($rendering_provider_first_name_3) . "',
                rendering_provider_last_name_3  = '" . mysql_real_escape_string($rendering_provider_last_name_3) . "',
                rendering_provider_org_3  = '" . mysql_real_escape_string($rendering_provider_org_3) . "',
                rendering_provider_npi_3  = '" . mysql_real_escape_string($rendering_provider_npi_3) . "',
                rendering_provider_entity_4  = '" . mysql_real_escape_string($rendering_provider_entity_4) . "',
                rendering_provider_first_name_4  = '" . mysql_real_escape_string($rendering_provider_first_name_4) . "',
                rendering_provider_last_name_4  = '" . mysql_real_escape_string($rendering_provider_last_name_4) . "',
                rendering_provider_org_4  = '" . mysql_real_escape_string($rendering_provider_org_4) . "',
                rendering_provider_npi_4  = '" . mysql_real_escape_string($rendering_provider_npi_4) . "',
                rendering_provider_entity_5  = '" . mysql_real_escape_string($rendering_provider_entity_5) . "',
                rendering_provider_first_name_5  = '" . mysql_real_escape_string($rendering_provider_first_name_5) . "',
                rendering_provider_last_name_5  = '" . mysql_real_escape_string($rendering_provider_last_name_5) . "',
                rendering_provider_org_5  = '" . mysql_real_escape_string($rendering_provider_org_5) . "',
                rendering_provider_npi_5  = '" . mysql_real_escape_string($rendering_provider_npi_5) . "',
                rendering_provider_entity_6  = '" . mysql_real_escape_string($rendering_provider_entity_6) . "',
                rendering_provider_first_name_6  = '" . mysql_real_escape_string($rendering_provider_first_name_6) . "',
                rendering_provider_last_name_6  = '" . mysql_real_escape_string($rendering_provider_last_name_6) . "',
                rendering_provider_org_6  = '" . mysql_real_escape_string($rendering_provider_org_6) . "',
                rendering_provider_npi_6  = '" . mysql_real_escape_string($rendering_provider_npi_6) . "',
                responsibility_sequence = '" . mysql_real_escape_string($responsibility_sequence) . "'";

        if (isset($_POST['reject_but'])) {
            $ed_sql .= ", status = '" . s_for(DSS_CLAIM_REJECTED) . "'";
            $ed_sql .= ", reject_reason = '" . s_for($reject_reason) . "'";
        } elseif ($u_status) {
            $ed_sql .= ", status = '" . s_for($u_status) . "'";
        }
        $ed_sql .= " where insuranceid = '" . s_for(!empty($_GET['insid']) ? $_GET['insid'] : '') . "'";

        $db->query($ed_sql);
    }
    // update the ledger trxns passed in with the form
    $trxn_status = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;
    update_ledger_trxns((!empty($_POST['ed']) ? $_POST['ed'] : ''), $trxn_status);

	$pat_sql = "UPDATE dental_patients SET 
			    p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con, $p_m_eligible_payer_name)."'
		        WHERE patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
	
    $db->query($pat_sql);
    $url = 'https://gds.eligibleapi.com/v1.5/claims.json';

    $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
    $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
    $api_key_query = mysqli_query($con, $api_key_sql);
    $api_key_result = mysqli_fetch_assoc($api_key_query);
    if($api_key_result && !empty($api_key_result['eligible_api_key'])){
        if(trim($api_key_result['eligible_api_key']) != ""){
          $api_key = $api_key_result['eligible_api_key'];
        }
    }

    $test_sql = "SELECT eligible_test FROM dental_users JOIN dental_insurance ON dental_insurance.docid = dental_users.userid WHERE insuranceid = '".mysqli_real_escape_string($con, $_GET['insid'])."'";
    $test_query = mysqli_query($con, $test_sql);
    $test_result = mysqli_fetch_assoc($test_query);

    $data = array(); //Initializing parameter array

    if($test_result['eligible_test']){
        // $data['test'] = 'true';
    }
    // @Todo: undo hot fix #140
    $data['test'] = 'true';

    $data['api_key'] = $api_key; //Setting your api key

    $data['eligibleToken'] = (!empty($_POST["eligibleToken"]) ? $_POST["eligibleToken"] : ''); // Reading eligibleToken and passing to claims endpoint

    $data['scrub_eligibility'] = 'true';

    //Curl post call to claim end point
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec ($ch);
    curl_close ($ch);

    $json_response = json_decode($result);

    if (!empty($json_response)) {
        $ref_id = $json_response->{"reference_id"};
        $success = $json_response->{"success"};
    } else {
        $ref_id = '';
        $success = '';  
    }

    $up_sql = "INSERT INTO dental_claim_electronic SET 
                claimid='".mysqli_real_escape_string($con, (!empty($_GET['insid']) ? $_GET['insid'] : ''))."',
                reference_id = '".mysqli_real_escape_string($con, $ref_id)."',
                response='".mysqli_real_escape_string($con, $result)."',
                adddate=now(),
                ip_address='".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'
                ";
    mysqli_query($con, $up_sql);
    if ($success) {
        $event = "claim_submitted";
    } else {
        $event = "claim_rejected";
    }
    $eligible_response_sql = "INSERT INTO dental_eligible_response SET
                response = '".mysqli_real_escape_string($con, $json_response)."',
                reference_id = '".mysqli_real_escape_string($con, $ref_id)."',
                event_type = '".mysqli_real_escape_string($con, $event)."',
                adddate = now(),
                ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
    mysqli_query($con, $eligible_response_sql);

    claim_status_history_update($_GET['insid'], DSS_CLAIM_SENT, DSS_CLAIM_PENDING, '', $_SESSION['adminuserid']);
    claim_history_update($_GET['insid'], '', $_SESSION['adminuserid']);
    $dce_id = $db->getInsertId($up_sql);
    invoice_add_efile('2', $_SESSION['admincompanyid'], $dce_id);
    invoice_add_claim('1', $docid, $_GET['insid']);

    if(!$success){
        error_log('Claim submission failed: ' . $result);
        $up_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_REJECTED."' WHERE insuranceid='".mysqli_real_escape_string($con, $_GET['insid'])."'";

        $db->query($up_sql);
        claim_history_update($_GET['insid'], '', $_SESSION['adminuserid']);
        claim_status_history_update($_GET['insid'], '', DSS_CLAIM_REJECTED, '', $_SESSION['adminuserid']);

        $confirm = "Submission failed. ";
        $errors = $json_response->{"errors"}->{"messages"};
        foreach($errors as $error){
            $confirm .= mysqli_real_escape_string($con, $error).", ";
        }
?>
        <script type="text/javascript">
            alert('RESPONSE: <?= $confirm; ?>');
            window.location = "manage_claims.php?status=0&insid=<?= $_GET['insid']; ?>";
        </script>
<?php
        } elseif ($result == "Invalid JSON") {
            $confirm = "Submission failed. Invalid JSON";
?>
        <script type="text/javascript">
            alert('RESPONSE: <?= $confirm; ?>');
           window.location = "manage_claims.php?status=0&insid=<?php echo  $_GET['insid']; ?>"; 
        </script>
<?php
    } else {
?>
        <script type="text/javascript">
          c = confirm('RESPONSE: <?php echo  $result; ?> Do you want to mark the claim sent?');
          if(c){
           window.location = "manage_claims.php?status=0";
          }
        </script>
<?php
    }
?>
