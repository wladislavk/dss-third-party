import LegacyModifier from '../services/LegacyModifier'

export default {
  goToPage (url) {
    window.location.href = url
  },
  goToLegacyPage (url, token) {
    window.location.href = LegacyModifier.modifyLegacyLink(url, token)
  }
}
