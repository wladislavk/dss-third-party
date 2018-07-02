import sinon from 'sinon'
import moxios from 'moxios'
import store from '../../../../src/store'
import ChartButtonsComponent from '../../../../src/components/manage/chart/ChartButtons.vue'
import symbols from '../../../../src/symbols'
import Alerter from '../../../../src/services/Alerter'
import { DSS_CONSTANTS, HST_STATUSES } from '../../../../src/constants/main'
import LocationWrapper from '../../../../src/wrappers/LocationWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('ChartButtons component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    moxios.install()
    this.testCase = new TestCase()

    store.state.main[symbols.state.companyData] = []
    store.state.patients[symbols.state.incompleteHomeSleepTests] = []

    this.testCase.setComponent(ChartButtonsComponent)
  })

  afterEach(function () {
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('shows without HST company', function () {
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(1)
    const link = links[0]
    expect(link.getAttribute('href')).toContain('manage/calendar_pat.php?pid=42')
  })

  it('clicks order button', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    store.state.patients[symbols.state.incompleteHomeSleepTests] = [1, DSS_CONSTANTS.DSS_HST_REQUESTED]
    let alertText = ''
    this.sandbox.stub(Alerter, 'alert').callsFake((alert) => {
      alertText = alert
    })
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    expect(firstLink.textContent).toBe('Order HST')
    firstLink.click()
    vm.$nextTick(() => {
      const expectedAlert = 'Patient has existing HST with status ' + HST_STATUSES[DSS_CONSTANTS.DSS_HST_REQUESTED] + '. Only one HST can be requested at a time.'
      expect(alertText).toBe(expectedAlert)
      done()
    })
  })

  it('clicks request button', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })
    let redirectUrl = ''
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      redirectUrl = url
    })
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    expect(firstLink.textContent).toBe('Request HST')
    firstLink.click()
    vm.$nextTick(() => {
      expect(redirectUrl).toBe('manage/hst_request_co.php?ed=42')
      done()
    })
  })

  it('clicks request button without confirmation', function (done) {
    store.state.main[symbols.state.companyData] = [1, 2]
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })
    let redirectUrl = ''
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      redirectUrl = url
    })
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(2)
    const firstLink = links[0]
    firstLink.click()
    vm.$nextTick(() => {
      expect(redirectUrl).toBe('')
      done()
    })
  })
})
