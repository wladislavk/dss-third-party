/* eslint-env browser */
/* global Vue */
/* global jQuery */
(function () {
  var soapNotes = new Vue({
    el: '#soap-notes-wrapper',
    methods: {
      openNewNoteCallback: function () {
        this.$refs.newNote.openNoteCallback()
      }
    }
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(soapNotes)
}(jQuery))
