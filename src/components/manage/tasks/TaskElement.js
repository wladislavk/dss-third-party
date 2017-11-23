import Alerter from '../../../services/Alerter'
import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'

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
      if (!event.target.checked) {
        // normally, component should not exist at this point but these lines are needed for
        // handling non-standard behavior and testing
        event.target.checked = true
        return
      }
      const checkbox = event.target
      this.updateTaskToActive().then(() => {
        this.removeItemFromTaskList()
        // component should be destroyed as a result of re-computing tasks on parent
      }).catch((response) => {
        console.error('updateTaskToActive [status]: ' + response.response.status)
        // allow to try again; preventDefault() cannot be used because of async
        checkbox.checked = false
      })
    },
    onClickDeleteTask () {
      const confirmText = 'Are you sure you want to delete this task?'
      if (!Alerter.isConfirmed(confirmText)) {
        return
      }
      http.delete(endpoints.tasks.destroy + '/' + this.task.id).then(() => {
        this.removeItemFromTaskList()
      }).catch((response) => {
        console.error('deleteTask [status]: ' + response.response.status)
      })
    },
    onClickTaskPopup (taskId) {
      const modalData = {
        name: 'add-task',
        params: {
          id: taskId
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
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
