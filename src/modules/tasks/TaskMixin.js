module.exports = {
  methods: {
    onMouseEnterTaskItem (event) {
      // get id from .task_status element
      const id = event.target.children[1].value || 0

      event.target.children['task_extra_' + id].style.display = 'block'
    },
    onMouseLeaveTaskItem (event) {
      // get id from .task_status element
      const id = event.target.children[1].value || 0

      event.target.children['task_extra_' + id].style.display = 'none'
    },
    onClickTaskStatus (event) {
      const id = event.target.value || 0
      let taskType = ''
      const isDashboardTaskList = (
          event.target.parentElement.parentElement.parentElement.id === 'index_task_list'
        )

      if (isDashboardTaskList) {
        taskType = event.target.parentElement.parentElement.className
      } else {
        taskType = event.target.parentElement.parentElement.id
      }

      this.updateTaskToActive(id)
        .then(function () {
          this.removeItemFromTaskList(taskType, id, isDashboardTaskList)
        }, function (response) {
          console.error('updateTaskToActive [status]: ', response.status)
        })
    },
    onClickDeleteTask (id, event) {
      event.preventDefault()

      let taskType = ''
      const isDashboardTaskList = (
          event.target.parentElement.parentElement.parentElement.parentElement.id === 'index_task_list'
        )

      if (isDashboardTaskList) {
        taskType = event.target.parentElement.parentElement.parentElement.className
      } else {
        taskType = event.target.parentElement.parentElement.parentElement.id
      }

      if (confirm('Are you sure you want to delete this task?')) {
        id = id || 0

        this.deleteTask(id)
          .then(function () {
            this.removeItemFromTaskList(taskType, id, isDashboardTaskList)
          }, function (response) {
            console.error('deleteTask [status]: ', response.status)
          })
      }
    },
    updateTaskToActive (id) {
      id = id || 0

      const data = {
        status: 1
      }

      return this.$http.put(process.env.API_PATH + 'tasks/' + id, data)
    },
    deleteTask (id) {
      id = id || 0

      return this.$http.delete(process.env.API_PATH + 'tasks/' + id)
    },
    removeItemFromTaskList (type, id, isDashboardTaskList) {
      let patientTask = false
      id = id || 0
      isDashboardTaskList = isDashboardTaskList || false

      switch (type) {
        case 'task_od_list':
          if (isDashboardTaskList) {
            this.headerInfo.overdueTasks.$remove(
              this.searchItemById(this.headerInfo.overdueTasks, id)
            )
            patientTask = true
          } else {
            this.overdueTasks.$remove(this.searchItemById(this.overdueTasks, id))
          }
          break
        case 'task_tod_list':
          if (isDashboardTaskList) {
            this.headerInfo.todayTasks.$remove(
              this.searchItemById(this.headerInfo.todayTasks, id)
            )
            patientTask = true
          } else {
            this.todayTasks.$remove(this.searchItemById(this.todayTasks, id))
          }
          break
        case 'task_tom_list':
          if (isDashboardTaskList) {
            this.headerInfo.tomorrowTasks.$remove(
              this.searchItemById(this.headerInfo.tomorrowTasks, id)
            )
            patientTask = true
          } else {
            this.tomorrowTasks.$remove(this.searchItemById(this.tomorrowTasks, id))
          }
          break
        case 'task_tw_list':
          if (isDashboardTaskList) {
            this.headerInfo.thisWeekTasks.$remove(
              this.searchItemById(this.headerInfo.thisWeekTasks, id)
            )
            patientTask = true
          } else {
            this.thisWeekTasks.$remove(this.searchItemById(this.thisWeekTasks, id))
          }
          break
        case 'task_nw_list':
          if (isDashboardTaskList) {
            this.headerInfo.nextWeekTasks.$remove(
              this.searchItemById(this.headerInfo.nextWeekTasks, id)
            )
            patientTask = true
          } else {
            this.nextWeekTasks.$remove(this.searchItemById(this.nextWeekTasks, id))
          }
          break
        case 'task_lat_list':
          if (isDashboardTaskList) {
            this.headerInfo.laterTasks.$remove(
              this.searchItemById(this.headerInfo.laterTasks, id)
            )
            patientTask = true
          } else {
            this.laterTasks.$remove(this.searchItemById(this.laterTasks, id))
          }
          break
        // patient tasks from header
        case 'pat_task_od_list':
          this.headerInfo.overdueTasks.$remove(
            this.searchItemById(this.headerInfo.overdueTasks, id)
          )
          patientTask = true
          break
        case 'pat_task_tod_list':
          this.headerInfo.todayTasks.$remove(
            this.searchItemById(this.headerInfo.todayTasks, id)
          )
          patientTask = true
          break
        case 'pat_task_tom_list':
          this.headerInfo.tomorrowTasks.$remove(
            this.searchItemById(this.headerInfo.tomorrowTasks, id)
          )
          patientTask = true
          break
        case 'pat_task_fut_list':
          this.futureTasks.$remove(
            this.searchItemById(this.futureTasks, id)
          )
          patientTask = true
          break
      }

      if (!patientTask) {
        this.$set(this.headerInfo, 'tasksNumber', --this.headerInfo.tasksNumber)
      } else {
        this.$set(this.headerInfo, 'patientTaskNumber', --this.headerInfo.patientTaskNumber)
      }
    },
    searchItemById (data, id) {
      id = id || 0
      let removeId = -1

      // need to optimize: if we find removeId then will break from the loop
      data.forEach(function (task, index) {
        if (task.id === id) {
          removeId = index
        }
      })

      if (removeId >= 0) {
        return data[removeId]
      }
      return null
    }
  }
}
