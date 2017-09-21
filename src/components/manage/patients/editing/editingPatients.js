import endpoints from '../../../../endpoints'
import handlerMixin from '../../../../modules/handler/HandlerMixin'
import http from '../../../../services/http'
import patientValidator from '../../../../modules/validators/PatientMixin'

export default {
  data: function () {
    return {
      consts: window.constants,
      headerInfo: {
        docInfo: {},
        patientName: '',
        patientHomeSleepTestStatus: ''
      },
      routeParameters: {
        patientId: this.$route.query.pid > 0 ? this.$route.query.pid : null
      },
      billingCompany: {
        exclusive: 0,
        name: 'DSS'
      },
      pressedButtons: {
        send_pin_code: false,
        send_hst: false
      },
      requestedEmails: {
        registration: false,
        reminder: false
      },
      componentParams: {},
      patientNotifications: [],
      homeSleepTestCompanies: [],
      patient: {
        salutation: 'Mr.',
        best_time: 'default',
        best_number: 'default',
        preferredcontact: 'paper',
        gender: 'default',
        feet: '0',
        inches: '-1',
        weight: '0',
        marital_status: 'default',
        display_alert: '0',
        p_m_same_address: '1',
        p_m_relation: 'default',
        p_m_gender: 'default',
        p_m_ins_type: 'default',
        p_m_ins_co: 'default',
        has_s_m_ins: 'No',
        s_m_relation: 'default',
        s_m_gender: 'default',
        s_m_ins_type: 'default',
        s_m_ins_co: 'default'
      },
      profilePhoto: null,
      insuranceCardImage: {},
      docLocations: [],
      insuranceContacts: [],
      introLetter: {},
      uncompletedHomeSleepTests: [],
      formedFullNames: {},
      pendingVob: {},
      patientLocation: 'default',
      message: '',
      eligiblePayerId: 0,
      eligiblePayerName: '',
      sendPin: '',
      showReferredNotes: false,
      showReferredbyHints: false,
      isReferredByChanged: false,
      isInsuranceInfoChanged: false,
      foundReferrersByName: [],
      foundPrimaryCareMdByName: [],
      foundEntByName: [],
      foundSleepMdByName: [],
      foundDentistContactsByName: [],
      foundOtherMdByName: [],
      foundOtherMd2ByName: [],
      foundOtherMd3ByName: [],
      typingTimer: null,
      doneTypingInterval: 600,
      autoCompleteSearchValue: '',
      eligiblePayerSource: [],
      eligiblePayers: [],
      secondaryEligiblePayers: []
    }
  },
  mixins: [handlerMixin, patientValidator],
  watch: {
    '$route.query.pid': function () {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid)

        // if patient data need to be updated - check local storage, it may contain status message about created patient
        const message = window.storage.get('message')
        if (message && message.length > 0) {
          this.message = message
          window.storage.remove('message')
        }

        this.fillForm(this.$route.query.pid)
      } else {
        this.$set(this.routeParameters, 'patientId', null)
        this.cleanPatientData()
      }
    },
    'patient.home_phone': function () {
      this.$set(this.patient, 'home_phone', this.phone(this.patient.home_phone))
    },
    'patient.cell_phone': function () {
      this.$set(this.patient, 'cell_phone', this.phone(this.patient.cell_phone))
    },
    'patient.work_phone': function () {
      this.$set(this.patient, 'work_phone', this.phone(this.patient.work_phone))
    },
    'patient.emergency_number': function () {
      this.$set(this.patient, 'emergency_number', this.phone(this.patient.emergency_number))
    },
    'patient.ssn': function () {
      this.$set(this.patient, 'ssn', this.ssn(this.patient.ssn))
    },
    'patient.dob': function () {
      this.$set(this.patient, 'dob', this.date(this.patient.dob))
    },
    'patient.feet': function () {
      this.calculateBmi()
    },
    'patient.inches': function () {
      this.calculateBmi()
    },
    'patient.weight': function () {
      this.calculateBmi()
    }
  },
  computed: {
    showSendingEmails: function () {
      return this.headerInfo.docInfo.use_patient_portal && this.patient.use_patient_portal
    },
    inches: function () {
      const result = []

      for (let i = 0; i < 12; i++) {
        result.push(i)
      }

      return result
    },
    weight: function () {
      const result = []

      for (let i = 80; i <= 500; i++) {
        result.push(i)
      }

      return result
    },
    buttonText: function () {
      return this.patient.userid > 0 ? 'Save/Update ' : 'Add '
    },
    portalStatus: function () {
      let status = 'Patient Portal In-active'

      if (this.patient.use_patient_portal === 1) {
        status = ''
        switch (+this.patient.registration_status) {
          case 0:
            status = 'Unregistered'
            break
          case 1:
            status = 'Registration Emailed ' + window.moment(this.patient.registration_senton).format('MM/DD/YYYY hh:mm a') + ' ET'
            break
          case 2:
            status = 'Registered'
            break
        }
      }

      return status
    },
    showReferredPerson: function () {
      if (
        this.patient.referred_source === window.constants.DSS_REFERRED_PATIENT ||
        this.patient.referred_source === window.constants.DSS_REFERRED_PHYSICIAN
      ) {
        return true
      } else {
        return false
      }
    },
    insCompanyContactInfo: function () {
      const foundCompany = this.insuranceContacts.find((el) => {
        return el.contactid === this.patient.p_m_ins_co
      })

      if (foundCompany) {
        return foundCompany.add1 + '\n' +
          (foundCompany.add2 ? foundCompany.add2 + '\n' : '') +
          foundCompany.city + ' ' + foundCompany.state + ' ' + foundCompany.zip + '\n' +
          this.phone(foundCompany.phone1)
      } else {
        return ''
      }
    },
    secondaryInsCompanyContactInfo: function () {
      const foundCompany = this.insuranceContacts.find((el) => {
        return el.contactid === this.patient.s_m_ins_co
      })

      if (foundCompany) {
        return foundCompany.add1 + '\n' +
          (foundCompany.add2 ? foundCompany.add2 + '\n' : '') +
          foundCompany.city + ' ' + foundCompany.state + ' ' + foundCompany.zip + '\n' +
          this.phone(foundCompany.phone1)
      } else {
        return ''
      }
    }
  },
  created: function () {
    const self = this
    window.eventHub.$emit('get-header-info')

    window.eventHub.$on('update-header-info', this.onUpdateHeaderInfo)
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal)

    this.fillForm(this.routeParameters.patientId)

    http.post(endpoints.companies.homeSleepTest).then(
      function (response) {
        const data = response.data.data

        if (data) {
          this.homeSleepTestCompanies = data
        }
      },
      function (response) {
        this.handleErrors('getHomeSleepTestCompanies', response)
      }
    )

    http.post(endpoints.locations.byDoctor).then(
      function (response) {
        const data = response.data.data

        if (data) {
          this.docLocations = data
        }
      },
      function (response) {
        this.handleErrors('getDocLocations', response)
      }
    )

    http.post(endpoints.companies.billingExclusiveCompany).then(
      function (response) {
        const data = response.data.data

        if (data) {
          this.billingCompany = data
        }
      },
      function (response) {
        this.handleErrors('getBillingCompany', response)
      }
    )

    this.getEligiblePayerSource().then(
      function (response) {
        let data = response.data.data

        if (data.length) {
          data = this.populateEligiblePayerSource(data)
          this.eligiblePayerSource = data
        }
      },
      function (response) {
        this.handleErrors('getEligiblePayerSource', response)

        http.get(endpoints.eligible.payers).then(
          function (response) {
            let data = response.data.data

            if (data.length) {
              data = this.populateEligiblePayerSource(data)
              this.eligiblePayerSource = data
            }
          },
          function (response) {
            self.handleErrors('getStaticEligiblePayerSource', response)
          }
        )
      }
    )

    http.post(endpoints.contacts.insurance).then(
      function (response) {
        const data = response.data.data

        if (data.length) {
          this.insuranceContacts = data
        }
      },
      function (response) {
        this.handleErrors('getInsuranceContacts', response)
      }
    )
  },
  beforeDestroy () {
    window.eventHub.$off('update-header-info', this.onUpdateHeaderInfo)
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal)
  },
  methods: {
    onSettingDataFromModal (data) {
      this.patient = data
    },
    onSettingComponentParams (parameters) {
      this.componentParams = parameters
    },
    onUpdateHeaderInfo (headerInfo) {
      this.headerInfo = headerInfo
    },
    checkMedicare: function () {
      if (this.patient.s_m_ins_type === 1) {
        alert(
          'Warning! It is very rare that Medicare is listed as a patient’s ' +
          'Secondary Insurance.  Please verify that Medicare is the secondary ' +
          'payer for this patient before proceeding.'
        )
      }
    },
    onClickQuickViewContact: function (id) {
      // loadPopup('view_contact.php?ed=' + id)
    },
    onClickDisplayFile: function () {
      // window.open('display_file.php?f=<?= rawurlencode($image['image_file']) ?>','welcome','width=800,height=400,scrollbars=yes') return false
    },
    onClickCreateNewContact: function () {
      // TODO: implement displaying the popup for creating a new contact
      // loadPopupRefer('add_contact.php?addtopat={{ routeParameters.patientId }}&from=add_patient')
    },
    validateDate: function (el) {
      if (!this.isValidDate(this.patient[el])) {
        alert('Invalid Day, Month, or Year range detected. Please correct.')
        this.$refs[el].focus()
      }
    },
    calculateBmi: function () {
      if (this.patient.feet !== 0 && this.patient.inches !== -1 && this.patient.weight !== 0) {
        const inc = (this.patient.feet * 12) + this.patient.inches
        const incSqr = inc * inc

        const wei = this.patient.weight * 703
        const bmi = wei / incSqr

        this.$set(this.patient, 'bmi', bmi.toFixed(1))
      } else {
        this.$set(this.patient, 'bmi', '')
      }
    },
    onClickAddImage: function (type) {
      // TODO: implement it when certain popup is finished

      switch (type) {
        case 'profile':
          // loadPopup('add_image.php?pid=<?= $patientId ?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:''?>&it=4&return=patinfo&return_field=profile')
          break
        case 'primary-insurance-card-image':
          // loadPopup('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:''?>&it=10&return=patinfo')
          break
        case 'secondary-insurance-card-image':
          // loadPopup('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:''?>&it=12&return=patinfo')
          break
      }
    },
    onClickOrderHst: function () {
      alert(
        'Patient has existing HST with status ' +
        this.headerInfo.patientHomeSleepTestStatus +
        '. Only one HST can be requested at a time.'
      )
    },
    searchItemById: function (data, id) {
      id = id || 0
      const removeId = data.findIndex((el) => el.id === id)

      return removeId >= 0 ? data[removeId] : null
    },
    removeNotification: function (id) {
      this.removeNotificationInDb(id)
        .then(function () {
          this.patientNotifications.$remove(
            this.searchItemById(this.patientNotifications, id)
          )
        }, function (response) {
          this.handleErrors('removeNotificationInDb', response)
        })
    },
    onClickCreatingNewInsuranceCompany: function (fromId) {
      // TODO: implement loading a popup for creating new insurance company

      // loadPopupRefer('add_contact.php?from=add_patient&from_id= + fromId + &ctype=ins{{ routeParameters.patientId ? '&pid=' + routeParameters.patientId + '&type=11&ctypeeq=1&activePat=' + routeParameters.patientId }}')
    },
    handleChangingInsuranceInfo: function () {
      this.isInsuranceInfoChanged = true
    },
    parseFailedResponseOnEditingPatient: function (data) {
      const errors = data.errors.shift()

      if (errors !== undefined) {
        const objKeys = Object.keys(errors)

        const arrOfMessages = objKeys.map((el) => {
          return el + ':' + errors[el].join('|').toLowerCase()
        })

        // TODO: create more readable format
        alert(arrOfMessages.join('\n'))
      }
    },
    parseSuccessfulResponseOnEditingPatient: function (data) {
      if (data.hasOwnProperty('redirect_to') && data.redirect_to.length > 0) {
        this.$router.push(data.redirect_to)
      }

      if (data.hasOwnProperty('created_patient_id') && data.created_patient_id > 0) {
        window.storage.save('message', data.status)
        this.$router.push(this.$route.path + '?pid=' + data.created_patient_id)
      }

      if (data.hasOwnProperty('status') && data.status.length > 0) {
        this.message = data.status
      }

      if (data.hasOwnProperty('mails')) {
        const mails = data.mails

        mails.forEach((el) => {
          if (mails[el] && mails[el].length > 0) {
            alert(mails[el])
          }
        })
      }

      if (data.send_pin_code) {
        this.$parent.$refs.modal.display('patient-access-code')
        this.$parent.$refs.modal.setComponentParameters({ patientId: this.routeParameters.patientId })
      }

      this.fillForm(this.routeParameters.patientId)
    },
    submitAddingOrEditingPatient: function () {
      const self = this
      if (this.validatePatientData(this.patient, null, this.formedFullNames.referred_name)) {
        this.checkEmail(this.patient.email, this.routeParameters.patientId)
          .then(function (response) {
            const data = response.data.data

            let isReadyForProcessing = false
            if (data.confirm_message.length > 0) {
              isReadyForProcessing = confirm(data.confirm_message)
            } else {
              isReadyForProcessing = true
            }

            if (isReadyForProcessing) {
              this.editPatient(self.routeParameters.patientId, self.patient, self.formedFullNames)
                .then(function (response) {
                  this.parseSuccessfulResponseOnEditingPatient(response.data.data)
                }, function (response) {
                  this.parseFailedResponseOnEditingPatient(response.data.data)

                  this.handleErrors('editPatient', response)
                })
            }
          }, function (response) {
            alert(response.data.message)
            this.handleErrors('checkEmail', response)
          })
      }
    },
    submitSendingPinCode: function () {
      if (this.validatePatientData(this.patient)) {
        this.pressedButtons.send_pin_code = true

        this.editPatient(
          this.routeParameters.patientId,
          this.patient,
          this.formedFullNames,
          this.pressedButtons
        ).then(function (response) {
          this.parseSuccessfulResponseOnEditingPatient(response.data.data)
        }, function (response) {
          this.parseFailedResponseOnEditingPatient(response.data.data)

          this.handleErrors('editPatient', response)
        })
      }
    },
    submitSendingRegistrationEmail: function () {
      this.requestedEmails.registration = true

      if (this.validatePatientData(this.patient, this.requestedEmails)) {
        this.editPatient(
          this.routeParameters.patientId,
          this.patient,
          this.formedFullNames,
          null,
          this.requestedEmails
        ).then(function (response) {
          this.parseSuccessfulResponseOnEditingPatient(response.data.data)
        }, function (response) {
          this.parseFailedResponseOnEditingPatient(response.data.data)

          this.handleErrors('editPatient', response)
        })
      }
    },
    submitSendingReminderEmail: function () {
      this.requestedEmails.reminder = true

      if (this.validatePatientData(this.patient, this.requestedEmails)) {
        this.editPatient(
          this.routeParameters.patientId,
          this.patient,
          this.formedFullNames,
          null,
          this.requestedEmails
        )
      }
    },
    submitSendingHst: function () {
      if (
        confirm(
          'Click OK to initiate a Home Sleep Test request. ' +
          'The HST request must be electronically signed by an authorized ' +
          'provider before it can be transmitted. You can view and save/update ' +
          'the request on the next screen.'
        ) && this.validatePatientData(this.patient)
      ) {
        this.pressedButtons.send_hst = true

        this.editPatient(
          this.routeParameters.patientId,
          this.patient,
          this.formedFullNames,
          this.pressedButtons
        )
      }
    },
    setContact: function (type, id) {
      this.$set(this.patient, type, id)
    },
    onKeyUpSearchContacts: function (type) {
      clearTimeout(this.typingTimer)

      const requiredName = this.formedFullNames[type + '_name'].trim()

      // @todo: check why this block is needed
      /*
      let arrName = ''
      switch (type) {
        case 'docpcp':
          arrName = 'foundPrimaryCareMdByName'
          break
        case 'docent':
          arrName = 'foundEntByName'
          break
        case 'docsleep':
          arrName = 'foundSleepMdByName'
          break
        case 'docdentist':
          arrName = 'foundDentistContactsByName'
          break
        case 'docmdother':
          arrName = 'foundOtherMdByName'
          break
        case 'docmdother2':
          arrName = 'foundOtherMd2ByName'
          break
        case 'docmdother3':
          arrName = 'foundOtherMd3ByName'
          break
      }
      */

      const self = this
      this.typingTimer = setTimeout(function () {
        if (requiredName.length > 1) {
          if (self.autoCompleteSearchValue !== requiredName) {
            self.autoCompleteSearchValue = requiredName

            self.getListContactsAndCompanies(requiredName)
              .then(function (response) {
                const data = response.data.data

                if (data.length) {
                  self.arrName = data
                } else if (data.error) {
                  self.arrName = []
                  alert(data.error)
                }
              }, function (response) {
                self.handleErrors('getListContactsAndCompanies', response)
              })
          }
        } else {
          self.arrName = []
        }
      }, this.doneTypingInterval)
    },
    setEligiblePayer: function (id, name, type) {
      let idField, nameField, fullNameField

      if (type === 'primary') {
        idField = 'p_m_eligible_payer_id'
        nameField = 'p_m_eligible_payer_name'
        fullNameField = 'ins_payer_name'
      } else {
        idField = 's_m_eligible_payer_id'
        nameField = 's_m_eligible_payer_name'
        fullNameField = 's_m_ins_payer_name'
      }

      this.$set(this.patient, idField, id)
      this.$set(this.patient, nameField, name)
      this.$set(this.formedFullNames, fullNameField, id + ' - ' + name)
    },
    searchEligiblePayersByName: function (name) {
      const LIMIT_RECORDS_TO_DISPLAY = 5
      const partsOfRequiredName = name.toLowerCase().split(' ')
      // the description of it is here: http://stackoverflow.com/a/4389683
      const regRequiredName = new RegExp('(?=.*\\b.*' + partsOfRequiredName.join('.*\\b)(?=.*\\b.*') + '.*\\b).*', 'i')

      const foundPayers = []
      let recordsToDisplay = 0
      this.eligiblePayerSource.some((el) => {
        const payerId = el.payer_id.replace(/(\r\n|\n|\r)/gm, '')
        // check unique id
        const foundPayerId = foundPayers.find((el) => {
          return el.id === payerId
        })

        if (el.payer_name.toLowerCase().search(regRequiredName) !== -1 && !foundPayerId) {
          foundPayers.push({
            id: payerId,
            name: el.payer_name.replace(/(\r\n|\n|\r)/gm, '')
          })

          if (++recordsToDisplay === LIMIT_RECORDS_TO_DISPLAY) {
            return true
          }
        }
      })

      return foundPayers
    },
    populateEligiblePayerSource: function (source) {
      const data = []

      source.forEach((el) => {
        if (typeof el['names'] === 'undefined' || el['names'].length === 0) {
          return
        }

        el['names'].forEach((name) => {
          data.push({
            payer_id: el['payer_id'],
            payer_name: name,
            enrollment_required: el['enrollment_required'],
            enrollment_mandatory_fields: el['enrollment_mandatory_fields']
          })
        })
      })

      return data
    },
    onKeyUpSearchEligiblePayers: function (type) {
      clearTimeout(this.typingTimer)

      let insPayerName, elementName
      // @todo: check why this variable is needed
      // let arrName

      if (type === 'primary') {
        insPayerName = this.formedFullNames.ins_payer_name.trim()
        // arrName = 'eligiblePayers'
        elementName = 'insPayerName'
      } else {
        insPayerName = this.formedFullNames.s_m_ins_payer_name.trim()
        // arrName = 'secondaryEligiblePayers'
        elementName = 'secondaryInsPayerName'
      }

      const self = this
      this.typingTimer = setTimeout(function () {
        if (insPayerName.length > 1) {
          if (self.autoCompleteSearchValue !== insPayerName) {
            self.autoCompleteSearchValue = insPayerName
            const foundPayers = self.searchEligiblePayersByName(insPayerName)

            if (foundPayers.length > 0) {
              self.arrName = foundPayers
            } else {
              self.arrName = []
              self.$refs[elementName].focus()

              alert('Error: No match found for this criteria.')
            }
          }
        } else {
          self.arrName = []
        }
      }, this.doneTypingInterval)
    },
    setReferredBy: function (id, referredType) {
      if (this.patient.referred_by !== id || this.patient.referred_source !== referredType) {
        this.isReferredByChanged = true
      }

      this.$set(this.patient, 'referred_by', id)
      this.$set(this.patient, 'referred_source', referredType)
    },
    onKeyUpSearchReferrers: function () {
      clearTimeout(this.typingTimer)

      const self = this
      this.typingTimer = setTimeout(function () {
        if (self.formedFullNames.referred_name.trim() !== '') {
          if (self.formedFullNames.referred_name.trim().length > 1) {
            self.getReferrers(self.formedFullNames.referred_name.trim())
              .then(function (response) {
                const data = response.data.data

                if (data.length) {
                  self.foundReferrersByName = data
                  self.showReferredbyHints = true
                } else if (data.error) {
                  self.foundReferrersByName = []
                  alert(data.error)
                }
              }, function (response) {
                self.handleErrors('getReferrers', response)
              })
          } else {
            self.showReferredbyHints = false
          }
        }
      }, this.doneTypingInterval)
    },
    showReferredBy: function (type, referredSource) {
      if (type === 'person') {
        this.showReferredNotes = false
        this.showReferredPerson = true
      } else {
        this.showReferredNotes = true
        this.showReferredPerson = false
      }
      this.$set(this.patient, 'referred_source', referredSource)
    },
    updateTrackerNotes: function (patientId, notes) {
      const data = {
        patient_id: patientId || 0,
        tracker_notes: notes
      }

      return http.post(endpoints.patientSummaries.updateTrackerNotes, data)
    },
    cleanPatientData: function () {
      const patient = {}

      this.setDefaultValues(patient)

      this.patient = patient
      this.profilePhoto = null
      this.introLetter = {}
      this.insuranceCardImage = {}
      this.uncompletedHomeSleepTests = []
      this.patientNotifications = []
      this.formedFullNames = {}
      this.pendingVob = {}
      this.patientLocation = ''

      // update patient name in the header
      window.eventHub.$emit('update-from-child', {
        patientName: '',
        medicare: 0,
        premedCheck: 0,
        title: '',
        alertText: '',
        displayAlert: false
      })
    },
    fillForm: function (patientId) {
      this.getDataForFillingPatientForm(patientId)
        .then(function (response) {
          const data = response.data.data

          if (data.length !== 0) {
            this.filterPhoneFields(data.patient)
            this.filterSsnField(data.patient)
            this.setDefaultValues(data.patient)

            this.patient = data.patient
            this.profilePhoto = data.profile_photo
            this.introLetter = data.intro_letter
            this.insuranceCardImage = data.insurance_card_image
            this.uncompletedHomeSleepTests = data.uncompleted_home_sleep_test
            this.patientNotifications = data.patient_notification
            this.formedFullNames = data.formed_full_names
            this.pendingVob = data.pending_vob
            this.patientLocation = data.patient_location

            // update patient name in the header
            window.eventHub.$emit('update-from-child', {
              patientName: data.patient.firstname + ' ' + data.patient.lastname,
              medicare: (data.patient.p_m_ins_type === 1),
              premedCheck: data.patient.premedcheck,
              title: 'Pre-medication: ' + data.patient.premed + '\n',
              alertText: data.patient.alert_text,
              displayAlert: data.patient.display_alert
            })
          }
        }, function (response) {
          this.handleErrors('getDataForFillingPatientForm', response)
        })
    },
    onChangeRelations: function (type) {
      if (this.value !== 'Self') {
        return
      }

      let resultFields = []
      const sourceFields = [
        this.patient.dob,
        this.patient.firstname,
        this.patient.middlename,
        this.patient.lastname,
        this.patient.gender
      ]

      if (type === 'primary_insurance') {
        resultFields = [
          'ins_dob', 'p_m_partyfname', 'p_m_partymname', 'p_m_partylname', 'p_m_gender'
        ]
      } else if (type === 'secondary_insurance') {
        resultFields = [
          'ins2_dob', 's_m_partyfname', 's_m_partymname', 's_m_partylname', 's_m_gender'
        ]
      }

      const self = this
      resultFields.forEach((el, index) => {
        self.$set(self.patient, el, sourceFields[index])
      })
    },
    onPreferredContactChange: function () {
      // need to test this function
      if (this.patient.preferredcontact === 'email' && this.patient.email.length === 0) {
        alert('You must enter an email address to use email as the preferred contact method.')

        this.$set(this.patient, 'preferredcontact', '')
        this.$refs.email.focus()
      } else if (this.patient.preferredcontact === 'fax' && this.patient.fax.length === 0) {
        alert('You must enter a fax number to use email as the preferred contact method.')

        this.$set(this.patient, 'preferredcontact', '')
        this.$refs.fax.focus()
      }
    },
    filterPhoneFields: function (patient) {
      const fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number']

      const self = this
      fields.forEach((el) => {
        patient[el] = self.phone(patient[el])
      })
    },
    filterSsnField: function (patient) {
      patient.ssn = this.ssn(patient.ssn)
    },
    setDefaultValues: function (patient) {
      const values = {
        copyreqdate: window.moment().format('DD/MM/YYYY'),
        salutation: 'Mr.',
        preferredcontact: 'paper',
        display_alert: 0,
        p_m_same_address: 1,
        has_s_m_ins: 'No'
      }

      const fields = Object.keys(values)

      fields.forEach((el) => {
        if (!patient[el]) {
          patient[el] = values[el]
        }
      })
    },
    phone: function (value) {
      value = value || ''
      return value.replace(/\D/g, '')
        .replace(/^(\d{3})(\d{3})(\d{4})$/, '($1) $2-$3')
    },
    ssn: function (value) {
      value = value || ''
      return value.replace(/\D/g, '')
        .replace(/^(\d{3})(\d{2})(\d{4})$/, '$1-$2-$3')
    },
    date: function (value) {
      value = value || ''
      return value.replace(/\D/g, '')
        .replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3')
    },
    number: function (value) {
      value = value || ''
      return value.replace(/\D/g, '')
    },
    getUncompletedHomeSleepTests: function (patientId) {
      const data = { patientId: patientId || 0 }

      return http.post(endpoints.homeSleepTests.uncompleted, data)
    },
    getGeneratedDateOfIntroLetter: function (patientId) {
      const data = { patient_id: patientId || 0 }

      return http.post(endpoints.letters.generateDateOfIntro, data)
    },
    getProfilePhoto: function (patientId) {
      const data = { patient_id: patientId || 0 }

      return http.post(endpoints.profileImages.photo, data)
    },
    getInsuranceCardImage: function (patientId) {
      const data = { patient_id: patientId || 0 }

      return http.post(endpoints.profileImages.insuranceCardImage, data)
    },
    getPatientById: function (patientId) {
      patientId = patientId || 0

      return http.get(endpoints.patients.show + '/' + patientId)
    },
    findPatientNotifications: function (patientId) {
      const data = {
        where: {
          patientid: patientId || 0,
          status: 1
        }
      }

      return http.post(endpoints.notifications.withFilter, data)
    },
    addNewPatient: function () {
      const data = {}

      // @todo: this endpoint does not exist
      return http.post('/patients/add-new-patient', data)
    },
    getDataForFillingPatientForm: function (patientId) {
      const data = { 'patient_id': patientId || 0 }

      return http.post(endpoints.patients.fillingForm, data)
    },
    getReferrers: function (requestedName) {
      const data = { partial_name: requestedName }

      return http.post(endpoints.patients.referrers, data)
    },
    getEligiblePayerSource: function () {
      return this.$http.get('https://eligibleapi.com/resources/payers/claims/medical.json')
    },
    getListContactsAndCompanies: function (requestedName) {
      const data = {
        partial_name: requestedName,
        without_companies: true
      }

      return http.post(endpoints.contacts.listContactsAndCompanies, data)
    },
    editPatient: function (
      patientId,
      patientFormData,
      formedFullNames,
      pressedButtons,
      requestedEmails,
      trackerNotes
    ) {
      patientId = patientId || 0
      patientFormData = Object.assign(patientFormData, {
        location: this.patientLocation
      })

      const fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number', 'ssn']

      const self = this
      fields.forEach((el) => {
        patientFormData[el] = self.number(patientFormData[el])
      })

      const data = {
        patient_form_data: patientFormData,
        pressed_buttons: pressedButtons || undefined,
        requested_emails: requestedEmails || undefined,
        tracker_notes: trackerNotes || undefined
      }

      return http.post(endpoints.patients.edit + '/' + patientId, data)
    },
    checkEmail: function (email, patientId) {
      const data = {
        email: email || '',
        patient_id: patientId || 0
      }

      return http.post(endpoints.patients.checkEmail, data)
    },
    removeNotificationInDb: function (id) {
      id = id || 0
      const data = { status: 2 }

      return http.put(endpoints.notifications.update + '/' + id, data)
    }
  }
}
