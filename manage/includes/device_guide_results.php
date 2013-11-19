<?php
session_start();
require_once('../admin/includes/main_include.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');

  $d_array = array();

  $d_sql = "SELECT d.deviceid id, d.device name, d.image_path FROM dental_device d";
  $d_q = mysql_query($d_sql);
  while($d = mysql_fetch_assoc($d_q)){
    $tot = 0;
    $show = true;
    $s_sql = "select s.id, s.setting_type, ds.value FROM dental_device_guide_settings s 
		LEFT JOIN dental_device_guide_device_setting ds ON s.id=ds.setting_id 
			and ds.device_id='".$d['id']."'";   
    $s_q = mysql_query($s_sql);
    while($s = mysql_fetch_assoc($s_q)){
      if($s['setting_type'] == 1){
	if($s['value'] != '1' && $_POST['setting'.$s['id']] == '1'){
          $show = false;
	}
      }else{
        $s_val = $_POST['setting'.$s['id']];
        $val = $s_val*$s['value'];
        if(isset($_POST['setting_imp_'.$s['id']])){
          $val *= 1.75;
        }
        $tot += $val;
      }
    }
    if($show){
    $a = array();
    $a['name'] = $d['name'];
    $a['id'] = $d['id'];
    $a['value'] = $tot;
    $a['image_path'] = ($d['image_path'])?"../q_file/".$d['image_path']:'';
    array_push($d_array, $a);
    }
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

