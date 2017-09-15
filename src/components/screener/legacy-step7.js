import $ from 'jquery'

export default function (e) {
  e.preventDefault()

  const hstFields = [
    'hst_first_name',
    'hst_last_name',
    'hst_dob',
    'hst_phone',
    'hst_email'
  ]

  const hstCompanyIdInput = $('input[name=hst_company_id]:checked')

  let hasMissingField = false
  for (let hstField of hstFields) {
    let hstDomObject = $('#' + hstField)
    if (hstDomObject.val() === '') {
      hasMissingField = true
    }
  }

  if (hasMissingField || hstCompanyIdInput.length === 0) {
    alert('All fields are required.')
    return
  }

  const $button = $('#secthst').find('#sect4_next')

  $button.addClass('disabled').show()

  const hstFirstName = $('#hst_first_name')
  const hstLastName = $('#hst_last_name')
  const hstDob = $('#hst_dob')
  const hstPhone = $('#hst_phone')
  const hstEmail = $('#hst_email')

  const epworthProps = []

  const ajaxData = {
    screenerid: screenerId,
    docid: $('#docid').val(),
    userid: $('#userid').val(),
    companyid: hstCompanyIdInput.val(),
    patient_first_name: hstFirstName.val(),
    patient_last_name: hstLastName.val(),
    patient_cell_phone: hstPhone.val(),
    patient_email: hstEmail.val(),
    patient_dob: hstDob.val()
  }

  for (let epworth of epworthProps) {
    let ajaxProperty = 'epworth_' + epworth.id
    ajaxData[ajaxProperty] = $('#' + ajaxProperty).val()
  }

  for (let i = 1; i <= 5; i++) {
    let propName = 'snore_' + i
    ajaxData[propName] = $('#' + propName).val()
  }

  $.ajax({
    url: 'script/submit_hst.php',
    type: 'post',
    data: ajaxData,
    success: function (data) {
      const r = $.parseJSON(data)
      if (r.error) {
        onFailure()
      } else {
        alert('HST submitted for approval and is in your Pending HST queue.')
        window.location = 'index.php'
      }
    },
    error: onFailure
  })
}
