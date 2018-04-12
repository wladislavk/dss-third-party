import moxios from 'moxios'
import Vue from 'vue'
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

  it('shows sleep study row')
  it('shows reason row')
  it('shows reason row with delay')
  it('shows reason row with non-compliance')
  it('shows device row')
  it('shows row with letters')
  it('shows row without segment data')
  it('deletes step')
  it('deletes step without confirmation')
  it('deletes step with sent letters')
  it('updates completed date')
})
