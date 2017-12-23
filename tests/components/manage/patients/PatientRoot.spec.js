import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import PatientRootComponent from '../../../../src/components/manage/patients/PatientRoot.vue'

describe('PatientRoot component', () => {
  beforeEach(function () {
    store.state.patients[symbols.state.patientId] = 0

    const Component = Vue.extend(PatientRootComponent)
    const Router = new VueRouter({
      mode: 'history',
      routes: [
        {
          name: 'route',
          path: '/route'
        }
      ]
    })
    this.mount = function () {
      return new Component({
        store: store,
        router: Router
      }).$mount()
    }
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
