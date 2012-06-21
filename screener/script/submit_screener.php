<?php
require_once '../../manage/admin/includes/config.php';
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
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

$s = "INSERT INTO dental_screener SET
	docid = '".mysql_real_escape_string($docid)."',
	userid = '".mysql_real_escape_string($userid)."',
	first_name = '".mysql_real_escape_string($first_name)."',
        last_name = '".mysql_real_escape_string($last_name)."',
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
	adddate=now(),
	ip_address='".$_SERVER['REMOTE_ADDR']."'
	";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>

