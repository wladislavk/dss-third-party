<?php
session_start();
require_once '../admin/includes/config.php';
$pid = $_REQUEST['pid'];
$d = json_decode($_REQUEST['response'], true);
//print_r($d);

$pi = $d['primary_insurance'];

$s = "INSERT INTO dental_eligibility SET
	patientid='".mysql_real_escape_string($pid)."',
	userid='".mysql_real_escape_string($_SESSION['userid'])."',
	eligible_id='".mysql_real_escape_string($d['eligible_id'])."',
	pi_name='".mysql_real_escape_string($pi['name'])."',
        pi_id='".mysql_real_escape_string($pi['id'])."',
        pi_group_name='".mysql_real_escape_string($pi['group_name'])."',
        pi_plan_begins='".mysql_real_escape_string($pi['plan_begins'])."',
        pi_plan_ends='".mysql_real_escape_string($pi['plan_ends'])."',
        pi_comments='".mysql_real_escape_string($pi['comments'])."',
        pi_deductible_in_individual_base_period='".mysql_real_escape_string($pi['deductible_in_network']['individual']['base_period'])."',
        pi_deductible_in_individual_remaining='".mysql_real_escape_string($pi['deductible_in_network']['individual']['remaining'])."',
        pi_deductible_in_individual_comments='".mysql_real_escape_string($pi['deductible_in_network']['individual']['comments'])."',
        pi_deductible_in_family_base_period='".mysql_real_escape_string($pi['deductible_in_network']['family']['base_period'])."',
        pi_deductible_in_family_remaining='".mysql_real_escape_string($pi['deductible_in_network']['family']['remaining'])."',
        pi_deductible_in_family_comments='".mysql_real_escape_string($pi['deductible_in_network']['family']['comments'])."',
        pi_deductible_out_individual_base_period='".mysql_real_escape_string($pi['deductible_out_network']['individual']['base_period'])."',
        pi_deductible_out_individual_remaining='".mysql_real_escape_string($pi['deductible_out_network']['individual']['remaining'])."',
        pi_deductible_out_individual_comments='".mysql_real_escape_string($pi['deductible_out_network']['individual']['comments'])."',
        pi_deductible_out_family_base_period='".mysql_real_escape_string($pi['deductible_out_network']['family']['base_period'])."',
        pi_deductible_out_family_remaining='".mysql_real_escape_string($pi['deductible_out_network']['family']['remaining'])."',
        pi_deductible_out_family_comments='".mysql_real_escape_string($pi['deductible_out_network']['family']['comments'])."',
        pi_stop_loss_in_individual_base_period='".mysql_real_escape_string($pi['stop_loss_in_network']['individual']['base_period'])."',
        pi_stop_loss_in_individual_remaining='".mysql_real_escape_string($pi['stop_loss_in_network']['individual']['remaining'])."',
        pi_stop_loss_in_individual_comments='".mysql_real_escape_string($pi['stop_loss_in_network']['individual']['comments'])."',
        pi_stop_loss_in_family_base_period='".mysql_real_escape_string($pi['stop_loss_in_network']['family']['base_period'])."',
        pi_stop_loss_in_family_remaining='".mysql_real_escape_string($pi['stop_loss_in_network']['family']['remaining'])."',
        pi_stop_loss_in_family_comments='".mysql_real_escape_string($pi['stop_loss_in_network']['family']['comments'])."',
        pi_stop_loss_out_individual_base_period='".mysql_real_escape_string($pi['stop_loss_out_network']['individual']['base_period'])."',
        pi_stop_loss_out_individual_remaining='".mysql_real_escape_string($pi['stop_loss_out_network']['individual']['remaining'])."',
        pi_stop_loss_out_individual_comments='".mysql_real_escape_string($pi['stop_loss_out_network']['individual']['comments'])."',
        pi_stop_loss_out_family_base_period='".mysql_real_escape_string($pi['stop_loss_out_network']['family']['base_period'])."',
        pi_stop_loss_out_family_remaining='".mysql_real_escape_string($pi['stop_loss_out_network']['family']['remaining'])."',
        pi_stop_loss_out_family_comments='".mysql_real_escape_string($pi['stop_loss_out_network']['family']['comments'])."',
        pi_balance='".mysql_real_escape_string($pi['balance'])."' ";

