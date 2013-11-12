<?php
session_start();
require_once('includes/constants.inc');
require_once('admin/includes/main_include.php');
if(!empty($_SERVER['HTTPS'])){
$path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
}else{
$path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
}

$sql = "SELECT i.*, u.npi, u.tax_id_or_ssn 
	
		FROM dental_claim_electronic ce 
	JOIN dental_insurance i ON i.insuranceid = ce.claimid
	JOIN dental_users u ON i.docid = u.userid
	 WHERE id='".mysql_real_escape_string($_GET['id'])."' ORDER BY id DESC LIMIT 1";
$q = mysql_query($sql) or die(mysql_error());
$r = mysql_fetch_assoc($q);

$l_sql = "SELECT * FROM dental_ledger WHERE primary_claim_id='".mysql_real_escape_string($_GET['id'])."'";
$l_q = mysql_query($l_sql);
$l = mysql_fetch_assoc($l_q);

$reference_id = '1380637728877506331397';//$r['reference_id'];

$api_key = '33b2e3a5-8642-1285-d573-07a22f8a15b4';
$data = array();                                                                    

$data['api_key'] = '33b2e3a5-8642-1285-d573-07a22f8a15b4';
$data['payer_id'] = $r['p_m_eligible_payer_id'];
$data['provider_npi']  = preg_replace("/[^0-9]/","",$r['npi']);
$data['provider_tax_id'] = preg_replace("/[^0-9]/","",$r['tax_id_or_ssn']);
$data['member_id'] = preg_replace("/[^0-9]/","",$r['insured_id_number']);
$data['member_last_name'] = $r['patient_lastname'];
$data['member_first_name'] = $r['patient_firstname'];
$data['member_dob'] = date_format(date_create_from_format('d-m-Y',$r['patient_dob']), 'Y-m-d');
$data['charge_amount'] = preg_replace("/[^0-9\.]/","",$r['total_charge']);
$data['start_date'] = date('Y-m-d',strtotime($l['service_date']));
$data['end_date'] = date('Y-m-d',strtotime($l['service_date']));

$ch = curl_init();
 
curl_setopt($ch, CURLOPT_URL,'https://gds.eligibleapi.com/v1.1/payment/status.json');
 
curl_setopt($ch, CURLOPT_POST, 1);
 
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
$data = curl_exec ($ch);
 
curl_close ($ch);
 
