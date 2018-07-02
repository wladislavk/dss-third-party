import sinon from 'sinon'
import store from '../../../../src/store'
import CommonHeaderComponent from '../../../../src/components/manage/common/CommonHeader.vue'
import symbols from '../../../../src/symbols'
import LocationWrapper from '../../../../src/wrappers/LocationWrapper'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('CommonHeader component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()

    store.commit(symbols.mutations.patientId, 0)
    store.commit(symbols.mutations.modal, { name: '' })

    const childComponents = [
      'patient-header',
      'right-top-menu',
      'left-top-menu',
      'task-menu',
      'patient-search',
      'welcome-text'
    ]
    this.testCase.setComponent(CommonHeaderComponent)
    this.testCase.setChildComponents(childComponents)
    this.testCase.setRoutes([
      {
        name: 'dashboard',
        path: '/'
      }
    ])
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  it('shows header', function () {
    const vm = this.testCase.mount()

    const companyLogoDiv = vm.$el.querySelector('div.company-logo')
    expect(companyLogoDiv).toBeNull()
  })

  it('shows patient header when ID present', function () {
    store.commit(symbols.mutations.patientId, 1)
    const vm = this.testCase.mount()

    const patientHeaderDiv = vm.$el.querySelector('div.patient-header')
    expect(patientHeaderDiv).not.toBeNull()
    const patientMenusDiv = vm.$el.querySelector('div.patient-menus')
    expect(patientMenusDiv).toBeNull()
  })

  it('clicks buttons', function (done) {
    let redirectUrl = ''
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      redirectUrl = ProcessWrapper.getLegacyRoot() + url
    })
    const vm = this.testCase.mount()

    const addTaskButton = vm.$el.querySelector('button#add_task_button')
    addTaskButton.click()
    vm.$nextTick(() => {
      const expectedModal = {
        name: symbols.modals.addTask,
        params: {
          id: 0,
          patientId: 0
        }
      }
      expect(vm.$store.state.main[symbols.mutations.modal]).toEqual(expectedModal)
      const addPatientButton = vm.$el.querySelector('button#add_patient_button')
      addPatientButton.click()
      vm.$nextTick(() => {
        expect(redirectUrl).toBe(ProcessWrapper.getLegacyRoot() + 'manage/add_patient.php')
        done()
      })
    })
  })
})
