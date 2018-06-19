<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once '../../manage/admin/includes/main_include.php';
$docid = $_REQUEST['docid'];
$userid = $_REQUEST['userid'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone = $_REQUEST['phone'];
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
$rx_heart_disease = $_REQUEST['rx_heart_disease'];
$rx_stroke = $_REQUEST['rx_stroke'];
$rx_diabetes = $_REQUEST['rx_diabetes'];
$rx_obesity = $_REQUEST['rx_obesity'];
$rx_heartburn = $_REQUEST['rx_heartburn'];
$rx_afib = $_REQUEST['rx_afib'];
$rx_cpap = $_REQUEST['rx_cpap'];

/*
$ = $_REQUEST[''];
$ = $_REQUEST[''];
$ = $_REQUEST[''];
*/

$s = "INSERT INTO dental_screener (
        docid,
        userid,
        first_name,
        last_name,
        phone,
        snore_1,
        snore_2,
        snore_3,
        snore_4,
        snore_5,
        breathing,
        driving,
        gasping,
        sleepy,
        snore,
        weight_gain,
        blood_pressure,
        jerk,
        burning,
        headaches,
        falling_asleep,
        staying_asleep,
        rx_cpap,
        rx_metabolic_syndrome,
        rx_hypertension,
        rx_heart_disease,
        rx_stroke,
        rx_diabetes,
        rx_obesity,
        rx_heartburn,
        rx_afib,
        adddate,
        ip_address
    ) VALUES (
        '".$db->escape( $docid)."',
        '".$db->escape( $userid)."',
        '".$db->escape( $first_name)."',
        '".$db->escape( $last_name)."',
        '".$db->escape( $phone)."',
        '".$db->escape( $snore_1)."',
        '".$db->escape( $snore_2)."',
        '".$db->escape( $snore_3)."',
        '".$db->escape( $snore_4)."',
        '".$db->escape( $snore_5)."',
        '".$db->escape( $breathing)."',
        '".$db->escape( $driving)."',
        '".$db->escape( $gasping)."',
        '".$db->escape( $sleepy)."',
        '".$db->escape( $snore)."',
        '".$db->escape( $weight_gain)."',
        '".$db->escape( $blood_pressure)."',
        '".$db->escape( $jerk)."',
        '".$db->escape( $burning)."',
        '".$db->escape( $headaches)."',
        '".$db->escape( $falling_asleep)."',
        '".$db->escape( $staying_asleep)."',
        '".$db->escape( $rx_cpap)."',
        '".$db->escape( $rx_metabolic_syndrome)."',
        '".$db->escape( $rx_hypertension)."',
        '".$db->escape( $rx_heart_disease)."',
        '".$db->escape( $rx_stroke)."',
        '".$db->escape( $rx_diabetes)."',
        '".$db->escape( $rx_obesity)."',
        '".$db->escape( $rx_heartburn)."',
        '".$db->escape( $rx_afib)."',
        now(),
        '".$_SERVER['REMOTE_ADDR']."'
    )";
	$q = mysqli_query($con, $s);
	$screenerid = mysqli_insert_id($con);

if($screenerid){
    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
    $epworth_my = mysqli_query($con, $epworth_sql);
    $epworth_number = mysqli_num_rows($epworth_my);
    while($epworth_myarray = mysqli_fetch_array($epworth_my))
    {
        $chk = $_REQUEST['epworth_'.$epworth_myarray['epworthid']];
        if($chk != ''){
            $hst_sql = "INSERT INTO dental_screener_epworth SET
                        screener_id = '".$db->escape( $screenerid)."',
                        epworth_id = '".$db->escape( $epworth_myarray['epworthid'])."',
                        response = '".$db->escape( $chk)."',
                        adddate = now(),
                        ip_address = '".$db->escape( $_SERVER['REMOTE_ADDR'])."'";
            mysqli_query($con, $hst_sql);
        }
    }
  echo '{"success":true, "screenerid": "'.$screenerid.'"}';

}else{
    $error = mysqli_error($con);
    error_log('Screener insertion failed: ' . $error);
  echo '{"error":true}';
}
