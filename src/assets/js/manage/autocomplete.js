import $ from 'jquery'

let fff = 0
let selectionref = 1
let selectedrefUrl = ''
let searchrefVal = '' // global variable to hold the last valid search string

function setupAutocomplete (inField, hint, idField, source, file, hinttype, pid) {
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
      sendValueRef($('#' + inField).val(), inField, hint, idField, source, file, hinttype, pid)
      if ($(this).val() > 2) {
        window.searchVal = $(this).val().replace(/(\s+)?.$/, '') // strip last character to match last positive result
      }
    }
  })
}

function sendValueRef (partialName, inField, hint, idField, source, file, hinttype, pid) {
  $.post(
    file,
    { partial_name: partialName },
    function (data) {
      let newLi
      if (data.length === 0) {
        $('.json_patient').remove()
        $('.create_new').remove()
        $('.no_matches').remove()
        const template = $('#' + hint + ' ul .template')
        newLi = template.clone(true).removeClass('template').addClass('no_matches')
        templateListRef(newLi, 'No Matches')
          .appendTo('#' + hint + ' ul')
          .fadeIn()
        let label
        if (hinttype === 'referrer') {
          label = 'referrer'
        } else if (hinttype === 'contact') {
          label = 'contact'
        } else {
          label = 'person'
        }
        if (hinttype !== 'eligibility' && hinttype !== 'ins_payer') {
          newLi = template.clone(true).removeClass('template').addClass('create_new')
            .attr('onclick', 'loadPopupRefer(\'add_contact.php?addtopat=' + pid + '&from=add_patient&in_field=' + inField + '&id_field=' + idField + '&search=' + (partialName.replace(/'/g, '\\\'')) + '\')')
          templateListRef(newLi, 'Add ' + label + ' with this name&#8230;')
            .appendTo('#' + hint + ' ul')
            .fadeIn()
        }
      } else {
        if (data.error) {
          alert(data.error)
        } else {
          $('.json_patient').remove()
          $('.create_new').remove()
          $('.no_matches').remove()
          for (let i in data) {
            if (data.hasOwnProperty(i)) {
              const name = data[i].name
              if (inField === 'contact_name') {
                newLi = $('#' + hint + ' ul .template')
                  .clone(true)
                  .removeClass('template')
                  .addClass('json_patient')
                  .data('rowid', data[i].id)
                  .data('rowsource', data[i].id)
                  .attr('onclick', 'loadPopup(\'view_contact.php?ed=' + data[i].id + '\')')
              } else {
                newLi = $('#' + hint + ' ul .template')
                  .clone(true)
                  .removeClass('template')
                  .addClass('json_patient')
                  .data('rowid', data[i].id)
                  .data('rowsource', data[i].id)
                  .attr('onclick', "update_referredby('" + inField + "','" + (name.replace(/'/g, "\\'")) + "', '" + idField + "', '" + data[i].id + "', '" + source + "', '" + data[i].source + "','" + hint + "')")
              }
              templateListRef(newLi, name)
                .appendTo('#' + hint + ' ul')
                .fadeIn()
            }
          }
        }
      }
    },
    'json'
  )
}

function templateListRef (li, val) {
  li.html(val)
  return li
}

function updateReferredby (inField, name, idField, id, source, t, hint) {
  $('#' + inField).val(name)
  $('#' + idField).val(id)
  if (source !== '') {
    $('#' + source).val(t)
  }
  $('#' + hint).css('display', 'none')
}

$('.autocomplete_search').click(function () {
  if ($(this).val() === 'Type referral name' || $(this).val() === 'Type contact name' || $(this).val() === 'Type insurance payer name') {
    $(this).val('')
  }
})

function updateval (t) {
  if (t.value === 'Type referral name' || t.value === 'Type contact name' || t.value === 'Type patient name' || t.value === 'Type insurance payer name' || t.value === 'Search Calendar') {
    t.value = ''
  }
}

function getParameterByName (name) {
  name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]')
  const regex = new RegExp('[\\?&]' + name + '=([^&#]*)')
  const results = regex.exec(location.search)
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '))
}
