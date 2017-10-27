import alerter from '../../services/alerter'
import DeviceSelectorComponent from '../manage/dashboard/device-selector/deviceSelector.vue'
import ViewContactComponent from '../manage/contacts/ViewContact.vue'
import PatientAccessCodeComponent from '../manage/patients/access-code/PatientAccessCode.vue'
import EditContactComponent from '../manage/contacts/EditContact.vue'
import EditReferredByContactComponent from '../manage/referredby/edit/editReferredByContacts.vue'
import ViewSleeplabComponent from '../manage/sleeplabs/view/viewSleeplab.vue'
import EditSleeplabComponent from '../manage/sleeplabs/edit/editSleeplab.vue'
import ViewCorporateContactComponent from '../manage/corporate-contacts/view/viewCorporateContact.vue'

export default {
  data () {
    return {
      popupEnabled: false,
      popupEdit: false,
      currentView: 'empty',
      topPosition: 0,
      leftPosition: 0
    }
  },
  created () {
    window.addEventListener('keyup', this.onKeyUp)
  },
  beforeDestroy () {
    this.$off('keyup')
  },
  components: {
    'empty': {
      name: 'empty-template',
      template: '<p></p>'
    },
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
    setComponentParameters (parameters) {
      this.$nextTick(() => {
        window.eventHub.$emit('setting-component-params', parameters)
      })
    },
    centering () {
      const windowWidth = document.documentElement.clientWidth
      const windowHeight = document.documentElement.clientHeight
      const popupHeight = document.getElementById('popupContact').height()
      const popupWidth = document.getElementById('popupContact').width()

      const topPos = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset)
      let leftPos = windowWidth / 2 - popupWidth / 2
      if (leftPos < 0) {
        leftPos = 10
      }
      this.topPosition = topPos + 'px'
      this.leftPosition = leftPos + 'px'
    },
    display (component) {
      if (this.hasComponent(component)) {
        this.centering()

        this.currentView = component
        this.popupEdit = true

        if (!this.popupEnabled) {
          window.$('#backgroundPopup').fadeIn('slow')
          window.$('#popupContact').fadeIn('slow')

          this.popupEnabled = true
        }
      }
    },
    disable () {
      if (!this.popupEnabled) {
        return
      }

      let answer = true
      if (this.$store.popupEdit) {
        const confirmText = 'Are you sure you want to exit without saving?'
        answer = alerter.isConfirmed(confirmText)
      }

      if (answer) {
        window.$('#backgroundPopup').fadeOut('slow')
        window.$('#popupContact').fadeOut('slow')
        this.popupEnabled = false
        this.popupEdit = false
        this.currentView = 'empty'
      }
    },
    onKeyUp (e) {
      if (e.keyCode === 27 && this.popupEnabled) {
        this.disable()
      }
    },
    hasComponent (component) {
      const existedComponents = Object.keys(this.$options.components)

      return (existedComponents.indexOf(component) > -1)
    },
    updateParentData (data) {
      window.eventHub.$emit('setting-data-from-modal', data)
    }
  }
}
