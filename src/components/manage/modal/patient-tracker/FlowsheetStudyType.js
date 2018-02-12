import symbols from '../../../../symbols'

export default {
  data () {
    return {
      firstName: '',
      lastName: '',
      selectedType: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    segmentId () {
      return this.$store.state.flowsheet[symbols.state.currentAppointmentSummary].segmentId
    },
    isTitration () {
      if (this.segmentId === 3) {
        return true
      }
      return false
    },
    isBaseline () {
      if (this.segmentId === 15) {
        return true
      }
      return false
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getAppointmentSummary, this.flowId)
  },
  methods: {
    selectType () {
      $('#study_type_' + this.flowId).val(this.selectedType)
      this.$store.commit(symbols.mutations.resetModal)
    }
  }
}

/*
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
