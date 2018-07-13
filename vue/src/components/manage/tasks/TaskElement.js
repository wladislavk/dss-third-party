import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'

export default {
  props: {
    taskId: {
      type: Number,
      required: true
    },
    task: {
      type: String,
      required: true
    },
    dueDate: {
      validator: function (value) {
        if (value instanceof Date) {
          return true
        }
        if (value === null) {
          return true
        }
        return false
      }
    },
    firstName: {
      type: String,
      default: ''
    },
    lastName: {
      type: String,
      default: ''
    },
    patientId: {
      type: Number,
      default: 0
    },
    hasDueDate: {
      type: Boolean,
      default: false
    },
    isPatient: {
      type: Boolean,
      default: false
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
      this.$store.dispatch(symbols.actions.updateTaskStatus, this.taskId).then(() => {
      }).catch(() => {
        // allow to try again; preventDefault() cannot be used because of async
        checkbox.checked = false
      })
    },
    onClickDeleteTask () {
      const confirmText = 'Are you sure you want to delete this task?'
      if (!Alerter.isConfirmed(confirmText)) {
        return
      }
      this.$store.dispatch(symbols.actions.deleteTask, this.taskId)
    },
    onClickTaskPopup () {
      const modalData = {
        name: symbols.modals.addTask,
        params: {
          id: this.taskId,
          patientId: 0
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    }
  }
}
