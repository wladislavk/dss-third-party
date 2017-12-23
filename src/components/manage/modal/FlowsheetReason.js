import symbols from '../../../symbols'

export default {
  data () {
    return {
      reason: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    }
  },
  methods: {
    submitForm () {

    }
  }
}

/*
  if(!empty($_POST["other_reason"]) && $_POST["other_reason"] == 1) {
    $ed_sql = "update dental_flow_pg2_info
          set
          description = '".s_for($_POST['reason'])."'
          where
          id='".$_REQUEST['ed']."' AND patientid='".$_REQUEST['pid']."';";

    $db->query($ed_sql);
?>
<script type="text/javascript">
  parent.disablePopup1()
</script>
<?php
    trigger_error("Die called", E_USER_ERROR);
  }
?>

      $thesql = "SELECT id, segmentid, description from dental_flow_pg2_info WHERE id='".(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '')."' AND patientid='".(!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '')."';";

      $segment = $db->getRow($thesql);
if ($segment['segmentid'] == '5') {
$segmenttype = "Delaying Treatment";
} elseif ($segment['segmentid'] == '9') {
$segmenttype = "Patient Non-Compliant";
}
*/
