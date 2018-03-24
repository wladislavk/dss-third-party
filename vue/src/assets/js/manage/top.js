import $ from 'jquery'

export function debounceCall (call, options) {
  let timeoutId = 0

  const newOptions = $.extend({
    timeout: 600,
    context: null,
    onTick: null
  }, options)

  return function () {
    const argumentArray = Array.prototype.slice.call(arguments, 0)

    if (timeoutId) {
      clearTimeout(timeoutId)
      timeoutId = 0
    }

    if (newOptions.onTick) {
      newOptions.onTick.apply(newOptions.context, argumentArray)
    }

    timeoutId = setTimeout(function () {
      call.apply(newOptions.context, argumentArray)
    }, newOptions.timeout)
  }
}

export function display () {
  $('#future_dental_det').show()
}

export function hide () {
  $('#future_dental_det').hide()
}

export function displaysmoke () {
  $('#smoke').show()
}

export function hidesmoke () {
  $('#smoke').hide()
}

export function LinkUp () {
  const link = $('[name=DDlinks]').val()
  window.location.href = link
}

export function toggleTB (what) {
  if ($(what).is(':checked')) {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', true)
  } else {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', false)
  }
}

export function jsConfirm (str) {
  const results = confirm(str)
  $('#results').html(results)
}

export function disableenable () {
  const bedTimePartner = $('form[name=q_page1frm] [name=bed_time_partner]')
  if (bedTimePartner.val() === 'No') {
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', true)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', true)
  }

  if (bedTimePartner.val() === 'Yes') {
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }

  if (bedTimePartner.val() === 'Sometimes') {
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }

  if (bedTimePartner.val() === '') {
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }
}

export function showMe (id) {
  $('#' + id).toggle()
}

export function showMe2 (id) {
  $('#' + id).toggle()
}

function createCookie (name, value, days) {
  let expires
  if (days) {
    const date = new Date()

    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))

    expires = '; expires=' + date.toGMTString()
  } else {
    expires = ''

    document.cookie = name + '=' + value + expires + '; path=/'
  }
}

export function readCookie (name) {
  const nameEQ = name + '='
  const ca = document.cookie.explode(';')

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

export function eraseCookie (name) {
  createCookie(name, '', -1)
}

export function check () {
  if (!(document.forms || []).length || !(document.forms[0].elements || []).length) {
    return
  }

  for (let i = 0; i < document.forms[0].elements.length; i++) {
    const element = document.forms[0].elements[i]

    switch (element.type) {
      case 'text': // textbox type
        document.forms[0].elements[i].readOnly = true
        break
      case 'select-one': // dropdown
        document.forms[0].elements[i].readOnly = true
        document.forms[0].elements[i].disabled = true
        break
      case 'checkbox': // checkbox
        document.forms[0].elements[i].disabled = true
        break
      case 'radio': // radiobutton
        document.forms[0].elements[i].disabled = true
        break
      case 'button': // button
        document.forms[0].elements[i].disabled = true
        break
      case 'submit': // button
        document.forms[0].elements[i].disabled = true
        break
      case 'textarea': // textarea
        document.forms[0].elements[i].readOnly = true
        break
    }
  }
}

export function focusIt (dtControl) {
  const mytext = $('#' + dtControl)
  setTimeout(function () {
    mytext.focus()
  }, 0)
}

export function validateDate (dtControl) {
  const input = $('#' + dtControl)
  const value = input.val() || ''
  const dateFormat = input.attr('data-date-format') || 'm/d/Y'
  const readableFormat = dateFormat.replace(/([mdy])/g, '$1$1').replace(/(Y)/g, '$1$1$1$1').toUpperCase()
  const regexValidator = new RegExp(
    '^' +
    dateFormat.replace(/[md]/g, '\\d{1,2}').replace(/y/g, '\\d{2}').replace(/Y/g, '\\d{4}') +
    '$'
  )

  if (!regexValidator.test(value)) {
    alert('Invalid Day, Month, or Year range detected. Please correct. Must be ' + readableFormat)
  } else if (dateFormat === 'm/d/Y') {
    const monthField = value.split('/')[0]
    const dayField = value.split('/')[1]
    const yearField = value.split('/')[2]
    const theDay = new Date(yearField, monthField - 1, dayField)

    if (
      (theDay.getMonth() + 1 !== monthField) ||
      (theDay.getDate() !== dayField) ||
      (theDay.getFullYear() !== yearField)
    ) {
      alert('Invalid Day, Month, or Year range detected. Please correct. Must be ' + readableFormat)
      return false
    }
  }

  return true
}

export function validate () {
  if (document.getElementById('service_date_ledger').value === '') {
    alert('service date must be filled!')
  }
}

export function getKey (keyStroke) {
  if (!window.event || !window.event.srcElement) {
    return
  }

  const t = window.event.srcElement.type
  const keyCode = (document.layers) ? keyStroke.which : event.keyCode
  const backSpaceKey = 8

  if (t && (t === 'text' || t === 'textarea' || t === 'file')) {
    // do not cancel the event
  } else {
    if (keyCode === backSpaceKey) {
      return false
    }
  }
}

export function popitup (url) {
  const newwindow = window.open(url, 'name', 'height=400,width=400')
  if (window.focus) {
    newwindow.focus()
  }
  return false
}

export function areyousure (tturl) {
  window.location = tturl
}

export function hideallblocksForFlowsheet (step) {
  if (step.indexOf('2') !== -1) {
    $('#consultrow').hide()
  }

  if (step.indexOf('3') !== -1) {
    $('#sleepstudyrow').hide()
  }

  if (step.indexOf('4') !== -1) {
    $('#impressionrow').hide()
  }

  if (step.indexOf('5') !== -1) {
    $('#delayingtreatmentrow').hide()
  }

  if (step.indexOf('6') !== -1) {
    $('#refusedtreatmentrow').hide()
  }

  if (step.indexOf('7') !== -1) {
    $('#devicedeliveryrow').hide()
  }

  if (step.indexOf('8') !== -1) {
    $('#checkuprow').hide()
  }

  if (step.indexOf('9') !== -1) {
    $('#patientnoncomprow').hide()
  }

  if (step.indexOf('10') !== -1) {
    $('#homesleeptestrow').hide()
  }

  if (step.indexOf('11') !== -1) {
    $('#starttreatmentrow').hide()
  }

  if (step.indexOf('12') !== -1) {
    $('#annualrecallrow').hide()
  }
}

export function hideallblocks () {
  $('#sleepstudyrow, #impressionrow, #delayingtreatmentrow').hide()
  $('#refusedtreatmentrow, #devicedeliveryrow, #checkuprow').hide()
  $('#patientnoncomprow, #starttreatmentrow, #annualrecallrow').hide()
  $('#homesleeptestrow, #consultrow').hide()
}
