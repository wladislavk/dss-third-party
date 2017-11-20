import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants/main'
import LocationWrapper from '../../../wrappers/LocationWrapper'

export default {
  data () {
    return {
      searchListHover: -1,
      searchTimeout: 0,
      inputValue: '',
      cursor: 'auto'
    }
  },
  computed: {
    patientList () {
      return this.$store.state.main[symbols.state.patientSearchList]
    },
    showSearchHints () {
      return this.$store.state.main[symbols.state.showSearchHints]
    }
  },
  methods: {
    patientNameKeyPress (event) {
      const enterCode = 13
      if (event.keyCode === enterCode) {
        return false
      }
      return true
    },
    patientNameKeyUp (event) {
      const asciiValue = event.which
      const currentInputValue = event.target.value

      if (currentInputValue.trim() === '') {
        this.$store.commit(symbols.mutations.hideSearchHints)
        this.$store.commit(symbols.mutations.patientSearchList, [])
        // @todo: deal with this line when migrating patient list
        // $parent.find('.initial_list').css('display', 'table-row')
        return
      }
      if (!this.checkAsciiCode(asciiValue)) {
        return
      }
      if (currentInputValue.length > 1 || this.patientList.length > 1) {
        // @todo: deal with this line when migrating patient list
        // $parent.find('.initial_list').css('display', 'none')
        this.$store.commit(symbols.mutations.showSearchHints)
        this.sendValue(currentInputValue)
        if (currentInputValue.length > 2) {
          this.inputValue.replace(/(\s+)?.$/, '') // strip last character to match last positive result
        }
      }
    },
    checkAsciiCode (asciiValue) {
      // for acceptance tests
      if (!asciiValue) {
        return true
      }
      const apostropheCode = 39
      const aCapitalCode = 41
      const zCode = 122
      const backspaceCode = 8
      if (asciiValue === backspaceCode) {
        return true
      }
      if (asciiValue === apostropheCode) {
        return true
      }
      if (asciiValue >= aCapitalCode && asciiValue <= zCode) {
        return true
      }
      return false
    },
    sendValue (searchTerm) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout)
      }
      const searchBounce = 600
      this.searchTimeout = setTimeout(() => {
        this.$store.dispatch(symbols.actions.patientSearchList, searchTerm)
        this.searchTimeout = 0
      }, searchBounce)
    },
    patientListMouseOver (index, patientType) {
      if (patientType !== 'no') {
        this.cursor = 'pointer'
      }
      this.searchListHover = index
    },
    patientListMouseOut (patientType) {
      if (patientType !== 'no') {
        this.cursor = 'auto'
      }
      this.searchListHover = -1
      this.selectedUrl = ''
    },
    patientListClick (listElement) {
      if (listElement.patientType === 'no') {
        return
      }
      if (listElement.link) {
        LocationWrapper.goToPage(LEGACY_URL + listElement.link)
        return
      }
      this.inputValue = listElement.name
      this.sendValue(listElement.name)
    }
  }
}
