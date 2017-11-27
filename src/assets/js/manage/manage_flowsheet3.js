import $ from 'jquery'
import { getParameterByName } from './autocomplete'
import { updateCompletedDate } from './appointment_summary'
import { debounceCall } from './top'
import { loadPopup } from './popup'
import Calendar from '../../../../static/third-party/JSCal/src/js/jscal2.min'

$('.completed_today').click(function () {
  const id = $(this).attr('id').substring(10)
  const pid = getParameterByName('pid')
  $.ajax({
    url: 'includes/update_appt_today.php',
    type: 'post',
    data: {id: id, pid: pid},
    success: function (data) {
      const r = $.parseJSON(data)
      if (!r.error) {
        updateCurrentStep()
        $('#next_step').html(r.next_steps)
        $('#' + id).val('')
        $('#datecomp_' + id).text(r.datecomp)
        const $tr = $('#completed_row_temp')
        const $clone = $tr.clone()
        $clone.attr('id', 'completed_row_' + r.id)
        $clone.find('.title').text(r.title)
        $clone.find('.completed_date').val(r.datecomp)
        $clone.find('.completed_date').attr('id', 'completed_date_' + r.id)
        if (r.letters > 0) {
          $clone.find('.letters').html('<a href="patient_letters.php?pid=' + pid + '">' + r.letters + ' Letters</a>')
        } else {
          $clone.find('.letters').text('0 Letters')
        }
        $clone.find('.deleteButton').attr('onclick', "return delete_segment('" + r.id + "');")
        $tr.after($clone)
        $clone.show()
        // SETUP CAL FOR NEW CALENDAR FIELD
        const cid = 'completed_date_' + r.id
        if (cid) {
          Calendar.setup({
            inputField: cid,
            trigger: cid,
            fdow: 0,
            align: 'Bl///T/',
            onSelect: function () {
              this.hide()
              updateCompletedDate(cid)
            },
            dateFormat: '%m/%d/%Y'
          })
        }

        $('#next_step').val('')
        $('#next_step_date').val('')
        $('#next_step_until').text('')
        if (id === 9) {
          const $r = $('#noncomp_reason_tmp')
          const $reason = $r.clone()
          const $t = $clone.find('.title')
          $reason.find('.noncomp_reason').attr('id', 'noncomp_reason' + r.id)
          $reason.find('.old_noncomp_reason').attr('id', 'old_noncomp_reason_' + r.id)
          $reason.find('.noncomp_reason').attr('onfocus', "$('#old_noncomp_reason_" + r.id + "').val($(this).val());")
          $reason.find('.reason_btn').attr('id', 'reason_btn' + r.id)
          $reason.find('.reason_btn').attr('onclick', "Javascript: loadPopup('flowsheet_other_reason.php?ed=" + r.id + "&pid=<?php echo $_GET['pid']?>&sid=9');")
          $t.after($reason)
          $reason.show()
          loadPopup('includes/flowsheet_noncomp_select.php?pid=' + pid + '&id=' + r.id)
        }
        if (id === 5) {
          const $r = $('#delay_reason_tmp')
          const $reason = $r.clone()
          const $t = $clone.find('.title')
          $reason.find('.delay_reason').attr('id', 'delay_reason_' + r.id)
          $reason.find('.old_delay_reason').attr('id', 'old_delay_reason_' + r.id)
          $reason.find('.delay_reason').attr('onfocus', "$('#old_delay_reason_" + r.id + "').val($(this).val());")
          $reason.find('.reason_btn').attr('id', 'reason_btn' + r.id)
          $reason.find('.reason_btn').attr('onclick', "Javascript: loadPopup('flowsheet_other_reason.php?ed=" + r.id + "&pid=<?php echo $_GET['pid']?>&sid=5');")
          $t.after($reason)
          $reason.show()
          loadPopup('includes/flowsheet_delay_tx_select.php?pid=' + pid + '&id=' + r.id)
        }
        if (id === 3) {
          const $r = $('#sleep_study_titration_tmp')
          const $type = $r.clone()
          const $t = $clone.find('.title')
          $type.find('.study_type').attr('id', 'study_type_' + r.id)
          $t.after($type)
          $type.show()
          loadPopup('includes/flowsheet_study_type_select.php?pid=' + pid + '&id=' + r.id)
        }
        if (id === 15) {
          const $r = $('#sleep_study_baseline_tmp')
          const $type = $r.clone()
          const $t = $clone.find('.title')
          $type.find('.study_type').attr('id', 'study_type_' + r.id)
          $t.after($type)
          $type.show()
          loadPopup('includes/flowsheet_study_type_select.php?pid=' + pid + '&id=' + r.id)
        }
        if ((id === 4 || id === 7)) {
          const $r = $('#dentaldevice_tmp')
          const $type = $r.clone()
          const $t = $clone.find('.title')
          $type.find('.dentaldevice').attr('id', 'dentaldevice_' + r.id)
          $t.after($type)
          $type.show()
          if (!r.impression) {
            loadPopup('includes/impression_device.php?pid=' + pid + '&id=' + r.id)
          } else {
            $('#dentaldevice_' + r.id).val(r.impression)
          }
        }
      }
    },
    failure: function () {}
  })
})

$('#next_step').change(function () {
  updateNextSched()
});

(function () {
  let ajaxCall = null
  const $this = $('#tracker-notes')

  $this.bind('change keyup', debounceCall(function () {
    $this.css('border-color', 'orange')
    $this.attr('title', 'Saving notes...')

    if (ajaxCall) {
      ajaxCall.abort()
      ajaxCall = null
    }

    $.ajax({
      url: '/manage/add_patient.php?noheaders=1&pid=' + getParameterByName('pid'),
      type: 'post',
      data: { from_tracker: true, tracker_notes: $this.val().trim() },
      success: function () {
        $this.css('border-color', 'green')
        $this.attr('title', 'Notes saved')
      },
      error: function () {
        $this.css('border-color', 'red')
        $this.attr('title', 'Error while saving the notes, type again to attempt to save once more')
      },
      complete: function () {
        ajaxCall = null
      }
    })
  }, { timeout: 2000 }))
}())

export function updateNextSched () {
  const id = $('#next_step').val()
  const pid = getParameterByName('pid')
  const sched = $('#next_step_date').val()
  $.ajax({
    url: 'includes/update_appt_sched.php',
    type: 'post',
    data: {id: id, sched: sched, pid: pid},
    success: function (data) {
      const r = $.parseJSON(data)
      if (!r.error) {
        updateCurrentStep()
      }
    },
    failure: function () {}
  })
}

export function updateStudyType (id, val) {
  $('#study_type_' + id).val(val)
}

export function updateDelayReason (id, val) {
  $('#delay_reason_' + id).val(val)
}

export function updateNoncompReason (id, val) {
  $('#noncomp_reason' + id).val(val)
}

export function updateDentalDevice (id, val) {
  $('#dentaldevice_' + id).val(val)
}

export function updateCurrentStep () {
  if ($('#next_step').val() !== '' && $('#next_step_date').val() !== '') {
    $('#treatment_list').addClass('current_step')
    $('#sched_div').removeClass('current_step')
  } else {
    $('#treatment_list').removeClass('current_step')
    $('#sched_div').addClass('current_step')
  }
}
