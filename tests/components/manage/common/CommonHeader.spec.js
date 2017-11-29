import Vue from 'vue'
import VueRouter from 'vue-router'
import sinon from 'sinon'
import store from '../../../../src/store'
import CommonHeaderComponent from '../../../../src/components/manage/common/CommonHeader.vue'
import symbols from '../../../../src/symbols'
import LocationWrapper from '../../../../src/wrappers/LocationWrapper'
import LegacyHref from '../../../../src/directives/LegacyHref'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'

describe('CommonHeader component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()

    Vue.directive('legacy-href', LegacyHref)
    store.commit(symbols.mutations.patientId, 0)
    store.commit(symbols.mutations.companyLogo, '')
    store.commit(symbols.mutations.modal, { name: '' })
    Vue.component('patient-header', {
      template: '<div class="patient-header"></div>'
    })
    Vue.component('right-top-menu', {
      template: '<div class="right-menu"></div>'
    })
    Vue.use(VueRouter)
    const Component = Vue.extend(CommonHeaderComponent)
    const Router = new VueRouter({
      routes: [
        {
          name: 'dashboard',
          path: '/'
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

  afterEach(function () {
    this.sandbox.restore()
  })

  it('shows header', function () {
    const vm = this.mount()
    const companyLogoDiv = vm.$el.querySelector('div.company-logo')
    expect(companyLogoDiv).toBeNull()
    const patientHeaderDiv = vm.$el.querySelector('div.patient-header')
    expect(patientHeaderDiv).toBeNull()
    const patientMenusDiv = vm.$el.querySelector('div.patient-menus')
    expect(patientMenusDiv).not.toBeNull()
  })

  it('shows patient header when ID present', function () {
    store.commit(symbols.mutations.patientId, 1)
    const vm = this.mount()
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
    const vm = this.mount()
    const addTaskButton = vm.$el.querySelector('button#add_task_button')
    addTaskButton.click()
    vm.$nextTick(() => {
      const expectedModal = {
        name: 'addTask',
        params: {
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
