export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      flowElements: [],
      devices: [],
      segments: [
        {
          number: 15,
          text: 'Baseline Sleep Test'
        },
        {
          number: 2,
          text: 'Consult'
        },
        {
          number: 4,
          text: 'Impressions'
        },
        {
          number: 7,
          text: 'Device Delivery'
        },
        {
          number: 8,
          text: 'Check / Follow Up'
        },
        {
          number: 3,
          text: 'Titration Sleep Study'
        },
        {
          number: 11,
          text: 'Treatment Complete'
        },
        {
          number: 12,
          text: 'Annual Recall'
        },
        {
          number: 14,
          text: 'Not a Candidate'
        },
        {
          number: 5,
          text: 'Delaying Tx / Waiting'
        },
        {
          number: 9,
          text: 'Pt. Non-Compliant'
        },
        {
          number: 6,
          text: 'Refused Treatment'
        },
        {
          number: 13,
          text: 'Termination'
        },
        {
          number: 1,
          text: 'Initial Contact'
        }
      ],
      delayReasons: [
        {
          value: 'insurance',
          text: 'Insurance'
        },
        {
          value: 'dental work',
          text: 'Dental Work'
        },
        {
          value: 'deciding',
          text: 'Deciding'
        },
        {
          value: 'sleep study',
          text: 'Sleep Study'
        },
        {
          value: 'other',
          text: 'Other'
        }
      ],
      nonComplianceReasons: [
        {
          value: 'pain/discomfort',
          text: 'Pain/Discomfort'
        },
        {
          value: 'lost device',
          text: 'Lost Device'
        },
        {
          value: 'device not working',
          text: 'Device Not Working'
        },
        {
          value: 'other',
          text: 'Other'
        }
      ]
    }
  },
  computed: {
    lastFlowElement () {
      if (!this.flowElements.length) {
        return null
      }
      return this.flowElements[this.flowElements.length - 1]
    }
  }
}

/*
$flow_pg2_info_query = "SELECT * FROM dental_flow_pg2_info WHERE patientid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY date_completed DESC, id DESC;";
$flow_pg2_info_res = $db->getResults($flow_pg2_info_query);

$device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
$device_my = $db->getResults($device_sql);

$dental_letters_query = "SELECT topatient, md_list, md_referral_list, status FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' AND info_id ='".$id."' AND deleted=0 ORDER BY stepid ASC;";
$dlq = $db->getResults($dental_letters_query);
*/
