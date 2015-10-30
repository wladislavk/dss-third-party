<?php namespace Ds3\Libraries\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include_once('includes/constants.inc');
    include("includes/sescheck.php");
    include_once('includes/authorization_functions.php');
    include_once('includes/claim_functions.php');
    include_once('admin/includes/invoice_functions.php');
require_once ROOT_DIR . '/manage/admin/includes/claim_functions.php';
?>

<html>
    <head>
        <script type="text/javascript" src="/manage/js/insert_ledger_entries.js"></script>
    </head>

    <body>
    <br /><br />
<?php
    $i = (!empty($_COOKIE['tempforledgerentry']) ? $_COOKIE['tempforledgerentry'] : '');
    $d = 1;
    if( authorize((!empty($_POST['username']) ? $_POST['username'] : ''), (!empty($_POST['password']) ? $_POST['password'] : ''), DSS_USER_TYPE_ADMIN))
    {
        $sqlinsertqry = "INSERT INTO `dental_ledger` (  `ledgerid` ,
                                                        `patientid` ,
                                                        `service_date` ,
                                                        `entry_date` ,
                                                        `description` ,
                                                        `producer` ,
                                                        `amount` ,
                                                        `transaction_type` ,
                                                        `paid_amount` ,
                                                        `userid` ,
                                                        `docid` ,
                                                        `status` ,
                                                        `adddate` ,
                                                        `ip_address` ,
                                                        `transaction_code`,
                                                        `producerid`,
                                                        `primary_claim_id`
                                                        ) VALUES ";

        if ( !empty($_POST['form']) )
        {
            foreach($_POST['form'] as $form)
            {
                $sqlinsertqry = "INSERT INTO `dental_ledger` (  `ledgerid` ,
                                                                `patientid` ,
                                                                `service_date` ,
                                                                `entry_date` ,
                                                                `description` ,
                                                                `producer` ,
                                                                `amount` ,
                                                                `transaction_type` ,
                                                                `paid_amount` ,
                                                                `userid` ,
                                                                `docid` ,
                                                                `status` ,
                                                                `adddate` ,
                                                                `ip_address` ,
                                                                `transaction_code`,
                                                                `producerid`,
                                                                `primary_claim_id`
                                                                ) VALUES ";

                if ($form['status']==DSS_TRXN_PENDING) 
                { 
                    $new_status = DSS_TRXN_PENDING;
                } else 
                {
                    $new_status = $form['status'];
                }

                if( $form['status']==1 )
                {
                    $pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $form['producer'])."'";
                        
                    $pf = $db->getRow($pf_sql);
                    if($pf['producer_files'] == '1') 
                    {
                        $claim_producer = $form['producer'];
                    } else 
                    {
                        $claim_producer = $_SESSION['docid'];
                    }

                    $s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".mysqli_real_escape_string($con, $_POST['patientid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
                        
                    $q = $db->getResults($s);
                    $n = count($q);
                    if($n > 0) 
                    {
                        $r = $q[0];
                        $claim_id = $r['insuranceid'];
                    } else
                    {
                        $claim_id = ClaimFormData::createPrimaryClaim($_POST['patientid'], $claim_producer);
                    }
                } else
                {
                    $claim_id = '';
                }

                $descsql = "SELECT description, transaction_code, amount_adjust FROM dental_transaction_code WHERE transaction_codeid='".$form['proccode']."' LIMIT 1;";
                
                $txcode = $db->getRow($descsql);
                if( $txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_NEGATIVE )
                {
                    $amount = -1 * abs($form['amount']);
                } elseif($txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_POSITIVE) 
                {
                    $amount = abs($form['amount']);
                } else 
                {
                    $amount = $form['amount'];
                }

                $_POST['patientid'] = mysqli_real_escape_string($con, $_POST['patientid']);
                $_SESSION['userid'] = mysqli_real_escape_string($con, $_SESSION['userid']);
                $_SESSION['docid'] = mysqli_real_escape_string($con, $_SESSION['docid']);
                $_SERVER['REMOTE_ADDR'] = mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR']);
                $txcode['transaction_code'] = mysqli_real_escape_string($con, $txcode['transaction_code']);
                $txcode['description'] = mysqli_real_escape_string($con, $txcode['description']);

                if($d <= $i)
                {
                    if($form['status']==1) 
                    {
                        $form_claim_id = $claim_id;
                    } else 
                    {
                        $form_claim_id = '';
                    }



                    if( $form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "( NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, '".str_replace(',','', $amount)."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."')";
                    } elseif( $form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."')";
                    } elseif( $form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    } elseif( $form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    } elseif( $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    }

                    if( !empty($query_ins) ) {
                        $sqlinsertqry .= $query_ins;
                        $ins_id = $db->getInsertId($sqlinsertqry);
                        if (strtolower($txcode['transaction_code']) == 'e0486') {
                            invoice_add_e0486('1', $_SESSION['docid'], $ins_id, DSS_INVOICE_TYPE_BC_FO);
                        }
                    }
                } elseif( $d == $i )
                {
                    $descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form['proccode']."' LIMIT 1;";
                        
                    $descquery = $db->getResults($descsql);
                    if ($descquery) 
                    {
                        foreach ($descquery as $txcode)
                        {
                            if( $form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != '' ) 
                            {
                                $service_date = $form['service_date'];
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($service_date))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, '".str_replace(',','', $amount)."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != '')
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            }
                            $d++;
                        }
                    }
                }
            }
        }
	            
        claim_history_update((!empty($claim_id) ? $claim_id : ''), $_SESSION['userid'], '');

        if( empty($ins_id) )
        {
?>
<script type="text/javascript">
    alert('Could not add ledger entries, please close this window and contact your system administrator');
    eraseCookie('tempforledgerentry');
    parent.window.location = parent.window.location;
</script>
<?php
        } else 
        {
?>
<script type="text/javascript">
    eraseCookie('tempforledgerentry');
    alert('Transaction(s) successfully added!');
    parent.window.location = parent.window.location;
</script>
<?php
        }
    } else 
    { 
        //NOT AUTHORIZED
?>
<script type="text/javascript">
    alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST');
    history.go(-1);
</script>
<?php
    }
