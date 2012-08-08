<?php
require_once '../../manage/admin/includes/config.php';
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone = $_REQUEST['phone'];
$epworth_reading = $_REQUEST['epworth_reading'];
$epworth_public = $_REQUEST['epworth_public'];
$epworth_passenger = $_REQUEST['epworth_passenger'];
$epworth_lying = $_REQUEST['epworth_lying'];
$epworth_talking = $_REQUEST['epworth_talking'];
$epworth_lunch = $_REQUEST['epworth_lunch'];
$epworth_traffic = $_REQUEST['epworth_traffic'];
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
$rx_cpap = $_REQUEST['rx_cpap'];
$rx_blood_pressure = $_REQUEST['rx_blood_pressure'];
$rx_hypertension = $_REQUEST['rx_hypertension'];
$rx_heart_disease = $_REQUEST['rx_heart_disease'];
$rx_stroke = $_REQUEST['rx_stroke'];
$rx_apnea = $_REQUEST['rx_apnea'];
$rx_diabetes = $_REQUEST['rx_diabetes'];
$rx_lung_disease = $_REQUEST['rx_lung_disease'];
$rx_insomnia = $_REQUEST['rx_insomnia'];
$rx_depression = $_REQUEST['rx_depression'];
$rx_narcolepsy = $_REQUEST['rx_narcolepsy'];
$rx_medication = $_REQUEST['rx_medication'];
$rx_restless_leg = $_REQUEST['rx_restless_leg'];
$rx_headaches = $_REQUEST['rx_headaches'];
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
        epworth_reading = '".mysql_real_escape_string($epworth_reading)."',
        epworth_public = '".mysql_real_escape_string($epworth_public)."',
        epworth_passenger = '".mysql_real_escape_string($epworth_passenger)."',
        epworth_lying = '".mysql_real_escape_string($epworth_lying)."',
        epworth_talking = '".mysql_real_escape_string($epworth_talking)."',
        epworth_lunch = '".mysql_real_escape_string($epworth_lunch)."',
        epworth_traffic = '".mysql_real_escape_string($epworth_traffic)."',
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
	rx_blood_pressure = '".mysql_real_escape_string($rx_blood_pressure)."',
        rx_hypertension = '".mysql_real_escape_string($rx_hypertension)."',
        rx_heart_disease = '".mysql_real_escape_string($rx_heart_disease)."',
        rx_stroke = '".mysql_real_escape_string($rx_stroke)."',
        rx_apnea = '".mysql_real_escape_string($rx_apnea)."',
        rx_diabetes = '".mysql_real_escape_string($rx_diabetes)."',
        rx_lung_disease = '".mysql_real_escape_string($rx_lung_disease)."',
        rx_insomnia = '".mysql_real_escape_string($rx_insomnia)."',
        rx_depression = '".mysql_real_escape_string($rx_depression)."',
        rx_narcolepsy = '".mysql_real_escape_string($rx_narcolepsy)."',
        rx_medication = '".mysql_real_escape_string($rx_medication)."',
        rx_restless_leg = '".mysql_real_escape_string($rx_restless_leg)."',
        rx_headaches = '".mysql_real_escape_string($rx_headaches)."',
        rx_heartburn = '".mysql_real_escape_string($rx_heartburn)."',
	adddate=now(),
	ip_address='".$_SERVER['REMOTE_ADDR']."'
	";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}

?>

