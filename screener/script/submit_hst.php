<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once '../../manage/admin/includes/main_include.php';
$screenerid = $_REQUEST['screenerid'];
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$companyid = $_REQUEST['companyid'];
$patient_first_name = $_REQUEST['patient_first_name'];
$patient_last_name = $_REQUEST['patient_last_name'];
$patient_dob = $_REQUEST['patient_dob'];
$patient_cell_phone = $_REQUEST['patient_cell_phone'];
$patient_email = $_REQUEST['patient_email'];
$snore_1 = $_REQUEST['snore_1'];
$snore_2 = $_REQUEST['snore_2'];
$snore_3 = $_REQUEST['snore_3'];
$snore_4 = $_REQUEST['snore_4'];
$snore_5 = $_REQUEST['snore_5'];

$s = "INSERT INTO dental_hst SET
	screener_id = '".mysqli_real_escape_string($con, $screenerid)."',
	doc_id = '".mysqli_real_escape_string($con, $docid)."',
	user_id = '".mysqli_real_escape_string($con, $userid)."',
	company_id = '".mysqli_real_escape_string($con, $companyid)."',
	patient_firstname = '".mysqli_real_escape_string($con, $patient_first_name)."',
        patient_lastname = '".mysqli_real_escape_string($con, $patient_last_name)."',
	patient_cell_phone = '".mysqli_real_escape_string($con, num($patient_cell_phone))."',
	patient_email = '".mysqli_real_escape_string($con, $patient_email)."',
	patient_dob = '".mysqli_real_escape_string($con, date('Y-m-d', strtotime($patient_dob)))."',
        snore_1 = '".mysqli_real_escape_string($con, $snore_1)."',
        snore_2 = '".mysqli_real_escape_string($con, $snore_2)."',
        snore_3 = '".mysqli_real_escape_string($con, $snore_3)."',
        snore_4 = '".mysqli_real_escape_string($con, $snore_4)."',
        snore_5 = '".mysqli_real_escape_string($con, $snore_5)."',
	status = 0,
	adddate=now(),
	ip_address='".$_SERVER['REMOTE_ADDR']."'
	";
	$hst = mysqli_query($con, $s);
	$hst_id = mysqli_insert_id($con);
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($epworth_myarray = mysqli_fetch_array($epworth_my))
  {
    $chk = $_REQUEST['epworth_'.$epworth_myarray['epworthid']];
    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysqli_real_escape_string($con, $hst_id)."',
                        epworth_id = '".mysqli_real_escape_string($con, $epworth_myarray['epworthid'])."',
                        response = '".mysqli_real_escape_string($con, $chk)."',
                        adddate = now(),
                        ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
      mysqli_query($con, $hst_sql);
    }
  }


if($hst){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}

function num($n, $phone=true){
$n = preg_replace('/\D/', '', $n);
if(!$phone){return $n; }
$pattern = '/([1]*)(.*)/';
preg_match($pattern, $n, $matches);
return $matches[2];
}

?>

