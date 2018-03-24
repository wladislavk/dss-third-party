function isEmail (email) {
  if (!email.match(/^[A-Za-z0-9._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/)) {
    return false
  }
  return true
}

export function trim (inputString) {
  // Removes leading and trailing spaces from the passed string. Also removes
  // consecutive spaces and replaces it with one space. If something besides
  // a string is passed in (null, custom object, etc.) then return the input.
  if (typeof inputString !== 'string') {
    return inputString
  }
  let retValue = inputString
  let ch = retValue.substring(0, 1)
  while (ch === ' ') { // Check for spaces at the beginning of the string
    retValue = retValue.substring(1, retValue.length)
    ch = retValue.substring(0, 1)
  }
  ch = retValue.substring(retValue.length - 1, retValue.length)
  while (ch === ' ') { // Check for spaces at the end of the string
    retValue = retValue.substring(0, retValue.length - 1)
    ch = retValue.substring(retValue.length - 1, retValue.length)
  }
  while (retValue.indexOf('  ') !== -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
    retValue = retValue.substring(0, retValue.indexOf('  ')) + retValue.substring(retValue.indexOf('  ') + 1, retValue.length) // Again, there are two spaces in each of the strings
  }
  return retValue
}

export function isDate (d) {
  if (d.search(/^(\d){1,2}[-/\\](\d){1,2}[-/\\]\d{4}$/) !== 0) {
    return -1 // Bad Date Format
  }
  const T = d.split(/[-/]/)
  const M = T[0]
  const D = T[1]
  const Y = T[2]
  return D > 0 &&
    (
      (D <= [null, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][M] || D === 29) &&
      Y % 4 === 0 &&
      (Y % 100 !== 0 || Y % 400 === 0)
    )
}

export function isValidCreditCard (type, ccnum) {
  let re
  switch (type) {
    // Visa: length 16, prefix 4, dashes optional.
    case 'Visa':
    case 'VI':
      re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/
      break
    // Mastercard: length 16, prefix 51-55, dashes optional.
    case 'MasterCard':
    case 'MC':
      re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/
      break
    // Discover: length 16, prefix 6011, dashes optional.
    case 'Discover':
    case 'NO':
      re = /^6011-?\d{4}-?\d{4}-?\d{4}$/
      break
    // American Express: length 15, prefix 34 or 37.
    case 'AmEx':
    case 'AX':
      re = /^3[4,7]\d{13}$/
      break
    // Diners: length 14, prefix 30, 36, or 38.
    case 'Diners':
      re = /^3[068,]\d{12}$/
      break
    // Bankcard: length 16, prefix 5610 dashes optional.
    case 'Bankcard':
      re = /^5610-?\d{4}-?\d{4}-?\d{4}$/
      break
    // @todo: these regexps do not work as expected
    case 'JCB':
      re = /^[01256789|]\d{12}$/
      break
    case 'EnRoute':
      re = /^[01249|]\d{11}$/
      break
    case 'Switch':
      re = /^[01345679|]\d{12}$/
      break
  }

  if (!re.test(ccnum)) return false
  // Checksum ("Mod 10")
  // Add even digits in even length strings or odd digits in odd length strings.
  let checksum = 0
  for (let i = (2 - (ccnum.length % 2)); i <= ccnum.length; i += 2) {
    checksum += parseInt(ccnum.charAt(i - 1))
  }
  // Analyze odd digits in even length strings or even digits in odd length strings.
  for (let j = (ccnum.length % 2) + 1; j < ccnum.length; j += 2) {
    const digit = parseInt(ccnum.charAt(j - 1)) * 2
    if (digit < 10) {
      checksum += digit
    } else {
      checksum += (digit - 9)
    }
  }
  if ((checksum % 10) === 0) {
    return true
  }
  return false
}

export function adminticketabc (fa) {
  if (trim(fa.docid.value) === '') {
    alert('Account is Required')
    fa.docid.focus()
    return false
  }
  if (trim(fa.userid.value) === '') {
    alert('User is Required')
    fa.userid.focus()
    return false
  }
  if (trim(fa.category_id.value) === '') {
    alert('Category is Required')
    fa.category_id.focus()
    return false
  }
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }
  if (trim(fa.body.value) === '') {
    alert('Message is Required')
    fa.body.focus()
    return false
  }
}

