import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'
import { INITIAL_FUTURE_APPOINTMENT } from '../../../../src/constants/chart'

describe('Flowsheet module mutations', () => {
  describe('getAppointmentSummary mutation', () => {
    it('gets summary without fields', function () {
      const initialData = {
        id: 42,
        name: 'foo'
      }

      const state = {
        [symbols.state.appointmentSummaries]: [
          initialData
        ]
      }
      const data = [
        {
          id: '1',
          segmentid: '2',
          device_id: '3',
          description: 'description',
          study_type: null,
          delay_reason: null,
          noncomp_reason: null,
          date_completed: null,
          date_scheduled: null
        },
        {
          id: '1',
          segmentid: '2',
          device_id: '3',
          description: 'description',
          study_type: 'study',
          delay_reason: 'delay',
          noncomp_reason: 'non-compliance',
          date_completed: '2016-01-01',
          date_scheduled: '2017-02-02'
        }
      ]
      FlowsheetModule.mutations[symbols.mutations.getAppointmentSummary](state, data)
      const expectedState = {
        [symbols.state.appointmentSummaries]: [
          {
            id: 1,
            segmentId: 2,
            deviceId: 3,
            description: 'description',
            studyType: '',
            delayReason: '',
            nonComplianceReason: '',
            dateCompleted: null,
            dateScheduled: null
          },
          {
            id: 1,
            segmentId: 2,
            deviceId: 3,
            description: 'description',
            studyType: 'study',
            delayReason: 'delay',
            nonComplianceReason: 'non-compliance',
            dateCompleted: new Date('2016-01-01'),
            dateScheduled: new Date('2017-02-02')
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('removeAppointmentSummary mutation', () => {
    it('removes appointment summary', function () {
      const state = {
        [symbols.state.appointmentSummaries]: [
          {
            id: 1,
            name: 'foo'
          },
          {
            id: 2,
            name: 'bar'
          },
          {
            id: 3,
            name: 'baz'
          }
        ]
      }
      const removedId = 2
      FlowsheetModule.mutations[symbols.mutations.removeAppointmentSummary](state, removedId)
      expect(state[symbols.state.appointmentSummaries].length).toBe(2)
      expect(state[symbols.state.appointmentSummaries][0].name).toBe('foo')
      expect(state[symbols.state.appointmentSummaries][1].name).toBe('baz')
    })
  })

  describe('devices mutation', () => {
    it('sets devices', function () {
      const state = {
        [symbols.state.devices]: [
          {
            id: 1,
            device: 'foo'
          }
        ]
      }
      const data = [
        {
          deviceid: '2',
          device: 'bar'
        },
        {
          deviceid: '3',
          device: 'baz'
        }
      ]
      FlowsheetModule.mutations[symbols.mutations.devices](state, data)
      const expectedState = {
        [symbols.state.devices]: [
          {
            id: 2,
            device: 'bar'
          },
          {
            id: 3,
            device: 'baz'
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('appointmentSummaryLetters mutation', () => {
    it('sets letters', function () {
      const state = {
        [symbols.state.appointmentSummaryLetters]: []
      }
      const data = [
        {
          letterid: '1',
          info_id: '11',
          topatient: '1',
          md_list: '1,2,3',
          md_referral_list: '4,5,6',
          status: '1'
        },
        {
          letterid: '2',
          info_id: '12',
          topatient: '0',
          md_list: '',
          md_referral_list: '',
          status: '0'
        }
      ]
      FlowsheetModule.mutations[symbols.mutations.appointmentSummaryLetters](state, data)
      const expectedState = {
        [symbols.state.appointmentSummaryLetters]: [
          {
            id: 1,
            infoId: 11,
            toPatient: true,
            mdList: '1,2,3',
            mdReferralList: '4,5,6',
            status: 1
          },
          {
            id: 2,
            infoId: 12,
            toPatient: false,
            mdList: '',
            mdReferralList: '',
            status: 0
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('trackerSteps mutation', () => {
    it('adds tracker steps', function () {
      const firstStep = {
        id: 1,
        name: 'first'
      }
      const secondStep = {
        id: 2,
        name: 'second'
      }
      const state = {
        [symbols.state.trackerSteps]: [
          firstStep,
          secondStep
        ]
      }
      const data = [
        {
          id: '3',
          name: 'third',
          rank: '11'
        },
        {
          id: '4',
          name: 'fourth',
          rank: '12'
        }
      ]
      const section = 2
      const payload = {
        data: data,
        section: section
      }
      FlowsheetModule.mutations[symbols.mutations.trackerSteps](state, payload)
      const expectedState = {
        [symbols.state.trackerSteps]: [
          firstStep,
          secondStep,
          {
            id: 3,
            name: 'third',
            rank: 11,
            section: 2
          },
          {
            id: 4,
            name: 'fourth',
            rank: 12,
            section: 2
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('futureAppointment mutation', () => {
    beforeEach(function () {
      this.state = {
        [symbols.state.futureAppointment]: INITIAL_FUTURE_APPOINTMENT
      }
    })
    it('sets appointment without date', function () {
      const data = {
        id: '1',
        segmentid: '2',
        date_scheduled: ''
      }
      FlowsheetModule.mutations[symbols.mutations.futureAppointment](this.state, data)
      const expectedState = {
        [symbols.state.futureAppointment]: {
          id: 1,
          segmentId: 2,
          dateScheduled: null
        }
      }
      expect(this.state).toEqual(expectedState)
    })
    it('sets appointment with date', function () {
      const data = {
        id: '1',
        segmentid: '2',
        date_scheduled: '2016-01-01'
      }
      FlowsheetModule.mutations[symbols.mutations.futureAppointment](this.state, data)
      const expectedState = {
        [symbols.state.futureAppointment]: {
          id: 1,
          segmentId: 2,
          dateScheduled: new Date('2016-01-01')
        }
      }
      expect(this.state).toEqual(expectedState)
    })
  })
})
