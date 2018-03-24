import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import PhoneFormatter from '../../../../services/PhoneFormatter'
import AwesomeMask from 'awesome-mask'
import symbols from '../../../../symbols'
import Alerter from '../../../../services/Alerter'

export default {
  name: 'edit-sleeplab',
  data () {
    return {
      phoneMask: '(999) 999-9999',
      componentParams: {
        sleeplabId: 0
      },
      sleeplab: {
        salutation: '',
        status: 1
      },
      message: '',
      fullName: '',
      isContactDataFetched: false,
      phoneFields: ['phone1', 'phone2', 'fax']
    }
  },
  directives: {
    mask: AwesomeMask
  },
  watch: {
    'sleeplab': {
      handler: function () {
        // we are editing some sleeplab and current sleeplab data has already fetched
        if (this.componentParams.sleeplabId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false
          this.$store.dispatch(symbols.actions.enablePopupEdit)
        } else if (this.componentParams.sleeplabId === 0) { // we are creating a new contact
          this.$store.dispatch(symbols.actions.enablePopupEdit)
        }

        if (!this.isContactDataFetched) {
          this.isContactDataFetched = true
        }
      },
      deep: true
    }
  },
  computed: {
    buttonText () {
      return this.sleeplab.sleeplabid > 0 ? 'Edit' : 'Add'
    },
    googleLink () {
      const link = 'http://google.com/search?q='
      const requiredFields = [
        'firstname',
        'lastname',
        'company',
        'add1',
        'city',
        'state',
        'zip'
      ]

      const notEmptyRequiredFields = []
      requiredFields.forEach((el) => {
        if (this.sleeplab[el]) {
          notEmptyRequiredFields.push(this.sleeplab[el])
        }
      })

      return link + notEmptyRequiredFields.join('+')
    }
  },
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // no one field was edited
    this.$store.dispatch(symbols.actions.disablePopupEdit)
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onClickDeleteSleeplab (sleeplabId) {
      const confirmText = 'Do Your Really want to Delete?'
      if (Alerter.isConfirmed(confirmText)) {
        this.$store.commit(symbols.mutations.resetModal)
        this.$router.push({
          name: 'sleeplabs',
          query: {
            delid: sleeplabId
          }
        })
      }
    },
    onSubmit () {
      if (this.validateSleeplabData(this.sleeplab)) {
        this.editSleeplab(this.componentParams.sleeplabId, this.sleeplab).then((response) => {
          const data = response.data.data
          this.$store.dispatch(symbols.actions.disablePopupEdit)
          if (data.status) {
            this.$parent.updateParentData({ message: data.status })
            this.$store.commit(symbols.mutations.resetModal)
          }
        }).catch((response) => {
          this.parseFailedResponseOnEditingSleeplab(response.data.data)
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'editSleeplab', response: response})
        })
      }
    },
    parseFailedResponseOnEditingSleeplab (data) {
      const errors = data.errors.shift()

      if (errors !== undefined) {
        const objKeys = Object.keys(errors)

        const arrOfMessages = objKeys.map((el) => {
          return el + ':' + errors[el].join('|').toLowerCase()
        })

        // TODO: create more readable format
        Alerter.alert(arrOfMessages.join('\n'))
      }
    },
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.fetchSleeplab(this.componentParams.sleeplabId)
    },
    fetchSleeplab (id) {
      this.getSleeplab(id).then((response) => {
        const data = response.data.data

        if (data) {
          this.fullName = (data.firstname ? data.firstname + ' ' : '') +
            (data.middlename ? data.middlename + ' ' : '') +
            (data.lastname || '')

          this.phoneFields.forEach(el => {
            if (data.hasOwnProperty(el)) {
              data[el] = PhoneFormatter.phoneForDisplaying(data[el])
            }
          })

          this.sleeplab = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getSleeplab', response: response})
      })
    },
    getSleeplab (id) {
      id = id || 0

      return http.get(endpoints.sleeplabs.show + '/' + id)
    },
    editSleeplab (sleeplabId, sleeplabFormData) {
      // convert phone fields before storing
      this.phoneFields.forEach(el => {
        if (sleeplabFormData.hasOwnProperty(el)) {
          sleeplabFormData[el] = PhoneFormatter.phoneForStoring(sleeplabFormData[el])
        }
      })

      const data = {
        sleeplab_form_data: sleeplabFormData
      }

      return http.post(endpoints.sleeplabs.edit + '/' + sleeplabId, data)
    },
    isEmail (email) {
      return email && email.match(/^[\w.+-]+@\w+\.\w+$/)
    },
    walkThroughMessages (messages, contact) {
      for (let property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (contact[property] === undefined || contact[property].trim() === '') {
            alert(messages[property])
            this.$refs[property].focus()
            return false
          }
        }
      }

      return true
    },
    validateSleeplabData (sleeplab) {
      const messages = {
        company: 'Lab Name is Required',
        firstname: 'Firstname is Required',
        lastname: 'Lastname is Required',
        add1: 'Address1 is Required',
        city: 'City is Required',
        state: 'State is Required',
        zip: 'Zip is Required'
      }

      if (!this.walkThroughMessages(messages, sleeplab)) {
        return false
      }

      if (!this.isEmail(sleeplab.email)) {
        const alertText = 'In-Valid Email'
        alert(alertText)
        this.$refs.email.focus()
        return false
      }

      return true
    }
  }
}
