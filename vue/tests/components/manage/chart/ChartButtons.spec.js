import store from '../../../../src/store'
import ChartButtonsComponent from '../../../../src/components/manage/chart/ChartButtons.vue'
import symbols from '../../../../src/symbols'
import { DSS_CONSTANTS, HST_STATUSES } from '../../../../src/constants/main'
import TestCase from '../../../cases/ComponentTestCase'

describe('ChartButtons component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.companyData] = []
    store.state.patients[symbols.state.incompleteHomeSleepTests] = []

    const props = {
      patientId: 42
    }

    this.testCase.setComponent(ChartButtonsComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows without HST company', function () {
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(1)
    const link = links[0]
    expect(link.getAttribute('href')).toContain('manage/calendar_pat.php?pid=42')
  })

  it('clicks order button', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    store.state.patients[symbols.state.incompleteHomeSleepTests] = [1, DSS_CONSTANTS.DSS_HST_REQUESTED]
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    expect(firstLink.textContent).toBe('Order HST')
    firstLink.click()
    this.testCase.wait(() => {
      const expectedAlert = 'Patient has existing HST with status ' + HST_STATUSES[DSS_CONSTANTS.DSS_HST_REQUESTED] + '. Only one HST can be requested at a time.'
      expect(this.testCase.alertText).toBe(expectedAlert)
      done()
    })
  })

  it('clicks request button', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    expect(firstLink.textContent).toBe('Request HST')
    firstLink.click()
    this.testCase.wait(() => {
      expect(this.testCase.redirectUrl).toBe('manage/hst_request_co.php?ed=42')
      done()
    })
  })

  it('clicks request button without confirmation', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    this.testCase.confirmDialog = false
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    firstLink.click()
    this.testCase.wait(() => {
      expect(this.testCase.redirectUrl).toBe('')
      done()
    })
  })
})
