import symbols from '../symbols'
import { NOTIFICATION_NUMBERS } from '../constants/main'

export default {
  [symbols.populators.populateClaims] (state, elementName) {
    let newName = elementName
    const pendingClaimsNumber = state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingClaims]
    newName += ` (${pendingClaimsNumber})`
    return newName
  }
}
