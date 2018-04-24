import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'
import { INITIAL_FUTURE_APPOINTMENT } from '../../../../src/constants/chart'

describe('Flowsheet module getters', () => {
  describe('trackerStepsFirst getter', () => {
    it('gets tracker steps for first section', function () {
      const state = {
        [symbols.state.trackerSteps]: [
          {
            name: 'foo',
            section: 1
          },
          {
            name: 'bar',
            section: 2
          },
          {
            name: 'baz',
            section: 1
          }
        ]
      }
      const result = FlowsheetModule.getters[symbols.getters.trackerStepsFirst](state)
      expect(result.length).toBe(2)
      expect(result[0].name).toBe('foo')
      expect(result[1].name).toBe('baz')
    })
  })

  describe('trackerStepsSecond getter', () => {
    it('gets tracker steps for second section', function () {
      const state = {
        [symbols.state.trackerSteps]: [
          {
            name: 'foo',
            section: 1
          },
          {
            name: 'bar',
            section: 2
          },
          {
            name: 'baz',
            section: 1
          }
        ]
      }
      const result = FlowsheetModule.getters[symbols.getters.trackerStepsSecond](state)
      expect(result.length).toBe(1)
      expect(result[0].name).toBe('bar')
    })
  })

  describe('shouldPreventFlowsheetModal getter', () => {
    it('returns true', function () {
      const state = {
        [symbols.state.existingDeviceId]: 2
      }
      const result = FlowsheetModule.getters[symbols.getters.shouldPreventFlowsheetModal](state)
      expect(result).toBe(true)
    })
  })

  describe('appointmentLetterCount getter', () => {
    it('sets letter counters', function () {
      const state = {
        [symbols.state.appointmentSummaryLetters]: [
          {
            infoId: 1,
            toPatient: true,
            mdList: [1, 2, 3],
            mdReferralList: [4, 5, 6]
          },
          {
            infoId: 2,
            toPatient: false,
            mdList: [],
            mdReferralList: []
          },
          {
            infoId: 1,
            toPatient: false,
            mdList: [1, 2],
            mdReferralList: [4, 5]
          }
        ]
      }
      const result = FlowsheetModule.getters[symbols.getters.appointmentLetterCount](state)
      const expected = {
        1: 11,
        2: 0
      }
      expect(result).toEqual(expected)
    })
  })

  describe('appointmentLettersSent getter', () => {
    it('sets if appointment letters are sent', function () {
      const state = {
        [symbols.state.appointmentSummaryLetters]: [
          {
            infoId: 1,
            status: 1
          },
          {
            infoId: 2,
            status: 0
          },
          {
            infoId: 1,
            status: 0
          },
          {
            infoId: 3,
            status: 1
          }
        ]
      }
      const result = FlowsheetModule.getters[symbols.getters.appointmentLettersSent](state)
      const expected = {
        1: true,
        2: false,
        3: true
      }
      expect(result).toEqual(expected)
    })
  })

  describe('hasScheduledAppointment getter', () => {
    it('returns false with initial appointment', function () {
      const state = {
        [symbols.state.futureAppointment]: INITIAL_FUTURE_APPOINTMENT
      }
      const result = FlowsheetModule.getters[symbols.getters.hasScheduledAppointment](state)
      expect(result).toBe(false)
    })
    it('returns false without scheduled date', function () {
      const state = {
        [symbols.state.futureAppointment]: {
          id: 1,
          segmentId: 1,
          dateScheduled: null,
          dateUntil: null
        }
      }
      const result = FlowsheetModule.getters[symbols.getters.hasScheduledAppointment](state)
      expect(result).toBe(false)
    })
    it('returns true', function () {
      const state = {
        [symbols.state.futureAppointment]: {
          id: 1,
          segmentId: 1,
          dateScheduled: new Date('2016-01-01'),
          dateUntil: null
        }
      }
      const result = FlowsheetModule.getters[symbols.getters.hasScheduledAppointment](state)
      expect(result).toBe(true)
    })
  })
})
