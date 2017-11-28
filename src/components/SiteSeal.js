import ScriptLoader from '../services/ScriptLoader'

export default {
  mounted () {
    const sealUrl = 'https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf'
    ScriptLoader.loadScriptFrom(sealUrl, 'siteseal')
  }
}
