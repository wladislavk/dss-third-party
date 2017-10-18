import $ from 'jquery'

let loTimer = ''
let wTimer = ''
const timerLength = 4 * 60 * 60 * 1000
const wTimerLength = 15 * 60 * 1000
let startTimeMS = 0

function setInterval () {
  startTimeMS = (new Date()).getTime()
  loTimer = setInterval(autoLogout(), timerLength)
  wTimer = setInterval(warnLogout(), wTimerLength)
}

function updateLogoutTimer () {
  const t = timerLength - ((new Date()).getTime() - startTimeMS)
  const m = Math.floor(t / 60000)
  $('#logout_time_remaining').text(m + ' minutes')
}

window.setInterval(updateLogoutTimer(), 30000)

function resetInterval (newTime) {
  window.clearInterval(loTimer)
  window.clearInterval(wTimer)
  startTimeMS = (new Date()).getTime()
  if (newTime === 0) {
    loTimer = window.setInterval(autoLogout(), timerLength)
    wTimer = window.setInterval(warnLogout(), wTimerLength)
  } else {
    loTimer = window.setInterval(autoLogout(), newTime)
    if (newTime - (45 * 60 * 1000) < 1000) {
      wTimer = window.setInterval(warnLogout(), 1000)
    } else {
      wTimer = window.setInterval(warnLogout(), (newTime - (45 * 60 * 1000)))
    }
  }
  $('#warn_logout').hide()
}

function warnLogout () {
  $('#warn_logout').show()
}

function autoLogout () {
  $.ajax({
    url: 'includes/check_logout_long.php',
    type: 'post',
    success: function (data) {
      const r = $.parseJSON(data)
      if (r.reset_time) {
        resetInterval(r.reset_time)
      } else {
        window.location = 'logout.php'
      }
    },
    failure: function () {
      window.location = 'logout.php'
    }
  })
}

$(document).ready(function () {
  setInterval()
})
