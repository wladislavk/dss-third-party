import symbols from '../../../symbols'

export default {
  data () {
    return {
      firstName: '',
      lastName: '',
      selectedReason: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    changeReason (event) {
      this.selectedReason = event.target.value
    },
    submitReason () {
      $('#noncomp_reason' + this.flowId).val(this.selectedReason)
      if (this.selectedReason === 'other') {
        const modalData = {
          name: 'flowsheetReason',
          params: {
            flowId: this.flowId,
            segmentId: 9
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
      }
      this.$store.commit(symbols.mutations.resetModal)
    }
  }
}

/*
<?php
  if(isset($_REQUEST['submit'])) {
    $sqlex = "update dental_flow_pg2_info set noncomp_reason='".mysqli_real_escape_string($con,$_REQUEST['noncomp_reason'])."' where id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
    $qex = $db->query($sqlex);
?>
<?php } ?>

<?php
  $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $r = $db->getRow($s);
?>

<?php
  $sql = "select * from dental_flow_pg2_info where id='".(!empty($_GET['id']) ? $_GET['id'] : '')."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
  $r = $db->getRow($sql);
  $sid = st($r['segmentid']);
?>
*/
