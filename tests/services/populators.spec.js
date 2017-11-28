import symbols from '../../src/symbols'
import populators from '../../src/services/populators'
import { NOTIFICATION_NUMBERS } from '../../src/constants/main'

describe('populateClaims populator', () => {
  it('populates claims', function () {
    const state = {
      main: {
        [symbols.state.notificationNumbers]: {
          [NOTIFICATION_NUMBERS.pendingClaims]: 5
        }
      }
    }
    const elementName = 'foo'
    const result = populators[symbols.populators.populateClaims](state, elementName)

    expect(result).toBe('foo (5)')
  })
})
