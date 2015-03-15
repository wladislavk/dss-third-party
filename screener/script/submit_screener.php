<?php namespace Ds3\Libraries\Legacy; ?><?php
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
	docid = '".mysql_real_escape_string($docid)."',
	userid = '".mysql_real_escape_string($userid)."',
	first_name = '".mysql_real_escape_string($first_name)."',
        last_name = '".mysql_real_escape_string($last_name)."',
	phone = '".mysql_real_escape_string($phone)."',
        snore_1 = '".mysql_real_escape_string($snore_1)."',
        snore_2 = '".mysql_real_escape_string($snore_2)."',
        snore_3 = '".mysql_real_escape_string($snore_3)."',
        snore_4 = '".mysql_real_escape_string($snore_4)."',
        snore_5 = '".mysql_real_escape_string($snore_5)."',
	breathing ='".mysql_real_escape_string($breathing)."',
        driving ='".mysql_real_escape_string($driving)."',
        gasping ='".mysql_real_escape_string($gasping)."',
        sleepy ='".mysql_real_escape_string($sleepy)."',
        snore ='".mysql_real_escape_string($snore)."',
        weight_gain ='".mysql_real_escape_string($weight_gain)."',
        blood_pressure ='".mysql_real_escape_string($blood_pressure)."',
        jerk ='".mysql_real_escape_string($jerk)."',
        burning ='".mysql_real_escape_string($burning)."',
        headaches ='".mysql_real_escape_string($headaches)."',
        falling_asleep='".mysql_real_escape_string($falling_asleep)."',
        staying_asleep ='".mysql_real_escape_string($staying_asleep)."',
        rx_cpap = '".mysql_real_escape_string($rx_cpap)."',
	rx_metabolic_syndrome = '".mysql_real_escape_string($rx_metabolic_syndrome)."',
        rx_hypertension = '".mysql_real_escape_string($rx_hypertension)."',
        rx_heart_failure = '".mysql_real_escape_string($rx_heart_failure)."',
        rx_stroke = '".mysql_real_escape_string($rx_stroke)."',
        rx_diabetes = '".mysql_real_escape_string($rx_diabetes)."',
        rx_obesity = '".mysql_real_escape_string($rx_obesity)."',
        rx_heartburn = '".mysql_real_escape_string($rx_heartburn)."',
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
                        screener_id = '".mysql_real_escape_string($screenerid)."',
                        epworth_id = '".mysql_real_escape_string($epworth_myarray['epworthid'])."',
                        response = '".mysql_real_escape_string($chk)."',
                        adddate = now(),
                        ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
      mysql_query($hst_sql);
    }
  }

if($q){
  echo '{"success":true, "screenerid": "'.$screenerid.'"}';

}else{
  echo '{"error":true}';
}

?>

