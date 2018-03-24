import $ from 'jquery'

function calcAmountLeftToMeet (shouldDisableCalculations) {
  if (shouldDisableCalculations) {
    return
  }
  let deductible = $('#patient_deductible').val()
  let amountMet = $('#patient_amount_met').val()
  if (isNaN(deductible)) {
    deductible = 0
  }
  if (isNaN(amountMet)) {
    amountMet = 0
  }
  let leftToMeet = deductible - amountMet
  if (leftToMeet < 0) {
    leftToMeet = 0
  }
  $('#patient_amount_left_to_meet').val(leftToMeet.toFixed(2))
  deductible = $('#in_patient_deductible').val()
  amountMet = $('#in_patient_amount_met').val()
  if (isNaN(deductible)) {
    deductible = 0
  }
  if (isNaN(amountMet)) {
    amountMet = 0
  }
  leftToMeet = deductible - amountMet
  if (leftToMeet < 0) {
    leftToMeet = 0
  }
  $('#in_patient_amount_left_to_meet').val(leftToMeet.toFixed(2))
}

function calcAmountLeftToMeetFamily (shouldDisableCalculations) {
  if (shouldDisableCalculations) {
    return
  }
  let deductible = $('#family_deductible').val()
  let amountMet = $('#family_amount_met').val()
  if (isNaN(deductible)) {
    deductible = 0
  }
  if (isNaN(amountMet)) {
    amountMet = 0
  }
  let leftToMeet = deductible - amountMet
  if (leftToMeet < 0) {
    leftToMeet = 0
  }
  $('#family_amount_left_to_meet').val(leftToMeet.toFixed(2))
  deductible = $('#in_family_deductible').val()
  amountMet = $('#in_family_amount_met').val()
  if (isNaN(deductible)) {
    deductible = 0
  }
  if (isNaN(amountMet)) {
    amountMet = 0
  }
  leftToMeet = deductible - amountMet
  if (leftToMeet < 0) {
    leftToMeet = 0
  }
  $('#in_family_amount_left_to_meet').val(leftToMeet.toFixed(2))
}

