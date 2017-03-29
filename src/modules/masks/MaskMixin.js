export default {
  mounted () {
    window.$.mask.definitions['~'] = '[2-9]'

    window.$('.extphonemask').mask('(~99) 999-9999? ext99999')
    window.$('.phonemask').mask('(~99) 999-9999')
  }
}
