import $ from 'jquery'
import { updateCompletedDate } from './appointment_summary'
import { updateNextSched } from './manage_flowsheet3'
import { updateDentalDeviceDate } from './summ_summ'
import Calendar from '../../../../static/third-party/JSCal/src/js/jscal2.min'

$(document).ready(function () {
  const inputCalendar = $('input.calendar')

  inputCalendar.each(function () {
    const $this = $(this)
    const cid = $this.attr('id')
    let dateFormat = $this.data('date-format') || 'm/d/Y'

    dateFormat = dateFormat.replace(/([a-z])/ig, '%$1')

    if (cid) {
      Calendar.setup({
        inputField: cid,
        trigger: cid,
        fdow: 0,
        align: 'Bl////',
        onSelect: function () {
          this.hide()
        },
        dateFormat: dateFormat
      })
    }
  })

  $('input.calendar_top').each(function () {
    const cid = $(this).attr('id')
    if (cid) {
      Calendar.setup({
        inputField: cid,
        trigger: cid,
        fdow: 0,
        align: 'T////',
        onSelect: function () {
          this.hide()
        },
        dateFormat: '%m/%d/%Y'
      })
    }
  })

  $('input.flow_next_calendar').each(function () {
    const cid = $(this).attr('id')
    if (cid) {
      Calendar.setup({
        inputField: cid,
        trigger: cid,
        fdow: 0,
        align: 'Bl///T/',
        onSelect: function () {
          this.hide()
          updateNextSched(cid)
        },
        dateFormat: '%m/%d/%Y'
      })
    }
  })

  $('input.flow_comp_calendar').each(function () {
    const cid = $(this).attr('id')
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
  })

  $('input.calendar_device_date').each(function () {
    const cid = $(this).attr('id')
    if (cid) {
      Calendar.setup({
        inputField: cid,
        trigger: cid,
        fdow: 0,
        align: 'Bl///T/',
        onSelect: function () {
          this.hide()
          updateDentalDeviceDate(cid)
        },
        dateFormat: '%m/%d/%Y'
      })
    }
  })

  // hack to force calendar on tabbing
  inputCalendar.focus(function () {
    $(this).click()
  })
})
