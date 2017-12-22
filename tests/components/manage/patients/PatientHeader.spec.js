import Vue from 'vue'
import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import PatientHeaderComponent from '../../../../src/components/manage/patients/PatientHeader.vue'

describe('PatientHeader component', () => {
  beforeEach(function () {
    store.state.patients[symbols.state.showAllWarnings] = true

    const Component = Vue.extend(PatientHeaderComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('hides and shows warnings', function (done) {
    const vm = this.mount({ patientId: 1 })
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
