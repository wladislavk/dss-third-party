import moxios from 'moxios'
import Vue from 'vue/dist/vue.common'
import store from 'src/store'
import AppointmentSummaryRowComponent from '../../../../src/components/manage/chart/AppointmentSummaryRow.vue'

describe('AppointmentSummaryRow component', () => {
  beforeEach(function () {
    moxios.install()

    const Component = Vue.extend(AppointmentSummaryRowComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })
})
