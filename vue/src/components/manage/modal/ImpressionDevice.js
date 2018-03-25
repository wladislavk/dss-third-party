/*
import symbols from '../../../symbols'

export default {
  computed: {
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    deviceId () {
      return this.$store.state.main[symbols.state.modal].params.deviceId
    }
  }
}

/*
<?php if(isset($_REQUEST['submit'])) {
  $sql = "SELECT * FROM dental_ex_page5 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
  if($db->getNumberRows($sql) == 0){
    $sqlex = "INSERT INTO dental_ex_page5 set
    dentaldevice='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."',
    patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."',
    userid = '".s_for($_SESSION['userid'])."',
    docid = '".s_for($_SESSION['docid'])."',
    adddate = now(),
    ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
  } else {
    $sqlex = "update dental_ex_page5 set dentaldevice='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."' where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
  }
  $qex = $db->query($sqlex);
  $flow_sql = "UPDATE dental_flow_pg2_info SET
    device_id='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."'
    WHERE id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."'";
  $db->query($flow_sql);
?>
*/
