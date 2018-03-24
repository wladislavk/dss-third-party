<?php namespace Ds3\Libraries\Legacy; ?><div style="clear:both;"></div>
<?php

$query = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$patientInfo = $db->getRow($query);
$docId = $patientInfo['docid'];

$insurancetype = $patientInfo['p_m_ins_type'];

$patient_firstname = $patientInfo['firstname'];
$patient_lastname = $patientInfo['lastname'];
$patient_dob = $patientInfo['dob'];
$patient_phone = $patientInfo['home_phone'];
$patient_sex = $patientInfo['gender'];

$insured_firstname = $patientInfo['p_m_partyfname'];
$insured_lastname = $patientInfo['p_m_partylname'];
$insured_phone = $patient_phone;
$insured_id_number = $patientInfo['p_m_ins_id'];
$insured_dob = $patientInfo['ins_dob'];
$insured_sex = $patientInfo['p_m_gender'];
$insured_policy_group_feca = $patientInfo['p_m_ins_grp'];
$patient_relation_insured = $patientInfo['p_m_relation'];

$other_insured_firstname = $patientInfo['s_m_partyfname'];
$other_insured_lastname = $patientInfo['s_m_partylname'];
$other_insured_id_number = $patientInfo['s_m_ins_id'];
$other_insured_phone = $patient_phone;
$other_insured_dob = $patientInfo['ins2_dob'];
$other_insured_sex = $patientInfo['s_m_gender'];
$other_insured_policy_group_feca = $patientInfo['s_m_ins_grp'];
$patient_relation_other_insured = $patientInfo['s_m_relation'];

$getDocInfo = "SELECT * FROM `dental_users` WHERE `userid` = '$docId'";
$docInfo = $db->getRow($getDocInfo);

if(empty($phone)){
  $phone = $docInfo['phone']; 
}
if(empty($doc)){ 
  $doc = $docInfo['first_name']." ".$docInfo['last_name']; 
}
if(empty($practice)){ 
  $practice = $docInfo['practice']; 
}
if(empty($address)){ 
  $address = $docInfo['address']; 
}
if(empty($city)){ 
  $city = $docInfo['city']; 
}
if(empty($state)){ 
  $state = $docInfo['state']; 
}
if(empty($zip)){
  $zip = $docInfo['zip']; 
}
if(empty($npi)){ 
  $npi = $docInfo['npi']; 
}
if(empty($medicare_npi)){
  $medicare_npi = $docInfo['medicare_npi'];
}
if(empty($medicare_ptan)){
  $medicare_ptan = $docInfo['medicare_ptan'];
}

if($docInfo['use_service_npi']==1){
  $service_npi = $docInfo['service_npi'];
  $service_doc = $docInfo['first_name']." ".$docInfo['last_name'];
  $service_practice = $docInfo['service_name'];
  $service_address = $docInfo['service_address'];
  $service_city = $docInfo['service_city'];
  $service_state = $docInfo['service_state'];
  $service_zip = $docInfo['service_zip'];
}else{
  $service_npi = $npi;
  $service_doc = $doc;
  $service_practice = $practice;
  $service_address = $address;
  $service_city = $city;
  $service_state = $state;
  $service_zip = $zip;
}

$hasSecondaryInsurance = $patientInfo['has_s_m_ins'] == 'Yes';
$primarySameAsBase = $patientInfo['p_m_same_address'] != 2;
$secondarySameAsBase = $patientInfo['s_m_same_address'] != 2;

$patientLocation = "{$patientInfo['add1']} {$patientInfo['add2']} {$patientInfo['city']} {$patientInfo['state']} {$patientInfo['zip']}";
$primaryInsuredLocation = $patientLocation;
$secondaryInsuredLocation = $patientLocation;

if (!$primarySameAsBase) {
    $insured_phone = '';
    $primaryInsuredLocation = "{$patientInfo['p_m_address']} {$patientInfo['p_m_city']} {$patientInfo['p_m_state']} {$patientInfo['p_m_zip']}";
}

if (!$secondarySameAsBase) {
    $other_insured_phone = '';
    $secondaryInsuredLocation = "{$patientInfo['s_m_address']} {$patientInfo['s_m_city']} {$patientInfo['s_m_state']} {$patientInfo['s_m_zip']}";
}

$query = "SELECT * FROM dental_contact WHERE contactid ='{$patientInfo['p_m_ins_co']}'";
$primaryInsurance = $db->getRow($query);

