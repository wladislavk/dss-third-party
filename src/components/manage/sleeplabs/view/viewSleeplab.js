import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import symbols from '../../../../symbols'

export default {
  data () {
    return {
      componentParam: {
        sleeplabId: 0
      },
      sleeplab: {}
    }
  },
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    this.$store.dispatch(symbols.actions.disablePopupEdit)
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onClickEditSleeplab () {
      const modalData = {
        name: symbols.modals.editSleeplab,
        params: {
          sleeplabId: this.componentParams.sleeplabId || 0
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    },
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.fetchSleeplab(this.componentParams.sleeplabId)
    },
    fetchSleeplab (id) {
      this.getSleeplab(id).then((response) => {
        const data = response.data.data

        if (data) {
          data['name'] = data.salutation + ' ' + data.firstname + ' ' + data.middlename + ' ' + data.lastname

          const phoneFields = ['phone1', 'phone2', 'fax']

          phoneFields.forEach(el => {
            if (data.hasOwnProperty(el)) {
              data[el] = data[el]
                .replace(/[^0-9]/g, '')
                .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
            }
          })

          this.sleeplab = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getSleeplab', response: response})
      })
    },
    getSleeplab (id) {
      return http.get(endpoints.sleeplabs.show + '/' + id)
    }
  }
}
