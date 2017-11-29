import $ from 'jquery'
import { getParameterByName } from './autocomplete'
import { loadPopup } from './popup'

export function deleteSegment (id) {
  const pid = getParameterByName('pid')
  if (confirm('Are you sure you want to delete this appointment?')) {
    $.ajax({
      url: '/manage/includes/delete_appt.php',
      type: 'post',
      data: {
        id: id,
        pid: pid
      },
      success: function (data) {
        const r = $.parseJSON(data)
        if (!r.error) {
          $('#completed_row_' + id).remove()
        }
      },
      failure: function () {}
    })
  } else {
    return false
  }
}

export function updateCompletedDate (cid) {
  const id = cid.substring(15)
  const compDate = $('#completed_date_' + id).val()
  const pid = getParameterByName('pid')
  $.ajax({
    url: '/manage/includes/update_appt.php',
    type: 'post',
    data: {
      id: id,
      comp_date: compDate,
      pid: pid
    },
    success: function () {},
    failure: function () {}
  })
}

$(document).delegate('.delay_reason', 'change', function () {
  const id = $(this).attr('id').substring(13)
  const reason = $(this).val()
  const pid = getParameterByName('pid')

  const oldReason = $('#old_delay_reason_' + id)
  if (oldReason.val() === 'other' && reason !== 'other') {
    if (!confirm('Are you sure you want to change the reason?')) {
      $(this).val(oldReason.val())
      return false
    }
  }

  $.ajax({
    url: '/manage/includes/flow_delay_reason_update.php',
    type: 'post',
    data: {
      id: id,
      reason: reason,
      pid: pid
    },
    success: function (data) {
      const r = $.parseJSON(data)
      if (!r.error) {
        if (reason === 'other') {
          $(document).find('#reason_btn' + id).show()
          loadPopup('flowsheet_other_reason.php?ed=' + id + '&pid=112&sid=5')
        } else {
          $(document).find('#reason_btn' + id).hide()
        }
      }
    },
    failure: function () {}
  })
})

$(document).delegate('.noncomp_reason', 'change', function () {
  const id = $(this).attr('id').substring(14)
  const reason = $(this).val()
  const pid = getParameterByName('pid')

  const oldReason = $('#old_noncomp_reason_' + id)
  if (oldReason.val() === 'other' && reason !== 'other') {
    if (!confirm('Are you sure you want to change the reason?')) {
      $(this).val(oldReason.val())
      return false
    }
  }

  $.ajax({
    url: '/manage/includes/flow_noncomp_reason_update.php',
    type: 'post',
    data: {
      id: id,
      reason: reason,
      pid: pid
    },
    success: function (data) {
      const r = $.parseJSON(data)
      if (!r.error) {
        if (reason === 'other') {
          $(document).find('#reason_btn' + id).show()
          loadPopup('flowsheet_other_reason.php?ed=' + id + '&pid=112&sid=5')
        } else {
          $(document).find('#reason_btn' + id).hide()
        }
      }
    },
    failure: function () {}
  })
})

$(document).delegate('.dentaldevice', 'change', function () {
  const id = $(this).attr('id').substring(13)
  const device = $(this).val()
  const pid = getParameterByName('pid')

  $.ajax({
    url: '/manage/includes/flow_device_update.php',
    type: 'post',
    data: {
      id: id,
      device: device,
      pid: pid
    },
    success: function () {},
    failure: function () {}
  })
})

$(document).delegate('.study_type', 'change', function () {
  const id = $(this).attr('id').substring(11)
  const type = $(this).val()
  const pid = getParameterByName('pid')

  $.ajax({
    url: '/manage/includes/flow_study_type_update.php',
    type: 'post',
    data: {
      id: id,
      type: type,
      pid: pid
    },
    success: function () {},
    failure: function () {}
  })
})
