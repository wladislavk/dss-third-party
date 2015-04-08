<?php
include 'manage/admin/includes/config.php';
$run_updates = false;
$debug = false;

$sql = "SELECT patientid, ssn, home_phone, cell_phone, work_phone, emp_phone, emp_fax, emergency_number FROM dental_patients";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_patients set
home_phone='".num($r['home_phone'])."',
cell_phone='".num($r['cell_phone'])."',
work_phone='".num($r['work_phone'])."',
ssn='".num($r['ssn'], false)."',
emp_phone='".num($r['emp_phone'])."',
emp_fax='".num($r['emp_fax'])."',
emergency_phone='".num($r['emergency_phone'])."'
WHERE patientid='".$r['patientid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}



$sql = "SELECT contactid, phone1, phone2, fax FROM dental_contact";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_contact set
phone1='".num($r['phone1'])."',
phone2='".num($r['phone2'])."',
fax='".num($r['fax'])."'
WHERE contactid='".$r['contactid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}





$sql = "SELECT contactid, phone1, phone2, fax FROM dental_fcontact";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_fcontact set
phone1='".num($r['phone1'])."',
phone2='".num($r['phone2'])."',
fax='".num($r['fax'])."'
WHERE contactid='".$r['contactid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}





$sql = "SELECT insuranceid, patient_phone_code, patient_phone, insured_phone_code, insured_phone, federal_tax_id_number FROM dental_insurance";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_insurance set
patient_phone_code='".num($r['patient_phone_code'])."',
patient_phone='".num($r['patient_phone'], false)."',
insured_phone_code='".num($r['insured_phone_code'])."',
insured_phone='".num($r['insured_phone'], false)."',
federal_tax_id_number='".num($r['federal_tax_id_number'], false)."'
WHERE insuranceid='".$r['insuranceid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}





$sql = "SELECT id, ins_phone, patient_phone, doc_tax_id_or_ssn FROM dental_insurance_preauth";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_insurance_preauth set
patient_phone='".num($r['patient_phone'])."',
ins_phone='".num($r['ins_phone'])."',
doc_tax_id_or_ssn='".num($r['doc_tax_id_or_ssn'], false)."'
WHERE id='".$r['id']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}




$sql = "SELECT id, phone FROM dental_patient_contacts";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_patient_contacts set
phone='".num($r['phone'])."'
WHERE id='".$r['id']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}




$sql = "SELECT id, phone, fax FROM dental_patient_insurance";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_patient_insurance set
phone='".num($r['phone'])."',
fax='".num($r['fax'])."'
WHERE id='".$r['id']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}



$sql = "SELECT referredbyid, phone1, phone2, fax FROM dental_referredby";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_referredby set
phone1='".num($r['phone1'])."',
phone2='".num($r['phone2'])."',
fax='".num($r['fax'])."'
WHERE referredbyid='".$r['referredbyid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}



$sql = "SELECT sleeplabid, phone1, phone2, fax FROM dental_sleeplab";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_sleeplab set
phone1='".num($r['phone1'])."',
phone2='".num($r['phone2'])."',
fax='".num($r['fax'])."'
WHERE sleeplabid='".$r['sleeplabid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}


$sql = "SELECT userid, phone FROM dental_users";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
$upsql = "UPDATE dental_users set
phone='".num($r['phone'])."'
WHERE userid='".$r['userid']."'";
if($debug){ echo $upsql."<br />"; }
if($run_updates){ mysqli_query($con, $upsql); }
}








function num($n, $phone=true){
$n = preg_replace('/\D/', '', $n);
if(!$phone){return $n; }
$pattern = '/([1]*)(.*)/'; 
preg_match($pattern, $n, $matches);
return $matches[2];
}

?>
