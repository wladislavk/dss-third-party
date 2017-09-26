export default {
  name: 'app',
  computed: {
    loadManageTemplate: function () {
      // const load = this.$route.matched.some(record => record.meta.requiresManageTemplate)
      return false
    }
  },
  beforeCreate () {
    window.$('body')
      .css('margin-top', 0)
      .css('margin-left', 0)
      .css('margin-right', 0)
      .css('margin-bottom', 0)
  },
  created () {
    // add main template style
    if (this.$route.name.indexOf('screener') === -1) {
      window.$('body').addClass('main-template')
    }
  }
}
