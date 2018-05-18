/* global apiRoot */
var EndpointPermissionsFormMixin = {
  data: function () {
    return {
      namespace: 'mixin',
      version: '20180518',
      listenerOnly: false,
      forceFirstLoad: false,
      groupsApiPath: apiRoot + 'api/v1/api-permission/groups',
      permissionsApiPath: apiRoot + 'api/v1/api-permission/all',
      timeout: 60,
      requests: 0,
      groups: {},
      userPermissions: {},
      patientPermissions: {},
      resources: {}
    }
  },
  props: {
    patientId: {
      type: Number,
      default: 0
    },
    docId: {
      type: Number,
      default: 0
    }
  },
  methods: {
    $redraw: function () {
      this.$set('forceRedraw', 0)
      this.$delete('forceRedraw')
    },
    indexResources: function () {
      for (var n in this.groups) {
        if (!this.groups.hasOwnProperty(n)) {
          continue
        }
        for (var m in this.groups[n].resources) {
          if (!this.groups[n].resources.hasOwnProperty(m)) {
            continue
          }
          var resource = this.groups[n].resources[m]
          this.resources[resource.slug] = resource
        }
      }
    },
    getResponseData: function (response) {
      try {
        return response.json()
      } catch (e) {
        return {}
      }
    },
    onLoadSuccess: function () {
      this.requests++
      if (this.requests < 3) {
        return
      }
      for (var n in this.groups) {
        if (!this.groups.hasOwnProperty(n)) {
          continue
        }
        if (this.groups[n].authorize_per_user && this.groups[n].authorize_per_patient) {
          if (this.patientPermissions.hasOwnProperty(n)) {
            this.patientPermissions[n].enabled = true
            continue
          }
          this.patientPermissions[n] = {
            group_id: n,
            enabled: false
          }
          continue
        }
        if (this.groups[n].authorize_per_user) {
          if (this.userPermissions.hasOwnProperty(n)) {
            this.userPermissions[n].enabled = true
            continue
          }
          this.userPermissions[n] = {
            group_id: n,
            enabled: false
          }
        }
      }
      this.indexResources()
      this.setInStorage('groups', this.groups)
      this.setInStorage('userPermissions', this.userPermissions, this.docId)
      this.setInStorage('patientPermissions', this.patientPermissions, this.patientId)
      this.$redraw()
    },
    clearStorage: function (key) {
      try {
        window.localStorage.removeItem('Vue.endpoint.' + key)
      } catch (e) { /* Fall through */ }
    },
    getFromStorage: function (key, id) {
      id = id || 0
      try {
        var item = window.localStorage.getItem('Vue.endpoint.' + key)
        var object = JSON.parse(item)
        var elapsedTime = ((new Date()).getTime() / 1000 - object.timestamp) / 60

        if (object.version === this.version && elapsedTime < this.timeout && object.id === id) {
          return object.data
        }
      } catch (e) {
        return null
      }

      return null
    },
    setInStorage: function (key, data, id) {
      try {
        var item = {
          version: this.version,
          timestamp: (new Date()).getTime() / 1000,
          id: id || 0,
          data: data
        }
        item = JSON.stringify(item)
        window.localStorage.setItem('Vue.endpoint.' + key, item)
      } catch (e) { /* Fall through */ }
    },
    loadFromLocalStorage: function () {
      var groups = null
      var userPermissions = null
      var patientPermissions = null
      try {
        groups = this.getFromStorage('groups')
        userPermissions = this.getFromStorage('userPermissions', this.docId)
        patientPermissions = this.getFromStorage('patientPermissions', this.patientId)
      } catch (e) { /* Fall through */ }
      if (groups === null || userPermissions === null || patientPermissions === null) {
        this.clearStorage('groups')
        this.clearStorage('userPermissions')
        this.clearStorage('patientPermissions')
        return false
      }
      this.$set('groups', groups)
      this.$set('userPermissions', userPermissions)
      this.$set('patientPermissions', patientPermissions)
      this.indexResources()
      this.$redraw()
      return true
    },
    loadFromApi: function () {
      var self = this
      this.requests = 0
      this.$http
        .get(this.groupsApiPath)
        .then(function (response) {
          var data = self.getResponseData(response)
          self.$set('groups', data.data)
          self.onLoadSuccess()
        }, function () {})

      setTimeout(function () {
        self.$http
          .get(self.permissionsApiPath)
          .then(function (response) {
            var data = self.getResponseData(response)
            self.$set('userPermissions', data.data)
            self.onLoadSuccess()
          }, function () {})
      }, 300)

      setTimeout(function () {
        self.$http
          .get(self.permissionsApiPath + '?patient_id=' + self.patientId)
          .then(function (response) {
            var data = self.getResponseData(response)
            self.$set('patientPermissions', data.data)
            self.onLoadSuccess()
          }, function () {})
      }, 300 * 2)
    },
    listener: function () {
      var self = this
      setInterval(self.loadFromLocalStorage, 2500)
    },
    asListener: function () {
      var self = this
      setTimeout(self.listener, 1000)
    }
  },
  ready: function () {
    if (this.listenerOnly) {
      this.asListener()
      return
    }

    if (this.forceFirstLoad) {
      this.loadFromApi()
      return
    }

    var loaded = this.loadFromLocalStorage()

    if (!loaded) {
      this.loadFromApi()
    }
  }
}
