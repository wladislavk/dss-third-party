import symbols from '../../../symbols'

export default {
  data () {
    return {
      task: '',
      status: false,
      responsible: this.$store.state.main[symbols.state.userInfo].plainUserId,
      userList: this.$store.state.tasks[symbols.state.responsibleUsers]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.responsibleUsers)
  },
  methods: {
    onSubmit () {
      const data = {
        task: this.task,
        status: parseInt(this.status),
        responsibleid: this.responsible
      }
      this.$store.dispatch(symbols.actions.addTask, data).then(() => {
        // @todo
      })
    }
  }
}
