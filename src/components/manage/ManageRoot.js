import ModalRootComponent from './modal/ModalRoot.vue'
import symbols from '../../symbols'

export default {
  components: {
    modalRoot: ModalRootComponent
  },
  created () {
    document.body.className += ' main-template'
  },
  methods: {
    hideSearchHints () {
      this.$store.commit(symbols.mutations.hideSearchHints)
    }
  }
}
