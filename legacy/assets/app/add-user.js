Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value

var userId = $('[name=ed]').val()
var docId = $('[name=docid]').val()
var externalApiPath = apiRoot + 'api/v1/external-user/'
var permissionsApiPath = apiRoot + 'api/v1/api-permission/all?sudo_id='
var groupsApiPath = apiRoot + 'api/v1/api-permission/groups?sudo_id='

var user = new Vue({
  el: '#add-user-form',
  data: {
    fields: {
      id: 0,
      user_id: userId,
      api_key: '',
      valid_from: '',
      valid_to: '',
      enabled: false
    },
    requests: 0,
    docId: +docId || +userId,
    permissions: [],
    groups: []
  },
  methods: {
    checkBox: function (selector) {
      var $checkbox = $(selector)
        .find(':checkbox')

      $checkbox.prop('checked', true)
        .closest('span')
        .addClass('checked')
    },
    onSaved: function () {
      this.requests--

      if (this.requests > 0) {
        return
      }

      this.$el.submit()
    },
    onDeleted: function (e) {
      this.requests--

      if (this.requests > 0) {
        return
      }

      if (e.target && e.target.href) {
        window.location = e.target.href
      }
    },
    saveUser: function (e) {
      e.preventDefault()

      if (typeof userabc_warn !== 'undefined' && !userabc_warn(this.$el)) {
        return
      }

      var method = this.fields.id ? 'put' : 'post'
      var id = this.fields.id ? userId : ''
      var self = this
      this.requests = 2

      this.$http.post(permissionsApiPath + userId, { permissions: this.permissions })
        .always(self.onSaved)

      setTimeout(function () {
        self.$http[method](externalApiPath + id, self.fields)
          .always(self.onSaved)
      }, 300)
    },
    deleteUser: function (e) {
      e.preventDefault()

      if (!confirm('Do your really want to delete this user?')) {
        return
      }

      var self = this
      this.requests = 2

      for (var n in this.permissions) {
        if (this.permissions.hasOwnProperty(n)) {
          this.permissions[n].enabled = false
        }
      }

      this.$http.post(permissionsApiPath + userId, { permissions: this.permissions })
        .always(function () {
          self.onDeleted(e)
        })

      setTimeout(function () {
        self.$http
          .delete(externalApiPath + userId)
          .always(function () {
            self.onDeleted(e)
          })
      }, 300)
    },
    generateApiKey: function (fields) {
      function guid () {
        function s4 () {
          return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1)
        }

        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
          s4() + '-' + s4() + s4() + s4()
      }
      fields.api_key = guid()
    },
    onSuccess: function () {
      this.requests++

      if (this.requests < 3) {
        return
      }

      for (var groupId in this.groups) {
        if (!this.groups.hasOwnProperty(groupId)) {
          continue
        }
        if (this.permissions.hasOwnProperty(groupId)) {
          this.permissions[groupId].enabled = true
          continue
        }
        this.permissions[groupId] = {
          group_id: groupId,
          enabled: false
        }
      }

      setTimeout(function () {
        $('#api-permissions-container')
          .find(':checkbox')
          .uniform()
      }, 300)

      if (this.fields.enabled) {
        this.checkBox('#dentrix-api-checkbox')
      }

      for (var n = 0; n < this.groups.length; n++) {
        if (this.permissions[this.groups[n].id]) {
          this.checkBox('#api-permissions-container [value=' + this.groups[n].id + ']')
        }
      }
    },
    onReady: function() {
      var self = this

      this.$http
        .get(externalApiPath + userId)
        .then(function (response) {
          self.$set('fields', response.data.data)
          self.onSuccess()
        }, self.onSuccess)

      setTimeout(function () {
        self.$http
          .get(permissionsApiPath + userId)
          .then(function (response) {
            self.$set('permissions', response.data.data)
            self.onSuccess()
          }, self.onSuccess)
      }, 300)

      setTimeout(function () {
        self.$http
          .get(groupsApiPath + userId)
          .then(function (response) {
            self.$set('groups', response.data.data)
            self.onSuccess()
          }, self.onSuccess)
      }, 300 * 2)
    }
  },
  ready: function() {
    this.onReady()
  }
})

window.VueModules = window.VueModules || []
window.VueModules.push(user)
