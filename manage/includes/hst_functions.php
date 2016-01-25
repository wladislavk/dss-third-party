<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/constants.inc';

function create_hst( $pid ) {
    $db = new Db();
    $con = $GLOBALS['con'];

    $sql = "SELECT u.* FROM
            dental_patients p
            JOIN dental_users u ON p.docid = u.userid
            WHERE p.patientid = '".mysqli_real_escape_string($con,$pid)."' AND
            u.npi != '' AND u.npi IS NOT NULL AND
            u.tax_id_or_ssn != '' AND u.tax_id_or_ssn IS NOT NULL AND
            (u.ssn = 1 OR u.ein = 1)
            ";

    $user_info = ($db->getNumberRows($sql) > 0);

    $sql = "SELECT "
         . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
         . "  p.p_m_ins_co, p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
         . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
         . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
         . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
         . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
         . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
         . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
         . "  d.userid as 'doc_id', p.home_phone as 'patient_phone'  "
         . "FROM "
         . "  dental_patients p  "
         . "  LEFT JOIN dental_contact r ON p.referred_by = r.contactid  "
         . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
         . "  JOIN dental_users d ON p.docid = d.userid "
         . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
         . "  LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
         . "WHERE "
         . "  p.patientid = ".$pid;

    $my_array = $db->getRow($sql);

    $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '".mysqli_real_escape_string($con,$pid)."'";

    $thorton = $db->getRow($thorton_sql);
    $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";

    $d = $db->getRow($sleepstudies);
    $diagnosis = $d['diagnosis'];
    $sd = date('Y-m-d H:i:s');
    $sql = "INSERT INTO dental_hst ("
         . "  patient_id, doc_id, user_id, ins_co_id, patient_ins_group_id, "
         . "  patient_ins_id, patient_firstname, patient_lastname, patient_add1, "
         . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
         . "  insured_firstname, insured_lastname, insured_dob, "
         . "  snore_1, snore_2, snore_3, snore_4, snore_5, "
         . "  status, adddate, ip_address "
         . ") VALUES ("
         . "  " . $pid . ", "
         . "  " . mysqli_real_escape_string($con,$my_array['doc_id']) . ", "
         . "  '" . mysqli_real_escape_string($con,$_SESSION['userid']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['p_m_ins_co']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_ins_group_id']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_ins_id']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_firstname']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_lastname']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_add1']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_add2']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_city']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_state']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_zip']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['patient_dob']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['insured_first_name']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['insured_last_name']) . "', "
         . "  '" . mysqli_real_escape_string($con,$my_array['insured_dob']) . "', "
         . "  '" . mysqli_real_escape_string($con,$thorton['snore_1']) . "', "
         . "  '" . mysqli_real_escape_string($con,$thorton['snore_2']) . "', "
         . "  '" . mysqli_real_escape_string($con,$thorton['snore_3']) . "', "
         . "  '" . mysqli_real_escape_string($con,$thorton['snore_4']) . "', "
         . "  '" . mysqli_real_escape_string($con,$thorton['snore_5']) . "', "
         . DSS_HST_PENDING . ", "
         . "  now(), "
         . "  '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."' "
         . ")";

    $hst_id = $db->getInsertId($sql);

    $sql = "select * from dental_q_sleep where patientid='".$pid."'";

    $myarray = $db->getRow($sql);

    $q_sleepid = st($myarray['q_sleepid']);
    $epworthid = st($myarray['epworthid']);
    $analysis = st($myarray['analysis']);

    if($epworthid <> '') {
        $epworth_arr1 = split('~',$epworthid);

        foreach($epworth_arr1 as $i => $val) {
                $epworth_arr2 = explode('|',$val);
                $epid[$i] = $epworth_arr2[0];
                $epseq[$i] = $epworth_arr2[1];
        }
    }

    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";

    $epworth_my = $db->getResults($epworth_sql);
    $epworth_number = count($epworth_my);
    if ($epworth_my) foreach ($epworth_my as $epworth_myarray) {
        if(@array_search($epworth_myarray['epworthid'],$epid) === false) {
            $chk = '';
        } else {
            $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
        }

        if($chk != '') {
            $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysqli_real_escape_string($con,$hst_id)."',
                        epworth_id = '".mysqli_real_escape_string($con,$epworth_myarray['epworthid'])."',
                        response = '".mysqli_real_escape_string($con,$chk)."',
                        adddate = now(),
                        ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";

            $db->query($hst_sql);
        }
    }

    return $hst;
}

/**
 * Create a new patient, based on a HST request. The patient will NOT be created if the requested HST already has
 * a patient id set.
 *
 * @param int $hstId
 * @return int
 */
function createPatientFromHSTRequest ($hstId) {
    $db = new Db();

    $hstId = intval($hstId);
    $hstData = $db->getRow("SELECT screener_id, patient_email, patient_dob
        FROM dental_hst
        WHERE id = '$hstId'
            AND COALESCE(patient_id, 0) = 0");

    if (!$hstData) {
        return 0;
    }

    $screenerId = intval($hstData['screener_id']);
    $screenerData = $db->getRow("SELECT docid, first_name, last_name, phone
        FROM dental_screener
        WHERE id = '$screenerId'
            AND COALESCE(patient_id, 0) = 0");

    if (!$screenerData) {
        return 0;
    }

    $patientData = [
        'docid' => $screenerData['docid'],
        'firstname' => $screenerData['first_name'],
        'lastname' => $screenerData['last_name'],
        'cell_phone' => $screenerData['phone'],
        'email' => $hstData['patient_email'],
        'dob' => !empty($hstData['patient_dob']) ? date('m/d/Y', strtotime($hstData['patient_dob'])) : '',
        'ip_address' => $_SERVER['REMOTE_ADDR']
    ];

    $patientData = $db->escapeAssignmentList($patientData);
    $patientId = $db->getInsertId("INSERT INTO dental_patients SET $patientData, status = '1', adddate = NOW()");

    $db->query("UPDATE dental_hst SET patient_id = $patientId, updatedate = NOW() WHERE id = '$hstId'");
    $db->query("UPDATE dental_screener SET patient_id = '$patientId' WHERE id = '$screenerId'");

    return $patientId;
}
