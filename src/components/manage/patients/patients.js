import accounting from 'accounting'
import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { PREAUTH_STATUS_LABELS } from '../../../constants/main'
import MomentWrapper from '../../../wrappers/MomentWrapper'

export default {
  data () {
    return {
      patientInfo: '',
      routeParameters: {
        patientId: null,
        currentPageNumber: 0,
        sortDirection: 'asc',
        selectedPatientType: '1',
        sortColumn: 'name',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      patientsTotalNumber: 0,
      patientsPerPage: 30,
      patientTypeSelect: [
        { text: 'Active Patients', value: '1' },
        { text: 'All Patients', value: '2' },
        { text: 'In-active Patients', value: '3' }
      ],
      patients: [],
      tableHeaders: {
        'name': 'Name',
        'tx': 'Ready for Tx',
        'next-visit': 'Next Visit',
        'last-visit': 'Last Visit',
        'last-treatment': 'Last Treatment',
        'appliance': 'Appliance',
        'appliance-since': 'Appliance Since',
        'vob': 'VOB',
        'rx-lomn': 'Rx./L.O.M.N.',
        'ledger': 'Ledger'
      },
      segments: [
        '',
        'Initial Contact',
        'Consult',
        'Sleep Study',
        'Impressions',
        'Delaying Tx / Waiting',
        'Refused Treatment',
        'Device Delivery',
        'Check / Follow Up',
        'Pt. Non-Compliant',
        'Home Sleep Test',
        'Treatment Complete',
        'Annual Recall',
        'Termination',
        'Not a Candidate',
        'Baseline Sleep Test'
      ],
      preauthLabels: PREAUTH_STATUS_LABELS
    }
  },
  watch: {
    '$route.query.sh': function () {
      if (this.$route.query.sh) {
        const foundOption = this.patientTypeSelect.find(el => el.value === this.$route.query.sh)

        if (foundOption) {
          this.$set(this.routeParameters, 'selectedPatientType', this.$route.query.sh)
        } else {
          this.$set(this.routeParameters, 'selectedPatientType', 1)
        }
      }
    },
    '$route.query.page': function () {
      if (this.$route.query.page) {
        if (this.$route.query.page <= this.totalPages) {
          this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page)
        }
      }
    },
    '$route.query.sort': function () {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
        } else {
          this.$set(this.routeParameters, 'sortColumn', null)
        }
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc')
        }
      }
    },
    '$route.query.pid': function () {
      const queryPatientId = this.$route.query.pid
      let patientId = null
      if (queryPatientId > 0) {
        patientId = queryPatientId
      }
      this.$set(this.routeParameters, 'patientId', patientId)
    },
    '$route.query.letter': function () {
      const queryLetter = this.$route.query.letter
      let letter = null
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter
      }
      this.$set(this.routeParameters, 'currentLetter', letter)
    },
    '$route.query.delid': function () {
      if (this.$route.query.delid > 0) {
        this.onDeletePatient(this.$route.query.delid)
      }
    },
    'routeParameters': {
      handler: function () {
        this.getPatients()
      },
      deep: true
    }
  },
  computed: {
    totalPages () {
      return Math.ceil(this.patientsTotalNumber / this.patientsPerPage)
    }
  },
  created () {
    this.getPatients()
  },
  methods: {
    onChangePatientTypeSelect () {
      this.$router.push({
        name: this.$route.name,
        query: {
          sh: this.routeParameters.selectedPatientType
        }
      })
    },
    onDeletePatient (patientId) {
      this.deletePatient(patientId).then(() => {
        this.message = 'Deleted Successfully'
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'deletePatient', response: response})
      })
    },
    getRxLomn (value) {
      switch (+value) {
        case 3:
          return 'Yes'
        case 2:
          return 'Yes/No'
        case 1:
          return 'No/Yes'
      }
      return 'No'
    },
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    },
    checkIfThisWeek (value) {
      const totalDays = MomentWrapper.create(value).diff(MomentWrapper.create(), 'days')
      const negative = (MomentWrapper.create(value) - MomentWrapper.create()) < 0

      return (totalDays >= 0 && totalDays <= 7 && !negative)
    },
    isNegativeTime (value) {
      return (MomentWrapper.create(value) - MomentWrapper.create()) < 0
    },
    readyForTx (insuranceNoError, numSleepStudy) {
      return +insuranceNoError && numSleepStudy !== 0
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      }
      return sort === 'name' ? 'asc' : 'desc'
    },
    getPatients () {
      this.findPatients(
        this.routeParameters.patientId,
        this.routeParameters.selectedPatientType,
        this.routeParameters.currentPageNumber,
        this.patientsPerPage,
        this.routeParameters.currentLetter,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection
      ).then((response) => {
        const data = response.data.data

        const totalCount = data.count[0].total
        const patients = data.results

        this.patientsTotalNumber = totalCount
        this.patients = patients
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'findPatients', response: response})
      })
    },
    deletePatient (patientId) {
      patientId = patientId || 0

      return http.delete(endpoints.patients.destroyForDoctor + '/' + patientId)
    },
    findPatients (
      patientId,
      type,
      pageNumber,
      patientsPerPage,
      letter,
      sortColumn,
      sortDir
    ) {
      let data = {
        patientId: patientId || 0,
        type: type || 0,
        page: pageNumber || 0,
        patientsPerPage: patientsPerPage || 0,
        letter: letter || '',
        sortColumn: sortColumn || '',
        sortDir: sortDir || ''
      }

      return http.post(endpoints.patients.find, data)
    }
  }
}
