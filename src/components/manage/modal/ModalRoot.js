import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'
import DeviceSelectorComponent from './DeviceSelector.vue'
import ViewContactComponent from '../contacts/ViewContact.vue'
import PatientAccessCodeComponent from '../patients/access-code/PatientAccessCode.vue'
import EditContactComponent from '../contacts/EditContact.vue'
import EditReferredByContactComponent from '../referredby/edit/editReferredByContacts.vue'
import ViewSleeplabComponent from '../sleeplabs/view/viewSleeplab.vue'
import EditSleeplabComponent from '../sleeplabs/edit/editSleeplab.vue'
import ViewCorporateContactComponent from '../corporate-contacts/view/viewCorporateContact.vue'

export default {
  data () {
    return {
      topPosition: 0,
      leftPosition: 0
    }
  },
  computed: {
    currentView () {
      const component = this.$store.state.main[symbols.state.modal]

      if (this.hasComponent(component)) {
        return component
      }

      return ''
    },
    popupEnabled () {
      if (this.currentView) {
        return true
      }
      return false
    }
  },
  created () {
    window.addEventListener('keyup', this.onKeyUp)
    this.centering()
  },
  beforeDestroy () {
    this.$off('keyup')
  },
  components: {
    deviceSelector: DeviceSelectorComponent,
    viewContact: ViewContactComponent,
    patientAccessCode: PatientAccessCodeComponent,
    editContact: EditContactComponent,
    editReferredByContact: EditReferredByContactComponent,
    viewSleeplab: ViewSleeplabComponent,
    editSleeplab: EditSleeplabComponent,
    viewCorporateContact: ViewCorporateContactComponent
  },
  methods: {
    centering () {
      const windowWidth = document.documentElement.clientWidth
      const windowHeight = document.documentElement.clientHeight
      let popupHeight = 0
      let popupWidth = 0
      const popupContact = document.getElementById('popupContact')
      if (popupContact) {
        popupHeight = popupContact.height()
        popupWidth = popupContact.width()
      }

      const topPos = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset)
      let leftPos = windowWidth / 2 - popupWidth / 2
      if (leftPos < 0) {
        leftPos = 10
      }
      this.topPosition = topPos + 'px'
      this.leftPosition = leftPos + 'px'
    },
    disable () {
      if (!this.popupEnabled) {
        return
      }
      let answer = true
      if (this.$store.state.main[symbols.state.popupEdit]) {
        const confirmText = 'Are you sure you want to exit without saving?'
        answer = Alerter.isConfirmed(confirmText)
      }
      if (answer) {
        this.$store.commit(symbols.state.modal, '')
      }
    },
    onKeyUp (e) {
      if (!this.popupEnabled) {
        return
      }
      const escapeCode = 27
      if (e.keyCode === escapeCode && this.popupEnabled) {
        this.disable()
      }
    },
    hasComponent (component) {
      const existedComponents = Object.keys(this.$options.components)
      const snakeToCamel = s => s.replace(/(\-\w)/g, m => m[1].toUpperCase())

      return existedComponents.includes(snakeToCamel(component))
    }
  }
}
