import Alerter from '../../../services/Alerter'
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
      this.$store.dispatch(symbols.actions.updateTaskStatus, this.task.id).then(() => {
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
      this.$store.dispatch(symbols.actions.deleteTask, this.task.id)
    },
    onClickTaskPopup (taskId) {
      const modalData = {
        name: symbols.modals.addTask,
        params: {
          id: taskId,
          patientId: 0
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    }
  }
}
