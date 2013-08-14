<?php

session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');

$data = array();
$claim_sql = "SELECT * FROM dental_insurance WHERE status='".DSS_CLAIM_PENDING."'";
$claim_q = mysql_query($claim_sql);
while($claim = mysql_fetch_assoc($claim_q)){
$row = array();
  $pat_sql = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($claim['patientid'])."'";
  $pat_q = mysql_query($pat_sql);
  $pat = mysql_fetch_assoc($pat_q);

	$other_insured_insurance_plan = strtoupper(st($pat['s_m_ins_plan']));
        if($pat['p_m_ins_type']==1){
          $insured_policy_group_feca = "NONE";
          $insured_insurance_plan = '';
          $insured_employer_school_name = '';
        }else{
          $insured_policy_group_feca = $pat['p_m_ins_grp'];
          $insured_insurance_plan = $pat['p_m_ins_plan'];
        }


$row[] = $insured_insurance_plan;
$row[] = ''; //Insurance Payer ID

	$ins_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['p_m_ins_co'])."'";
	$ins_q = mysql_query($ins_sql);
	$ins = mysql_fetch_assoc($ins_q);

$row[] = $ins['add1'];
$row[] = $ins['city'];
$row[] = $ins['state'];
$row[] = $ins['zip'];
$row[] = ''; //Insurance city, state, zip
$row[] = $ins['phone1'];


