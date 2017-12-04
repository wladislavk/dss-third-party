import Datepicker from 'vuejs-datepicker'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'
import LocationWrapper from '../../../wrappers/LocationWrapper'

export default {
  data () {
    return {
      currentTask: {
        id: 0,
        task: '',
        dueDate: null,
        status: false,
        responsible: this.$store.state.main[symbols.state.userInfo].plainUserId,
        patientId: 0,
        patientName: ''
      },
      validationError: ''
    }
  },
  computed: {
    task () {
      return this.$store.state.tasks[symbols.state.currentTask]
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    userList () {
      return this.$store.state.tasks[symbols.state.responsibleUsers]
    }
  },
  components: {
    datepicker: Datepicker
  },
  created () {
    this.$store.dispatch(symbols.actions.responsibleUsers)
    const taskId = this.$store.state.main[symbols.state.modal].params.id
    if (taskId) {
      this.$store.dispatch(symbols.actions.getTask, taskId).then(() => {
        this.currentTask = this.task
      })
    }
  },
  methods: {
    onSubmit () {
      this.$store.dispatch(symbols.actions.addTask, this.currentTask).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      }).catch((response) => {
        if (response.hasOwnProperty('message')) {
          this.validationError = response.message
        }
      })
    },
    onDelete () {
      const confirmText = 'Are you sure you want to delete this task?'
      if (!Alerter.isConfirmed(confirmText)) {
        return
      }
      this.$store.dispatch(symbols.actions.deleteTask, this.currentTask.id).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
        LocationWrapper.goToLegacyPage('manage/manage_tasks.php', this.$store.state.main[symbols.state.mainToken])
      })
    }
  }
}
