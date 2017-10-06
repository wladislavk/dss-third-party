import TaskElementComponent from './TaskElement.vue'

export default {
  props: {
    tasks: {
      type: Array,
      required: true
    },
    taskCode: {
      type: String,
      required: true
    },
    taskType: {
      type: String,
      required: true
    },
    redHeader: {
      type: Boolean,
      default: false
    },
    dueDate: {
      type: Boolean,
      default: false
    },
    isPatient: {
      type: Boolean,
      required: true
    }
  },
  components: {
    taskElement: TaskElementComponent
  }
}