var_dump($data);
/*
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
if($success == "false"){
  $up_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_REJECTED."' WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
  mysql_query($up_sql);
?>
<script type="text/javascript">
  c = confirm('RESPONSE: <?= $result; ?> Do you want to mark the claim sent?');
  if(c){
   window.location = "manage_claims.php?insid=<?= $_GET['insid']; ?>"; 
  }
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
//echo($result);
*/
/*
die();
$prefix = array( 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX');

// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";
$mod_my = mysql_query($mod_sql);
$mod_array = array();
while ($mod_row = mysql_fetch_array($mod_my)) {
  $mod_array[] = $mod_row;
}

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "";
  $sql = "SELECT "
       . "  ledger.*, ";
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
       . "  ledger.primary_claim_id = " . $insuranceid . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";

$query = mysql_query($sql);
$c=0;
while ($array = mysql_fetch_array($query)) { 
$p = $prefix[$c];
$c++;
  if($array['service_date']!=''){
    $fdf .= "
      << /T(".$field_path.".".$p."_dates_of_service_from_mm_fill[0]) /V(".date('m', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_from_dd_fill[0]) /V(".date('d', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_from_yy_fill[0]) /V(".date('y', strtotime($array['service_date'])).") >>
    ";
  }
  if($array['service_date']){
    $fdf .= " 
      << /T(".$field_path.".".$p."_dates_of_service_to_mm_fill[0]) /V(".date('m', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_to_dd_fill[0]) /V(".date('d', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_to_yy_fill[0]) /V(".date('y', strtotime($array['service_date'])).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".".$p."_place_of_service_fill[0]) /V(".$array['placeofservice'].") >>
  << /T(".$field_path.".".$p."_EMG_fill[0]) /V(".$array['emg'].") >>
  << /T(".$field_path.".".$p."_CPT_fill[0]) /V(".$array['transaction_code'] . " - " .$array['description'].") >>
  << /T(".$field_path.".".$p."_modifier_one_fill[0]) /V(".$array['modcode'].") >>
  << /T(".$field_path.".".$p."_modifier_two_fill[0]) /V(".$array['modcode2'].") >>
  << /T(".$field_path.".".$p."_modifier_three_fill[0]) /V(".$array['modcode3'].") >>
  << /T(".$field_path.".".$p."_modifier_four_fill[0]) /V(".$array['modcode4'].") >>
  << /T(".$field_path.".".$p."_diagnosis_pointer_fill[0]) /V(".$array['diagnosispointer'].") >>
  << /T(".$field_path.".".$p."_charges_dollars_fill[0]) /V(".number_format($array['amount'],0).") >>
  << /T(".$field_path.".".$p."_charges_cents_fill[0]) /V(".fill_cents($array['amount']-floor($array['amount'])).") >>
  << /T(".$field_path.".".$p."_days_or_units_fill[0]) /V(".$array['daysorunits'].") >>
  << /T(".$field_path.".".$p."_EPSDT_fill[0]) /V(".$array['epsdt'].") >>
  << /T(".$field_path.".".$p."_rendering_provider_fill[0]) /V(".$array['provider_id'].") >> ";
}

  // re-calculate balance due
  //$balance_due = $total_charge - $amount_paid;

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

$fdf .= "
  << /T(".$field_path.".fed_tax_id_number_fill[0]) /V(".$tax_id_or_ssn.") >>
  << /T(".$field_path.".fed_tax_id_SSN_chkbox[0]) /V(".(($ssn == "1")?1:'').") >>
  << /T(".$field_path.".fed_tax_id_EIN_chkbox[0]) /V(".(($ein == "1")?1:'').") >>
  << /T(".$field_path.".pt_account_number_fill[0]) /V(".$patient_account_no.") >>
  << /T(".$field_path.".accept_assignment_yes_chkbox[0]) /V(".(($accept_assignment == "Yes")?1:'').") >>
  << /T(".$field_path.".accept_assignment_no_chkbox[0]) /V(".(($accept_assignment == "No")?1:'').") >>
  
  << /T(".$field_path.".total_charge_dollars_fill[0]) /V(".number_format($total_charge,0).") >>
  << /T(".$field_path.".total_charge_cents_fill[0]) /V(".fill_cents(floor(($total_charge-floor($total_charge))*100)).") >>
  << /T(".$field_path.".amount_paid_dollars_fill[0]) /V(".number_format($amount_paid,0).") >>
  << /T(".$field_path.".amount_paid_cents_fill[0]) /V(".fill_cents(floor(($amount_paid-floor($amount_paid))*100)).") >>
  << /T(".$field_path.".balance_due_dollars_fill[0]) /V(".number_format($balance_due,0).") >>
  << /T(".$field_path.".balance_due_cents_fill[0]) /V(".fill_cents(floor(($balance_due-floor($balance_due))*100)).") >>
  
  << /T(".$field_path.".service_facility_location_info_fill[0]) /V(".strtoupper($practice)."\n".strtoupper($address)."\n".strtoupper($city).", ".strtoupper($state)." ".$zip.") >>
  << /T(".$field_path.".billing_provider_phone_areacode_fill[0]) /V(".format_phone($phone, true).") >>
  << /T(".$field_path.".billing_provider_phone_number_fill[0]) /V(".format_phone($phone, false).") >>
  << /T(".$field_path.".billing_provider_info_fill[0]) /V(".strtoupper($practice)."\n".strtoupper($address)."\n".strtoupper($city).", ".strtoupper($state)." ".$zip.") >>
  << /T(".$field_path.".signature_of_physician-supplier_signed_fill[0]) /V(".$signature_physician.") >>  
  << /T(".$field_path.".signature_of_physician-supplier_date_fill[0]) /V(".date('m/d/y').") >>
  << /T(".$field_path.".service_facility_NPI_a_fill[0]) /V(".(($insurancetype == '1')?$medicare_npi:$npi).") >>
  << /T(".$field_path.".service_facility_other_id_b_fill[0]) /V(".$service_info_b_other.") >>
  << /T(".$field_path.".billing_provider_NPI_a_fill[0]) /V(".(($insurancetype == '1')?$medicare_npi:$npi).") >>
  << /T(".$field_path.".billing_provider_other_id_b_fill[0]) /V(".$billing_provider_b_other.") >>
";


$fdf .= "
]
/F (".$pdf_doc.") 
>>
>>
endobj
trailer
<<
/Root 1 0 R

>>
%%EOF
";
$d = date('YmdHms');
$file = "fdf_".$_GET['insid']."_".$_GET['pid']."_".$d.".fdf";
if($_REQUEST['type']=="secondary"){
  $fdf_field = "secondary_fdf";
}else{
  $fdf_field = "primary_fdf";
}
$sql = "UPDATE dental_insurance SET ".$fdf_field."='".mysql_real_escape_string($file)."' WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
mysql_query($sql);
            // this is where you'd do any custom handling of the data
            // if you wanted to put it in a database, email the
            // FDF data, push ti back to the user with a header() call, etc.

            // write the file out
            //echo  $fdf;
	$handle = fopen("./q_file/".$file, 'x+');
	fwrite($handle, $fdf);
	fclose($handle);

echo $fdf;
*/
function fill_cents($v){
  if($v<10){
	return '0'.$v;
  }else{
	return $v;
  }
}

function format_phone($num, $a){
        $num = ereg_replace("[^0-9]", "", $num);
        preg_match('/([0-1]*)(.*)/',$num, $m);
        $num = $m[2];
  if($a){
        return substr($num, 0, 3);
  }else{
        return substr($num,3);
  }
  return $num;
}

?>