function calcExpectedPayments (shouldDisableCalculations) {
  if (shouldDisableCalculations) {
    return
  }
  // OUT OF NETWORK BENEFITS
  let debug = true
  if (debug) {
    console.log('calc_expected_payments')
  }
  let deductibleFrom = $("input[name='deductible_from']:checked").val()
  let deviceAmount = $('#trxn_code_amount2').val()
  let amountLeftToMeet
  if (deductibleFrom === '1') {
    amountLeftToMeet = $('#patient_amount_left_to_meet').val()
  } else {
    amountLeftToMeet = $('#family_amount_left_to_meet').val()
  }
  const hasOutOfNetwork = $("input[name='has_out_of_network_benefits']:checked").val()
  let isHmo = $("input[name='is_hmo']:checked").val()
  let outOfPocketMet = $("input[name='out_of_pocket_met']:checked").val()
  let percentagePaid = 0

  if (debug) {
    console.log('amountLeftToMeet: ' + amountLeftToMeet)
    console.log('hasOutOfNetwork: ' + hasOutOfNetwork)
    console.log('isHmo: ' + isHmo)
    console.log('outOfPocketMet: ' + outOfPocketMet)
  }
  if (hasOutOfNetwork === 1) {
    // percentage from out_of_network_percentage
    percentagePaid = $('#out_of_network_percentage').val()
  } else {
    // no percentage, set to 0
    percentagePaid = 0
  }
  if (debug) {
    console.log('percentagePaid: ' + percentagePaid)
  }

  if (isNaN(deviceAmount)) {
    deviceAmount = 0
  }
  if (isNaN(percentagePaid)) {
    percentagePaid = 0
  }
  if (isNaN(amountLeftToMeet)) {
    amountLeftToMeet = 0
  }

  if (outOfPocketMet === 1) {
    $('#expected_insurance_payment').val(deviceAmount)
    $('#expected_patient_payment').val('0.00')
    if (debug) {
      console.log('expected_insurance_payment: ' + deviceAmount)
      console.log('expected_patient_payment: ' + 0.00)
    }
  } else {
    let expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid / 100)
    if (expectedInsurancePayment < 0) {
      expectedInsurancePayment = 0
    }

    let expectedPatientPayment = deviceAmount - expectedInsurancePayment
    if (expectedPatientPayment < 0) {
      expectedPatientPayment = 0
    }

    if (debug) {
      console.log('expectedInsurancePayment: ' + expectedInsurancePayment.toFixed(2))
      console.log('expectedPatientPayment: ' + expectedPatientPayment.toFixed(2))
    }
    $('#expected_insurance_payment').val(expectedInsurancePayment.toFixed(2))
    $('#expected_patient_payment').val(expectedPatientPayment.toFixed(2))
  }

  if (debug) {
    console.log('-----------------------')
  }

  // IN NETWORK BENEFITS
  if (debug) {
    console.log('calc_expected_payments')
  }
  deductibleFrom = $("input[name='in_deductible_from']:checked").val()
  deviceAmount = $('#in_trxn_code_amount2').val()
  if (deductibleFrom === '1') {
    amountLeftToMeet = $('#in_patient_amount_left_to_meet').val()
  } else {
    amountLeftToMeet = $('#in_family_amount_left_to_meet').val()
  }
  const hasInNetwork = $("input[name='has_in_network_benefits']:checked").val()
  isHmo = $('input[name="is_hmo"]:checked').val()
  outOfPocketMet = $("input[name='in_out_of_pocket_met']:checked").val()
  percentagePaid = 0

  if (debug) {
    console.log('amountLeftToMeet: ' + amountLeftToMeet)
    console.log('hasOutOfNetwork: ' + hasOutOfNetwork)
    console.log('isHmo: ' + isHmo)
    console.log('outOfPocketMet: ' + outOfPocketMet)
  }
  if (hasInNetwork === 1) {
    // percentage from out_of_network_percentage
    percentagePaid = $('#in_network_percentage').val()
  } else {
    // no percentage, set to 0
    percentagePaid = 0
  }
  if (debug) {
    console.log('percentagePaid: ' + percentagePaid)
  }

  if (isNaN(deviceAmount)) {
    deviceAmount = 0
  }
  if (isNaN(percentagePaid)) {
    percentagePaid = 0
  }
  if (isNaN(amountLeftToMeet)) {
    amountLeftToMeet = 0
  }

  if (outOfPocketMet === 1) {
    $('#in_expected_insurance_payment').val(deviceAmount)
    $('#in_expected_patient_payment').val('0.00')
    if (debug) {
      console.log('in_expected_insurance_payment: ' + deviceAmount)
      console.log('in_expected_patient_payment: ' + 0.00)
    }
  } else {
    let expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid / 100)
    if (expectedInsurancePayment < 0) {
      expectedInsurancePayment = 0
    }

    let expectedPatientPayment = deviceAmount - expectedInsurancePayment
    if (expectedPatientPayment < 0) {
      expectedPatientPayment = 0
    }

    if (debug) {
      console.log('expectedInsurancePayment: ' + expectedInsurancePayment.toFixed(2))
      console.log('expectedPatientPayment: ' + expectedPatientPayment.toFixed(2))
    }
    $('#in_expected_insurance_payment').val(expectedInsurancePayment.toFixed(2))
    $('#in_expected_patient_payment').val(expectedPatientPayment.toFixed(2))
  }

  if (debug) {
    console.log('-----------------------')
  }
}

$("input[name='has_out_of_network_benefits']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#has_out_of_network_benefits_yes').css('display', 'block')
    $('#has_out_of_network_benefits_no').css('display', 'none')
  } else {
    $('#has_out_of_network_benefits_yes').css('display', 'none')
    $('#has_out_of_network_benefits_no').css('display', 'block')
  }
})
$("input[name='has_out_of_network_benefits']:checked").click()

$("input[name='has_in_network_benefits']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#has_in_network_benefits_yes').css('display', 'block')
    $('#has_in_network_benefits_no').css('display', 'none')
  } else {
    $('#has_in_network_benefits_yes').css('display', 'none')
    $('#has_in_network_benefits_no').css('display', 'block')
  }
})
$("input[name='has_in_network_benefits']:checked").click()

$("input[name='is_hmo']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#is_hmo_yes').css('display', 'block')
    $('#is_hmo_no').css('display', 'none')
  } else {
    $('#is_hmo_yes').css('display', 'none')
    $('#is_hmo_no').css('display', 'block')
  }
})
$("input[name='is_hmo']:checked").click()

$("input[name='hmo_needs_auth']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#hmo_needs_auth_yes').css('display', 'block')
  } else {
    $('#hmo_needs_auth_yes').css('display', 'none')
  }
})
$("input[name='hmo_needs_auth']:checked").click()

