import ModalRootComponent from './modal/ModalRoot.vue'

export default {
  components: {
    modalRoot: ModalRootComponent
  },
  created () {
    document.body.className += ' main-template'
  }
}
