import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'
import { LEGACY_URL } from '../../../constants'

export default {
  data () {
    return {
      patientList: [],
      searchListHover: -1,
      searchTimeout: 0,
      showSearchHints: false,
      inputValue: '',
      cursor: 'auto'
    }
  },
  created () {
    window.addEventListener('click', () => {
      this.showSearchHints = false
    })
  },
  beforeDestroy () {
    this.$off('click')
  },
  methods: {
    patientListKeyUp (link, event) {
      const enterCode = 13
      const upArrowCode = 38
      const downArrowCode = 40
      if (event.which === upArrowCode) {
        this.moveSelection('up')
        return
      }
      if (event.which === downArrowCode) {
        this.moveSelection('down')
        return
      }
      if (event.which === enterCode && this.showSearchHints && link) {
        window.location = LEGACY_URL + link
      }
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
        window.location = LEGACY_URL + listElement.link
        return
      }
      this.inputValue = listElement.name
      this.sendValue(listElement.name)
    },
    patientNameKeyPress (event) {
      const enterCode = 13
      if (event.keyCode === enterCode) {
        return false
      }
      return true
    },
    patientNameKeyUp (event) {
      const date = new Date()
      console.log.apply(console, 'START', this.inputValue, date.getTime())

      const asciiValue = event.which

      if (this.inputValue.trim() === '') {
        this.showSearchHints = false
        this.patientList = []
        // @todo: deal with this line when migrating patient list
        // $parent.find('.initial_list').css('display', 'table-row')
        return
      }
      const apostropheCode = 39
      const aCapitalCode = 41
      const zCode = 122
      const backspaceCode = 8
      if (
        (
          this.inputValue.length > 1 ||
          this.patientList.length > 1
        ) &&
        (
          (asciiValue >= aCapitalCode && asciiValue <= zCode) ||
          asciiValue === backspaceCode ||
          asciiValue === apostropheCode
        )
      ) {
        // @todo: deal with this line when migrating patient list
        // $parent.find('.initial_list').css('display', 'none')
        this.showSearchHints = true
        this.sendValue(this.inputValue)
        if (this.inputValue.length > 2) {
          this.inputValue.replace(/(\s+)?.$/, '') // strip last character to match last positive result
        }
      }
    },
    sendValue (searchTerm) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout)
      }

      const searchBounce = 600
      this.searchTimeout = setTimeout(() => {
        http.token = this.$store.state.main[symbols.state.mainToken]
        const queryData = {
          partial_name: searchTerm
        }
        http.post(endpoints.patients.list, queryData).then((response) => {
          this.handleResults(response.data)
          this.searchTimeout = 0
        }).catch(() => {
          const alertText = 'Could not select patient from database'
          Alerter.alert(alertText)
        })
      }, searchBounce)
    },
    moveSelection (direction) {
      if (direction === 'up' && this.searchListHover > 0) {
        this.searchListHover--
        return
      }
      if (direction === 'down' && this.searchListHover < this.patientList.length - 1) {
        this.searchListHover++
      }
    },
    handleResults (data) {
      this.patientList = []

      if (data.length === 0) {
        const noMatchesElement = {
          name: 'No Matches',
          patientType: 'no',
          link: ''
        }
        this.patientList.push(noMatchesElement)
        // @todo: add transition
        // this.templateListNew().fadeIn(noMatchesElement)

        const newElement = {
          name: 'Add patient with this name&#8230;',
          patientType: 'new',
          link: 'add_patient.php?search=' + this.inputValue
        }
        this.patientList.push(newElement)

        // @todo: add transition
        // this.templateListNew().fadeIn(newElement)
        return
      }

      for (let element of data) {
        let middleName = ''
        if (element.middlename !== null) {
          middleName = element.middlename
        }
        const fullName = `${element.lastname}, ${element.firstname} ${middleName}`
        let link = '/manage/add_patient.php?pid=' + element.patientId + '&ed=' + element.patientId
        if (element.patientInfo === 1) {
          link = '/manage/manage_flowsheet3.php?pid=' + element.patientId
        }
        const patientElement = {
          name: fullName,
          patientType: 'json',
          link: link
        }
        this.patientList.push(patientElement)
        // @todo: add transition
        // this.templateList().fadeIn(patientElement)
      }
    }
  }
}
