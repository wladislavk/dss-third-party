<?php
namespace Ds3\Libraries\Legacy;

use const DSS_PREAUTH_PENDING;

function claim_errors($pid, $medicare = false )
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
    /*  $sql = "SELECT * FROM dental_patients p JOIN dental_q_page2 q2 ON p.patientid = q2.patientid WHERE p.patientid=".$pid;
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

function create_vob ($patientId, $billingCompanyId=0)
{
    $db = new Db();
    $patientId = intval($patientId);
    $billingCompanyId = intval($billingCompanyId);

    $sql = "SELECT COUNT(tc.transaction_codeid) AS total
        FROM dental_patients p 
            JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486'
        WHERE p.patientid = '$patientId'";
    $e0486 = $db->getColumn($sql, 'total', 0) > 0;
    
    $sql = "SELECT COUNT(u.userid) AS total
        FROM dental_patients p
            JOIN dental_users u ON p.docid = u.userid 
        WHERE p.patientid = '$patientId'
            AND u.npi != ''
            AND u.npi IS NOT NULL
            AND u.tax_id_or_ssn != ''
            AND u.tax_id_or_ssn IS NOT NULL
            AND (u.ssn = 1 OR u.ein = 1) 
            ";
    $user_info = $db->getColumn($sql, 'total', 0) > 0;

    if (!$e0486 && !$user_info) {
        return 'e0486_user';
    }
    
    if (!$e0486) {
        return 'e0486';
    }
    
    if (!$user_info) {
        return 'user';
    }

    $sql = "SELECT
            i.company AS 'ins_co',
            'primary' AS 'ins_rank',
            i.phone1 AS 'ins_phone',
            p.p_m_ins_grp AS 'patient_ins_group_id',
            p.p_m_ins_id AS 'patient_ins_id',
            p.firstname AS 'patient_firstname',
            p.lastname AS 'patient_lastname',
            p.add1 AS 'patient_add1',
            p.add2 AS 'patient_add2',
            p.city AS 'patient_city',
            p.state AS 'patient_state',
            p.zip AS 'patient_zip',
            p.dob AS 'patient_dob',
            p.p_m_partyfname AS 'insured_first_name',
            p.p_m_partylname AS 'insured_last_name',
            p.ins_dob AS 'insured_dob',
            d.npi AS 'doc_npi',
            r.national_provider_id AS 'referring_doc_npi',
            d.medicare_npi AS 'doc_medicare_npi',
            d.tax_id_or_ssn AS 'doc_tax_id_or_ssn',
            CONCAT(d.first_name, ' ', d.last_name) AS doc_name,
            CONCAT(d.address, ', ', d.city, ', ',d.state,' ',d.zip) AS doc_address,
            d.practice AS doc_practice,
            d.phone AS doc_phone,
            tc.amount AS 'trxn_code_amount',
            q2.confirmed_diagnosis AS 'diagnosis_code',
            d.userid AS 'doc_id',
            p.home_phone AS 'patient_phone'
        FROM dental_patients p  
            LEFT JOIN dental_contact r ON p.referred_by = r.contactid  
            JOIN dental_contact i ON p.p_m_ins_co = i.contactid 
            JOIN dental_users d ON p.docid = d.userid 
            JOIN dental_transaction_code tc ON p.docid = tc.docid
                AND tc.transaction_code = 'E0486' 
            LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  
        WHERE p.patientid = '$patientId'";
    $vobModel = $db->getRow($sql);

    $sql = "SELECT diagnosis
        FROM dental_summ_sleeplab
        WHERE (
                diagnosis IS NOT NULL
                AND diagnosis != ''
            )
            AND filename IS NOT NULL
            AND patiendid = '$patientId'
        ORDER BY id DESC
        LIMIT 1";
    $diagnosisCode = $db->getColumn($sql, 'diagnosis', '');
    
    $vobModel['patient_id'] = $patientId;
    $vobModel['billing_company_id'] = $billingCompanyId;
    $vobModel['diagnosis_code'] = $diagnosisCode;
    $vobModel['status'] = DSS_PREAUTH_PENDING;
    $vobModel['userid'] = $_SESSION['userid'];
    $vobModel['viewed'] = 1;
    $vobModel['ip_address'] = $_SERVER['REMOTE_ADDR'];
    
    $db->escapeAssignmentList($vobModel);
    
    $sql = "INSERT INTO dental_insurance_preauth
        SET $vobModel, adddate = NOW()";
    
    $insertId = $db->getInsertId($sql);
    return $insertId;
}
