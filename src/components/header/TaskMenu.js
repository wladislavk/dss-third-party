import { TASK_TYPES } from '../../constants'
import symbols from '../../symbols'
import TaskDataComponent from './TaskData.vue'

export default {
  data () {
    return {
      showTaskList: false
    }
  },
  computed: {
    tasksNumber () {
      return this.$store.getters[symbols.getters.tasksNumber]
    },
    overdueTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.OVERDUE)
    },
    todayTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.TODAY)
    },
    tomorrowTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.TOMORROW)
    },
    thisWeekTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.THIS_WEEK)
    },
    nextWeekTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.NEXT_WEEK)
    },
    laterTasks () {
      return this.$store.getters[symbols.getters.tasksByType](TASK_TYPES.LATER)
    }
  },
  components: {
    taskData: TaskDataComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.retrieveTasks)
  }
}