export function loginabc (fa) {
  if (trim(fa.username.value) === '') {
    alert('Username is Required')
    fa.username.focus()
    return false
  }
  if (trim(fa.password.value) === '') {
    alert('Password is Required')
    fa.password.focus()
    return false
  }
  return true
}

export function passabc (fa) {
  if (trim(fa.old_pass.value) === '') {
    alert('Old Password is Required')
    fa.old_pass.focus()
    return false
  }
  if (trim(fa.new_pass.value) === '') {
    alert('New Password is Required')
    fa.new_pass.focus()
    return false
  }
  if (trim(fa.new_pass.value) !== trim(fa.re_pass.value)) {
    alert('Re-Enter Password Mismatch')
    fa.re_pass.focus()
    return false
  }
  return true
}

export function areaabc (fa) {
  if (trim(fa.area.value) === '') {
    alert('Area is Required')
    fa.area.focus()
    return false
  }
}

export function userregabc (fa) {
  if (trim(fa.first_name.value) === '') {
    alert('First Name is Required')
    fa.first_name.focus()
    return false
  }
  if (trim(fa.last_name.value) === '') {
    alert('Last Name is Required')
    fa.last_name.focus()
    return false
  }
  if (trim(fa.phone.value) === '') {
    alert('Cell Phone is Required')
    fa.phone.focus()
    return false
  }
  if (trim(fa.email.value) === '') {
    alert('Email is Required')
    fa.email.focus()
    return false
  }
  return true
}

export function userabcWarn (fa) {
  const errors = []
  if (trim(fa.username.value) === '') {
    errors.push('Username is Required')
  }
  if (trim(fa.npi.value) === '') {
    errors.push('NPI Number is Required')
  }
  if (trim(fa.tax_id_or_ssn.value) === '') {
    errors.push('Tax ID or SSN is Required')
  }
  if (!fa.ein.checked && !fa.ssn.checked) {
    errors.push('EIN or SSN is Required')
  }
  if (trim(fa.practice.value) === '') {
    errors.push('Practice is Required')
  }
  if (fa.password) {
    if (trim(fa.password.value) === '') {
      errors.push('Password is Required')
    }
    const pass = fa.password.value
    if (pass.search(/[A-Za-z]/) < 0) {
      errors.push('Password must contain an alpha character')
    }
    if (pass.search(/[0-9]/) < 0) {
      errors.push('Password must contain a numeric character')
    }
    if (trim(fa.password.value) !== trim(fa.password2.value)) {
      errors.push('Password fields must match')
    }
  }
  if (trim(fa.first_name.value) === '') {
    errors.push('First Name is Required')
  }
  if (trim(fa.last_name.value) === '') {
    errors.push('Last Name is Required')
  }
  if (trim(fa.email.value) === '') {
    errors.push('Email is Required')
  }
  if (!isEmail(trim(fa.email.value))) {
    errors.push('In-Valid Email ')
  }
  if (trim(fa.address.value) === '') {
    errors.push('Address is Required')
  }
  if (trim(fa.city.value) === '') {
    errors.push('City is Required')
  }
  if (trim(fa.state.value) === '') {
    errors.push('State is Required')
  }
  if (trim(fa.zip.value) === '') {
    errors.push('Zip is Required')
  }
  if (trim(fa.phone.value) === '') {
    errors.push('Phone is Required')
  }
  if (errors.length > 0) {
    return confirm('Warning! There following fields are incomplete in this user profile:\n' + errors + '\nContinue and save without completing the remaining fields?')
  }
  return true
}

