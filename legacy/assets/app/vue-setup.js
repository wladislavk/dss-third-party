/* global $ */
/* global moment */
/* global RefreshTokenInterceptor */
/* global Vue */
window.successAction = null
window.errorAction = null
window.userTimeZone = moment.tz.guess()

var apiToken = $('#dom-api-token').val()

if (typeof apiToken !== 'string' || !apiToken.length) {
  try {
    apiToken = localStorage.getItem('apiToken')
  } catch (e) { /* No localStorage support, ignore it */ }
}

function setApiToken (apiToken) {
  Vue.http.headers.common['Authorization'] = 'Bearer ' + apiToken
}

setApiToken(apiToken)
Vue.http.interceptors.push(RefreshTokenInterceptor)

$(document).ready(function () {
  $('.vue-module table.table-striped').each(function () {
    var $this = $(this)

    $this.removeClass('tr_bg')
      .find('> tr:nth-child(1), > * > tr:nth-child(1)')
      .addClass('tr_bg_h')
      .find('> td, > th')
      .addClass('col_head')

    $this.find('> tr:not(.tr_bg_h):even, > * > tr:not(.tr_bg_h):even')
      .addClass('tr_bg')
  })
})
