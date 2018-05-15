import axios from 'axios'
import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import LocalStorageManager from '../../../../services/LocalStorageManager'
import symbols from '../../../../symbols'
import Alerter from '../../../../services/Alerter'
import { DSS_CONSTANTS } from '../../../../constants/main'
import MomentWrapper from '../../../../wrappers/MomentWrapper'

export default {
  data: function () {
    return {
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
      secondaryEligiblePayers: [],
      docInfo: this.$store.state.main[symbols.state.docInfo]
    }
  },
  watch: {
    '$route.query.pid': function () {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid)

        // if patient data need to be updated - check local storage, it may contain status message about created patient
        const message = LocalStorageManager.get('message')
        if (message && message.length > 0) {
          this.message = message
          LocalStorageManager.remove('message')
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
      return this.$store.state.main[symbols.state.docInfo].use_patient_portal && this.patient.use_patient_portal
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
            status = 'Registration Emailed ' + MomentWrapper.create(this.patient.registration_senton).format('MM/DD/YYYY hh:mm a') + ' ET'
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
        this.patient.referred_source === DSS_CONSTANTS.DSS_REFERRED_PATIENT ||
        this.patient.referred_source === DSS_CONSTANTS.DSS_REFERRED_PHYSICIAN
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
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal)

    this.fillForm(this.routeParameters.patientId)

    http.post(endpoints.companies.homeSleepTest).then((response) => {
      const data = response.data.data

      if (data) {
        this.homeSleepTestCompanies = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getHomeSleepTestCompanies', response: response})
    })

    http.post(endpoints.locations.byDoctor).then((response) => {
      const data = response.data.data

      if (data) {
        this.docLocations = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getDocLocations', response: response})
    })

    http.post(endpoints.companies.billingExclusiveCompany).then((response) => {
      const data = response.data.data

      if (data) {
        this.billingCompany = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getBillingCompany', response: response})
    })

    this.getEligiblePayerSource().then((response) => {
      let data = response.data.data

      if (data.length) {
        data = this.populateEligiblePayerSource(data)
        this.eligiblePayerSource = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getEligiblePayerSource', response: response})

      http.get(endpoints.eligible.payers).then((response) => {
        let data = response.data.data

        if (data.length) {
          data = this.populateEligiblePayerSource(data)
          this.eligiblePayerSource = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getStaticEligiblePayerSource', response: response})
      })
    })

    http.post(endpoints.contacts.insurance).then((response) => {
      const data = response.data.data

      if (data.length) {
        this.insuranceContacts = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getInsuranceContacts', response: response})
    })
  },
  beforeDestroy () {
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
    checkMedicare: function () {
      if (this.patient.s_m_ins_type === 1) {
        const alertText = 'Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.'
        Alerter.alert(alertText)
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
        const alertText = 'Invalid Day, Month, or Year range detected. Please correct.'
        Alerter.alert(alertText)
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
      const alertText = 'Patient has existing HST with status %s. Only one HST can be requested at a time.'
      Alerter.alert(alertText.replace('%s', this.$store.state.main[symbols.state.patientHomeSleepTestStatus]))
    },
    searchItemById: function (data, id) {
      id = id || 0
      const removeId = data.findIndex((el) => el.id === id)

      return removeId >= 0 ? data[removeId] : null
    },
    removeNotification: function (id) {
      this.removeNotificationInDb(id).then(() => {
        this.patientNotifications.$remove(
          this.searchItemById(this.patientNotifications, id)
        )
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'removeNotificationInDb', response: response})
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
        Alerter.alert(arrOfMessages.join('\n'))
      }
    },
    parseSuccessfulResponseOnEditingPatient: function (data) {
      if (data.hasOwnProperty('redirect_to') && data.redirect_to.length > 0) {
        this.$router.push(data.redirect_to)
      }

      if (data.hasOwnProperty('created_patient_id') && data.created_patient_id > 0) {
        LocalStorageManager.save('message', data.status)
        this.$router.push(this.$route.path + '?pid=' + data.created_patient_id)
      }

      if (data.hasOwnProperty('status') && data.status.length > 0) {
        this.message = data.status
      }

      if (data.hasOwnProperty('mails')) {
        const mails = data.mails

        mails.forEach((el) => {
          if (mails[el] && mails[el].length > 0) {
            Alerter.alert(mails[el])
          }
        })
      }

      if (data.send_pin_code) {
        const modalData = {
          name: symbols.modals.patientAccessCode,
          params: {
            patientId: this.routeParameters.patientId
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
      }

      this.fillForm(this.routeParameters.patientId)
    },
    submitAddingOrEditingPatient: function () {
      if (this.validatePatientData(this.patient, null, this.formedFullNames.referred_name)) {
        this.checkEmail(this.patient.email, this.routeParameters.patientId).then((response) => {
          const data = response.data.data

          let isReadyForProcessing = false
          if (data.confirm_message.length > 0) {
            isReadyForProcessing = Alerter.isConfirmed(data.confirm_message)
          } else {
            isReadyForProcessing = true
          }

          if (isReadyForProcessing) {
            this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames).then((response) => {
              this.parseSuccessfulResponseOnEditingPatient(response.data.data)
            }).catch((response) => {
              this.parseFailedResponseOnEditingPatient(response.data.data)

              this.$store.dispatch(symbols.actions.handleErrors, {title: 'editPatient', response: response})
            })
          }
        }).catch((response) => {
          Alerter.alert(response.data.message)
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'checkEmail', response: response})
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
        ).then((response) => {
          this.parseSuccessfulResponseOnEditingPatient(response.data.data)
        }).catch((response) => {
          this.parseFailedResponseOnEditingPatient(response.data.data)

          this.$store.dispatch(symbols.actions.handleErrors, {title: 'editPatient', response: response})
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
        ).then((response) => {
          this.parseSuccessfulResponseOnEditingPatient(response.data.data)
        }).catch((response) => {
          this.parseFailedResponseOnEditingPatient(response.data.data)

          this.$store.dispatch(symbols.actions.handleErrors, {title: 'editPatient', response: response})
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
        Alerter.isConfirmed(
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

      this.typingTimer = setTimeout(() => {
        if (requiredName.length > 1) {
          if (this.autoCompleteSearchValue !== requiredName) {
            this.autoCompleteSearchValue = requiredName

            this.getListContactsAndCompanies(requiredName).then((response) => {
              const data = response.data.data

              if (data.length) {
                this.arrName = data
              } else if (data.error) {
                this.arrName = []
                Alerter.alert(data.error)
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'getListContactsAndCompanies', response: response})
            })
          }
        } else {
          this.arrName = []
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

      this.typingTimer = setTimeout(() => {
        if (insPayerName.length > 1) {
          if (this.autoCompleteSearchValue !== insPayerName) {
            this.autoCompleteSearchValue = insPayerName
            const foundPayers = this.searchEligiblePayersByName(insPayerName)
            if (foundPayers.length > 0) {
              this.arrName = foundPayers
            } else {
              this.arrName = []
              this.$refs[elementName].focus()
              Alerter.alert('Error: No match found for this criteria.')
            }
          }
        } else {
          this.arrName = []
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
      this.typingTimer = setTimeout(() => {
        if (this.formedFullNames.referred_name.trim() !== '') {
          if (this.formedFullNames.referred_name.trim().length > 1) {
            this.getReferrers(this.formedFullNames.referred_name.trim()).then((response) => {
              const data = response.data.data
              if (data.length) {
                this.foundReferrersByName = data
                this.showReferredbyHints = true
              } else if (data.error) {
                this.foundReferrersByName = []
                Alerter.alert(data.error)
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'getReferrers', response: response})
            })
          } else {
            this.showReferredbyHints = false
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
      return http.put(endpoints.patientSummaries.updateTrackerNotes, data)
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
      this.getDataForFillingPatientForm(patientId).then((response) => {
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
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getDataForFillingPatientForm', response: response})
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
      resultFields.forEach((el, index) => {
        this.$set(this.patient, el, sourceFields[index])
      })
    },
    onPreferredContactChange: function () {
      // need to test this function
      if (this.patient.preferredcontact === 'email' && this.patient.email.length === 0) {
        Alerter.alert('You must enter an email address to use email as the preferred contact method.')
        this.$set(this.patient, 'preferredcontact', '')
        this.$refs.email.focus()
      } else if (this.patient.preferredcontact === 'fax' && this.patient.fax.length === 0) {
        Alerter.alert('You must enter a fax number to use email as the preferred contact method.')
        this.$set(this.patient, 'preferredcontact', '')
        this.$refs.fax.focus()
      }
    },
    filterPhoneFields: function (patient) {
      const fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number']

      fields.forEach((el) => {
        patient[el] = this.phone(patient[el])
      })
    },
    filterSsnField: function (patient) {
      patient.ssn = this.ssn(patient.ssn)
    },
    setDefaultValues: function (patient) {
      const values = {
        copyreqdate: MomentWrapper.create().format('DD/MM/YYYY'),
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
      return axios.get('https://eligibleapi.com/resources/payers/claims/medical.json')
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
      fields.forEach((el) => {
        patientFormData[el] = this.number(patientFormData[el])
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
    },
    walkThroughMessages (messages, patient) {
      for (let property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (patient[property] === undefined || patient[property].trim() === '') {
            Alerter.alert(messages[property])
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
            Alerter.alert(messages[property].message)
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
        Alerter.alert('Invalid referred by.')
        this.$refs.referred_by_name.focus()
        return false
      }
      if (!this.isValidDate(patient.dob)) {
        Alerter.alert('Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format')
        this.$refs.dob.focus()
        return false
      }
      if (patient.home_phone.trim() === '' && patient.work_phone.trim() === '' && patient.cell_phone.trim() === '') {
        Alerter.alert('Phone Number is required')
        return false
      }
      if (patient.p_m_ins_ass === 'No' || patient.s_m_ins_ass === 'No') {
        return Alerter.isConfirmed(
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
          return Alerter.isConfirmed(
            'You indicated that ' + this.billingCompany.name +
            ' will file Primary insurance claims but NOT Secondary insurance claims. ' +
            'Normally patients expect claims to be filed in both cases please select ' +
            '"Yes" for Secondary unless you are sure of your choice.'
          )
        }
        if (patient.p_m_ins_plan.trim() === '' && parseInt(patient.p_m_ins_type.value) !== 1) {
          Alerter.alert('Plan Name is a Required Field')
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
            Alerter.alert('Secondary Plan Name is a Required Field')
            this.$refs.s_m_ins_plan.focus()
            return false
          }
        }
        if (patient.s_m_ins_ass !== 'Yes' && patient.s_m_ins_ass !== 'No') {
          Alerter.alert('You must choose \'Accept Assignment of Benefits\' or \'Payment to Patient\'')
          this.$refs.s_m_ins_ass.focus()
          return false
        }
        // if primary insurance - no, but secondary - yes
      } else if (parseInt(patient.p_m_dss_file) === 2 && parseInt(patient.dss_file_radio) === 1) {
        Alerter.alert(this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.')
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
      if (this.isReferredByChanged && !Alerter.isConfirmed(messageAboutChangingReferredBy)) {
        return false
      }
      // if pending VOB make sure insurance hasn't changed
      if (this.pendingVob && this.isInsuranceInfoChanged) {
        if (parseInt(this.pendingVob.status) === DSS_CONSTANTS.DSS_PREAUTH_PREAUTH_PENDING) {
          if (!Alerter.isConfirmed("Warning! This patient has a Verification of Benefits (VOB) that is currently awaiting pre-authorization from the insurance company. You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
            //
          }
        } else {
          if (!Alerter.isConfirmed("Warning! This patient has a pending Verification of Benefits (VOB). You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
            return false
          }
        }
      }
      if (
        requestedEmails &&
        requestedEmails.registration &&
        !Alerter.isConfirmed(
          'You are about to send the patient a registration email. ' +
          'The patient will receive a text message activation code by clicking ' +
          'a link contained in this email, and the patient can complete his/her ' +
          'forms online. Are you sure you want to continue?'
        )
      ) {
        return false
      }
      if (
        requestedEmails &&
        requestedEmails.reminder &&
        !Alerter.isConfirmed(
          'You are about to send the patient an email. ' +
          'Are you sure you want to continue?'
        )
      ) {
        return false
      }
      let alertText
      if (parseInt(patient.s_m_dss_file) === 1 && parseInt(patient.p_m_dss_file) !== 1) {
        alertText = this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.'
        Alerter.alert(alertText)
        return false
      }
      if (parseInt(patient.s_m_ins_type) === 1) {
        alertText = 'Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.'
        Alerter.alert(alertText)
      }
      return true
    },
    isValidDate (date) {
      const dateObject = new Date(date)
      return (dateObject instanceof Date && !isNaN(dateObject.valueOf()))
    }
  }
}
