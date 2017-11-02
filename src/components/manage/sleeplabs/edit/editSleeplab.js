import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import phoneFilters from '../../../../modules/filters/phoneMixin'
import sleeplabValidator from '../../../../modules/validators/SleeplabMixin'
import AwesomeMask from 'awesome-mask'
import symbols from '../../../../symbols'
import alerter from '../../../../services/alerter'

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
  mixins: [phoneFilters, sleeplabValidator],
  directives: {
    mask: AwesomeMask
  },
  watch: {
    'sleeplab': {
      handler: function () {
        // we are editing some sleeplab and current sleeplab data has already fetched
        if (this.componentParams.sleeplabId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false
          this.$parent.popupEdit = true
        } else if (this.componentParams.sleeplabId === 0) { // we are creating a new contact
          this.$parent.popupEdit = true
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
    this.$parent.popupEdit = false
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onClickDeleteSleeplab (sleeplabId) {
      const confirmText = 'Do Your Really want to Delete?'
      if (confirm(confirmText)) {
        this.$parent.disable()

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

          this.$parent.popupEdit = false

          if (data.status) {
            this.$parent.updateParentData({ message: data.status })
            this.$parent.disable()
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
        alerter.alert(arrOfMessages.join('\n'))
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
              data[el] = this.phoneForDisplaying(data[el])
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
          sleeplabFormData[el] = this.phoneForStoring(sleeplabFormData[el])
        }
      })

      const data = {
        sleeplab_form_data: sleeplabFormData
      }

      return http.post(endpoints.sleeplabs.edit + '/' + sleeplabId, data)
    }
  }
}
