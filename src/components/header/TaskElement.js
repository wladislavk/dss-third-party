import alerter from '../../services/alerter'
import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  props: {
    task: {
      type: Object,
      required: true
    },
    taskCode: {
      type: String,
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
    onClickTaskStatus () {
      this.updateTaskToActive().then(() => {
        this.removeItemFromTaskList()
      }).catch((response) => {
        console.error('updateTaskToActive [status]: ', response.status)
      })
    },
    onClickDeleteTask () {
      const confirmText = 'Are you sure you want to delete this task?'
      if (!alerter.isConfirmed(confirmText)) {
        return
      }
      this.deleteTask().then(() => {
        this.removeItemFromTaskList()
      }).catch((response) => {
        console.error('deleteTask [status]: ', response.status)
      })
    },
    deleteTask () {
      return http.delete(endpoints.tasks.destroy + '/' + this.task.id)
    },
    updateTaskToActive () {
      const data = {
        status: 1
      }
      return http.put(endpoints.tasks.update + '/' + this.task.id, data)
    },
    removeItemFromTaskList () {
      if (this.isPatient) {
        this.$store.commit(symbols.mutations.removeTaskForPatient, this.task)
        return
      }
      this.$store.commit(symbols.mutations.removeTask, this.task)
    }
  }
}
