import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import PatientHeaderComponent from '../../../../src/components/manage/patients/PatientHeader.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientHeader component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.showAllWarnings] = true

    this.testCase.setComponent(PatientHeaderComponent)
    this.testCase.setRoutes([
      {
        name: 'patient-tracker',
        path: '/tracker'
      }
    ])
  })

  it('hides and shows warnings', function (done) {
    const props = {
      patientId: 1
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const showWarningsButton = vm.$el.querySelector('a#show_patient_warnings')
    const hideWarningsButton = vm.$el.querySelector('a#hide_patient_warnings')
    expect(showWarningsButton.style.display).toBe('none')
    expect(hideWarningsButton.style.display).toBe('')
    hideWarningsButton.click()
    vm.$nextTick(() => {
      expect(showWarningsButton.style.display).toBe('')
      expect(hideWarningsButton.style.display).toBe('none')
      showWarningsButton.click()
      vm.$nextTick(() => {
        expect(showWarningsButton.style.display).toBe('none')
        expect(hideWarningsButton.style.display).toBe('')
        done()
      })
    })
  })
})