export function userabc (fa) {
  if (trim(fa.username.value) === '') {
    alert('Username is Required')
    fa.username.focus()
    return false
  }
  if (trim(fa.npi.value) === '') {
    alert('NPI Number is Required')
    fa.npi.focus()
    return false
  }
  if (trim(fa.tax_id_or_ssn.value) === '') {
    alert('Tax ID or SSN is Required')
    fa.tax_id_or_ssn.focus()
    return false
  }
  if (!fa.ein.checked && !fa.ssn.checked) {
    alert('EIN or SSN is Required')
    fa.ein.focus()
    return false
  }
  if (trim(fa.practice.value) === '') {
    alert('Practice is Required')
    fa.practice.focus()
    return false
  }
  if (fa.password) {
    if (trim(fa.password.value) === '') {
      alert('Password is Required')
      fa.password.focus()
      return false
    }
    const pass = fa.password.value
    if (pass.search(/[A-Za-z]/) < 0) {
      alert('Password must contain an alpha character')
      fa.password.focus()
      return false
    }
    if (pass.search(/[0-9]/) < 0) {
      alert('Password must contain a numeric character')
      fa.password.focus()
      return false
    }
    if (trim(fa.password.value) !== trim(fa.password2.value)) {
      alert('Password fields must match')
      fa.password.focus()
      return false
    }
  }
  if (trim(fa.first_name.value) === '') {
    alert('First Name is Required')
    fa.first_name.focus()
    return false
  }
  if (trim(fa.last_name.value) === '') {
    alert('Last Name is Required')
    fa.last_name.focus()
    return false
  }
  if (trim(fa.email.value) === '') {
    alert('Email is Required')
    fa.email.focus()
    return false
  }
  if (!isEmail(trim(fa.email.value))) {
    alert('In-Valid Email ')
    fa.email.focus()
    return false
  }
  if (trim(fa.address.value) === '') {
    alert('Address is Required')
    fa.address.focus()
    return false
  }
  if (trim(fa.city.value) === '') {
    alert('City is Required')
    fa.city.focus()
    return false
  }
  if (trim(fa.state.value) === '') {
    alert('State is Required')
    fa.state.focus()
    return false
  }
  if (trim(fa.zip.value) === '') {
    alert('Zip is Required')
    fa.zip.focus()
    return false
  }
  if (trim(fa.phone.value) === '') {
    alert('Phone is Required')
    fa.phone.focus()
    return false
  }
}

export function staffabc (fa) {
  if (trim(fa.username.value) === '') {
    alert('Username is Required')
    fa.username.focus()
    return false
  }
  if (fa.password) {
    if (trim(fa.password.value) === '') {
      alert('Password is Required')
      fa.password.focus()
      return false
    }
  }
  if (trim(fa.name.value) === '') {
    alert('Name is Required')
    fa.name.focus()
    return false
  }
  if (trim(fa.email.value) === '') {
    alert('Email is Required')
    fa.email.focus()
    return false
  } else if (!isEmail(trim(fa.email.value))) {
    alert('In-Valid Email ')
    fa.email.focus()
    return false
  }
}

export function pageabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }
}

export function patientabc (fa) {
  if (trim(fa.firstname.value) === '') {
    alert('First Name is Required')
    fa.firstname.focus()
    return false
  }
  if (trim(fa.lastname.value) === '') {
    alert('Last Name is Required')
    fa.lastname.focus()
    return false
  }
  if (trim(fa.middlename.value) === '') {
    alert('Middle Name is Required')
    fa.middlename.focus()
    return false
  }
  if (trim(fa.salutation.value) === '') {
    alert('Salutation is Required')
    fa.salutation.focus()
    return false
  }
  if (trim(fa.add1.value) === '') {
    alert('Address1 is Required')
    fa.add1.focus()
    return false
  }
  if (trim(fa.city.value) === '') {
    alert('City is Required')
    fa.city.focus()
    return false
  }
  if (trim(fa.state.value) === '') {
    alert('State is Required')
    fa.state.focus()
    return false
  }
  if (trim(fa.zip.value) === '') {
    alert('Zip is Required')
    fa.zip.focus()
    return false
  }
  if (trim(fa.dob.value) === '') {
    alert('Birthday is Required')
    fa.dob.focus()
    return false
  }
  if (trim(fa.gender.value) === '') {
    alert('Gender is Required')
    fa.gender.focus()
    return false
  }
  if (trim(fa.marital_status.value) === '') {
    alert('Marital Status is Required')
    fa.marital_status.focus()
    return false
  }
  if (trim(fa.ssn.value) === '') {
    alert('Patient\'s Soc Sec No. is Required')
    fa.ssn.focus()
    return false
  }

  if (trim(fa.email.value) !== '') {
    if (!isEmail(trim(fa.email.value))) {
      alert('In-Valid Email')
      fa.email.focus()
      return false
    }
  }
  return true
}

