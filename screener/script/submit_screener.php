<?php
require_once '../../manage/admin/includes/main_include.php';
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone = $_REQUEST['phone'];
/*$epworth_reading = $_REQUEST['epworth_reading'];
$epworth_public = $_REQUEST['epworth_public'];
$epworth_passenger = $_REQUEST['epworth_passenger'];
$epworth_lying = $_REQUEST['epworth_lying'];
$epworth_talking = $_REQUEST['epworth_talking'];
$epworth_lunch = $_REQUEST['epworth_lunch'];
$epworth_traffic = $_REQUEST['epworth_traffic'];
*/
$snore_1 = $_REQUEST['snore_1'];
$snore_2 = $_REQUEST['snore_2'];
$snore_3 = $_REQUEST['snore_3'];
$snore_4 = $_REQUEST['snore_4'];
$snore_5 = $_REQUEST['snore_5'];
$breathing = $_REQUEST['breathing'];
$driving = $_REQUEST['driving'];
$gasping = $_REQUEST['gasping'];
$sleepy = $_REQUEST['sleepy'];
$snore = $_REQUEST['snore'];
$weight_gain = $_REQUEST['weight_gain'];
$blood_pressure = $_REQUEST['blood_pressure'];
$jerk = $_REQUEST['jerk'];
$burning = $_REQUEST['burning'];
$headaches = $_REQUEST['headaches'];
$falling_asleep = $_REQUEST['falling_asleep'];
$staying_asleep = $_REQUEST['staying_asleep'];
$rx_metabolic_syndrome = $_REQUEST['rx_metabolic_syndrome'];
$rx_hypertension = $_REQUEST['rx_hypertension'];
$rx_heart_failure = $_REQUEST['rx_heart_failure'];
$rx_stroke = $_REQUEST['rx_stroke'];
$rx_diabetes = $_REQUEST['rx_diabetes'];
$rx_obesity = $_REQUEST['rx_obesity'];
$rx_heartburn = $_REQUEST['rx_heartburn'];

/*
$ = $_REQUEST[''];
$ = $_REQUEST[''];
$ = $_REQUEST[''];
*/

$s = "INSERT INTO dental_screener SET
	docid = '".mysqli_real_escape_string($con, $docid)."',
	userid = '".mysqli_real_escape_string($con, $userid)."',
	first_name = '".mysqli_real_escape_string($con, $first_name)."',
        last_name = '".mysqli_real_escape_string($con, $last_name)."',
	phone = '".mysqli_real_escape_string($con, $phone)."',
        snore_1 = '".mysqli_real_escape_string($con, $snore_1)."',
        snore_2 = '".mysqli_real_escape_string($con, $snore_2)."',
        snore_3 = '".mysqli_real_escape_string($con, $snore_3)."',
        snore_4 = '".mysqli_real_escape_string($con, $snore_4)."',
        snore_5 = '".mysqli_real_escape_string($con, $snore_5)."',
	breathing ='".mysqli_real_escape_string($con, $breathing)."',
        driving ='".mysqli_real_escape_string($con, $driving)."',
        gasping ='".mysqli_real_escape_string($con, $gasping)."',
        sleepy ='".mysqli_real_escape_string($con, $sleepy)."',
        snore ='".mysqli_real_escape_string($con, $snore)."',
        weight_gain ='".mysqli_real_escape_string($con, $weight_gain)."',
        blood_pressure ='".mysqli_real_escape_string($con, $blood_pressure)."',
        jerk ='".mysqli_real_escape_string($con, $jerk)."',
        burning ='".mysqli_real_escape_string($con, $burning)."',
        headaches ='".mysqli_real_escape_string($con, $headaches)."',
        falling_asleep='".mysqli_real_escape_string($con, $falling_asleep)."',
        staying_asleep ='".mysqli_real_escape_string($con, $staying_asleep)."',
        rx_cpap = '".mysqli_real_escape_string($con, $rx_cpap)."',
	rx_metabolic_syndrome = '".mysqli_real_escape_string($con, $rx_metabolic_syndrome)."',
        rx_hypertension = '".mysqli_real_escape_string($con, $rx_hypertension)."',
        rx_heart_failure = '".mysqli_real_escape_string($con, $rx_heart_failure)."',
        rx_stroke = '".mysqli_real_escape_string($con, $rx_stroke)."',
        rx_diabetes = '".mysqli_real_escape_string($con, $rx_diabetes)."',
        rx_obesity = '".mysqli_real_escape_string($con, $rx_obesity)."',
        rx_heartburn = '".mysqli_real_escape_string($con, $rx_heartburn)."',
	adddate=now(),
	ip_address='".$_SERVER['REMOTE_ADDR']."'
	";
	$q = mysql_query($s);
	$screenerid = mysql_insert_id();

  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysql_query($epworth_sql);
  $epworth_number = mysql_num_rows($epworth_my);
  while($epworth_myarray = mysql_fetch_array($epworth_my))
  {
    $chk = $_REQUEST['epworth_'.$epworth_myarray['epworthid']];
    if($chk != ''){
      $hst_sql = "INSERT INTO dental_screener_epworth SET
                        screener_id = '".mysqli_real_escape_string($con, $screenerid)."',
                        epworth_id = '".mysqli_real_escape_string($con, $epworth_myarray['epworthid'])."',
                        response = '".mysqli_real_escape_string($con, $chk)."',
                        adddate = now(),
                        ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
      mysql_query($hst_sql);
    }
  }

if($q){
  echo '{"success":true, "screenerid": "'.$screenerid.'"}';

}else{
  echo '{"error":true}';
}

?>

