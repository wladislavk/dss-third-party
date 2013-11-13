<?php
require_once '../../manage/admin/includes/main_include.php';
$screenerid = $_REQUEST['screenerid'];
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$patient_first_name = $_REQUEST['patient_first_name'];
$patient_last_name = $_REQUEST['patient_last_name'];
$patient_cell_phone = $_REQUEST['patient_cell_phone'];
$patient_email = $_REQUEST['patient_email'];
$snore_1 = $_REQUEST['snore_1'];
$snore_2 = $_REQUEST['snore_2'];
$snore_3 = $_REQUEST['snore_3'];
$snore_4 = $_REQUEST['snore_4'];
$snore_5 = $_REQUEST['snore_5'];

$s = "INSERT INTO dental_hst SET
	screener_id = '".mysql_real_escape_string($screenerid)."',
	doc_id = '".mysql_real_escape_string($docid)."',
	user_id = '".mysql_real_escape_string($userid)."',
	patient_firstname = '".mysql_real_escape_string($patient_first_name)."',
        patient_lastname = '".mysql_real_escape_string($patient_last_name)."',
	patient_cell_phone = '".mysql_real_escape_string(num($patient_cell_phone))."',
	patient_email = '".mysql_real_escape_string($patient_email)."',
        snore_1 = '".mysql_real_escape_string($snore_1)."',
        snore_2 = '".mysql_real_escape_string($snore_2)."',
        snore_3 = '".mysql_real_escape_string($snore_3)."',
        snore_4 = '".mysql_real_escape_string($snore_4)."',
        snore_5 = '".mysql_real_escape_string($snore_5)."',
	status = 0,
	adddate=now(),
	ip_address='".$_SERVER['REMOTE_ADDR']."'
	";
	$hst = mysql_query($s);
	$hst_id = mysql_insert_id();
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysql_query($epworth_sql);
  $epworth_number = mysql_num_rows($epworth_my);
  while($epworth_myarray = mysql_fetch_array($epworth_my))
  {
    $chk = $_REQUEST['epworth_'.$epworth_myarray['epworthid']];
    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysql_real_escape_string($hst_id)."',
                        epworth_id = '".mysql_real_escape_string($epworth_myarray['epworthid'])."',
                        response = '".mysql_real_escape_string($chk)."',
                        adddate = now(),
                        ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
      mysql_query($hst_sql);
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

