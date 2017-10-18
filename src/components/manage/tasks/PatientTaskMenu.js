import symbols from '../../../symbols'
import { TASK_TYPES } from '../../../constants'
import TaskDataComponent from './TaskData.vue'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      showTaskList: false
    }
  },
  computed: {
    tasksNumber () {
      return this.$store.getters[symbols.getters.tasksPatientNumber]
    },
    overdueTasks () {
      return this.$store.getters[symbols.getters.tasksPatientByType](TASK_TYPES.OVERDUE)
    },
    todayTasks () {
      return this.$store.getters[symbols.getters.tasksPatientByType](TASK_TYPES.TODAY)
    },
    tomorrowTasks () {
      return this.$store.getters[symbols.getters.tasksPatientByType](TASK_TYPES.TOMORROW)
    },
    futureTasks () {
      return this.$store.getters[symbols.getters.tasksPatientByType](TASK_TYPES.FUTURE)
    }
  },
  components: {
    taskData: TaskDataComponent
  },
  mounted () {
    this.$store.dispatch(symbols.actions.retrieveTasksForPatient, this.patientId)
  },
  watch: {
    patientId: function (value) {
      this.$store.dispatch(symbols.actions.retrieveTasksForPatient, value)
    }
  }
}
