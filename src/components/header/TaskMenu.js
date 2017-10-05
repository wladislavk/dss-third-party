import endpoints from '../../endpoints'
import http from '../../services/http'
import handlerMixin from '../../modules/handler/HandlerMixin'
import TaskDataComponent from './TaskData.vue'

export default {
  data () {
    return {
      tasksNumber: 0,
      overdueTasks: [],
      todayTasks: [],
      tomorrowTasks: [],
      thisWeekTasks: [],
      nextWeekTasks: [],
      laterTasks: [],
      showTaskList: false
    }
  },
  components: {
    taskData: TaskDataComponent
  },
  mixins: [handlerMixin],
  created () {
    http.post(endpoints.tasks.all).then((response) => {
      const data = response.data.data
      if (data) {
        this.tasksNumber = data.length
      }
    }).catch((response) => {
      this.handleErrors('getTasks', response)
    })
    http.post(endpoints.tasks.overdue).then((response) => {
      const data = response.data.data
      if (data) {
        this.overdueTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getOverdueTasks', response)
    })
    http.post(endpoints.tasks.today).then((response) => {
      const data = response.data.data
      if (data) {
        this.todayTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getTodayTasks', response)
    })
    http.post(endpoints.tasks.tomorrow).then((response) => {
      const data = response.data.data
      if (data) {
        this.tomorrowTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getTomorrowTasks', response)
    })
    http.post(endpoints.tasks.thisWeek).then((response) => {
      const data = response.data.data
      if (data) {
        this.thisWeekTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getThisWeekTasks', response)
    })
    http.post(endpoints.tasks.nextWeek).then((response) => {
      const data = response.data.data
      if (data) {
        this.nextWeekTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getNextWeekTasks', response)
    })
    http.post(endpoints.tasks.later).then((response) => {
      const data = response.data.data
      if (data) {
        this.laterTasks = data
      }
    }).catch((response) => {
      this.handleErrors('getLaterTasks', response)
    })
  }
}
