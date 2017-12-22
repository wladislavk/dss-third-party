import $ from 'jquery'
import LocationWrapper from '../../../wrappers/LocationWrapper'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

let localData = ''

export function setupAutocompleteLocal (inField, hint, idField, source, file, hinttype, pid, idOnly, checkEnrollment, npi, officeType) {
  $.getJSON(file).done(function (data) {
    localData = []
    let cpl = data
    let arrayIndex = 0
    for (let i = 0; i < cpl.length; i++) {
      if (typeof cpl[i]['names'] !== 'undefined' && cpl[i]['names'].length > 0) {
        for (let nameIndex = 0; nameIndex < cpl[i]['names'].length; nameIndex++) {
          if (cpl[i]['names'][nameIndex]) {
            localData[arrayIndex] = []
            localData[arrayIndex]['payer_id'] = cpl[i]['payer_id']
            localData[arrayIndex]['payer_name'] = cpl[i]['names'][nameIndex]
            localData[arrayIndex]['enrollment_required'] = cpl[i]['enrollment_required']
            localData[arrayIndex]['enrollment_mandatory_fields'] = cpl[i]['enrollment_mandatory_fields']
            arrayIndex++
          }
        }
      }
    }
  })
  $('#' + inField).keyup(function (e) {
    $('#' + idField).val('')
    if (source !== '') {
      $('#' + source).val('')
    }
    const a = e.which // ascii decimal value
    const listSize = $('#' + hint + ' ul li').size()
    const stringSize = $(this).val().length
    if ($(this).val().trim() === '') {
      $('#' + hint).css('display', 'none')
    } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($(this).val() === window.searchVal)) && ((a >= 39 && a <= 122 && a !== 40) || a === 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
      $('#' + hint).css('display', 'inline')
      sendValueRefLocal($('#' + inField).val(), inField, hint, idField, source, file, hinttype, pid, idOnly, checkEnrollment, npi, officeType)
      if ($(this).val() > 2) {
        window.searchVal = $(this).val().replace(/(\s+)?.$/, '') // strip last character to match last positive result
      }
    }
  })
}

