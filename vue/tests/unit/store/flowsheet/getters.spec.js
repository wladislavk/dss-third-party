import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'

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
})
