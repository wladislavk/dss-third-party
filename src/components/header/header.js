import endpoints from '../../endpoints'
import handlerMixin from '../../modules/handler/HandlerMixin'
import http from '../../services/http'
import logoutTimerMixin from '../../modules/logout/LogoutTimerMixin'
import modal from '../modal/modal.vue'
import symbols from '../../symbols'
import PatientTaskMenuComponent from '../manage/tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../manage/tasks/TaskMenu.vue'
import { LEGACY_URL } from '../../constants'

// include static libs
require('../../../static/third-party/dynamic-drive-dhtml/ddlevelsmenu.js')

const moment = require('moment')

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      headerInfo: {
        unmailedLettersNumber: 0,
        pendingClaimsNumber: 0,
        pendingNodssClaimsNumber: 0,
        unmailedClaimsNumber: 0,
        rejectedClaimsNumber: 0,
        preauthNumber: 0,
        rejectedPreAuthNumber: 0,
        alertsNumber: 0,
        hstNumber: 0,
        requestedHSTNumber: 0,
        rejectedHSTNumber: 0,
        patientContactsNumber: 0,
        patientInsurancesNumber: 0,
        patientChangesNumber: 0,
        pendingDuplicatesNumber: 0,
        emailBouncesNumber: 0,
        paymentReportsNumber: 0,
        unsignedNotesNumber: 0,
        faxAlertsNumber: 0,
        usePaymentReports: false,
        useLetters: false,
        pendingLetters: [],
        user: {},
        docInfo: {},
        courseStaff: {
          use_course: 0,
          use_course_staff: 0
        },
        patientName: '',
        patientHomeSleepTestStatus: '',
        medicare: 0,
        premedCheck: 0,
        title: '',
        alertText: '',
        displayAlert: false
      },
      secondsPerDay: 86400,
      oldestLetter: 0,
      pendingPreauthNumber: 0,
      supportTicketsNumber: 0,
      alergen: 0,
      companyLogo: '',
      childrenPatients: [],
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      bouncedEmailsNumberForCurrentPatient: 0,
      rejectedClaimsForCurrentPatient: [],
      uncompletedHomeSleepTests: [],
      showAllWarnings: true
    }
  },
  computed: {
    patientId () {
      return parseInt(this.$route.query.pid)
    },
    notificationsNumber: function () {
      let notificationsNumber = +this.headerInfo.pendingLetters.length +
        +this.headerInfo.preauthNumber +
        +this.headerInfo.rejectedPreAuthNumber +
        +this.headerInfo.patientContactsNumber +
        +this.headerInfo.patientInsurancesNumber +
        +this.headerInfo.patientChangesNumber +
        +this.headerInfo.emailBouncesNumber +
        +this.headerInfo.unsignedNotesNumber +
        +this.headerInfo.pendingDuplicatesNumber
      if (parseInt(this.headerInfo.user.user_type) === window.constants.DSS_USER_TYPE_SOFTWARE) {
        notificationsNumber += +this.headerInfo.unmailedClaimsNumber + +this.headerInfo.pendingNodssClaimsNumber
      } else {
        notificationsNumber += +this.headerInfo.pendingClaimsNumber
      }
      return notificationsNumber
    },
    isUserDoctor: function () {
      return (this.headerInfo.user.docid === this.headerInfo.user.id)
    },
    showOnlineCEAndSnoozleHelp: function () {
      return (
        (this.isUserDoctor && parseInt(this.headerInfo.user.use_course) === 1) ||
        (
          !this.isUserDoctor &&
          parseInt(this.headerInfo.courseStaff.use_course) === 1 &&
          parseInt(this.headerInfo.courseStaff.use_course_staff) === 1
        )
      )
    },
    showWarningAboutPatientChanges: function () {
      return ((this.childrenPatients.length + this.totalContacts + this.totalInsurances) > 0)
    },
    showWarningAboutQuestionnaireChanges: function () {
      return (parseInt(this.questionnaireStatuses.symptoms_status) === 2 || parseInt(this.questionnaireStatuses.treatments_status) === 2 || parseInt(this.questionnaireStatuses.history_status) === 2)
    },
    showWarningAboutBouncedEmails: function () {
      return this.bouncedEmailsNumberForCurrentPatient
    }
  },
  components: {
    modal: modal,
    taskMenu: TaskMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent
  },
  mixins: [handlerMixin, logoutTimerMixin],
  created () {
    window.eventHub.$on('get-header-info', this.onGetHeaderInfo)
    window.eventHub.$on('update-from-child', this.onUpdateFromChild)

    this.setLogoutTimer()
    http.token = this.$store.state.main[symbols.state.mainToken]

    http.post(endpoints.users.current).then((response) => {
      const data = response.data.data
      if (data) {
        for (let field in data) {
          if (data.hasOwnProperty(field)) {
            this.$set(this.headerInfo.user, field, data[field])
          }
        }
      }
    }).then(() => {
      this.getUser(this.headerInfo.user.docid).then((response) => {
        const data = response.data.data
        if (data) {
          for (let field in data) {
            if (data.hasOwnProperty(field)) {
              this.$set(this.headerInfo.docInfo, field, data[field])
            }
          }
        }
      }).then(() => {
        if (this.headerInfo.docInfo.homepage !== '1') {
          // @todo: rewrite legacy
          // include_once 'includes/top2.htm'
        } else {
          if (this.headerInfo.user.loginid) {
            const currentPage = this.$route.query
            this.setLoginDetails(currentPage).then(() => {
              // @todo: add handler
            }).catch((response) => {
              this.handleErrors('setLoginDetails', response)
            })
          }
          http.post(endpoints.letters.pending).then((response) => {
            const data = response.data.data
            if (data) {
              this.$set(this.headerInfo, 'pendingLetters', data)
            }
          }).then(() => {
            if (this.headerInfo.pendingLetters[0].generated_date.length === 0) {
              this.oldestLetter = 0
            } else {
              this.oldestLetter = Math.floor(
                (moment().valueOf() - moment(this.headerInfo.pendingLetters[0].generated_date).valueOf()) / this.secondsPerDay
              )
            }
          }).catch((response) => {
            this.handleErrors('getPendingLetters', response)
          })
          http.post(endpoints.letters.unmailed).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.unmailedLettersNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getUnmailedLettersNumber', response)
          })
          http.post(endpoints.insurances.pendingClaims).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.pendingClaimsNumber = data.total
              this.headerInfo.pendingNodssClaimsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPendingClaimsNumber', response)
          })
          http.post(endpoints.insurances.unmailedClaims).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.unmailedClaimsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getUnmailedClaimsNumber', response)
          })
          http.post(endpoints.insurances.rejectedClaims).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.rejectedClaimsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getRejectedClaimsNumber', response)
          })
          http.post(endpoints.insurancePreauth.completed).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.preauthNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPreauthNumber', response)
          })
          http.post(endpoints.insurancePreauth.pending).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.pendingPreauthNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPendingPreauthNumber', response)
          })
          http.post(endpoints.insurancePreauth.rejected).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.rejectedPreAuthNumber = data.total
              this.headerInfo.alertsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getRejectedPreauthNumber', response)
          })
          http.post(endpoints.homeSleepTests.completed).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.hstNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getHSTNumber', response)
          })
          http.post(endpoints.homeSleepTests.requested).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.requestedHSTNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getRequestedHSTNumber', response)
          })
          http.post(endpoints.homeSleepTests.rejected).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.rejectedHSTNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getRejectedHSTNumber', response)
          })
          http.post(endpoints.patientContacts.number).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.patientContactsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPatientContactsNumber', response)
          })
          http.post(endpoints.patientInsurances.number).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.patientInsurancesNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPatientInsurancesNumber', response)
          })
          http.post(endpoints.patients.number).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.patientChangesNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPatientChangesNumber', response)
          })
          http.post(endpoints.patients.duplicates).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.pendingDuplicatesNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getPendingDuplicatesNumber', response)
          })
          http.post(endpoints.patients.bounces).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.emailBouncesNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getBouncesNumber', response)
          })
          http.post(endpoints.users.paymentReports).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.usePaymentReports = data.use_payment_reports
            }
          }).then(() => {
            if (this.headerInfo.usePaymentReports) {
              http.post(endpoints.paymentReports.number).then((response) => {
                const data = response.data.data
                if (data) {
                  this.headerInfo.paymentReportsNumber = data.total
                }
              }).catch((response) => {
                this.handleErrors('getPaymentReportsNumber', response)
              })
            }
          }).catch((response) => {
            this.handleErrors('getUsingPaymentReports', response)
          })
          http.post(endpoints.notes.unsigned).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.unsignedNotesNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getUnsignedNotesNumber', response)
          })
          http.post(endpoints.faxes.alerts).then((response) => {
            const data = response.data.data
            if (data) {
              this.headerInfo.faxAlertsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getFaxAlertsNumber', response)
          })
          http.post(endpoints.supportTickets.number).then((response) => {
            const data = response.data.data
            if (data) {
              this.supportTicketsNumber = data.total
            }
          }).catch((response) => {
            this.handleErrors('getSupportTicketsNumber', response)
          })
        }
      }).catch((response) => {
        this.handleErrors('getUser', response)
      })
    }).then(() => {
      if (this.$route.query.pid) {
        this.getPatientByIdAndDocId(this.headerInfo.user.docid, this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data.length) {
            this.$set(this.headerInfo, 'medicare', (parseInt(data[0].p_m_ins_type) === 1))
            this.$set(this.headerInfo, 'premedCheck', data[0].premedcheck)
            this.$set(this.headerInfo, 'alertText', data[0].alert_text)
            this.$set(this.headerInfo, 'displayAlert', data[0].display_alert)
            if (this.headerInfo.premedCheck) {
              this.headerInfo.title += 'Pre-medication: ' + data[0].premed + '\n'
            }
            this.$set(this.headerInfo, 'patientName', data[0].firstname + ' ' + data[0].lastname)
          }
        }).catch((response) => {
          this.handleErrors('getPatientByIdAndDocId', response)
        })
        this.getHealthHistoryByPatientId(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data.length) {
            this.alergen = data[0].allergenscheck
            if (this.alergen) {
              this.headerInfo.title += 'Allergens: ' + data[0].other_allergens
            }
          }
        }).catch((response) => {
          this.handleErrors('getHealthHistoryByPatientId', response)
        })
      }
    }).then(() => {
      const userId = this.headerInfo.user.id.replace('u_', '')
      this.getUserById(userId).then((response) => {
        const data = response.data.data
        if (data) {
          this.$set(this.headerInfo.user, 'use_course', data.use_course)
        }
      }).catch((response) => {
        this.handleErrors('getUserById', response)
      })
      http.post(endpoints.users.courseStaff).then((response) => {
        const data = response.data.data
        if (data) {
          this.$set(this.headerInfo.courseStaff, 'use_course', data.use_course)
          this.$set(this.headerInfo.courseStaff, 'use_course_staff', data.use_course_staff)
        }
      }).catch((response) => {
        this.handleErrors('getCourseStaff', response)
      })
    }).then(() => {
      http.get(endpoints.companies.companyByUser).then((response) => {
        const data = response.data.data
        if (data) {
          this.getFileForDisplaying(data.logo).then((response) => {
            const data = response.data.data
            this.companyLogo = data.image
          }).catch((response) => {
            this.handleErrors('getFileForDisplaying', response)
          })
        }
      }).catch((response) => {
        this.handleErrors('getCompanyByUser', response)
      })
    }).then(() => {
      if (this.$route.query.pid) {
        this.getPatientsByParentId(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            this.childrenPatients = data
          }
        }).catch((response) => {
          this.handleErrors('getPatientsByParentId', response)
        })
        this.getCurrentPatientContacts(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            this.totalContacts = data.length
          }
        }).catch((response) => {
          this.handleErrors('getCurrentPatientContacts', response)
        })
        this.getCurrentPatientInsurances(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            this.totalInsurances = data.length
          }
        }).catch((response) => {
          this.handleErrors('getCurrentPatientInsurances', response)
        })
        this.getQuestionnaireStatuses(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            for (let field in data) {
              if (data.hasOwnProperty(field)) {
                this.questionnaireStatuses[field] = data[field]
              }
            }
          }
        }).catch((response) => {
          this.handleErrors('getQuestionnaireStatuses', response)
        })
        this.getBouncedEmailsNumberForCurrentPatient(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            this.bouncedEmailsNumberForCurrentPatient = data.length
          }
        }).catch((response) => {
          this.handleErrors('getBouncedEmailsNumberForCurrentPatient', response)
        })
        this.getRejectedClaimsForCurrentPatient(this.$route.query.pid).then((response) => {
          const data = response.data.data
          if (data) {
            this.rejectedClaimsForCurrentPatient = data
          }
        }).catch((response) => {
          this.handleErrors('getRejectedClaimsForCurrentPatient', response)
        })
      }
    }).then(() => {
      this.getUncompletedHomeSleepTests().then((response) => {
        const data = response.data.data
        if (data) {
          this.uncompletedHomeSleepTests = data
        }
      }).catch((response) => {
        this.handleErrors('getUncompletedHomeSleepTests', response)
      })
    }).catch((response) => {
      this.handleErrors('getCurrentUser', response)
    })
  },
  beforeDestroy () {
    window.eventHub.$off('get-header-info', this.onGetHeaderInfo)
    window.eventHub.$off('update-from-child', this.onUpdateFromChild)
  },
  watch: {
    'headerInfo': {
      handler: function () {
        window.eventHub.$emit('update-header-info', this.headerInfo)
      },
      deep: true
    },
    'headerInfo.docInfo.use_letters': function () {
      this.$set(this.headerInfo, 'useLetters', (parseInt(this.headerInfo.docInfo.use_letters) === 1))
    },
    'uncompletedHomeSleepTests': function () {
      let status = ''
      if (this.uncompletedHomeSleepTests.length > 0) {
        const lastElement = this.uncompletedHomeSleepTests[this.uncompletedHomeSleepTests.length - 1]
        status = window.constants.dssHstStatusLabels[lastElement.status]
      }
      this.$set(this.headerInfo, 'patientHomeSleepTestStatus', status)
    }
  },
  methods: {
    onUpdateFromChild (headerInfo) {
      const keys = Object.keys(headerInfo)
      keys.forEach((el) => {
        this.headerInfo[el] = headerInfo[el]
      })
    },
    onGetHeaderInfo () {
      window.eventHub.$emit('update-header-info', this.headerInfo)
    },
    getUser: function (userId) {
      userId = userId || 0
      return http.get(endpoints.users.show + '/' + userId)
    },
    setLoginDetails: function (currentPage) {
      const data = {
        loginid: this.headerInfo.user.loginid || 0,
        userid: this.headerInfo.user.id || 0,
        cur_page: currentPage || ''
      }
      return http.post(endpoints.loginDetails.store, data)
    },
    getPatientByIdAndDocId: function (docId, patientId) {
      const data = {
        where: {
          docid: docId || 0,
          patientid: patientId || 0
        }
      }
      return http.post(endpoints.patients.withFilter, data)
    },
    getHealthHistoryByPatientId: function (patientId) {
      const data = {
        fields: ['other_allergens', 'allergenscheck'],
        where: { patientid: patientId || 0 }
      }
      return http.post(endpoints.healthHistories.withFilter, data)
    },
    getUserById: function (userId) {
      userId = userId || 0

      return http.get(endpoints.users.show + '/' + userId)
    },
    getPatientsByParentId: function (parentPatientId) {
      const data = {
        where: { parent_patientid: parentPatientId || 0 }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getCurrentPatientContacts: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.patientContacts.current, data)
    },
    getCurrentPatientInsurances: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.patientInsurances.current, data)
    },
    getQuestionnaireStatuses: function (patientId) {
      const data = {
        fields: ['symptoms_status', 'treatments_status', 'history_status'],
        where: {
          patientid: patientId || 0
        }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getBouncedEmailsNumberForCurrentPatient: function (patientId) {
      const data = {
        fields: ['patientid'],
        where: {
          email_bounce: 1,
          patientId: patientId || 0
        }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getRejectedClaimsForCurrentPatient: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.insurances.rejected, data)
    },
    getUncompletedHomeSleepTests: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.homeSleepTests.uncompleted, data)
    },
    getFileForDisplaying: function (filename) {
      filename = filename || ''

      return http.get(endpoints.displayFile + '/' + filename)
    },
    showWarnings: function () {
      this.showAllWarnings = true
    },
    hideWarnings: function () {
      this.showAllWarnings = false
    },
    logout () {
      http.token = this.$store.state.main[symbols.state.mainToken]
      http.post(endpoints.logout).then(() => {
        window.swal({
          title: '',
          text: 'Logout Successfully!',
          type: 'success'
        }, () => {
          this.$store.commit(symbols.mutations.mainToken, '')
          this.$router.push({ name: 'login' })
        })
      }).catch((response) => {
        console.error('invalidateToken [status]: ', response.status)
      })
    }
  }
}