if ($hasSecondaryInsurance) {
    $query = "SELECT * FROM dental_contact WHERE contactid ='{$patientInfo['s_m_ins_co']}'";
    $secondaryInsurance = $db->getRow($query);
}

?>
<div style="display:block; float:left; width:48%;">
  <h3>Primary</h3>
  <ul>
    <li><label>Insurance Co.:</label><span class="value"><?= htmlspecialchars($primaryInsurance['company']) ?></span></li>
    <li><label>Insurance Addr:</label><span class="value"><?= htmlspecialchars($primaryInsurance['add1']." ".$primaryInsurance['add2']." ".$primaryInsurance['city']." ".$primaryInsurance['state']." ".$primaryInsurance['zip']) ?></span></li>
    <li><label>Insurance Phone: </label> <span class="value"><?= htmlspecialchars($primaryInsurance['phone1']) ?></span></li>
    <li><label>Insurance Fax: </label> <span class="value"><?= htmlspecialchars($primaryInsurance['fax']) ?></span></li>
  </ul>

  <ul>
    <li><label>Doc Name:</label><span class="value"><?= htmlspecialchars($service_doc) ?></span></li>
    <li><label>Doc Practice:</label><span class="value"><?= htmlspecialchars($service_practice) ?></span></li>
    <li><label>Doc Addr:</label><span class="value"><?= htmlspecialchars($service_address." " .$service_city." ".$service_state." ".$service_zip) ?></span></li>
    <li><label>Doc Tax ID:</label><span class="value"><?= htmlspecialchars($docInfo['tax_id_or_ssn']) ?></span></li>
    <li><label>Doc NPI:</label><span class="value"><?= htmlspecialchars($service_npi) ?></span></li>
  </ul>

  <ul>
    <li><label>Billing Name:</label> <span class="value"><?= htmlspecialchars($practice) ?></span></li>
    <li><label>Billing Addr:</label> <span class="value"><?= htmlspecialchars("$address $city $state $zip") ?></span></li>
    <li><label>Billing Tax ID:</label> <span class="value"><?= htmlspecialchars($docInfo['tax_id_or_ssn']) ?></span></li>
    <li><label>Billing NPI:</label> <span class="value"><?= htmlspecialchars(($insurancetype == '1')?$medicare_npi:$npi) ?></span></li>
    <li><label>Medicare Billing NPI:</label> <span class="value"><?= htmlspecialchars((!empty($medicare_npi) ? $medicare_npi : '')) ?></span></li>
    <li><label>Medicare PTAN:</label> <span class="value"><?= htmlspecialchars((!empty($medicare_ptan) ? $medicare_ptan : '')) ?></span></li>
  </ul>

  <ul>
    <li><label>Pt Name:</label> <span class="value"><?= htmlspecialchars($patient_firstname. " ".$patient_lastname) ?></span></li>
    <li><label>Pt DOB:</label> <span class="value"><?= htmlspecialchars($patient_dob) ?></span></li>
    <li><label>Pt Sex:</label> <span class="value"><?= htmlspecialchars($patient_sex) ?></span></li>
    <li><label>Pt Addr:</label> <span class="value"><?= htmlspecialchars($patientLocation) ?></span></li>
    <li><label>Pt Ins ID:</label> <span class="value"><?= htmlspecialchars($insured_id_number) ?></span></li>
    <li><label>Pt Group #:</label> <span class="value"><?= htmlspecialchars($insured_policy_group_feca) ?></span></li>
    <li><label>Pt Phone:</label> <span class="value"><?= htmlspecialchars($patient_phone) ?></span></li>
    <li><label>Pt Relation to Insd:</label> <span class="value"><?= htmlspecialchars($patient_relation_insured) ?></span></li>
  </ul>

  <ul>
    <li><label>Insured Name:</label> <span class="value"><?= htmlspecialchars($insured_firstname." ".$insured_lastname) ?></span></li>
    <li><label>Insured DOB:</label> <span class="value"><?= htmlspecialchars($insured_dob) ?></span></li>
    <li><label>Insured Sex:</label> <span class="value"><?= htmlspecialchars($insured_sex) ?></span></li>
    <li><label>Insured Addr:</label> <span class="value"><?= htmlspecialchars($primaryInsuredLocation) ?></span></li>
    <li><label>Insured Ins ID:</label> <span class="value"><?= htmlspecialchars($insured_id_number) ?></span></li>
    <li><label>Insured Group #:</label> <span class="value"><?= htmlspecialchars($insured_policy_group_feca) ?></span></li>
    <li><label>Insured Phone:</label> <span class="value"><?= htmlspecialchars($insured_phone) ?></span></li>
  </ul>