function sendValueRefLocal (partialName, inField, hint, idField, source, file, hinttype, pid, idOnly, checkEnrollment, npi, officeType) {
  const data = []
  const ld = []
  let r = 0
  for (let i = 0; i < localData.length; i++) {
    ld[i] = localData[i].payer_name.toLowerCase().split(' ')
  }
  const pn = partialName.toLowerCase().split(' ')

  for (let j = 0; j < ld.length; j++) {
    let fail = 0
    for (let k = 0; k < pn.length; k++) {
      const ldn = ld[j]
      let found = 0
      for (let l = 0; l < ldn.length; l++) {
        if (ldn[l].indexOf(pn[k]) !== -1) {
          found = 1
          break
        }
      }

      if (found === 0) {
        fail = 1
        break
      }
    }
    if (fail === 0) {
      data[r] = []
      if (idOnly) {
        data[r][0] = localData[j].payer_id.replace(/(\r\n|\n|\r)/gm, '')
      } else {
        data[r][0] = localData[j].payer_id.replace(/(\r\n|\n|\r)/gm, '') + '-' + localData[j].payer_name.replace(/(\r\n|\n|\r)/gm, '')
      }
      data[r][1] = localData[j].payer_id.replace(/(\r\n|\n|\r)/gm, '') + ' - ' + localData[j].payer_name.replace(/(\r\n|\n|\r)/gm, '')
      data[r][2] = localData[j].enrollment_required
      data[r][3] = localData[j].enrollment_mandatory_fields
      r++
    }
  }

  if (data.length === 0) {
    $('.json_patient').remove()
    $('.create_new').remove()
    $('.no_matches').remove()
    const template = $('#' + hint + ' ul .template')
    let newLi = template
      .clone(true)
      .removeClass('template')
      .addClass('no_matches')
    templateListRefLocal(newLi, 'No Matches')
      .appendTo('#' + hint + ' ul')
      .fadeIn()
    let label = 'person'
    if (hinttype === 'referrer') {
      label = 'referrer'
    } else if (hinttype === 'contact') {
      label = 'contact'
    }
    if (hinttype !== 'eligibility' && hinttype !== 'ins_payer') {
      newLi = template
        .clone(true)
        .removeClass('template')
        .addClass('create_new')
        .attr('onclick', 'loadPopupRefer(\'add_contact.php?addtopat=' + pid + '&from=add_patient&in_field=' + inField + '&id_field=' + idField + '&search=' + (partialName.replace(/'/g, "\\'")) + '\')')
      templateListRefLocal(newLi, 'Add ' + label + ' with this name&#8230;')
        .appendTo('#' + hint + ' ul')
        .fadeIn()
    }
  } else {
    $('.json_patient').remove()
    $('.create_new').remove()
    $('.no_matches').remove()
    for (let i in data) {
      const name = data[i][1]
      let newLi
      if (inField === 'contact_name') {
        newLi = $('#' + hint + ' ul .template')
          .clone(true)
          .removeClass('template')
          .addClass('json_patient')
          .data('rowid', data[i][0])
          .data('rowsource', data[i][0])
          .attr('onclick', "loadPopup('view_contact.php?ed=" + data[i][0] + "')")
      } else {
        newLi = $('#' + hint + ' ul .template')
          .clone(true)
          .removeClass('template')
          .addClass('json_patient')
          .data('rowid', data[i][0])
          .data('rowsource', data[i][0])
          .attr('onclick', "update_referredby_local('" + inField + "','" + (name.replace(/'/g, "\\'")) + "', '" + idField + "', '" + data[i][0] + "', '" + source + "', '" + data[i][1] + "','" + hint + "','" + data[i][2] + "', '" + checkEnrollment + "', '" + npi + "','" + officeType + "', '" + data[i][3] + "')")
      }
      templateListRefLocal(newLi, name)
        .appendTo('#' + hint + ' ul')
        .fadeIn()
    }
  }
}

function templateListRefLocal (li, val) {
  li.html(val)
  return li
}

export function updateReferredbyLocal (inField, name, idField, id, source, t, hint, enrollment, checkEnrollment, npi, officeType, enrollmentMandatoryFields) {
  if (enrollmentMandatoryFields !== '') {
    const emf = enrollmentMandatoryFields.split(',')
    $('.formControl').removeClass('required')
    for (let i = 0; i < emf.length; i++) {
      $('#' + emf[i]).addClass('required')
      if (emf[i] === 'medicaid_id') {
        alert('Medicaid enrollment is not supported at this time. Please open a support ticket for further assistance.')
      }
    }
  }

  if (enrollment === 'true' && checkEnrollment === 'true') {
    $.ajax({
      url: '/manage/includes/check_enrollment.php',
      type: 'post',
      data: {payer: id, npi: npi},
      success: function (data) {
        const r = $.parseJSON(data)
        if (r.enrolled === 'yes') {
          // Allow to be selected
        } else {
          alert(r.message)
          const legacyUrl = ProcessWrapper.getLegacyRoot()
          if (officeType === 1) {
            LocationWrapper.goToPage(legacyUrl + 'manage_enrollment.php')
            return
          }
          LocationWrapper.goToPage(legacyUrl + 'manage_enrollments.php?ed=' + r.userid)
        }
      },
      failure: function () {
      }
    })
    return false
  }

  $('#' + inField).val(name).trigger('change')
  $('#' + idField).val(id).trigger('change')

  if (source !== '') {
    $('#' + source).val(t)
  }
  $('#' + hint).css('display', 'none')
}

$('.autocomplete_search').click(function () {
  if ($(this).val() === 'Type referral name' || $(this).val() === 'Type contact name' || $(this).val() === 'Type insurance payer name' || $(this).val() === 'TYPE INSURANCE PAYER NAME') {
    $(this).val('')
  }
})

export function updatevalLocal (t) {
  if (t.value === 'Type referral name' || t.value === 'Type contact name' || t.value === 'Type insurance payer name') {
    t.value = ''
  }
}
