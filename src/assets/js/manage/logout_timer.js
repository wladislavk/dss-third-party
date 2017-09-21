import $ from 'jquery'

function reset_interval () {

}

$(document).ready(function () {
  const seconds = 1000
  const minutes = 60 * seconds
  const hours = 60 * minutes
  const modalWait = 15 * minutes
  const logoutWait = hours
  const ticker = seconds - 1
  let lastActivity = currentTime()
  let interval = 0
  let waitingForResponse = false
  const modalWindow = $('#warn_logout')
  const cancelButton = 'a:contains(logged)'
  const timerDisplay = $('#logout_time_remaining')

  function currentTime () {
    return (new Date()).getTime()
  }

  function formatTime (time) {
    const h = Math.floor(time / hours)
    const m = Math.floor((time - h * hours) / minutes)
    const s = Math.floor((time - h * hours - m * minutes) / seconds)
    let newTime

    function plural (n, text) {
      return n + ' ' + (n === 1 ? text : text + 's')
    }

    if (h) {
      newTime = plural(h, 'hour')
      if (m) {
        newTime += ', ' + plural(m, 'minute')
      }
      return newTime
    }

    if (m) {
      newTime = plural(m, 'minute')
      if (m < 2 && s) {
        newTime += ', ' + plural(s, 'second')
      }
      return newTime
    }

    return plural(s, 'second')
  }

  $(document).delegate('body', 'keydown mousemove', function () {
    if (modalWindow.is(':visible')) {
      return
    }
    lastActivity = currentTime()
  })

  modalWindow.delegate(cancelButton, 'click', function () {
    modalWindow.hide()
    lastActivity = currentTime()
  })

  interval = setInterval(function () {
    const now = currentTime()
    const inactiveTime = now - lastActivity
    let timeBeforeModal = modalWait - inactiveTime
    let timeBeforeLogout = logoutWait - inactiveTime

    timeBeforeModal = timeBeforeModal > 0 ? timeBeforeModal : 0
    timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0

    timerDisplay.text(formatTime(timeBeforeLogout))

    if (timeBeforeLogout <= 0) {
      if (waitingForResponse) {
        return
      }

      waitingForResponse = true

      $.post('/manage/includes/check_logout.php', function (json) {
        const newLast = currentTime() + (json.reset_time || 0) - logoutWait

        if (json.reset_time) {
          lastActivity = newLast > lastActivity ? newLast : lastActivity
        } else {
          clearInterval(interval)
          window.location = '/manage/logout.php'
        }

        waitingForResponse = false
      }, 'json')
    }

    if (timeBeforeModal <= 0 && !modalWindow.is(':visible')) {
      modalWindow.show()
    }
  }, ticker)
})
