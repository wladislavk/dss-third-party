/* global jQuery */
/* global Vue */
/* global EndpointPermissionsFormMixin */
(function () {
  var SoapPermissions = Vue.extend({
    mixins: [EndpointPermissionsFormMixin],
    computed: {
      isSoapAuthorized: function () {
        var groupId = 0
        for (var n in this.groups) {
          if (!this.groups.hasOwnProperty(n)) {
            continue
          }
          if (this.groups[n].slug === 'soap-notes') {
            groupId = this.groups[n].id
            break
          }
        }
        if (!groupId || !this.userPermissions.hasOwnProperty(groupId)) {
          return false
        }
        return this.userPermissions[groupId].enabled
      }
    }
  })
  var indexSoapPermissions = new SoapPermissions({
    el: '#soap-permissions-index-menu',
    data: {
      namespace: 'permissions',
      forceFirstLoad: true
    }
  })
  var summarySoapPermissions = new SoapPermissions({
    el: '#summ_nav',
    data: {
      namespace: 'permissions',
      forceFirstLoad: true
    }
  })
  var noteSoapPermissions = new SoapPermissions({
    el: '#soap-permissions-note-buttons',
    data: {
      namespace: 'permissions',
      forceFirstLoad: true
    }
  })
  window.VueModules = window.VueModules || []
  window.VueModules.push(indexSoapPermissions)
  window.VueModules.push(summarySoapPermissions)
  window.VueModules.push(noteSoapPermissions)
}(jQuery))
