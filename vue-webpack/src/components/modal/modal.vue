<style src="../../assets/css/manage/popup.css" scoped></style>
<style scoped>
  #modal-content {
    background: url(/assets/images/tall.jpg);
    background-repeat: repeat-x;
    background-color: rgb(191, 207, 220);
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    width: 100%;
    height: 100%;
    overflow: auto;
  }
</style>

<template>
  <div id="modal" class="modal">
    <div id="popupContact" style="width:750px">
      <a id="popupContactClose" v-on:click="disable"><button>X</button></a>

      <div id="modal-content">
        <component :is="currentView"></component>
      </div>
    </div>

    <div id="backgroundPopup" v-on:click="disable"></div>
  </div>
</template>

<script>
  var deviceSelector = require('../manage/dashboard/device-selector/deviceSelector.vue')
  var viewContact = require('../manage/contacts/ViewContact.vue')
  var patientAccessCode = require('../manage/patients/access-code/PatientAccessCode.vue')
  var editContact = require('../manage/contacts/EditContact.vue')

  module.exports = {
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
      'empty': { template: '' },
      'device-selector': deviceSelector,
      'view-contact': viewContact,
      'patient-access-code': patientAccessCode,
      'edit-contact': editContact
    },
    methods: {
      setComponentParameters (parameters) {
        this.$nextTick(function () {
          this.$emit('setting-component-params', parameters)
        })
      },
      centering () {
        var windowWidth = document.documentElement.clientWidth
        var windowHeight = document.documentElement.clientHeight
        var popupHeight = window.$('#popupContact').height()
        var popupWidth = window.$('#popupContact').width()
        var topPos = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset) + 'px'
        var leftPos = windowWidth / 2 - popupWidth / 2
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
        var answer = false
        // disables popup only if it is enabled
        if (this.popupStatus === 1) {
          if (this.popupEdit) {
            answer = confirm('Are you sure you want to exit without saving?')
          } else {
            answer = true
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
        // TODO: __proto__ is deprecated - must be updated
        // var existedComponents = Object.keys(this.$options.components.__proto__)
        var existedComponents = []

        if (existedComponents.indexOf(component) > -1) {
          return true
        } else {
          return false
        }
      },
      updateParentData (data) {
        this.$emit('getting-data-from-modal', data)
      }
    }
  }
</script>
