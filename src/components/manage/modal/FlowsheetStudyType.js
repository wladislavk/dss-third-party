import symbols from '../../../symbols'

export default {
  data () {
    return {
      segmentId: 0,
      firstName: '',
      lastName: '',
      selectedType: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    selectType () {
      $('#study_type_' + this.flowId).val(this.selectedType)
      this.$store.commit(symbols.mutations.resetModal)
    }
  }
}

/*
<?php
  $sql = "select * from dental_flow_pg2_info where id='".(!empty($_GET['id']) ? $_GET['id'] : '')."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
  $r = $db->getRow($sql);
  $sid = st($r['segmentid']);
?>

<?php if(isset($_REQUEST['submit'])) {
        $sqlex = "update dental_flow_pg2_info set study_type='".mysqli_real_escape_string($con,$_REQUEST['study_type'])."' where id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
        $qex = $db->query($sqlex);
?>
<?php } ?>
<?php
      $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

      $r = $db->getRow($s);
?>
*/
