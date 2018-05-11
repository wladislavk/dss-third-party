<?php namespace Ds3\Libraries\Legacy; ?><?php
    function claim_errors( $pid, $medicare = false )
    {
        $db = new Db();
        $con = $GLOBALS['con'];

        $errors = array();
        /*
           $sql = "SELECT * FROM dental_patients p WHERE p.referred_source IS NOT NULL AND p.referred_source != '' AND p.patientid=".$pid;
          $my = mysqli_query($con, $sql);
          $num = mysqli_num_rows($my);
          if( $num <= 0 ){
            array_push($errors, "Missing referral - Flow Sheet");
          }
        */
        if ($medicare) {
            $sql = "SELECT p_m_ins_type FROM dental_patients p WHERE p.patientid=".(!empty($pid) ? $pid : '')." LIMIT 1";
            
            $row = $db->getRow($sql);
            if($row['p_m_ins_type']==1){
                array_push($errors, "patient has Medicare Insurance. You can change patient\'s insurance type in the Patient Info section");
            }
        }

        $sql = "SELECT * FROM dental_patients p JOIN dental_contact i ON p.p_m_ins_co = i.contactid WHERE p.patientid=".$pid;
        
        $num = $db->getNumberRows($sql);
        if ( $num <= 0 ) {
            array_push($errors, "Missing insurance company - Patient Info");
        }

        $sql = "SELECT * FROM dental_patients p JOIN dental_users d ON p.docid = d.userid WHERE p.patientid=".$pid;

        $num = $db->getNumberRows($sql);
        if ( $num <= 0 ) {
            array_push($errors, "Missing doctor");
        }

        $sql = "SELECT * FROM dental_patients p WHERE p.patientid=".$pid;
        
        $m = $db->getRow($sql);

        if (!empty($_SESSION['user_type'])) {
            $user_type = $_SESSION['user_type'];
        } else {
            $user_type = '';
        }

        if( $m['p_m_dss_file']!=1 && $user_type != DSS_USER_TYPE_SOFTWARE ){
            array_push($errors, "Primary DSS filing insurance not selected - Patient Info");
        }

        if ($m['p_m_relation']=='' ||
            $m['p_m_partyfname'] == "" ||
            $m['p_m_partylname'] == "" ||
            $m['p_m_relation'] == "" ||
            $m['ins_dob'] == "" ||
            $m['p_m_gender'] == "" ||
            $m['p_m_ins_co'] == "" ||
            $m['p_m_ins_grp'] == "" ||
            ($m['p_m_ins_plan'] == "" && $m['p_m_ins_type'] != 1) || 
            $m['p_m_ins_type'] == '' ||
            $m['p_m_ins_ass'] == ''
        ){
            array_push($errors, "Primary insurance not completed - Patient Info");
        }

        $sql = "SELECT * FROM dental_patients p JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' WHERE p.patientid=".$pid;

        $num = $db->getNumberRows($sql);
        if ( $num <= 0 ) {
            array_push($errors, "Missing transaction code E0486");
        }

        $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                        WHERE                                 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

        $num = $db->getNumberRows($sleepstudies);
        if( $num <= 0 ){
            array_push($errors, "Summary Sheet - Missing completed sleep study");
        } else { 
            $p_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='".$pid."';";
            
            $p = $db->getRow($p_sql);
            if ($p['p_m_ins_type'] == 1) {
                $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                                 JOIN dental_patients p on ss.patiendid=p.patientid                        
                                 WHERE                                 
                                (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                                (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                                ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";
                
                $num = $db->getNumberRows($sleepstudies);
                if( $num <= 0 ){
                    array_push($errors, "Flowsheet - Sleep Study: Diagnosing Phys. and Diagnosing NPI# are required for Medicare claims.");
                }

                $doc_sql = "SELECT u.* FROM 
                            dental_patients p 
                            JOIN dental_users u ON p.docid = u.userid 
                            WHERE p.patientid = '".mysqli_real_escape_string($con,$pid)."'";
                
                $doc = $db->getRow($doc_sql);
                if ($doc['medicare_npi'] == '') {
                    array_push($errors, "No Medicare NPI on file - cannot file Medicare claims. Please add your Medicare NPI via Admin -> Profile.");
                }
            }
        }

        /*
        $sql = "SELECT * FROM dental_summ_sleeplab p WHERE p.patiendid=".$pid;
          $my = mysqli_query($con, $sql);
          $num = mysqli_num_rows($my);
          if( $num <= 0 ){
            array_push($errors, "Missing sleep lab");
          }
        */
        /*  $sql = "SELECT * FROM dental_patients p JOIN dental_q_page2_view q2 ON p.patientid = q2.patientid WHERE p.patientid=".$pid;
          $my = mysqli_query($con, $sql);
          $num = mysqli_num_rows($my);
          if( $num <= 0 ){
            array_push($errors, "Missing questionnaire page 2");
          }
        */

        $flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$pid."' LIMIT 1;";
        
        $flowresult = $db->getResults($flowquery);
        if (count($flowresult) <= 0) {
            array_push($errors, "Does not have flowsheet");
        } else {
            $flow = $flowresult[0];
            $copyreqdate = $flow['copyreqdate'];
            $referred_by = $flow['referred_by'];
            $referreddate = $flow['referreddate'];
            $thxletter = $flow['thxletter'];
            $queststartdate = $flow['queststartdate'];
            $questcompdate = $flow['questcompdate'];
            $insinforec = $flow['insinforec'];
            $rxreq = $flow['rxreq'];
            $rxrec = $flow['rxrec'];
            $lomnreq = $flow['lomnreq'];
            $lomnrec = $flow['lomnrec'];
            $rxlomnrec = $flow['rxlomnrec'];
            $contact_location = $flow['contact_location'];
            $questsendmeth = $flow['questsendmeth'];
            $questsender = $flow['questsender'];
            $refneed = $flow['refneed'];
            $refneeddate1 = $flow['refneeddate1'];
            $refneeddate2 = $flow['refneeddate2'];
            $preauth = $flow['preauth'];
            $preauth1 = $flow['preauth1'];
            $preauth2 = $flow['preauth2'];
            $insverbendate1 = $flow['insverbendate1'];
            $insverbendate2 = $flow['insverbendate2'];
        }

        if(!(($rxrec != '' && $lomnrec != '') || $rxlomnrec != '')) {
            array_push($errors, "Insurance - Rx and LOMN not completed");
        }

        return $errors;
    }


    function list_preauth_errors( $pid )
    {
        $errors = preauth_errors($pid);
        if(count($errors) > 0){
            $e_text = 'Unable to request verification of benefits:\n';
            foreach($errors as $e) {
                $e_text .= '\n'.$e;
            }
        }
        return $e_text;
    }

    function create_vob( $pid )
    {
        $db = new Db();
        $con = $GLOBALS['con'];

        $sql = "SELECT tc.* FROM 
                dental_patients p 
                JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486'
                WHERE p.patientid = '".mysqli_real_escape_string($con,$pid)."'";

        $e0486 = ($db->getNumberRows($sql) > 0);
        $sql = "SELECT u.* FROM 
                dental_patients p 
                JOIN dental_users u ON p.docid = u.userid 
                WHERE p.patientid = '".mysqli_real_escape_string($con,$pid)."' AND
                u.npi != '' AND u.npi IS NOT NULL AND
                u.tax_id_or_ssn != '' AND u.tax_id_or_ssn IS NOT NULL AND
                (u.ssn = 1 OR u.ein = 1) 
                ";

        $user_info = ($db->getNumberRows($sql) > 0);

        if(!$e0486 && !$user_info){
            return "e0486_user";
        }elseif(!$e0486){
            return "e0486";
        }elseif(!$user_info){
            return "user";
        }

        $sql = "SELECT "
             . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
             . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
             . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
             . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
             . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
             . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
             . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
             . "  CONCAT(d.first_name, ' ', d.last_name) as doc_name, CONCAT(d.address, ', ', d.city, ', ',d.state,' ',d.zip) as doc_address, d.practice as doc_practice, d.phone as doc_phone, "
             . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
             . "  d.userid as 'doc_id', p.home_phone as 'patient_phone'  "
             . "FROM "
             . "  dental_patients p  "
             . "  LEFT JOIN dental_contact r ON p.referred_by = r.contactid  "
             . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
             . "  JOIN dental_users d ON p.docid = d.userid "
             . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
             . "  LEFT JOIN dental_q_page2_view q2 ON p.patientid = q2.patientid  "
             . "WHERE "
             . "  p.patientid = ".$pid;

        $my_array = $db->getRow($sql);

        $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";

        $d = $db->getRow($sleepstudies);
        $diagnosis = $d['diagnosis'];

        $sd = date('Y-m-d H:i:s');
        $sql = "INSERT INTO dental_insurance_preauth ("
             . "  patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, "
             . "  patient_ins_id, patient_firstname, patient_lastname, patient_phone, patient_add1, "
             . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
             . "  insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, "
             . "  trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, "
             . "  front_office_request_date, status, userid, viewed, "
             . "  doc_name, doc_practice, doc_address, doc_phone "
             . ") VALUES ("
             . "  '" . $pid . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_id']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['ins_co']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['ins_rank']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['ins_phone']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_ins_group_id']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_ins_id']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_firstname']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_lastname']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_phone']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_add1']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_add2']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_city']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_state']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_zip']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['patient_dob']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['insured_first_name']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['insured_last_name']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['insured_dob']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_npi']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['referring_doc_npi']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['trxn_code_amount']) . "', "
             . "  '" . mysqli_real_escape_string($con,$diagnosis) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_medicare_npi']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_tax_id_or_ssn']) . "', "
             . "  '" . mysqli_real_escape_string($con,$sd) . "', "
             . DSS_PREAUTH_PENDING . ", "
             . "  '" . mysqli_real_escape_string($con,$_SESSION['userid']) . "', "
             . " 1, "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_name']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_practice']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_address']) . "', "
             . "  '" . mysqli_real_escape_string($con,$my_array['doc_phone']) . "' "
             . ")";

        return $db->query($sql);
    }
?>
