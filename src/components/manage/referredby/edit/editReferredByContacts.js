var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'edit-referred-by-contacts',
  data () {
    return {
      message: '',
      componentParams: {
        contactId: 0,
        addToPatient: 0,
        from: ''
      },
      contact: {
        salutation: 'default'
      },
      qualifiers: []
    }
  },
  mixins: [handlerMixin],
  watch: {
    'contact': {
      handler: function () {
        // some field was changed
        this.$parent.popupEdit = true
      },
      deep: true
    }
  },
  computed: {
    buttonText () {
      return this.componentParams.contactId > 0 ? 'Edit' : 'Add'
    }
  },
  created () {
    eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // no one field was edited
    this.$parent.popupEdit = false
  },
  mounted () {
    this.getActiveQualifiers()
      .then(function (response) {
        var data = response.data.data

        if (data.length) {
          this.qualifiers = data
        }
      }, function (response) {
        this.handleErrors('getActiveQualifiers', response)
      })
  },
  beforeDestroy () {
    eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getReferredByContact(this.componentParams.contactId)
        .then(function (response) {
          this.contact = response.data.data
        }, function (response) {
          this.handleErrors('getReferredByContact', response)
        })
    },
    onSubmit () {
      // add validation

      this.editContact(this.componentParams.contactId, this.contact)
        .then(function (response) {
          var data = response.data.data;

          if (data.status) {
            alert(data.status);
          }

          if (this.componentParams.addToPatient) {
            // redirect to 'add_patient.php?ed=<?php echo $addedtopat;?>'
          } else {
            // redirect to 'manage_referredby.php?msg=<?php echo $msg;?>'
          }

          if (this.componentParams.from == 'flowsheet3') {
            // redirect to "/manage/manage_flowsheet3.php?pid=<?php echo $addedtopat; ?>&refid=<?php echo $rid; ?>"
          }
        }, function (response) {
          this.parseFailedResponseOnEditingContact(response.data.data)

          this.handleErrors('editContact', response)
        });
    },
    parseFailedResponseOnEditingContact (data) {
      var errors = data.errors.shift()

      if (errors != undefined) {
        var objKeys = Object.keys(errors)

        var arrOfMessages = objKeys.map((el) => {
          return el + ':' + errors[el].join('|').toLowerCase()
        })

        // TODO: create more readable format
        alert(arrOfMessages.join("\n"))
      }
    },
    getReferredByContact (id) {
      return this.$http.get(process.env.API_PATH + 'referred-by-contacts/' + id)
    },
    getActiveQualifiers () {
      return this.$http.post(process.env.API_PATH + 'qualifiers/active')
    },
    editContact (contactId, contactFormData) {
      contactId = contactId || 0;

      var data = {
        contact_form_data: contactFormData
      }

      return this.$http.post(process.env.API_PATH + 'referred-by-contacts/edit/' + contactId, data)
    }
  }
}