if($claim['insurance_type'] == 1){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['insurance_type'] == 2){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['insurance_type'] == 3){
  $row[] = "X";
}else{
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
if($claim['insurance_type'] == 6){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['insurance_type'] == 7){
  $row[] = "X";
}else{
  $row[] = "";
}


$row[] = $claim['patientid'];
$row[] = $pat['lastname'];
$row[] = $pat['firstname'];
$row[] = $pat['middilename'];
$row[] = $pat['dob'];
if($pat['gender']=="Male"){
  $row[] = "X";
  $row[] = "";
}elseif($pat['gender']=="Female"){
  $row[] = "";
  $row[] = "X";
}else{
  $row[] = "";
  $row[] = "";
}


if($pat['p_m_relation'] == "Self"){
  $row[] = "";
  $row[] = "";
  $row[] = "";
}else{
  $row[] = $claim['insured_lastname'];
  $row[] = $claim['insured_firstname'];
  $row[] = $claim['insured_middle'];
}


$row[] = $claim['patient_address'];
$row[] = $claim['patient_city'];
$row[] = $claim['patient_state'];
$row[] = $claim['patient_zip'];
$row[] = $claim['patient_phone_code'].$claim['patient_phone'];




if($pat['p_m_relation'] == "Self"){
  $row[] = "X";
}else{
  $row[] = "";
}

if($pat['p_m_relation'] == "Spouse"){
  $row[] = "X";
}else{
  $row[] = "";
}

if($pat['p_m_relation'] == "Child"){
  $row[] = "X";
}else{
  $row[] = "";
}

if($pat['p_m_relation'] != "Self" && $pat['p_m_relation'] != "Spouse" && $pat['p_m_relation'] != "Child"){
  $row[] = "X";
}else{
  $row[] = "";
}

if($pat['p_m_relation'] == "Self"){
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
$patient_status_array = split('~', $patient_status);


if(in_array("Single", $patient_status_array)){
  $row[] = "X";
  $row[] = "";
  $row[] = "";
}elseif(in_array("Married", $pat_status_array)){
  $row[] = "";
  $row[] = "X";
  $row[] = "";
}else{
  $row[] = "";
  $row[] = "";
  $row[] = "X";
}


if(in_array("Employed", $patient_status_array)){
  $row[] = "X";
  $row[] = "";
  $row[] = "";
}elseif(in_array("Full Time Student", $pat_status_array)){
  $row[] = "";
  $row[] = "X";
  $row[] = "";
}elseif(in_array("Part Time Student", $pat_status_array)){
  $row[] = "";
  $row[] = "";
  $row[] = "X";
}else{
  $row[] = "";
  $row[] = "";
  $row[] = "";
}

$row[] = $claim['other_insured_lastname'];
$row[] = $claim['other_insured_firstname'];
$row[] = $claim['other_insured_middle'];
$row[] = $claim['other_insured_policy_group_feca'];
$row[] = $claim['other_insured_dob'];
if($claim['other_insured_sex']=="M"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['other_insured_sex']=="F"){
  $row[] = "X";
}else{
  $row[] = "";
}
$row[] = $claim['other_insured_employer_school_name'];
$row[] = $claim['other_insured_insurance_plan'];
if($claim['employment'] == "YES"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['employment'] == "NO"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['auto_accident'] == "YES"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['auto_accident'] == "NO"){
  $row[] = "X";
}else{
  $row[] = "";
}
$row[] = $claim['auto_accident_place'];
if($claim['other_accident'] == "YES"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['other_accident'] == "NO"){
  $row[] = "X";
}else{
  $row[] = "";
}
$row[] = $claim['reserved_local_use']; 

$row[] = $claim['insured_policy_group_feca'];
$row[] = $claim['insured_dob'];
if($claim['insured_sex']=="M"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['insured_sex']=="F"){
  $row[] = "X";
}else{
  $row[] = "";
}
$row[] = $claim['insured_employer_school_name'];
$row[] = $claim['insured_insurance_plan'];

if($claim['another_plan']=="YES"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['another_plan']=="NO"){
  $row[] = "X";
}else{
  $row[] = "";
}

$row[] = "X"; //patient signature
$row[] = $claim['patient_signed_date'];
$row[] = "X"; //insured signature
$row[] = $claim['patient_signed_date']; //insured signed date

$row[] = $claim['date_current'];
$row[] = $claim['date_same_illness'];
$row[] = $claim['unable_date_from'];
$row[] = $claim['referring_provider'];
$row[] = $claim['field_17a_dd'];
$row[] = $claim['field_17a'];
$row[] = $claim['field_17b'];
$row[] = ""; //super npi
$row[] = $claim['hospitalization_date_from'];
$row[] = $claim['hospitalization_date_to'];
$row[] = $claim['reserved_local_use1'];
if($claim['outside_lab']=="YES"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['outside_lab']=="NO"){
  $row[] = "X";
}else{
  $row[] = "";
}
$row[] = $claim['s_charges'];

$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss
                        JOIN dental_patients p on ss.patiendid=p.patientid
                WHERE
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND
                        ss.filename IS NOT NULL AND ss.patiendid = '".$claim['patientid']."';";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis_1 = $d['diagnosis'];
$diag_sql = "SELECT ins_diagnosis FROM dental_ins_diagnosis WHERE ins_diagnosisid='".$diagnosis_1."'";
$diag_q = mysql_query($diag_sql);
$diag = mysql_fetch_assoc($diag_q);
$row[] = $diag['ins_diagnosis'];
$row[] = $claim['diagnosis_2'];
$row[] = $claim['diagnosis_3'];
$row[] = $claim['diagnosis_4'];
$row[] = "";
$row[] = "";
$row[] = "";
$row[] = "";

$row[] = $claim['medicaid_resubmission_code'];
$row[] = $claim['original_ref_no'];
$row[] = $claim['prior_authorization_number'];
$row[] = ""; //HCFACLIANumber Send to Nathan


// INDIVIDUAL LEDGER ITEMS

$diagnosis_pointer = array();
$diagnosis_pointer[1] = $diagnosis_1;
$diagnosis_pointer[2] = $diagnosis_2;
$diagnosis_pointer[3] = $diagnosis_3;
$diagnosis_pointer[4] = $diagnosis_4;

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "";
  $sql = "SELECT "
       . "  ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits,";
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= " as 'provider_id', ps.place_service as 'place' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "WHERE "
       . "  ledger.primary_claim_id = " . $claim['insuranceid'] . " "
       . "  AND ledger.patientid = " . $claim['patientid'] . " "
       . "  AND ledger.docid = " . $claim['docid'] . " "
       . "  AND trxn_code.docid = " . $claim['docid'] . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";

$query = mysql_query($sql);
$c=0;
$claim_lines = array();
while ($ledger = mysql_fetch_assoc($query)) {
if($array['diagnosispointer']!=''){
  if(isset($diagnosis_pointer[$array['diagnosispointer']])){
    $diagnosis = $diagnosis_pointer[$array['diagnosispointer']];
  }
}

$row[] = $ledger['service_date'];
$row[] = $ledger['service_date'];
$row[] = preg_replace("/[^0-9]/","",$ledger['place']);
$row[] = $ledger['emg'];
$row[] = $ledger['transaction_code'];
$row[] = $ledger['modcode'];
$row[] = $ledger['modcode2'];
$row[] = $ledger['modcode3'];
$row[] = $ledger['modcode4'];
$row[] = $diagnosis;
$row[] = $ledger['amount'];
$row[] = $ledger['daysorunits'];
$row[] = $ledger['epsdt'];
$row[] = $ledger['idqual'];
$row[] = "";
$row[] = "";
$c++;
}

//fill rest of ledger rows with blanks
while($c < 6){
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


$row[] = $claim['federal_tax_id_number'];
if($claim['ssn']=="1"){
  $row[] = "X";
}else{
  $row[] = "";
}
if($claim['ein']=="1"){
  $row[] = "X";
}else{
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

$row[] = $claim['total_charge'];
$row[] = $claim['amount_paid'];
$row[] = $claim['balance_due'];
$row[] = "X"; //Physician Signature
$row[] = $claim['physician_signed_date'];

$row[] = $user['last_name'];//Physician name
$row[] = $user['first_name'];
$row[] = "";

$row[] = $claim['service_facility_info_name'];
$row[] = $claim['service_facility_info_address'];
$row[] = "";
$row[] = "";
$row[] = $claim['service_facility_info_city'];
$row[] = $claim['service_facility_info_a'];
$row[] = ""; //facility_id
$row[] = $claim[''];
$row[] = $claim['billing_provider_name'];
$row[] = $claim['billing_provider_address'];
$row[] = $claim[''];
$row[] = $claim[''];
$row[] = $claim[''];
$row[] = $claim['billing_provider_city'];
$row[] = $claim['billing_provider_phone_code']. " ".$claim['billing_provider_phone'];
$row[] = $claim['billing_provider_a'];
$row[] = $claim['insured_policy_group_feca'];

$data[] = $row;
}

//print_r($data);


header("Content-Type: text/plain");
header("Content-Disposition: attachment;filename=file.txt");
$f  =   fopen('php://output', 'a');
foreach ($data as $fields) {
    fputcsv($f, $fields, "\t");
}
fclose($f);



?>
