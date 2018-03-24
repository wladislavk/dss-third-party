import $ from 'jquery'
import { getParameterByName } from './autocomplete'

$(document).ready(function () {
  $('#notecontent').find('input').change(function () {
    window.onbeforeunload = function () {
      return 'You have made changes to Notes/Personal and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.'
    }
  })

  $('#rom_form').find('input').change(function () {
    window.onbeforeunload = function () {
      return 'You have made changes to ROM data and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.'
    }
  })
})

$('#dental_device').change(function () {
  const val = $('#dental_device').val()
  const pid = getParameterByName('pid')

  $.ajax({
    url: 'includes/summ_device_update.php',
    type: 'post',
    data: {device: val, pid: pid},
    success: function () {},
    failure: function () {}
  })
})

export function updateDentalDeviceDate () {
  const val = $('#dental_device_date').val()
  const pid = getParameterByName('pid')
  $.ajax({
    url: 'includes/summ_device_date_update.php',
    type: 'post',
    data: {device_date: val, pid: pid},
    success: function () {},
    failure: function () {}
  })
}
