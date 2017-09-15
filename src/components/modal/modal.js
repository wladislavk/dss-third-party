import deviceSelector from '../manage/dashboard/device-selector/deviceSelector.vue'
import viewContact from '../manage/contacts/ViewContact.vue'
import patientAccessCode from '../manage/patients/access-code/PatientAccessCode.vue'
import editContact from '../manage/contacts/EditContact.vue'
import editReferredByContact from '../manage/referredby/edit/editReferredByContacts.vue'
import viewSleeplab from '../manage/sleeplabs/view/viewSleeplab.vue'
import editSleeplab from '../manage/sleeplabs/edit/editSleeplab.vue'
import viewCorporateContact from '../manage/corporate-contacts/view/viewCorporateContact.vue'

export default {
  data () {
    return {
      popupStatus: 0, // 0 - disabled, 1 - enabled
      popupEdit: false,
      currentView: 'empty'
    }
  },
  created () {
    window.addEventListener('keyup', this.onKeyUp)
  },
  beforeDestroy () {
    this.$off('keyup')
  },
  components: {
    'empty': { name: 'empty-template', template: '<p></p>' },
    'device-selector': deviceSelector,
    'view-contact': viewContact,
    'patient-access-code': patientAccessCode,
    'edit-contact': editContact,
    'edit-referred-by-contact': editReferredByContact,
    'view-sleeplab': viewSleeplab,
    'edit-sleeplab': editSleeplab,
    'view-corporate-contact': viewCorporateContact
  },
  methods: {
    setComponentParameters (parameters) {
      this.$nextTick(function () {
        window.eventHub.$emit('setting-component-params', parameters)
      })
    },
    centering () {
      const windowWidth = document.documentElement.clientWidth
      const windowHeight = document.documentElement.clientHeight
      const popupHeight = window.$('#popupContact').height()
      const popupWidth = window.$('#popupContact').width()
      const topPos = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset) + 'px'
      let leftPos = windowWidth / 2 - popupWidth / 2
      if (leftPos < 0) {
        leftPos = 10
      }
      // centering
      window.$('#popupContact').css({
        'position': 'absolute',
        'top': topPos,
        'left': leftPos
      })
      // only need force for IE6
      window.$('#backgroundPopup').css({
        'height': windowHeight
      })
    },
    display (component) {
      if (this.hasComponent(component)) {
        this.centering()

        this.currentView = component
        this.popupEdit = true

        // loads popup only if it is disabled
        if (this.popupStatus === 0) {
          window.$('#backgroundPopup').css({
            'opacity': '0.7'
          })
          window.$('#backgroundPopup').fadeIn('slow')
          window.$('#popupContact').fadeIn('slow')

          this.popupStatus = 1
        }
      }
    },
    disable () {
      let answer = false
      // disables popup only if it is enabled
      if (this.popupStatus === 1) {
        answer = true
        if (this.$store.popupEdit) {
          answer = confirm('Are you sure you want to exit without saving?')
        }

        if (answer) {
          window.$('#backgroundPopup').fadeOut('slow')
          window.$('#popupContact').fadeOut('slow')
          this.popupStatus = 0
          this.popupEdit = false
          this.currentView = 'empty'
        }
      }
    },
    onKeyUp (e) {
      if (e.keyCode === 27 && this.popupStatus === 1) {
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
