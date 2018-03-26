import $ from 'jquery'

let popupStatus = 0
let popupEdit = false
let close = false

export function loadPopup (fa) {
  centerPopup()
  popupEdit = false
  $('#aj_pop').attr('src', fa).load(function () {
    $('#aj_pop').contents().find('input, textarea, select').change(function () {
      popupEdit = true
    })
  })

  if (popupStatus === 0) {
    const backgroundPopup = $('#backgroundPopup')
    backgroundPopup.css({
      opacity: 0.7
    })
    backgroundPopup.fadeIn('slow')
    $('#popupContact').fadeIn('slow')
    popupStatus = 1
  }
}

export function loadPopupWithClose (fa, c) {
  close = c
  centerPopup()
  popupEdit = false
  $('#aj_pop').attr('src', fa).load(function () {
    $('#aj_pop').contents().find('input, textarea, select').change(function () {
      popupEdit = true
    })
  })
  if (popupStatus === 0) {
    const backgroundPopup = $('#backgroundPopup')
    backgroundPopup.css({
      opacity: 0.7
    })
    backgroundPopup.fadeIn('slow')
    $('#popupContact').fadeIn('slow')
    popupStatus = 1
  }
}

export function loadPopupRefer (fa) {
  centerPopupRef()

  document.getElementById('aj_ref').src = fa

  if (popupStatus === 0) {
    const backgroundPopupRef = $('#backgroundPopupRef')
    backgroundPopupRef.css({
      opacity: 0.7
    })
    backgroundPopupRef.fadeIn('slow')
    $('#popupRefer').fadeIn('slow')
    popupStatus = 1
  }
}

export function loadPopupClean (fa) {
  centerPopupClean()

  document.getElementById('aj_clean').src = fa

  if (popupStatus === 0) {
    const backgroundPopupClean = $('#backgroundPopupClean')
    backgroundPopupClean.css({
      opacity: 0.7
    })
    backgroundPopupClean.fadeIn('slow')
    $('#popupClean').fadeIn('slow')
    popupStatus = 1
  }
}

export function loadPopup1 (fa) {
  centerPopup1()

  document.getElementById('aj_pop').src = fa

  if (popupStatus === 0) {
    const backgroundPopup = $('#backgroundPopup')
    backgroundPopup.css({
      opacity: 0.7
    })
    backgroundPopup.fadeIn('slow')
    $('#popupContact').fadeIn('slow')
    popupStatus = 1
  }
}

function createCookie (name, value, days) {
  let expires = ''
  if (days) {
    const date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    expires = '; expires=' + date.toGMTString()
  }
  document.cookie = name + '=' + value + expires + '; path=/'
}

export function readCookie (name) {
  const nameEQ = name + '='
  const ca = document.cookie.split(';')
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) === ' ') {
      c = c.substring(1, c.length)
    }
    if (c.indexOf(nameEQ) === 0) {
      return c.substring(nameEQ.length, c.length)
    }
  }
  return null
}

function eraseCookie (name) {
  createCookie(name, '', -1)
}

function disablePopup () {
  if (popupStatus === 1) {
    let answer = true
    if (popupEdit) {
      answer = confirm('Are you sure you want to exit without saving?')
    }
    if (answer) {
      $('#backgroundPopup').fadeOut('slow')
      $('#popupContact').fadeOut('slow')
      eraseCookie('tempforledgerentry')
      popupStatus = 0
    }
    if (close) {
      parent.window.location = close
      return
    }
    parent.window.location.reload(true)
  }
}

function disablePopupClean () {
  if (popupStatus === 1) {
    $('#backgroundPopup').fadeOut('slow')
    $('#popupContact').fadeOut('slow')
    $('#backgroundPopupClean').fadeOut('slow')
    $('#popupClean').fadeOut('slow')

    eraseCookie('tempforledgerentry')
    popupStatus = 0
  }
}

