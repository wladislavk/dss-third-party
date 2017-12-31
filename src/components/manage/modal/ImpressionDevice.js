import symbols from '../../../symbols'

export default {
  data () {
    return {
      firstName: '',
      lastName: '',
      devices: [],
      patientDevice: ''
    }
  },
  computed: {
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    selectDevice () {
      $('#dentaldevice_' + this.flowId).val(this.patientDevice)
      this.$store.commit(symbols.mutations.resetModal)
    }
  }
}

/*
<?php
if(isset($_REQUEST['submit'])) {
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
}
?>

<?php
  $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $r = $db->getRow($s);

  $sqlex = "select * from dental_ex_page5 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
  $myarrayex = $db->getRow($sqlex);
  $dentaldevice = st($myarrayex['dentaldevice']);

  $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
  $device_my = $db->getResults($device_sql);
?>
*/
