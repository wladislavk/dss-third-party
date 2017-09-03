export default {
  created () {
    // http://stackoverflow.com/a/15829686
    // @todo: this is not gonna work
    String.toCamelCase = function () {
      return this.replace(/^([A-Z])|[\s-_](\w)/g, function (match, p1, p2) {
        if (p2) return p2.toUpperCase()
        return p1.toLowerCase()
      })
    }
  },
  methods: {
    walkThroughMessages (messages, patient) {
      for (let property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (patient[property] === undefined || patient[property].trim() === '') {
            alert(messages[property])
            this.$refs[property].focus()

            return false
          }
        }
      }

      return true
    },
    walkThroughComplexMessages (messages, patient) {
      for (let property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (patient.hasOwnProperty(property) && patient[property].length > 0 && patient[messages[property].connect_to] === '') {
            alert(messages[property].message)
            this.$refs[property].focus()

            return false
          }
        }
      }

      return true
    },
    validatePatientData (patient, requestedEmails, referredName) {
      referredName = referredName || ''

      let messages = {
        firstname: 'First Name is Required',
        lastname: 'Last Name is Required',
        email: 'Email is Required',
        add1: 'Address is Required',
        city: 'City is Required',
        state: 'State is Required',
        zip: 'Zip is Required',
        gender: 'Gender is Required',
        cell_phone: 'Cell phone is Required'
      }

      if (!this.walkThroughMessages(messages, patient)) {
        return false
      }

      if (referredName.length > 0 && !patient.referred_by) {
        alert('Invalid referred by.')
        this.$refs.referred_by_name.focus()

        return false
      }

      if (!this.isValidDate(patient.dob)) {
        alert('Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format')
        this.$refs.dob.focus()

        return false
      }

      if (patient.home_phone.trim() === '' && patient.work_phone.trim() === '' && patient.cell_phone.trim() === '') {
        alert('Phone Number is required')

        return false
      }

      if (patient.p_m_ins_ass === 'No' || patient.s_m_ins_ass === 'No') {
        return confirm(
          'Selecting "Payment to Patient" means NO payment will go to your' +
          'office (payment will be mailed to patient). Select "Accept Assignment ' +
          'of Benefits" to have the insurance check go to your office instead. ' +
          '"Accept Assignment" is recommended in nearly all cases, so make sure ' +
          'you choose correctly.'
        )
      }

      if (parseInt(patient.p_m_dss_file) === 1) {
        messages = {
          p_m_partyfname: 'Insured Party First Name is a Required Field',
          p_m_partylname: 'Insured Party Last Name is a Required Field',
          p_m_relation: 'Relationship to insured party is a Required Field',
          ins_dob: 'Insured Date of Birth is a Required Field',
          p_m_gender: 'Insured Gender is a Required Field',
          p_m_ins_co: 'Insurance Company is a Required Field',
          p_m_party: 'Insurance ID. is a Required Field',
          p_m_ins_grp: 'Group # is a Required Field',
          p_m_ins_type: 'Insurance Type is a Required Field'
        }

        if (!this.walkThroughMessages(messages, patient)) {
          return false
        }

        // if primary insurance - yes and secondary - not
        if (parseInt(patient.dss_file_radio) === 2) {
          return confirm(
            'You indicated that ' + this.billingCompany.name +
            ' will file Primary insurance claims but NOT Secondary insurance claims. ' +
            'Normally patients expect claims to be filed in both cases please select ' +
            '"Yes" for Secondary unless you are sure of your choice.'
          )
        }

        if (patient.p_m_ins_plan.trim() === '' && parseInt(patient.p_m_ins_type.value) !== 1) {
          alert('Plan Name is a Required Field')
          this.$refs.p_m_ins_plan.focus()

          return false
        }

        if (patient.has_s_m_ins === 'Yes' && parseInt(patient.s_m_dss_file) === 1) {
          messages = {
            s_m_partyfname: 'Secondary Insured Party First Name is a Required Field',
            s_m_partylname: 'Secondary Insured Party Last Name is a Required Field',
            s_m_relation: 'Secondary Relationship to insured party is a Required Field',
            ins2_dob: 'Secondary Insured Date of Birth is a Required Field',
            s_m_gender: 'Secondary Insured Gender is a Required Field',
            s_m_ins_co: 'Secondary Insurance Company is a Required Field',
            s_m_party: 'Secondary Insurance ID. is a Required Field',
            s_m_ins_grp: 'Secondary Group # is a Required Field',
            s_m_ins_type: 'Secondary Insurance Type is a Required Field'
          }

          if (!this.walkThroughMessages(messages, patient)) {
            return false
          }

          if (patient.s_m_ins_plan.trim() === '' && parseInt(patient.p_m_ins_type.value) !== 1) {
            alert('Secondary Plan Name is a Required Field')
            this.$refs.s_m_ins_plan.focus()

            return false
          }
        }

        if (patient.s_m_ins_ass !== 'Yes' && patient.s_m_ins_ass !== 'No') {
          alert('You must choose \'Accept Assignment of Benefits\' or \'Payment to Patient\'')
          this.$refs.s_m_ins_ass.focus()

          return false
        }
      // if primary insurance - no, but secondary - yes
      } else if (parseInt(patient.p_m_dss_file) === 2 && parseInt(patient.dss_file_radio) === 1) {
        alert(this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.')
        return false
      }

      if (patient.patientid > 0) {
        messages = {
          docsleep_name: {
            connect_to: 'docsleep',
            message: 'Invalid sleep md.'
          },
          docpcp_name: {
            connect_to: 'docpcp',
            message: 'Invalid primary care md.'
          },
          docdentist_name: {
            connect_to: 'docdentist',
            message: 'Invalid dentist'
          },
          docent_name: {
            connect_to: 'docent',
            message: 'Invalid ENT.'
          },
          docmdother_name: {
            connect_to: 'docmdother',
            message: 'Invalid other md.'
          }
        }

        if (!this.walkThroughComplexMessages(messages, patient)) {
          return false
        }
      }

      const messageAboutChangingReferredBy = 'The referrer has been updated. Existing pending letters to the referrer may be updated or deleted and previous changes lost. Proceed?'

      if (this.isReferredByChanged && !confirm(messageAboutChangingReferredBy)) {
        return false
      }

      // if pending VOB make sure insurance hasn't changed
      if (this.pendingVob && this.isInsuranceInfoChanged) {
        if (parseInt(this.pendingVob.status) === window.constants.DSS_PREAUTH_PREAUTH_PENDING) {
          if (!confirm("Warning! This patient has a Verification of Benefits (VOB) that is currently awaiting pre-authorization from the insurance company. You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
            //
          }
        } else {
          if (!confirm("Warning! This patient has a pending Verification of Benefits (VOB). You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
            return false
          }
        }
      }

      if (
        requestedEmails && requestedEmails.registration &&
        !confirm(
          'You are about to send the patient a registration email. ' +
          'The patient will receive a text message activation code by clicking ' +
          'a link contained in this email, and the patient can complete his/her ' +
          'forms online. Are you sure you want to continue?'
        )
      ) {
        return false
      }

      if (
        requestedEmails && requestedEmails.reminder &&
        !confirm(
          'You are about to send the patient an email. ' +
          'Are you sure you want to continue?'
        )
      ) {
        return false
      }

      if (parseInt(patient.s_m_dss_file) === 1 && parseInt(patient.p_m_dss_file) !== 1) {
        alert(this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.')

        return false
      }

      if (parseInt(patient.s_m_ins_type) === 1) {
        alert('Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.')
      }

      return true
    },
    isValidDate (date) {
      const dateObject = new Date(date)
      return (dateObject instanceof Date && !isNaN(dateObject.valueOf()))
    }
  }
}
