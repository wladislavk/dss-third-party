import symbols from '../symbols'
import { NOTIFICATION_NUMBERS } from '../constants'

export default {
  [symbols.populators.populateClaims] (state, elementName) {
    const pendingClaimsNumber = state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingClaims]
    elementName += ` (${pendingClaimsNumber})`
    return elementName
  }
}