function disablePopupRef () {
  if (popupStatus === 1) {
    const answer = confirm('Are you sure you want to exit without saving?')
    if (answer) {
      $('#backgroundPopupRef').fadeOut('slow')
      $('#popupRefer').fadeOut('slow')
      popupStatus = 0
    }
  }
}

export function disablePopupRefClean () {
  if (popupStatus === 1) {
    $('#backgroundPopupRef').fadeOut('slow')
    $('#popupRefer').fadeOut('slow')
    popupStatus = 0
  }
}

export function disablePopup1 () {
  if (popupStatus === 1) {
    $('#backgroundPopup').fadeOut('slow')
    $('#popupContact').fadeOut('slow')
    popupStatus = 0
  }
}

function centerPopup () {
  const windowWidth = document.documentElement.clientWidth
  const windowHeight = document.documentElement.clientHeight
  const popupContact = $('#popupContact')
  const popupHeight = popupContact.height()
  const popupWidth = popupContact.width()
  const topPos = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset) + 'px'
  let leftPos = windowWidth / 2 - popupWidth / 2
  if (leftPos < 0) {
    leftPos = 10
  }

  popupContact.css({
    position: 'absolute',
    top: topPos,
    left: leftPos
  })

  $('#backgroundPopup').css({
    height: windowHeight
  })
}

function centerPopupRef () {
  const windowWidth = document.documentElement.clientWidth
  const windowHeight = document.documentElement.clientHeight
  const popupRefer = $('#popupRefer')
  const popupHeight = popupRefer.height()
  const popupWidth = popupRefer.width()
  const topPos = (windowHeight / 2 - popupHeight / 2 + $(document).scrollTop()) + 'px'
  let leftPos = windowWidth / 2 - popupWidth / 2
  if (leftPos < 0) {
    leftPos = 10
  }

  popupRefer.css({
    position: 'absolute',
    top: topPos,
    left: leftPos
  })

  $('#backgroundPopupRef').css({
    height: windowHeight
  })
}

function centerPopupClean () {
  const windowWidth = document.documentElement.clientWidth
  const windowHeight = document.documentElement.clientHeight
  const popupClean = $('#popupClean')
  const popupHeight = popupClean.height()
  const popupWidth = popupClean.width()
  const topPos = (windowHeight / 2 - popupHeight / 2 + $(document).scrollTop()) + 'px'
  let leftPos = windowWidth / 2 - popupWidth / 2
  if (leftPos < 0) {
    leftPos = 10
  }

  popupClean.css({
    position: 'absolute',
    top: topPos,
    left: leftPos
  })

  $('#backgroundPopupClean').css({
    height: windowHeight
  })
}

function centerPopup1 () {
  const selector = $('#popupContact')
  const windowWidth = document.documentElement.clientWidth
  const windowHeight = document.documentElement.clientHeight
  const popupHeight = selector.height()
  const popupWidth = selector.width()
  let leftPos = windowWidth / 2 - popupWidth / 2
  if (leftPos < 0) {
    leftPos = 10
  }

  selector.css({
    position: 'absolute',
    top: (windowHeight / 2 - popupHeight / 2) + 1100,
    left: leftPos
  })

  $('#backgroundPopup').css({
    height: windowHeight
  })
}

$(document).ready(function () {
  $('#popupContactClose').click(function () {
    disablePopup()
  })

  $('#backgroundPopup').click(function () {
    disablePopup()
  })

  $('#popupReferClose').click(function () {
    disablePopupRef()
  })

  $('#backgroundPopupRef').click(function () {
    disablePopupRef()
  })

  $('#popupCleanClose').click(function () {
    disablePopupClean()
  })

  $('#backgroundPopupClean').click(function () {
    disablePopupClean()
  })

  $(document).keypress(function (e) {
    if (e.keyCode === 27 && popupStatus === 1) {
      disablePopup()
    }
  })
})

window.closeModal = function () {
  $('#popup-window').modal('hide')
}

window.refreshParent = function () {
  window.location = window.location
}
