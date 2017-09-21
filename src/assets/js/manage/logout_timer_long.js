import $ from 'jquery'

let lo_timer = ''
let w_timer = ''
const timer_length = 4 * 60 * 60 * 1000
const w_timer_length = 15 * 60 * 1000
let startTimeMS = 0

function set_interval () {
  startTimeMS = (new Date()).getTime()
  lo_timer = setInterval(auto_logout(), timer_length)
  w_timer = setInterval(warn_logout(), w_timer_length)
}

function update_logout_timer () {
  const t = timer_length - ((new Date()).getTime() - startTimeMS)
  const m = Math.floor(t / 60000)
  $('#logout_time_remaining').text(m + ' minutes')
}

window.setInterval(update_logout_timer(), 30000)

function reset_interval (newTime) {
  window.clearInterval(lo_timer)
  window.clearInterval(w_timer)
  startTimeMS = (new Date()).getTime()
  if (newTime !== 0) {
    lo_timer = window.setInterval(auto_logout(), newTime)
    if (newTime - (45 * 60 * 1000) < 1000) {
      w_timer = window.setInterval(warn_logout(), 1000)
    } else {
      w_timer = window.setInterval(warn_logout(), (newTime - (45 * 60 * 1000)))
    }
  } else {
    lo_timer = window.setInterval(auto_logout(), timer_length)
    w_timer = window.setInterval(warn_logout(), w_timer_length)
  }
  $('#warn_logout').hide()
}

function warn_logout () {
  $('#warn_logout').show()
}

function auto_logout () {
  $.ajax({
    url: 'includes/check_logout_long.php',
    type: 'post',
    success: function (data) {
      const r = $.parseJSON(data)
      if (r.reset_time) {
        reset_interval(r.reset_time)
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
  set_interval()
})
