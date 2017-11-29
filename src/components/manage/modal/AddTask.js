import Datepicker from 'vuejs-datepicker'
import symbols from '../../../symbols'

export default {
  data () {
    return {
      currentTask: {
        id: 0,
        task: '',
        dueDate: null,
        status: false,
        responsible: this.$store.state.main[symbols.state.userInfo].plainUserId,
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
    }
  }
}