</div>


<div style="display:block; float:left; width:48%;">
  <h3>Secondary</h3>
<?php if (!$hasSecondaryInsurance) { ?>
    None
<?php } else { ?>
  <ul>
    <li><label>Insurance Co.:</label><span class="value"><?= htmlspecialchars($secondaryInsurance['company']) ?></span></li>
    <li><label>Insurance Addr:</label><span class="value"><?= htmlspecialchars($secondaryInsurance['add1']." ".$secondaryInsurance['add2']." ".$secondaryInsurance['city']." ".$secondaryInsurance['state']." ".$secondaryInsurance['zip']) ?></span></li>
    <li><label>Insurance Phone: </label> <span class="value"><?= htmlspecialchars($secondaryInsurance['phone1']) ?></span></li>
    <li><label>Insurance Fax: </label> <span class="value"><?= htmlspecialchars($secondaryInsurance['fax']) ?></span></li>
  </ul>

  <ul>
    <li><label>Doc Name:</label><span class="value"><?= htmlspecialchars($service_doc) ?></span></li>
    <li><label>Doc Practice:</label><span class="value"><?= htmlspecialchars($service_practice) ?></span></li>
    <li><label>Doc Addr:</label><span class="value"><?= htmlspecialchars("$service_address $service_city $service_state $service_zip") ?></span></li>
    <li><label>Doc Tax ID:</label><span class="value"><?= htmlspecialchars($docInfo['tax_id_or_ssn']) ?></span></li>
    <li><label>Doc NPI:</label><span class="value"><?= htmlspecialchars($service_npi) ?></span></li>
  </ul>

  <ul>
    <li><label>Billing Name:</label> <span class="value"><?= htmlspecialchars($practice) ?></span></li>
    <li><label>Billing Addr:</label> <span class="value"><?= htmlspecialchars("$address $city $state $zip") ?></span></li>
    <li><label>Billing Tax ID:</label> <span class="value"><?= htmlspecialchars($docInfo['tax_id_or_ssn']) ?></span></li>
    <li><label>Billing NPI:</label> <span class="value"><?= htmlspecialchars(($insurancetype == '1')?$medicare_npi:$npi) ?></span></li>
  </ul>

  <ul>
    <li><label>Pt Name:</label> <span class="value"><?= htmlspecialchars($patient_firstname. " ".$patient_lastname) ?></span></li>
    <li><label>Pt DOB:</label> <span class="value"><?= htmlspecialchars($patient_dob) ?></span></li>
    <li><label>Pt Sex:</label> <span class="value"><?= htmlspecialchars($patient_sex) ?></span></li>
    <li><label>Pt Addr:</label> <span class="value"><?= htmlspecialchars($patientLocation) ?></span></li>
    <li><label>Pt Ins ID:</label> <span class="value"><?= htmlspecialchars($insured_id_number) ?></span></li>
    <li><label>Pt Group #:</label> <span class="value"><?= htmlspecialchars($insured_policy_group_feca) ?></span></li>
    <li><label>Pt Phone:</label> <span class="value"><?= htmlspecialchars($patient_phone) ?></span></li>
    <li><label>Pt Relation to Insd:</label> <span class="value"><?= htmlspecialchars($patient_relation_other_insured) ?></span></li>
  </ul>

  <ul>
    <li><label>Insured Name:</label> <span class="value"><?= htmlspecialchars($other_insured_firstname." ".$other_insured_lastname) ?></span></li>
    <li><label>Insured DOB:</label> <span class="value"><?= htmlspecialchars($other_insured_dob) ?></span></li>
    <li><label>Insured Sex:</label> <span class="value"><?= htmlspecialchars($other_insured_sex) ?></span></li>
    <li><label>Insured Addr:</label> <span class="value"><?= htmlspecialchars($secondaryInsuredLocation) ?></span></li>
    <li><label>Insured Ins ID:</label> <span class="value"><?= htmlspecialchars($other_insured_id_number) ?></span></li>
    <li><label>Insured Group #:</label> <span class="value"><?= htmlspecialchars($other_insured_policy_group_feca) ?></span></li>
    <li><label>Insured Phone:</label> <span class="value"><?= htmlspecialchars($other_insured_phone) ?></span></li>
  </ul>
<?php 
} ?>
</div>
<div style="clear:both;"></div>
