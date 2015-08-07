<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once('../admin/includes/main_include.php');
  include_once('../includes/constants.inc');
  include("../includes/sescheck.php");
  include_once('../includes/general_functions.php');

  $d_array = array();

  $d_sql = "SELECT d.deviceid id, d.device name, d.image_path FROM dental_device d";
  $d_q = $db->getResults($d_sql);
  if ($d_q) foreach ($d_q as $d){
    $tot = 0;
    $show = true;
    $s_sql = "select s.id, s.setting_type, ds.value FROM dental_device_guide_settings s 
		LEFT JOIN dental_device_guide_device_setting ds ON s.id=ds.setting_id 
			and ds.device_id='".$d['id']."'";

    $s_q = $db->getResults($s_sql);
    if ($s_q) foreach ($s_q as $s){
      if($s['setting_type'] == 1){
      	if($s['value'] != '1' && $_POST['setting'.$s['id']] == '1'){
          $show = false;
      	}
      } else {
        $s_val = (!empty($_POST['setting'.$s['id']]) ? $_POST['setting'.$s['id']] : '');
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
      $a['image_path'] = ($d['image_path'])?"../display_file.php?f=".$d['image_path']:'';
      array_push($d_array, $a);
    }
  }

  usort($d_array, "ds3\Libraries\Legacy\cmp");

  echo json_encode($d_array);

  function cmp($a, $b)
  {
      if ($a['value'] == $b['value']) {
          return 0;
      }
      return ($a['value'] > $b['value']) ? -1 : 1;
  }
?>