$sections[0] = "medical_care";
$section_data[0] = $d['1'];
$sections[1] = "medical_equipment";
$section_data[1] = $d['12'];
$sections[2] = "plan_coverage";
$section_data[2] = $d['30'];
for($i=0; $i<=2; $i++){
  $sect = $sections[$i];
  $sect_data = $section_data[$i];
  $s .= ", ".$sect."_coverage_status='".mysql_real_escape_string($sect_data['coverage_status'])."', "
  	.$sect."_coinsurance_in_individual_percent='".mysql_real_escape_string($sect_data['coinsurance_in_network']['individual']['percent'])."',"
        .$sect."_coinsurance_in_individual_comments='".mysql_real_escape_string($sect_data['coinsurance_in_network']['individual']['comments'])."',"
        .$sect."_coinsurance_in_family_percent='".mysql_real_escape_string($sect_data['coinsurance_in_network']['family']['percent'])."',"
        .$sect."_coinsurance_in_family_comments='".mysql_real_escape_string($sect_data['coinsurance_in_network']['family']['comments'])."',"
        .$sect."_coinsurance_out_individual_percent='".mysql_real_escape_string($sect_data['coinsurance_out_network']['individual']['percent'])."',"
        .$sect."_coinsurance_out_individual_comments='".mysql_real_escape_string($sect_data['coinsurance_out_network']['individual']['comments'])."',"
        .$sect."_coinsurance_out_family_percent='".mysql_real_escape_string($sect_data['coinsurance_out_network']['family']['percent'])."',"
        .$sect."_coinsurance_out_family_comments='".mysql_real_escape_string($sect_data['coinsurance_out_network']['family']['comments'])."',"
        .$sect."_copayment_in_individual_amount='".mysql_real_escape_string($sect_data['copayment_in_network']['individual']['amount'])."',"
        .$sect."_copayment_in_individual_comments='".mysql_real_escape_string($sect_data['copayment_in_network']['individual']['comments'])."',"
        .$sect."_copayment_in_family_amount='".mysql_real_escape_string($sect_data['copayment_in_network']['family']['amount'])."',"
        .$sect."_copayment_in_family_comments='".mysql_real_escape_string($sect_data['copayment_in_network']['family']['comments'])."',"
        .$sect."_copayment_out_individual_amount='".mysql_real_escape_string($sect_data['copayment_out_network']['individual']['amount'])."',"
        .$sect."_copayment_out_individual_comments='".mysql_real_escape_string($sect_data['copayment_out_network']['individual']['comments'])."',"
        .$sect."_copayment_out_family_amount='".mysql_real_escape_string($sect_data['copayment_out_network']['family']['amount'])."',"
        .$sect."_copayment_out_family_comments='".mysql_real_escape_string($sect_data['copayment_out_network']['family']['comments'])."',"
        .$sect."_deductible_in_individual_base_period='".mysql_real_escape_string($sect_data['deductible_in_network']['individual']['base_period'])."',"
        .$sect."_deductible_in_individual_remaining='".mysql_real_escape_string($sect_data['deductible_in_network']['individual']['remaining'])."',"
        .$sect."_deductible_in_individual_comments='".mysql_real_escape_string($sect_data['deductible_in_network']['individual']['comments'])."',"
        .$sect."_deductible_in_family_base_period='".mysql_real_escape_string($sect_data['deductible_in_network']['family']['base_period'])."',"
        .$sect."_deductible_in_family_remaining='".mysql_real_escape_string($sect_data['deductible_in_network']['family']['remaining'])."',"
        .$sect."_deductible_in_family_comments='".mysql_real_escape_string($sect_data['deductible_in_network']['family']['comments'])."',"
        .$sect."_deductible_out_individual_base_period='".mysql_real_escape_string($sect_data['deductible_out_network']['individual']['base_period'])."',"
        .$sect."_deductible_out_individual_remaining='".mysql_real_escape_string($sect_data['deductible_out_network']['individual']['remaining'])."',"
        .$sect."_deductible_out_individual_comments='".mysql_real_escape_string($sect_data['deductible_out_network']['individual']['comments'])."',"
        .$sect."_deductible_out_family_base_period='".mysql_real_escape_string($sect_data['deductible_out_network']['family']['base_period'])."',"
        .$sect."_deductible_out_family_remaining='".mysql_real_escape_string($sect_data['deductible_out_network']['family']['remaining'])."',"
        .$sect."_deductible_out_family_comments='".mysql_real_escape_string($sect_data['deductible_out_network']['family']['comments'])."'";


}

//$s = "UPDATE dental_task SET status = 1
	//WHERE id='".mysql_real_escape_string($id)."'";
if(mysql_query($s)){
  echo '{"success":true}';
}else{
  echo mysql_error();
  echo '{"error":true}';
}
?>
