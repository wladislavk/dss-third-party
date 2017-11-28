import symbols from '../symbols'
import LegacyModifier from '../services/LegacyModifier'

export default {
  bind: function (el, binding, vnode) {
    const currentHref = binding.value
    const token = vnode.context.$store.getters[symbols.state.mainToken]
    const newHref = LegacyModifier.modifyLegacyLink(currentHref, token)
    el.setAttribute('href', newHref)
  }
}
