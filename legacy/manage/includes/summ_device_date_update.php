<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once '../admin/includes/main_include.php';

  $pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

  if (!empty($_REQUEST['device_date'])) {
    $d = date('Y-m-d', strtotime($_REQUEST['device_date']));
  } else {
    $d = date('Y-m-d');
  }

  $sql = "SELECT * FROM dental_ex_page5_view where patientid='".$pid."'";

  if($db->getNumberRows($sql)==0){
    $s = "INSERT INTO dental_ex_page5 set 
          dentaldevice_date='".mysqli_real_escape_string($con,$d)."', 
          patientid='".$pid."',
          userid = '".s_for($_SESSION['userid'])."',
          docid = '".s_for($_SESSION['docid'])."',
          adddate = now(),
          ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
  } else {
    $s = "UPDATE dental_ex_page5_view set dentaldevice_date='".mysqli_real_escape_string($con,$d)."' where patientid='".$pid."'";
  }
  
  $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".mysqli_real_escape_string($con,$pid)." ORDER BY date_completed DESC";

  $last_r = $db->getRow($last_sql);
	$u = "UPDATE dental_flow_pg2_info SET date_completed='".mysqli_real_escape_string($con,$d)."' WHERE id='".$last_r['id']."'";
	$db->query($u);

  $q = $db->query($s);

  $imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysqli_real_escape_string($con,$pid)."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
  
  $imp_r = $db->getRow($imp_s);

  //competed_date changed to date_completed
  
  $flow_sql = "UPDATE dental_flow_pg2_info SET
              date_completed='".mysqli_real_escape_string($con,$d)."'
              WHERE id='".mysqli_real_escape_string($con,$imp_r['id'])."'";
  $db->query($flow_sql);

  if($q){
    echo '{"success":true}';
  }else{
    echo '{"error":true}';
  }
?>
