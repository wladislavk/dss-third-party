import validateName from './legacy-step1'
import validateEpworth from './legacy-step2'
import validateSect3 from './legacy-step3'
import submitScreener from './legacy-step4'
import showDoctor from './legacy-step5'
import showHst from './legacy-step6'
import submitHst from './legacy-step7'

let screenerId = ''

// TODO: remove this line
const $ = function () {}

function getNext (sectionNumber) {
  return {
    section: $('#sect' + sectionNumber + '_next'),
    sectionDis: $('#sect' + sectionNumber + '_next_dis')
  }
}

$(document).ready(function () {
  const sectResultsNext = $('#sect_results_next')
  const stepActions = {
    1: validateName,
    2: validateEpworth,
    3: validateSect3,
    4: submitScreener,
    5: showDoctor,
    6: showHst,
    7: submitHst
  }

  nextSect(0)
  for (let i = 1; i <= 7; i++) {
    getNext(i).section.click(stepActions[i])
  }
  sectResultsNext.click(showResults)

  // regular dialog
  const fancyReg = $('a[rel="fancyReg"]')
  fancyReg.fancybox({
    'transitionIn': 'elastic',
    'width': 300,
    'height': 150,
    'autoDimensions': false,
    'overlayOpacity': '0',
    'hideOnOverlayClick': false
  })
})

function nextSect (sect) {
  if (sect === 2) {
    $('#restart_nav').show()
  }
  $('.sect').hide()
  $('#sect' + sect).show()
}

function onFailure () {
  const $button = $('#secthst').find('#sect4_next')
  $button.removeClass('disabled')
  alert('There was a problem communicating with the server, please try again in a few minutes')
}

function showResults (e) {
  e.preventDefault()
  $('#results_div').toggle()
}
