<?php
namespace Ds3\Libraries\Legacy;

include_once('../includes/constants.inc');
include_once('includes/main_include.php');

$data = [];

$db = new Db();

if (!empty($_POST['claim'])) {
    foreach ($_POST['claim'] as $claimid) {
        $claim_sql = "SELECT i.* 
            FROM dental_insurance i 
            JOIN dental_patients p on p.patientid=i.patientid
            WHERE i.insuranceid='".$db->escape($claimid)."'";
        $claim_q = mysqli_query($con,$claim_sql);
        if ($claim = mysqli_fetch_assoc($claim_q)) {
            $row = [];
            $pat_sql = "SELECT * FROM dental_patients where patientid='".$db->escape($claim['patientid'])."'";
            $pat_q = mysqli_query($con,$pat_sql);
            $pat = mysqli_fetch_assoc($pat_q);

            $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi 
                FROM dental_summ_sleeplab ss
                JOIN dental_patients p on ss.patiendid=p.patientid
                WHERE (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) 
                AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') 
                AND ss.filename IS NOT NULL 
                AND ss.patiendid = '".$claim['patientid']."';";
            $result = mysqli_query($con,$sleepstudies);
            $d = mysqli_fetch_assoc($result);

            $referring_provider = $d['diagnosising_doc'];
            $diagnosising_npi = $d['diagnosising_npi'];
            $insurancetype = $claim['insurance_type'];
            if ($insurancetype != 1) {
                $referring_provider = '';
                $diagnosising_npi = '';
            }

            $row[] = "9"; //New ICD field for new cms 1500 form
            $ins_sql = "SELECT * FROM dental_contact where contactid='".$pat['p_m_ins_co']."'";
            $ins_q = mysqli_query($con,$ins_sql);
            $ins_co = mysqli_fetch_assoc($ins_q);

            $row[] = $ins_co['company'];
            $row[] = '';

            $ins_sql = "SELECT * FROM dental_contact WHERE contactid='".$db->escape($pat['p_m_ins_co'])."'";
            $ins_q = mysqli_query($con,$ins_sql);
            $ins = mysqli_fetch_assoc($ins_q);

            $row[] = $ins['add1'];
            $row[] = $ins['city'];
            $row[] = $ins['state'];
            $row[] = $ins['zip'];
            $row[] = '';
            $row[] = $ins['phone1'];

            if ($claim['insurance_type'] == 1) {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['insurance_type'] == 2) {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['insurance_type'] == 3) {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if($claim['insurance_type'] == 4){
                $row[] = "X";
            }else{
                $row[] = "";
            }
            if($claim['insurance_type'] == 5){
                $row[] = "X";
            }else{
                $row[] = "";
            }
            if ($claim['insurance_type'] == 6) {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['insurance_type'] == 7) {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $pat['p_m_ins_id'];
            $row[] = $pat['lastname'];
            $row[] = $pat['firstname'];
            $row[] = $pat['middilename'];
            $row[] = $pat['dob'];
            if ($pat['gender'] == "Male") {
                $row[] = "X";
                $row[] = "";
            } elseif ($pat['gender']=="Female") {
                $row[] = "";
                $row[] = "X";
            } else {
                $row[] = "";
                $row[] = "";
            }

            if ($pat['p_m_relation'] == "Self") {
                $row[] = "";
                $row[] = "";
                $row[] = "";
            } else {
                $row[] = $pat['p_m_partylname'];
                $row[] = $pat['p_m_partyfname'];
                $row[] = $pat['p_m_partymname'];
            }

            $row[] = $claim['patient_address'];
            $row[] = $claim['patient_city'];
            $row[] = $claim['patient_state'];
            $row[] = $claim['patient_zip'];
            $row[] = $claim['patient_phone_code'].$claim['patient_phone'];

            if ($pat['p_m_relation'] == "Self") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            if ($pat['p_m_relation'] == "Spouse") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            if ($pat['p_m_relation'] == "Child") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            if ($pat['p_m_relation'] != "Self" && $pat['p_m_relation'] != "Spouse" && $pat['p_m_relation'] != "Child") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            if ($pat['p_m_relation'] == "Self") {
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
            }else{
                $row[] = $claim['insured_address'];
                $row[] = $claim['insured_city'];
                $row[] = $claim['insured_state'];
                $row[] = $claim['insured_zip'];
                $row[] = $claim['insured_phone_code'].$claim['insured_phone'];
            }

            $patient_status = st($claim['patient_status']);
            $patient_status_array = explode('~', $patient_status);

            if (in_array("Single", $patient_status_array)) {
                $row[] = "X";
                $row[] = "";
                $row[] = "";
            } elseif (in_array("Married", $pat_status_array)) {
                $row[] = "";
                $row[] = "X";
                $row[] = "";
            } else {
                $row[] = "";
                $row[] = "";
                $row[] = "X";
            }

            if (in_array("Employed", $patient_status_array)) {
                $row[] = "X";
                $row[] = "";
                $row[] = "";
            } elseif (in_array("Full Time Student", $pat_status_array)) {
                $row[] = "";
                $row[] = "X";
                $row[] = "";
            } elseif (in_array("Part Time Student", $pat_status_array)) {
                $row[] = "";
                $row[] = "";
                $row[] = "X";
            } else {
                $row[] = "";
                $row[] = "";
                $row[] = "";
            }

            $row[] = $pat['s_m_partylname'];
            $row[] = $pat['s_m_partyfname'];
            $row[] = $pat['s_m_partymname'];
            $row[] = $pat['s_m_ins_grp'];
            $row[] = $pat['ins2_dob'];
            if ($claim['other_insured_sex'] == "M") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['other_insured_sex'] == "F") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $claim['other_insured_employer_school_name'];
            $row[] = $claim['other_insured_insurance_plan'];
            if ($claim['employment'] == "YES") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['employment'] == "NO") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['auto_accident'] == "YES") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['auto_accident'] == "NO") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $claim['auto_accident_place'];
            if ($claim['other_accident'] == "YES") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['other_accident'] == "NO") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $claim['reserved_local_use'];

            $row[] = $pat['p_m_ins_grp'];
            $row[] = $claim['insured_dob'];
            if ($claim['insured_sex'] == "M") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['insured_sex'] == "F") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $claim['insured_employer_school_name'];
            $row[] = $claim['insured_insurance_plan'];

            if ($claim['another_plan'] == "YES") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['another_plan'] == "NO") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            $row[] = "X"; //patient signature
            $row[] = $claim['patient_signed_date'];
            $row[] = "X"; //insured signature
            $row[] = $claim['patient_signed_date']; //insured signed date

            $row[] = $claim['date_current'];
            $row[] = $claim['date_same_illness'];
            $row[] = $claim['unable_date_from'];
            $row[] = $referring_provider;
            $row[] = $claim['field_17a_dd'];
            $row[] = $claim['field_17a'];
            $row[] = $diagnosising_npi;
            $row[] = "";
            $row[] = $claim['hospitalization_date_from'];
            $row[] = $claim['hospitalization_date_to'];
            $row[] = $claim['reserved_local_use1'];
            if ($claim['outside_lab'] == "YES") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($claim['outside_lab'] == "NO") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            $row[] = $claim['s_charges'];

            $sleepstudies = "SELECT ss.diagnosis 
                FROM dental_summ_sleeplab ss
                JOIN dental_patients p on ss.patiendid=p.patientid
                WHERE (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) 
                AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') 
                AND ss.filename IS NOT NULL 
                AND ss.patiendid = '".$claim['patientid']."';";
            $result = mysqli_query($con,$sleepstudies);
            $d = mysqli_fetch_assoc($result);

            $diagnosis_1 = $d['diagnosis'];
            $diag_sql = "SELECT ins_diagnosis FROM dental_ins_diagnosis WHERE ins_diagnosisid='".$diagnosis_1."'";
            $diag_q = mysqli_query($con,$diag_sql);
            $diag = mysqli_fetch_assoc($diag_q);
            $row[] = $diag['ins_diagnosis'];
            $row[] = $claim['diagnosis_2'];
            $row[] = $claim['diagnosis_3'];
            $row[] = $claim['diagnosis_4'];
            $row[] = "";
            $row[] = "";
            $row[] = "";
            $row[] = "";
            $row[] = ""; //Extra diagnosis codes for new CMS 1500 form
            $row[] = "";
            $row[] = "";
            $row[] = "";

            $row[] = $claim['medicaid_resubmission_code'];
            $row[] = $claim['original_ref_no'];
            $row[] = $claim['prior_authorization_number'];
            $row[] = ""; //HCFACLIANumber Send to Nathan

            // INDIVIDUAL LEDGER ITEMS

            $diagnosis_pointer = [];
            $diagnosis_pointer[1] = $diagnosis_1;
            $diagnosis_pointer[2] = $diagnosis_2;
            $diagnosis_pointer[3] = $diagnosis_3;
            $diagnosis_pointer[4] = $diagnosis_4;

            //reset values
            $producer_last_name = "";
            $producer_first_name = "";
            $phone = "";
            $practice = "";
            $address = "";
            $city = "";
            $state = "";
            $zip = "";
            $npi = "";
            $medicare_npi = "";
            $tax_id_or_ssn = "";
            $ssn = "";
            $ein = "";

            $claim_producer = $claim['producer'];

            $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
            $userquery = mysqli_query($con,$getuserinfo);
            if ($userinfo = mysqli_fetch_array($userquery)) {
                $producer_last_name = $userinfo['last_name'];
                $producer_first_name = $userinfo['first_name'];
                $phone = $userinfo['phone'];
                $practice = $userinfo['practice'];
                $address = $userinfo['address'];
                $city = $userinfo['city'];
                $state = $userinfo['state'];
                $zip = $userinfo['zip'];
                $npi = $userinfo['npi'];
                $medicare_npi = $userinfo['medicare_npi'];
                $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
                $ssn = $userinfo['ssn'];
                $ein = $userinfo['ein'];
            }
            $getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$claim['docid']."'";
            $docquery = mysqli_query($con,$getdocinfo);
            $docinfo = mysqli_fetch_array($docquery);
            if ($producer_last_name == "") {
                $producer_last_name = $docinfo['last_name'];
            }
            if ($producer_first_name == "") {
                $producer_first_name = $docinfo['first_name'];
            }
            if ($phone == "") {
                $phone = $docinfo['phone'];
            }
            if ($practice == "") {
                $practice = $docinfo['practice'];
            }
            if ($address == "") {
                $address = $docinfo['address'];
            }
            if ($city == "") {
                $city = $docinfo['city'];
            }
            if ($state == "") {
                $state = $docinfo['state'];
            }
            if ($zip == "") {
                $zip = $docinfo['zip'];
            }
            if ($npi == "") {
                $npi = $docinfo['npi'];
            }
            if ($medicare_npi == "") {
                $medicare_npi = $docinfo['medicare_npi'];
            }
            if ($tax_id_or_ssn == "") {
                $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
            }
            if ($ssn == "" && $ein == "") {
                $ssn = $docinfo['ssn'];
            }
            if ($ssn == "" && $ein == "") {
                $ein = $docinfo['ein'];
            }

            // Load pending medical trxns if new claim form. Otherwise, load associated trxns.
            $sql = "SELECT ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits,";
            if ($insurancetype == '1') {
                $sql .= " user.medicare_npi ";
            } else {
                $sql .= " user.npi ";
            }
            $sql .= " as 'provider_id', ps.place_service as 'place' 
                FROM dental_ledger ledger 
                JOIN dental_users user ON user.userid = ledger.docid 
                JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code 
                LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid 
                WHERE ledger.primary_claim_id = " . $claim['insuranceid'] . " 
                AND ledger.patientid = " . $claim['patientid'] . " 
                AND ledger.docid = " . $claim['docid'] . " 
                AND trxn_code.docid = " . $claim['docid'] . "
                AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " 
                ORDER BY ledger.service_date ASC";
            $query = mysqli_query($con,$sql);

            $c=0;
            while ($ledger = mysqli_fetch_assoc($query)) {
                $diagnosispointer = ($ledger['diagnosispointer'])?$ledger['diagnosispointer']:'1';
                $row[] = $ledger['service_date'];
                $row[] = $ledger['service_date'];
                $row[] = preg_replace("/[^0-9]/","",$ledger['place']);
                $row[] = $ledger['emg'];
                $row[] = $ledger['transaction_code'];
                $row[] = $ledger['modcode'];
                $row[] = $ledger['modcode2'];
                $row[] = $ledger['modcode3'];
                $row[] = $ledger['modcode4'];
                $row[] = $diagnosispointer;
                $row[] = $ledger['amount'];
                $row[] = $ledger['daysorunits'];
                $row[] = $ledger['epsdt'];
                $row[] = $ledger['idqual'];
                $row[] = "";
                $row[] = (($insurancetype == '1')?$medicare_npi:$npi);
                $c++;
            }

            //fill rest of ledger rows with blanks
            while ($c < 6) {
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $row[] = "";
                $c++;
            }

            $row[] = $tax_id_or_ssn;
            if ($ssn == "1") {
                $row[] = "X";
            } else {
                $row[] = "";
            }
            if ($ein == "1") {
                $row[] = "X";
            } else {
                $row[] = "";
            }

            $row[] = $claim['patient_account_no'];
            if($claim['accept_assignment'] == "Yes"){
                $row[] = "X";
            }else{
                $row[] = "";
            }
            if($claim['accept_assignment'] == "No"){
                $row[] = "X";
            }else{
                $row[] = "";
            }

            $sql = "SELECT SUM(ledger.amount) as 'total_charge' 
                FROM dental_ledger ledger 
                JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code 
                WHERE ledger.status = " . DSS_TRXN_PENDING . " 
                AND ledger.patientid = " . $claim['patientid'] . " 
                AND ledger.docid = " . $claim['docid'] . " 
                AND trxn_code.docid = " . $claim['docid'] . " 
                AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " 
                ORDER BY ledger.service_date ASC";
            $charge_my = mysqli_query($con,$sql);

            if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
                $charge_row = mysqli_fetch_array($charge_my);
                $total_charge = $charge_row['total_charge'];
            }

            $sql = "SELECT SUM(ledger.paid_amount) as 'amount_paid' 
                FROM dental_ledger ledger 
                JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code 
                WHERE ledger.status = " . DSS_TRXN_PENDING . " 
                AND ledger.patientid = " . $claim['patientid'] . " 
                AND ledger.docid = " . $claim['docid'] . " 
                AND trxn_code.docid = " . $claim['docid'] . " 
                AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") 
                ORDER BY ledger.service_date ASC";
            $paid_my = mysqli_query($con,$sql);

            if ($paid_my && (mysqli_num_rows($paid_my) > 0)) {
                $paid_row = mysqli_fetch_array($paid_my);
                $amount_paid = $paid_row['amount_paid'];
            }

            // re-calculate balance due
            $balance_due = $total_charge - $amount_paid;

            // format calculations
            $total_charge = number_format($total_charge, 2);
            $amount_paid = number_format($amount_paid, 2);
            $balance_due = number_format($balance_due, 2, '.', '');


            $row[] = $total_charge;
            $row[] = $amount_paid;
            $row[] = $balance_due;
            $row[] = $producer_first_name." ".$producer_last_name; //Physician Signature
            $row[] = date('m/d/Y');

            $row[] = $producer_last_name;//Physician name
            $row[] = $producer_first_name;
            $row[] = "";

            $row[] = $practice;
            $row[] = $address;
            $row[] = $city;
            $row[] = $state;
            $row[] = $zip;
            $row[] = "";
            $row[] = (($insurancetype == '1')?$medicare_npi:$npi);
            $row[] = "";
            $row[] = "";
            $row[] = $practice;
            $row[] = $address;
            $row[] = $city;
            $row[] = $state;
            $row[] = $zip;
            $row[] = "";
            $row[] = $phone;
            $row[] = (($insurancetype == '1')?$medicare_npi:$npi);
            $row[] = $pat['p_m_ins_grp'];
            $row[] = "";
            $data[] = $row;
        }
    }
}

header("Content-Type: text/plain");
header("Content-Disposition: attachment;filename=OfficeAlly_HCFA_".date('Ymd-Hi').".txt");

$f = fopen('php://output', 'a');
foreach ($data as $fields) {
    fputs($f, implode($fields, "\t")."\n");
}
fclose($f);
