import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'
import AddTaskComponent from './AddTask.vue'
import DeviceSelectorComponent from './device-selector/DeviceSelector.vue'
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
      const componentName = this.$store.state.main[symbols.state.modal].name
      if (this.hasComponent(componentName)) {
        return componentName
      }

      return ''
    },
    currentProperties () {
      const component = this.$store.state.main[symbols.state.modal]
      return component.params
    },
    popupEnabled () {
      return !!this.currentView
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
    addTask: AddTaskComponent,
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
      const windowWidth = window.innerWidth
      const windowHeight = window.innerHeight
      const popupHeight = 400
      const popupWidth = 750
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
      if (this.$store.state.main[symbols.state.popupEdit]) {
        const confirmText = 'Are you sure you want to exit without saving?'
        if (!Alerter.isConfirmed(confirmText)) {
          return
        }
      }
      this.$store.commit(symbols.mutations.resetModal)
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
    hasComponent (componentName) {
      const existedComponents = Object.keys(this.$options.components)
      return (existedComponents.indexOf(componentName) > -1)
    }
  }
}
