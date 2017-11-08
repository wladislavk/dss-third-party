import ScriptLoader from '../services/ScriptLoader'

export default {
  mounted () {
    ScriptLoader.loadScriptFrom(
      'https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf',
      '#siteseal',
      window.verifySeal,
      window.seal_installSeal,
      this.$el
    )
  }
}
