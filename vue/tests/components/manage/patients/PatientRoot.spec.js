import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import PatientRootComponent from '../../../../src/components/manage/patients/PatientRoot.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientRoot component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientId] = 0

    this.testCase.setComponent(PatientRootComponent)
    this.testCase.setRoutes([
      {
        name: 'route',
        path: '/route'
      }
    ])
  })

  it('updates patient ID', function () {
    // @todo: check why beforeRouteUpdate() does not fire
    /*
    const vm = this.mount()
    vm.$router.push({ query: { pid: '2' } })
    vm.$nextTick(() => {
      expect(store.state.patients[symbols.state.patientId]).toBe(2)
      done()
    })
    */
  })
})