export function complaintabc (fa) {
  if (trim(fa.complaint.value) === '') {
    alert('Complaint is Required')
    fa.complaint.focus()
    return false
  }
  return true
}

export function intoleranceabc (fa) {
  if (trim(fa.intolerance.value) === '') {
    alert('Intolerance is Required')
    fa.intolerance.focus()
    return false
  }
}

export function allergensabc (fa) {
  if (trim(fa.allergens.value) === '') {
    alert('Allergens is Required')
    fa.allergens.focus()
    return false
  }
}

export function medicationsabc (fa) {
  if (trim(fa.medications.value) === '') {
    alert('Medications is Required')
    fa.medications.focus()
    return false
  }
}

export function historyabc (fa) {
  if (trim(fa.history.value) === '') {
    alert('Medical History is Required')
    fa.history.focus()
    return false
  }
}

export function tongueabc (fa) {
  if (trim(fa.tongue.value) === '') {
    alert('Tongue is Required')
    fa.tongue.focus()
    return false
  }
}

export function uvulaabc (fa) {
  if (trim(fa.uvula.value) === '') {
    alert('Uvula is Required')
    fa.uvula.focus()
    return false
  }
}

export function softPalateabc (fa) {
  if (trim(fa.soft_palate.value) === '') {
    alert('Soft Palate is Required')
    fa.soft_palate.focus()
    return false
  }
}

export function gagReflexabc (fa) {
  if (trim(fa.gag_reflex.value) === '') {
    alert('Gag Reflex is Required')
    fa.gag_reflex.focus()
    return false
  }
}

export function nasalPassagesabc (fa) {
  if (trim(fa.nasal_passages.value) === '') {
    alert('Nasal Passages is Required')
    fa.nasal_passages.focus()
    return false
  }
}

export function maxillaabc (fa) {
  if (trim(fa.maxilla.value) === '') {
    alert('Maxilla is Required')
    fa.maxilla.focus()
    return false
  }
}

export function mandibleabc (fa) {
  if (trim(fa.mandible.value) === '') {
    alert('Mandible is Required')
    fa.mandible.focus()
    return false
  }
}

export function examTeethabc (fa) {
  if (trim(fa.exam_teeth.value) === '') {
    alert('Teeth Examination is Required')
    fa.exam_teeth.focus()
    return false
  }
}

export function diagnosticabc (fa) {
  if (trim(fa.diagnostic.value) === '') {
    alert('Diagnostic Test is Required')
    fa.diagnostic.focus()
    return false
  }
}

export function assessmentabc (fa) {
  if (trim(fa.assessment.value) === '') {
    alert('Assessment is Required')
    fa.assessment.focus()
    return false
  }
}

export function assessAdditionabc (fa) {
  if (trim(fa.assess_addition.value) === '') {
    alert('Assessment Addition is Required')
    fa.assess_addition.focus()
    return false
  }
}

export function consultationabc (fa) {
  if (trim(fa.consultation.value) === '') {
    alert('Consultation is Required')
    fa.consultation.focus()
    return false
  }
}

export function evaluationNewabc (fa) {
  if (trim(fa.evaluation_new.value) === '') {
    alert('Evaluation New is Required')
    fa.evaluation_new.focus()
    return false
  }
}

export function evaluationEstabc (fa) {
  if (trim(fa.evaluation_est.value) === '') {
    alert('Evaluation Established is Required')
    fa.evaluation_est.focus()
    return false
  }
}

