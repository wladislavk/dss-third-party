import QueryStringComposer from 'qs'
import moxios from 'moxios'
import Vue from 'vue'
import store from '../../../../src/store'
import AppointmentSummaryComponent from '../../../../src/components/manage/chart/AppointmentSummary.vue'
import http from 'src/services/http'
import endpoints from 'src/endpoints'

describe('AppointmentSummary component', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('appointment-summary-row', {
      template: '<div class="summary-row"></div>'
    })
    const Component = Vue.extend(AppointmentSummaryComponent)
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

  it('shows summary rows', function (done) {
    const patientId = 42
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.byPatient + '/' + patientId), {
      status: 200,
      responseText: {
        data: [
          {
            id: '1',
            segmentid: '2',
            device_id: '3',
            date_completed: '2016-01-01',
            date_scheduled: null,
            delay_reason: 'delay',
            noncomp_reason: 'non-compliance',
            study_type: 'study',
            description: ''
          },
          {
            id: '10',
            segmentid: '12',
            device_id: '13',
            date_completed: '2017-02-02',
            date_scheduled: null,
            delay_reason: 'delay 2',
            noncomp_reason: 'non-compliance 2',
            study_type: 'study 2',
            description: ''
          },
          {
            id: '20',
            segmentid: '22',
            device_id: '23',
            date_completed: null,
            date_scheduled: null,
            delay_reason: 'delay 3',
            noncomp_reason: 'non-compliance 3',
            study_type: 'study 3',
            description: ''
          }
        ]
      }
    })
    const queryStringData = {
      patient_id: patientId,
      info_ids: [1, 10, 20]
    }
    const queryString = QueryStringComposer.stringify(queryStringData)
    moxios.stubRequest(http.formUrl(endpoints.letters.byPatientAndInfo + '?' + queryString), {
      status: 200,
      responseText: {
        data: [
          {
            letterid: '1',
            info_id: '1',
            topatient: '0',
            md_list: [1, 2],
            md_referral_list: [],
            status: '1'
          }
        ]
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.devices.byStatus), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const propsData = {
      patientId: patientId
    }
    const vm = this.mount(propsData)
    moxios.wait(() => {
      const rows = vm.$el.querySelectorAll('div.summary-row')
      expect(rows.length).toBe(2)
      const firstRow = rows[0]
      expect(firstRow.getAttribute('patient-id')).toBe('' + patientId)
      expect(firstRow.getAttribute('element-id')).toBe('1')
      expect(firstRow.getAttribute('segment-id')).toBe('2')
      expect(firstRow.getAttribute('device-id')).toBe('3')
      const expectedDate = new Date('2016-01-01')
      expect(firstRow.getAttribute('date-completed')).toBe(expectedDate.toString())
      expect(firstRow.getAttribute('delay-reason')).toBe('delay')
      expect(firstRow.getAttribute('non-compliance-reason')).toBe('non-compliance')
      expect(firstRow.getAttribute('study-type')).toBe('study')
      expect(firstRow.getAttribute('letter-count')).toBe('2')
      expect(firstRow.getAttribute('letters-sent')).toBe('true')
      const secondRow = rows[1]
      expect(secondRow.getAttribute('element-id')).toBe('10')
      expect(secondRow.getAttribute('letter-count')).toBe('0')
      expect(secondRow.getAttribute('letters-sent')).toBeNull()
      done()
    })
  })

  it('shows new data if patient id changed', function (done) {
    const oldPatientId = 42
    const newPatientId = 43
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.byPatient + '/' + oldPatientId), {
      status: 200,
      responseText: {
        data: [
          {
            id: '1',
            segmentid: '2',
            device_id: '3',
            date_completed: '2016-01-01',
            date_scheduled: null,
            delay_reason: 'delay',
            noncomp_reason: 'non-compliance',
            study_type: 'study',
            description: ''
          }
        ]
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.byPatient + '/' + newPatientId), {
      status: 200,
      responseText: {
        data: [
          {
            id: '2',
            segmentid: '2',
            device_id: '3',
            date_completed: '2016-01-01',
            date_scheduled: null,
            delay_reason: 'delay',
            noncomp_reason: 'non-compliance',
            study_type: 'study',
            description: ''
          }
        ]
      }
    })
    const queryStringData = {
      patient_id: oldPatientId,
      info_ids: [1]
    }
    const queryString = QueryStringComposer.stringify(queryStringData)
    moxios.stubRequest(http.formUrl(endpoints.letters.byPatientAndInfo + '?' + queryString), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const newQueryStringData = {
      patient_id: newPatientId,
      info_ids: [2]
    }
    const newQueryString = QueryStringComposer.stringify(newQueryStringData)
    moxios.stubRequest(http.formUrl(endpoints.letters.byPatientAndInfo + '?' + newQueryString), {
      status: 200,
      responseText: {
        data: []
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.devices.byStatus), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const propsData = {
      patientId: oldPatientId
    }
    const vm = this.mount(propsData)
    moxios.wait(() => {
      let row = vm.$el.querySelector('div.summary-row')
      expect(row.getAttribute('patient-id')).toBe('' + oldPatientId)
      expect(row.getAttribute('element-id')).toBe('1')
      vm.$props.patientId = newPatientId
      vm.$forceUpdate()
      moxios.wait(() => {
        let row = vm.$el.querySelector('div.summary-row')
        expect(row.getAttribute('patient-id')).toBe('' + newPatientId)
        expect(row.getAttribute('element-id')).toBe('2')
        done()
      })
    })
  })
})
