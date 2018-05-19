/* eslint-env browser */
/* global Vue */
/* global apiRoot */
(function () {
  var apiPath = apiRoot + 'api/v1/transaction-codes'

  var TransactionCodesSelectorComponent = Vue.extend({
    replace: true,
    template: '<style>.diagnosis-codes-selector select { width: 160px; }</style>' +
      '<div class="diagnosis-codes-selector">' +
        '<table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">' +
          '<tr>' +
            '<th colspan="2">' +
              '{{ codeType | capitalize }} Codes <img alt="Loading..." src="/manage/images/loading.gif" v-if="!loaded" />' +
            '</th>' +
          '</tr>' +
          '<tr>' +
            '<td>' +
              '<select v-model="selection[0].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy sortBy"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
            '<td>' +
              '<select v-model="selection[1].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy \'sortby\'"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
          '</tr>' +
          '<tr>' +
            '<td>' +
              '<select v-model="selection[2].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy \'sortby\'"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
            '<td>' +
              '<select v-model="selection[3].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy \'sortby\'"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
          '</tr>' +
          '<tr>' +
            '<td>' +
              '<select v-model="selection[4].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy \'sortby\'"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
            '<td>' +
              '<select v-model="selection[5].value">' +
                '<option></option>' +
                '<option v-for="code in codes | filterBy codeTypeFilter | orderBy \'sortby\'"' +
                  ' v-bind:value="code.transaction_code">' +
                  '[{{ code.transaction_code }}] {{ code.description }}' +
                '</option>' +
              '</select>' +
            '</td>' +
          '</tr>' +
        '</table>' +
      '</div>',
    data: function () {
      return {
        selection: [
          { value: '' },
          { value: '' },
          { value: '' },
          { value: '' },
          { value: '' },
          { value: '' }
        ],
        codes: [],
        apiEndPoint: apiPath,
        busy: false,
        loaded: false
      }
    },
    props: {
      selector: {
        twoWay: true
      },
      patientId: {
        type: String,
        default: 0
      },
      patientKey: {
        type: String,
        default: 'patient_id'
      },
      codeType: {
        type: String,
        default: 'treatment'
      }
    },
    watch: {
      selection: {
        handler: 'updateSelector',
        deep: true
      },
      selector: {
        handler: 'updateSelection',
        deep: true
      }
    },
    methods: {
      codeTypeFilter: function (object) {
        var type

        try {
          type = parseInt(object.type)
        } catch (e) {
          type = 0
        }

        switch (type) {
          case 1:
            return this.codeType === 'treatment'
          case 2:
          case 3:
            return false
          case 4:
            return this.codeType === 'diagnosis'
          default:
            return false
        }
      },
      sortBy: function (object) {
        var sort

        try {
          sort = parseInt(object.sortby)
        } catch (e) {
          sort = 0
        }

        return -sort
      },
      updateSelector: function () {
        var index

        if (this.busy) {
          return
        }

        this.busy = true

        for (index = 0; index < 6; index++) {
          this.$set('selector[' + index + ']', this.selection[index].value)
        }

        this.busy = false
      },
      updateSelection: function () {
        var index

        if (this.busy) {
          return
        }

        this.busy = true

        for (index = 0; index < 6; index++) {
          this.$set('selection[' + index + '].value', this.selector[index])
        }

        this.busy = false
      }
    },
    ready: function () {
      var options = {}

      /**
       * These references need a function wrapper, or they won't be testable
       */
      this.$http.get(this.apiEndPoint + '?' + this.patientKey + '=' + this.patientId, options)
        .then(function (response) {
          var data = {}

          try {
            data = response.json()
          } catch (e) {}

          if (typeof data.data === 'object') {
            this.$set('loaded', true)
            this.$set('codes', data.data)
            this.updateSelection()
          }
        }, function () {})
    }
  })

  Vue.component('transaction-codes-selector', TransactionCodesSelectorComponent)
}())
