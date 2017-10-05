import endpoints from '../../endpoints'
import http from '../../services/http'
import handlerMixin from '../../modules/handler/HandlerMixin'
import TaskDataComponent from './TaskData.vue'

export default {
  data () {
    return {
      patientTaskNumber: 0,
      patientTasks: [],
      overdueTasks: [],
      todayTasks: [],
      tomorrowTasks: [],
      futureTasks: []
    }
  },
  components: {
    taskData: TaskDataComponent
  },
  mixins: [handlerMixin],
  created () {
    if (this.$route.query.pid) {
      this.getPatientTasks(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.patientTaskNumber = data.length
        }
      }).then(() => {
        if (this.patientTaskNumber > 0) {
          this.getPatientOverdueTasks(this.$route.query.pid).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.overdueTasks = data
            }
          }).catch((response) => {
            this.handleErrors('getPatientOverdueTasks', response)
          })
          this.getPatientTodayTasks(this.$route.query.pid).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.todayTasks = data
            }
          }).catch((response) => {
            this.handleErrors('getPatientTodayTasks', response)
          })
          this.getPatientTomorrowTasks(this.$route.query.pid).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.tomorrowTasks = data
            }
          }).catch((response) => {
            this.handleErrors('getPatientTomorrowTasks', response)
          })
          this.getPatientFutureTasks(this.$route.query.pid).then((response) => {
            const data = response.data.data
            if (data) {
              this.futureTasks = data
            }
          }).catch((response) => {
            this.handleErrors('getPatientFutureTasks', response)
          })
        }
      }).catch((response) => {
        this.handleErrors('getPatientTasks', response)
      })
    }
  },
  methods: {
    getPatientTasks: function (patientId) {
      patientId = patientId || 0
      return http.post(endpoints.tasks.allForPatient + '/' + patientId)
    },
    getPatientOverdueTasks: function (patientId) {
      patientId = patientId || 0
      return http.post(endpoints.tasks.overdueForPatient + '/' + patientId)
    },
    getPatientTodayTasks: function (patientId) {
      patientId = patientId || 0
      return http.post(endpoints.tasks.todayForPatient + '/' + patientId)
    },
    getPatientTomorrowTasks: function (patientId) {
      patientId = patientId || 0
      return http.post(endpoints.tasks.tomorrowForPatient + '/' + patientId)
    },
    getPatientFutureTasks: function (patientId) {
      patientId = patientId || 0

      return http.post(endpoints.tasks.futureForPatient + '/' + patientId)
    },
    onMouseOverPatientTaskHeader: function (event) {
      event.target.parentElement.children['pat_task_list'].style.display = 'block'
    },
    onMouseLeavePatientTaskMenu: function (event) {
      event.target.children['pat_task_list'].style.display = 'none'
    }
  }
}
