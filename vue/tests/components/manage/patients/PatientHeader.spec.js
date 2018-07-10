import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import PatientHeaderComponent from '../../../../src/components/manage/patients/PatientHeader.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientHeader component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.showAllWarnings] = true

    const props = {
      patientId: 1
    }

    this.testCase.setComponent(PatientHeaderComponent)
    this.testCase.setRoutes([
      {
        name: 'patient-tracker',
        path: '/tracker'
      }
    ])
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('hides and shows warnings', function (done) {
    const vm = this.testCase.mount()

    const showWarningsButton = vm.$el.querySelector('a#show_patient_warnings')
    const hideWarningsButton = vm.$el.querySelector('a#hide_patient_warnings')
    expect(showWarningsButton.style.display).toBe('none')
    expect(hideWarningsButton.style.display).toBe('')
    hideWarningsButton.click()
    this.testCase.wait(() => {
      expect(showWarningsButton.style.display).toBe('')
      expect(hideWarningsButton.style.display).toBe('none')
      showWarningsButton.click()
      this.testCase.wait(() => {
        expect(showWarningsButton.style.display).toBe('none')
        expect(hideWarningsButton.style.display).toBe('')
        done()
      })
    })
  })
})
