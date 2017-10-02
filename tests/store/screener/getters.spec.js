import symbols from '../../../src/symbols'
import ScreenerModule from '../../../src/store/screener'

describe('Screener module getters', () => {
  describe('fullName getter', () => {
    it('should get full name with last name', function () {
      const state = {
        [symbols.state.contactData]: [
          {
            camelName: 'firstName',
            value: 'John'
          },
          {
            camelName: 'lastName',
            value: 'Doe'
          },
          {
            camelName: 'foo',
            value: 'bar'
          }
        ]
      }
      const fullName = ScreenerModule.getters[symbols.getters.fullName](state)
      expect(fullName).toBe('John Doe')
    })
    it('should get full name without last name', function () {
      const state = {
        [symbols.state.contactData]: [
          {
            camelName: 'firstName',
            value: 'John'
          },
          {
            camelName: 'foo',
            value: 'bar'
          }
        ]
      }
      const fullName = ScreenerModule.getters[symbols.getters.fullName](state)
      expect(fullName).toBe('John ')
    })
  })
  describe('calculateRisk getter', () => {
    it('will give low risk', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 1,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('low')
    })
    it('will give moderate risk based on survey', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 10,
          epworth: 1,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('moderate')
    })
    it('will give high risk based on survey', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 13,
          epworth: 1,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('high')
    })
    it('will give severe risk based on survey', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 17,
          epworth: 1,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('severe')
    })
    it('will give moderate risk based on epworth', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 10,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('moderate')
    })
    it('will give high risk based on epworth', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 15,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('high')
    })
    it('will give severe risk based on epworth', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 20,
          coMorbidity: 1
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('severe')
    })
    it('will give moderate risk based on co-morbidity', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 1,
          coMorbidity: 2
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('moderate')
    })
    it('will give high risk based on co-morbidity', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 1,
          coMorbidity: 3
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('high')
    })
    it('will give severe risk based on co-morbidity', function () {
      const state = {
        [symbols.state.screenerWeights]: {
          survey: 1,
          epworth: 1,
          coMorbidity: 4
        }
      }
      const risk = ScreenerModule.getters[symbols.getters.calculateRisk](state)
      expect(risk).toBe('severe')
    })
  })
})