$("input[name='is_pre_auth_required']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#is_pre_auth_required_yes').css('display', 'block')
  } else {
    $('#is_pre_auth_required_yes').css('display', 'none')
  }
})
$("input[name='is_pre_auth_required']:checked").click()
$("input[name='in_is_pre_auth_required']").bind('click', function () {
  if ($(this).val() === 1) {
    $('#in_is_pre_auth_required_yes').css('display', 'block')
  } else {
    $('#in_is_pre_auth_required_yes').css('display', 'none')
  }
})
$("input[name='in_is_pre_auth_required']:checked").click()

const insCalYearEnd = $('#ins_cal_year_end')
insCalYearEnd.bind('focus blur click', function () {
  if ($(this).val() === '') {
    $('#deductible_reset_date').val('')
    $('#in_deductible_reset_date').val('')
  } else {
    const myDate = new Date($(this).val())
    myDate.setDate(myDate.getDate() + 1)
    $('#deductible_reset_date').val(parseInt(myDate.getMonth() + 1, 10) + '/' + myDate.getDate() + '/' + myDate.getFullYear())
    $('#in_deductible_reset_date').val(parseInt(myDate.getMonth() + 1, 10) + '/' + myDate.getDate() + '/' + myDate.getFullYear())
  }
})
insCalYearEnd.blur()

$('#ins_cal_year').bind('click', function () {
  if (insCalYearEnd.val() === '') {
    $('#deductible_reset_date').val('')
    $('#in_deductible_reset_date').val('')
  } else {
    const myDate = new Date($('#ins_cal_year_end').val())
    myDate.setDate(myDate.getDate() + 1)
    $('#deductible_reset_date').val(parseInt(myDate.getMonth() + 1, 10) + '/' + myDate.getDate() + '/' + myDate.getFullYear())
    $('#in_deductible_reset_date').val(parseInt(myDate.getMonth() + 1, 10) + '/' + myDate.getDate() + '/' + myDate.getFullYear())
  }
})

$('#patient_deductible, #patient_amount_met, #in_patient_deductible, #in_patient_amount_met').bind('focus blur click', function () {
  calcAmountLeftToMeet()
  calcExpectedPayments()
})

$("input[name='deductible_from'], input[name='in_deductible_from']").bind('focus blur click', function () {
  calcExpectedPayments()
})

$('#family_deductible, #family_amount_met, #in_family_deductible, #in_family_amount_met').bind('focus blur click', function () {
  calcAmountLeftToMeetFamily()
  calcExpectedPayments()
})

const fields = $('#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met, #in_patient_deductible, #in_patient_amount_met, #in_family_deductible, #in_family_amount_met')
// Fields that should be clear on focus if value is 0
fields.bind('focus', function () {
  const value = $(this).val()
  if (isNaN(value) || (value === 0)) {
    $(this).val('')
  }
})

// Fields that should display two decimal places on blur
fields.bind('blur', function () {
  const value = parseFloat($(this).val())
  if (!isNaN(value)) {
    $(this).val(value.toFixed(2))
  }
})

// Fields that should trigger calculations
$('#out_of_network_percentage, #in_network_percentage, #patient_deductible, #patient_amount_met').bind('mouseup keyup', function () {
  calcExpectedPayments()
})
$("[name='has_out_of_network_benefits'], [name='has_in_network_benefits'], [name='network_benefits'], [name='is_hmo'], [name='out_of_pocket_met']").bind('change', function () {
  calcExpectedPayments()
})

// Fields where the user shouldn't be able to gain focus
$('#patient_amount_left_to_meet, #family_amount_left_to_meet, #in_patient_amount_left_to_meet, #in_family_amount_left_to_meet, #deductible_reset_date, #expected_insurance_payment, #expected_patient_payment').bind('focus', function () {
  $(this).blur()
})

// Disable/enable fields related to this trxn code being covered by insurance
$("input[name='trxn_code_covered']").bind('click', function () {
  if ($(this).val() === '1') {
    // enable all the "covered" fields
    $('.covered').each(function () {
      $(this).removeAttr('disabled')
      $(this).css('background-color', '')
    })

    // show all the "covered-row" elements
    $('.covered-row').show()

    // update expected payments
    calcExpectedPayments()
  } else {
    // hide all the "covered-row" elements
    $('.covered-row').hide()

    // manually set expected payments
    const deviceAmount = $('#trxn_code_amount2').val()
    $('#expected_insurance_payment').val('0.00')
    $('#expected_patient_payment').val(deviceAmount)

    // disable all the "covered" fields
    $('.covered').each(function () {
      $(this).attr('disabled', 'true')
      $(this).css('background-color', '#cccccc')
    })
  }
})
$("input[name='trxn_code_covered']:checked").click()
