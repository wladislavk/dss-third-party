/* eslint-env browser */
/* global $ */
/* global Modal */
/* global Promise */
/* global VueModules */
/* global updateFormChanges */
/* global formHasChanges */
/* global isHistoricView */
/* global apiRoot */
/* global apiToken */
/* global getParameterByName */
/* global moment */
/* global userTimeZone */
/* exported MultipleEndpointsMixin */
/* exported setupRedirections */
$(document).ready(function () {
  /**
  * Save current status of the form, to later compare it with changes
  */
  var $forms = $('.q_form, .ex_form')
  var $timestamps = $('#history-timestamps')
  var $backupDropdown = $timestamps.find('select')
  var $historySelector = $('.history-selector')
  var $backupSingle = $backupDropdown.find('.new-backup:not(.watchdog)')
  var $backupAll = $backupDropdown.find('.backup-all-forms:not(.watchdog)')
  var savedState = {}
  var sectionName = window.sectionName || 'exams'
  var displayDateFormat = 'MM/DD/YYYY HH:mm'

  if (!$historySelector.prev().is($forms)) {
    $historySelector.insertAfter($forms)
    $historySelector.removeClass('hidden')
  }

  $forms.addClass('sidetabs')
  if ($timestamps.length) {
    $timestamps.find('.tz-timestamp').each(function () {
      var $this = $(this)
      var date = moment($this.text(), displayDateFormat)

      if (date.isValid() && date.year() !== 1) {
        $this.text(date.tz(userTimeZone).format(displayDateFormat))
        return
      }

      if ($this.is('.initiated-timestamp')) {
        $this.text(moment().format(displayDateFormat))
        return
      }

      $this.text('')
    })

    if ($timestamps.closest('form').length) {
      $forms.prepend($timestamps)
    }
  }

  $backupSingle.addClass('watchdog')
  $backupAll.addClass('watchdog')

  function backupSingle () {
    var section = $backupSingle.data('section-name')

    if (!confirm('Are you sure you want to create new and archive ' + section + '?')) {
      return
    }

    $forms
      .find('.save-action:contains(Archive), .do-backup:contains(Archive)')
      .first()
      .click()

    return false
  }

  function backupAll () {
    var section = $backupAll.data('section-name')

    if (confirm('Are you sure you want to create new and archive all ' + section + ' pages?')) {
      backupAllExams(sectionName)
    }
  }

  $backupDropdown.change(function (e) {
    e.preventDefault()

    var $selected = $backupDropdown.find('option:selected')

    if ($selected[0] === $backupSingle[0]) {
      backupSingle()
      return
    }

    if ($selected[0] === $backupAll[0]) {
      backupAll()
    }
  })

  if ($forms.filter('.vue-module').length) {
    /**
     * Walk over the collection of Vue modules, save the initial state of each one, listed by their namespaces
     */
    var module, namespace, n

    var setInitialValue = function (eventName, module) {
      savedState[module.$get('mixin.namespace')] = JSON.stringify(module.$get('form'))
    }

    for (n = 0; n < VueModules.length; n++) {
      module = VueModules[n]
      namespace = module.$get('mixin.namespace')

      if (!namespace || !module.hasOwnProperty('on')) {
        continue
      }

      savedState[namespace] = JSON.stringify(module.$get('form'))

      /**
       * Update the saved state on module: load, reset, and save
       */
      module.on('load:success', setInitialValue)
      module.on('reset', setInitialValue)
      module.on('save:success', setInitialValue)
      module.on('dataload', setInitialValue)
    }

    /**
     * Declare a global function to determine if any form has unsaved changes
     * @returns {boolean}
     */
    window.formHasChanges = function () {
      var currentState = {}
      var module
      var namespace
      var n

      /**
       * Retrieve the state of all the modules in the global list
       */
      for (n = 0; n < VueModules.length; n++) {
        module = VueModules[n]
        namespace = module.$get('mixin.namespace')

        if (namespace && module.hasOwnProperty('on')) {
          currentState[namespace] = JSON.stringify(module.$get('form'))
        }
      }

      return JSON.stringify(savedState) !== JSON.stringify(currentState)
    }
  } else if ($forms.length) {
    savedState = $forms.serialize()

    window.updateFormChanges = function () {
      savedState = $forms.serialize()
    }

    window.formHasChanges = function () {
      return savedState !== $forms.serialize()
    }

    $forms.submit(updateFormChanges)

    $forms.find('button.do-backup:not(.hooked)').addClass('hooked').click(function (event) {
      event.preventDefault()
      $('form#archive-page-form').submit()

      return false
    })
  }

  if (typeof isHistoricView !== 'undefined' && isHistoricView) {
    $forms.find('select, textarea, :checkbox, :radio, :text, :submit, input[type=button], button, a, .form-backup-disable')
      .not('.form-backup-enable').prop('disabled', true)
  } else if ($forms.length) {
    $(window).unload(function () {
      if (formHasChanges()) {
        confirm('There are unsaved changes in the form. Are you sure you want to leave?')
      }
    })
  }
})

function setupRedirections (returnPath) {
  if (typeof window.successAction !== 'undefined') {
    window.successAction = function () {
      window.successAction = null
      window.location = returnPath
    }
  }

  if (typeof window.errorAction !== 'undefined') {
    window.errorAction = function () {
      window.errorAction = null
      window.location = returnPath
    }
  }
}

function change_page (goToPage, fa, pid) {
  var returnPath = goToPage + '.php?fid=' + pid + '&pid=' + pid
  var canLeave = true

  if ((typeof isHistoricView === 'undefined' || !isHistoricView) && formHasChanges()) {
    canLeave = confirm('There are unsaved changes in the form. Are you sure you want to leave?')
  }

  if (canLeave) {
    window.location = returnPath
  }
}

function change_page1 (goToPage) {
  var returnPath = goToPage + '.php'
  var canLeave = true

  if ((typeof isHistoricView === 'undefined' || !isHistoricView) && formHasChanges()) {
    canLeave = confirm('There are unsaved changes in the form. Are you sure you want to leave?')
  }

  if (canLeave) {
    window.location = returnPath
  }
}

function backupAllExams (sectionName) {
  var section = 'questionnaires'

  if (sectionName === 'exam') {
    section = 'exams'
  }

  Modal.showBusy('Processing, please wait...')

  $.ajax({
    url: '/manage/backup-section.php',
    type: 'post',
    data: {
      section: section,
      pid: getParameterByName('pid')
    },
    dataType: 'json',
    timeout: 30000,
    complete: function () {
      window.location = window.location
    }
  })
}