export function contacttypeabc (fa) {
  if (trim(fa.contacttype.value) === '') {
    alert('Contact Type is Required')
    fa.contacttype.focus()
    return false
  }
}

export function accesscodeabc (fa) {
  if (trim(fa.access_code.value) === '') {
    alert('Access Code is Required')
    fa.access_code.focus()
    return false
  }
}

export function imagetypeabc (fa) {
  if (trim(fa.imagetype.value) === '') {
    alert('Image Type is Required')
    fa.imagetype.focus()
    return false
  }
}

export function qualifierabc (fa) {
  if (trim(fa.qualifier.value) === '') {
    alert('Qualifier is Required')
    fa.qualifier.focus()
    return false
  }
}

export function epworthabc (fa) {
  if (trim(fa.epworth.value) === '') {
    alert('Epworth is Required')
    fa.epworth.focus()
    return false
  }
}

export function palpationabc (fa) {
  if (trim(fa.palpation.value) === '') {
    alert('Palpation is Required')
    fa.palpation.focus()
    return false
  }
}

export function jointExamabc (fa) {
  if (trim(fa.joint_exam.value) === '') {
    alert('Joint Examination is Required')
    fa.joint_exam.focus()
    return false
  }
}

export function jointabc (fa) {
  if (trim(fa.joint.value) === '') {
    alert('Joint is Required')
    fa.joint.focus()
    return false
  }
}

export function rangeMotionabc (fa) {
  if (trim(fa.range_motion.value) === '') {
    alert('Range Motion is Required')
    fa.range_motion.focus()
    return false
  }
}

export function screeningabc (fa) {
  if (trim(fa.screening.value) === '') {
    alert('Screening is Required')
    fa.screening.focus()
    return false
  }
}

export function deviceabc (fa) {
  if (trim(fa.device.value) === '') {
    alert('Device is Required')
    fa.device.focus()
    return false
  }
}

export function followupabc (fa) {
  if (trim(fa.followup.value) === '') {
    alert('Follow Up is Required')
    fa.followup.focus()
    return false
  }
}

export function insDiagnosisabc (fa) {
  if (trim(fa.ins_diagnosis.value) === '') {
    alert('Insurance Diagnosis is Required')
    fa.ins_diagnosis.focus()
    return false
  }
}

export function placeServiceabc (fa) {
  if (trim(fa.place_service.value) === '') {
    alert('Place of Service is Required')
    fa.place_service.focus()
    return false
  }
}

export function typeServiceabc (fa) {
  if (trim(fa.type_service.value) === '') {
    alert('Type of Service is Required')
    fa.type_service.focus()
    return false
  }
}

export function cptCodeabc (fa) {
  if (trim(fa.cpt_code.value) === '') {
    alert('CPT Code is Required')
    fa.cpt_code.focus()
    return false
  }
}

export function modifierCodeabc (fa) {
  if (trim(fa.modifier_code.value) === '') {
    alert('Modifier Code is Required')
    fa.modifier_code.focus()
    return false
  }
}

export function insTypeabc (fa) {
  if (trim(fa.ins_type.value) === '') {
    alert('Insurance Type is Required')
    fa.ins_type.focus()
    return false
  }
}

export function docWelcomeabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docEducationalabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docMarketingabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docDvdabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docLababc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docNewabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function docInsuranceabc (fa) {
  if (trim(fa.title.value) === '') {
    alert('Title is Required')
    fa.title.focus()
    return false
  }

  if (fa.video_file.value !== '') {
    const fname = fa.video_file.value
    const lastdot = fname.split('.')
    const ll = lastdot.length
    const extArr = parseInt(ll - 1)
    const ext = lastdot[extArr].toLowerCase()

    if (ext !== 'flv') {
      alert('Only Upload FLV Files for Video File.')
      fa.video_file.focus()
      return false
    }
  }
}

export function transactionCodeabc (fa) {
  if (trim(fa.transaction_code.value) === '') {
    alert('Transaction Code is Required')
    fa.transaction_code.focus()
    return false
  }
}
