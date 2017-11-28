import $ from 'jquery'

const hasVB = false

// Patient Search Suggestion Script
const localPatData = []

function display () {
  $('#future_dental_det').show()
}

function hide () {
  $('#future_dental_det').hide()
}

function displaysmoke () {
  $('#smoke').show()
}

function hidesmoke () {
  $('#smoke').hide()
}

function LinkUp () {
  const link = $('[name=DDlinks]').val()
  window.location.href = link
}

function toggleTB (what) {
  if ($(what).is(':checked')) {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', true)
  } else {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', false)
  }
}

function jsConfirm (str) {
  const results = (hasVB) ? vbConfirm(str) : confirm(str)
  $('#results').html(results)
}

function disableenable () {
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

function showMe (id) {
  $('#' + id).toggle()
}

function showMe2 (id) {
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

function readCookie (name) {
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

function eraseCookie (name) {
  createCookie(name, '', -1)
}

function check () {
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

function focusIt (dtControl) {
  const mytext = $('#' + dtControl)
  setTimeout(function () {
    mytext.focus()
  }, 0)
}

function validateDate (dtControl) {
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

function validate () {
  if (document.getElementById('service_date_ledger').value === '') {
    alert('service date must be filled!')
  }
}

function getKey (keyStroke) {
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

function popitup (url) {
  const newwindow = window.open(url, 'name', 'height=400,width=400')

  if (window.focus) {
    newwindow.focus()
  }

  return false
}

function areyousure (tturl) {
  window.location = tturl
}

function hideallblocksForFlowsheet (step) {
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

function hideallblocks () {
  $('#sleepstudyrow, #impressionrow, #delayingtreatmentrow').hide()
  $('#refusedtreatmentrow, #devicedeliveryrow, #checkuprow').hide()
  $('#patientnoncomprow, #starttreatmentrow, #annualrecallrow').hide()
  $('#homesleeptestrow, #consultrow').hide()
}
