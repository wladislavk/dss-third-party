import symbols from '../../../symbols'
import http from '../../../services/http'
import Datepicker from 'vuejs-datepicker'
import AppointmentSummaryComponent from './AppointmentSummary.vue'
import ChartButtonsComponent from './ChartButtons.vue'
import TrackerSectionOneComponent from './TrackerSectionOne.vue'
import TrackerSectionTwoComponent from './TrackerSectionTwo.vue'

export default {
  data () {
    return {
      patientId: this.$store.state.patients[symbols.state.patientId],
      lastElement: {},
      finalElement: {},
      finalRank: 0,
      schedules: [],
      secondSchedule: {},
      hasScheduledAppointment: false,
      letterCount: 0
    }
  },
  computed: {
    scheduledAppointment () {
      if (this.hasScheduledAppointment) {
        return true
      }
      if (this.schedules.length > 0) {
        return true
      }
      return false
    }
  },
  components: {
    datepicker: Datepicker,
    appointmentSummary: AppointmentSummaryComponent,
    chartButtons: ChartButtonsComponent,
    trackerSectionOne: TrackerSectionOneComponent,
    trackerSectionTwo: TrackerSectionTwoComponent
  }
}

/*
$last_sql = "SELECT * FROM dental_flow_pg2_info info
    JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
    WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY date_completed DESC, info.id DESC";
$last = $db->getRow($last_sql);

if($last['section']==1){
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
        JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
        WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND section=1
        order by steps.section DESC, steps.sort_by DESC";
}else{
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
                    JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
                    WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by steps.section DESC, steps.sort_by DESC";
}

$trackerNotes = $db->getColumn("SELECT tracker_notes
    FROM dental_patient_summary
    WHERE pid = '$patientId'", 'tracker_notes', '');

$final = $db->getRow($final_sql);
$final_rank = 0;
$db->query("SET @rank=0");
$rank_sql = "SELECT @rank:=@rank+1 as rank, id from dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
$rank_query = $db->getResults($rank_sql);
foreach ($rank_query as $rank_r) {
    if($final['segmentid']==$rank_r['id']){
        $final_rank = $rank_r['rank'];
    }
}
$arrow_height = ($final_rank*20);

// first
$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=0 and segmentid!='' AND date_scheduled != '' AND date_scheduled != '0000-00-00' AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$sched_q = $db->getResults($sched_sql);

$bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h
              JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
              WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
$bu_q = $db->getResults($bu_sql);

$db->query("SET @step_rank=0");

// first
$step_sql = "SELECT s.*, @step_rank:=@step_rank+1 as rank from dental_flowsheet_steps s WHERE s.section=1 ORDER BY s.sort_by ASC";
$step_q = $db->getResults($step_sql);

// second
$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=2 ORDER BY sort_by ASC";
$step_q = $db->getResults($step_sql);

// second
$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND appointment_type=0";
$sched_r = $db->getRow($sched_sql);

$next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
  JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
  WHERE next.parent_id='".mysqli_real_escape_string($con,$last['segmentid'])."'
  ORDER BY next.sort_by ASC";
$next_q = $db->getResults($next_sql);
*/
