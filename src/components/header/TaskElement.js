import alerter from '../../services/alerter'
import endpoints from '../../endpoints'
import http from '../../services/http'

export default {
  props: {
    task: {
      type: Object,
      required: true
    },
    dueDate: {
      type: Boolean,
      required: true
    },
    isPatient: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      isVisible: false
    }
  },
  methods: {
    onMouseEnterTaskItem () {
      this.isVisible = true
    },
    onMouseLeaveTaskItem () {
      this.isVisible = false
    },
    onClickTaskStatus (event) {
      let taskType = ''
      const isDashboardTaskList = (
        event.target.parentElement.parentElement.parentElement.id === 'index_task_list'
      )

      const grandparent = event.target.parentElement.parentElement
      taskType = grandparent.id
      if (isDashboardTaskList) {
        taskType = grandparent.className
      }

      this.updateTaskToActive().then(() => {
        this.removeItemFromTaskList(taskType, this.task.id, isDashboardTaskList)
      }).catch((response) => {
        console.error('updateTaskToActive [status]: ', response.status)
      })
    },
    onClickDeleteTask (event) {
      event.preventDefault()

      let taskType = ''
      const isDashboardTaskList = (
        event.target.parentElement.parentElement.parentElement.parentElement.id === 'index_task_list'
      )

      const greatGrandparent = event.target.parentElement.parentElement
      taskType = greatGrandparent.id
      if (isDashboardTaskList) {
        taskType = greatGrandparent.className
      }

      const confirmText = 'Are you sure you want to delete this task?'
      if (alerter.isConfirmed(confirmText)) {
        this.deleteTask(this.task.id).then(() => {
          this.removeItemFromTaskList(taskType, isDashboardTaskList)
        }).catch((response) => {
          console.error('deleteTask [status]: ', response.status)
        })
      }
    },
    deleteTask (id) {
      id = id || 0

      return http.delete(endpoints.tasks.destroy + '/' + id)
    },
    updateTaskToActive () {
      const data = {
        status: 1
      }
      return http.put(endpoints.tasks.update + '/' + this.task.id, data)
    },
    removeItemFromTaskList (type, isDashboardTaskList) {
      let patientTask = false
      isDashboardTaskList = isDashboardTaskList || false

      switch (type) {
        case 'task_od_list':
          if (isDashboardTaskList) {
            this.headerInfo.overdueTasks.$remove(this.searchItemById(this.headerInfo.overdueTasks))
            patientTask = true
          } else {
            this.overdueTasks.$remove(this.searchItemById(this.overdueTasks))
          }
          break
        case 'task_tod_list':
          if (isDashboardTaskList) {
            this.headerInfo.todayTasks.$remove(this.searchItemById(this.headerInfo.todayTasks))
            patientTask = true
          } else {
            this.todayTasks.$remove(this.searchItemById(this.todayTasks))
          }
          break
        case 'task_tom_list':
          if (isDashboardTaskList) {
            this.headerInfo.tomorrowTasks.$remove(this.searchItemById(this.headerInfo.tomorrowTasks))
            patientTask = true
          } else {
            this.tomorrowTasks.$remove(this.searchItemById(this.tomorrowTasks))
          }
          break
        case 'task_tw_list':
          if (isDashboardTaskList) {
            this.headerInfo.thisWeekTasks.$remove(this.searchItemById(this.headerInfo.thisWeekTasks))
            patientTask = true
          } else {
            this.thisWeekTasks.$remove(this.searchItemById(this.thisWeekTasks))
          }
          break
        case 'task_nw_list':
          if (isDashboardTaskList) {
            this.headerInfo.nextWeekTasks.$remove(this.searchItemById(this.headerInfo.nextWeekTasks))
            patientTask = true
          } else {
            this.nextWeekTasks.$remove(this.searchItemById(this.nextWeekTasks))
          }
          break
        case 'task_lat_list':
          if (isDashboardTaskList) {
            this.headerInfo.laterTasks.$remove(this.searchItemById(this.headerInfo.laterTasks))
            patientTask = true
          } else {
            this.laterTasks.$remove(this.searchItemById(this.laterTasks))
          }
          break
        // patient tasks from header
        case 'pat_task_od_list':
          this.headerInfo.overdueTasks.$remove(this.searchItemById(this.headerInfo.overdueTasks))
          patientTask = true
          break
        case 'pat_task_tod_list':
          this.headerInfo.todayTasks.$remove(this.searchItemById(this.headerInfo.todayTasks))
          patientTask = true
          break
        case 'pat_task_tom_list':
          this.headerInfo.tomorrowTasks.$remove(this.searchItemById(this.headerInfo.tomorrowTasks))
          patientTask = true
          break
        case 'pat_task_fut_list':
          this.futureTasks.$remove(this.searchItemById(this.futureTasks))
          patientTask = true
          break
      }

      if (patientTask) {
        this.$set(this.headerInfo, 'patientTaskNumber', --this.headerInfo.patientTaskNumber)
      } else {
        this.$set(this.headerInfo, 'tasksNumber', --this.headerInfo.tasksNumber)
      }
    },
    searchItemById (data) {
      for (let task of data) {
        if (task.id === this.task.id) {
          return task
        }
      }
      return null
    }
  }
}