?>
<?php
    function create_claim($pid, $prod)
    {
        $db = new Db();

        $pat_sql = "select p.*, u.billing_company_id from dental_patients p 
    		        JOIN dental_users u ON u.userid=p.docid
    		        where p.patientid='".s_for($pid)."'";

        $pat_myarray = $db->getRow($pat_sql);
        $p_m_dss_file = $pat_myarray['p_m_dss_file'];
        $p_m_billing_id = $pat_myarray['billing_company_id'];
        $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
        $insurancetype = st($pat_myarray['p_m_ins_type']);
        $other_insurancetype = st($pat_myarray['s_m_ins_type']);
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
        $insured_sex = $pat_myarray['p_m_gender'];

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

    	if($pat_myarray['p_m_same_address']=='1'){
            $insured_address = $pat_myarray['add1'];
            $insured_city = $pat_myarray['city'];
            $insured_state = $pat_myarray['state'];
            $insured_zip = $pat_myarray['zip'];
    	}else{
            $insured_address = $pat_myarray['p_m_address'];
            $insured_city = $pat_myarray['p_m_city'];
            $insured_state = $pat_myarray['p_m_state'];
            $insured_zip = $pat_myarray['p_m_zip'];
    	}

    	if($pat_myarray['s_m_same_address']=='1'){
            $other_insured_address = $pat_myarray['add1'];
            $other_insured_city = $pat_myarray['city'];
            $other_insured_state = $pat_myarray['state'];
            $other_insured_zip = $pat_myarray['zip'];
    	}else{
            $other_insured_address = $pat_myarray['s_m_address'];
            $other_insured_city = $pat_myarray['s_m_city'];
            $other_insured_state = $pat_myarray['s_m_state'];
            $other_insured_zip = $pat_myarray['s_m_zip'];
    	}

        $insured_dob = $pat_myarray['ins_dob'];
        $patient_relation_insured = $pat_myarray['p_m_relation'];
        $patient_relation_other_insured = $pat_myarray['s_m_relation'];
        $insured_employer_school_name = $pat_myarray['employer'];
        $p_m_eligible_payer_id = $pat_myarray['p_m_eligible_payer_id'];
        $p_m_eligible_payer_name = $pat_myarray['p_m_eligible_payer_name'];


        $sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                        WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

        $d = $db->getRow($sleepstudies);
        $diagnosis_1 = $d['diagnosis'];

        $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con, $diagnosis_1)."'";

        $ins_diag = $db->getRow($ins_diag_sql);
        $diagnosis_a = $ins_diag['ins_diagnosis'];

        $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                        WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

        $d = $db->getRow($sleepstudies);
        $diagnosising_doc = $d['diagnosising_doc'];
        $diagnosising_npi = $d['diagnosising_npi'];

        $accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
        if ($dent_rows <= 0) {
            $accept_assignment = $accept_assignmentnew;
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

            $my = $db->getResults($sql);
            $num_rows = count($my);

            if ($num_rows > 0) {
                $myarray = $my[0];
                $prior_authorization_number = $myarray['pre_auth_num'];
            }
        }

    	$ins_sql = " insert into dental_insurance set 
        	patientid = '".s_for($pid)."',
        	pica1 = '".s_for($pica1)."',
        	pica2 = '".s_for($pica2)."',
        	pica3 = '".s_for($pica3)."',
        	insurance_type = '".s_for($insurancetype)."',
        	other_insurance_type = '".s_for($other_insurancetype)."',
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
        	patient_relation_other_insured = '".s_for($patient_relation_other_insured)."',
        	patient_city = '".s_for($patient_city)."',
        	patient_state = '".s_for($patient_state)."',
        	patient_status = '".s_for($patient_status_arr)."',
        	insured_address = '".s_for($insured_address)."',
        	insured_city = '".s_for($insured_city)."',
        	insured_state = '".s_for($insured_state)."',
        	insured_zip = '".s_for($insured_zip)."',
        	other_insured_address = '".s_for($other_insured_address)."',
        	other_insured_city = '".s_for($other_insured_city)."',
        	other_insured_state = '".s_for($other_insured_state)."',
        	other_insured_zip = '".s_for($other_insured_zip)."',
        	patient_zip = '".s_for($patient_zip)."',
        	patient_phone_code = '".s_for($patient_phone_code)."',
        	patient_phone = '".s_for($patient_phone)."',
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
    		p_m_eligible_payer_id = '".$db->escape($p_m_eligible_payer_id)."',
            p_m_eligible_payer_name = '".$db->escape($p_m_eligible_payer_name)."',
            status = '".s_for(DSS_CLAIM_PENDING)."',
            userid = '".s_for($_SESSION['userid'])."',
            docid = '".s_for($_SESSION['docid'])."',
    		producer = '".s_for($prod)."',
    		p_m_billing_id='".s_for($p_m_billing_id)."',
    		p_m_dss_file='".s_for($p_m_dss_file)."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

    	$primary_claim_id = $db->getInsertId($ins_sql);
        return $primary_claim_id;
    }
?>

</body>
</html>
