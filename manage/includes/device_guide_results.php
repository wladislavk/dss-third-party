<?php
session_start();
require_once('../admin/includes/config.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');

  $d_array = array();

  $d_sql = "SELECT d.deviceid id, d.device name FROM dental_device d";
  $d_q = mysql_query($d_sql);
  while($d = mysql_fetch_assoc($d_q)){
    $tot = 0;
    $s_sql = "SELECT ds.value, ds.setting_id FROM dental_device_guide_device_setting ds WHERE ds.device_id='".$d['id']."'";   
    $s_q = mysql_query($s_sql);
    while($s = mysql_fetch_assoc($s_q)){
      $s_val = $_POST['setting'.$s['setting_id']]. " ".$s['setting_id'];
      $val = $s_val*$s['value'];
      if(isset($_POST['setting_imp_'.$s['setting_id']])){
        $val *= 1.5;
      }
      $tot += $val;
    }
    $a = array();
    $a['name'] = $d['name'];
    $a['id'] = $d['id'];
    $a['value'] = $tot;
    array_push($d_array, $a);
  }
usort($d_array, "cmp");

echo json_encode($d_array);

function cmp($a, $b)
{
    if ($a['value'] == $b['value']) {
        return 0;
    }
    return ($a['value'] > $b['value']) ? -1 : 1;
}


?>

