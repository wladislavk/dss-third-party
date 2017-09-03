// include static libs
require('../../../static/third-party/dynamic-drive-dhtml/ddlevelsmenu.js')

const moment = require('moment')

const modal = require('../modal/modal.vue')
const taskMixin = require('../../modules/tasks/TaskMixin.js')
const logoutMixin = require('../../modules/logout/LogoutMixin.js')
const handlerMixin = require('../../modules/handler/HandlerMixin.js')
const logoutTimerMixin = require('../../modules/logout/LogoutTimerMixin.js')

export default {
  data () {
    return {
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
        overdueTasks: [],
        todayTasks: [],
        tomorrowTasks: [],
        thisWeekTasks: [],
        nextWeekTasks: [],
        laterTasks: [],
        user: {},
        docInfo: {},
        courseStaff: {
          use_course: 0,
          use_course_staff: 0
        },
        tasksNumber: 0,
        patientTaskNumber: 0,
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
      patientTasks: [],
      companyLogo: '',
      overdueTasks: [],
      todayTasks: [],
      tomorrowTasks: [],
      futureTasks: [],
      childrenPatients: [],
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      bouncedEmailsNumberForCurrentPatient: 0,
      rejectedClaimsForCurrentPatient: [],
      uncompletedHomeSleepTests: [],
      showAllWarnings: true,
      showTaskList: false
    }
  },
  components: {
    'modal': modal
  },
  mixins: [taskMixin, logoutMixin, handlerMixin, logoutTimerMixin],
  created () {
    window.eventHub.$on('get-header-info', this.onGetHeaderInfo)
    window.eventHub.$on('update-from-child', this.onUpdateFromChild)

    this.setLogoutTimer()
    const self = this
    this.getCurrentUser() // get current user info
      .then(function (response) {
        const data = response.data.data
        if (data) {
          for (let field in data) {
            if (data.hasOwnProperty(field)) {
              this.$set(this.headerInfo.user, field, data[field])
            }
          }
        }
      }, function (response) {
        this.handleErrors('getCurrentUser', response)
      }).then(function () {
        this.getUser(this.headerInfo.user.docid) // get doc info
          .then(function (response) {
            const data = response.data.data
            if (data) {
              for (let field in data) {
                if (data.hasOwnProperty(field)) {
                  this.$set(self.headerInfo.docInfo, field, data[field])
                }
              }
            }
          }, function (response) {
            this.handleErrors('getUser', response)
          }).then(function () {
            if (self.headerInfo.docInfo.homepage !== '1') {
              // include_once 'includes/top2.htm'
            } else {
              if (self.headerInfo.user.loginid) {
                const currentPage = this.$route.query
                this.setLoginDetails(currentPage)
                  .then(function () {
                    // if success
                  }, function (response) {
                    this.handleErrors('setLoginDetails', response)
                  })
              }
              this.getPendingLetters()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    this.$set(self.headerInfo, 'pendingLetters', data)
                  }
                }, function (response) {
                  this.handleErrors('getPendingLetters', response)
                }).then(function () {
                  if (self.headerInfo.pendingLetters[0].generated_date.length === 0) {
                    this.oldestLetter = 0
                  } else {
                    this.oldestLetter = Math.floor(
                      (moment().valueOf() - moment(self.headerInfo.pendingLetters[0].generated_date).valueOf()) / this.secondsPerDay
                    )
                  }
                })
              this.getUnmailedLettersNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.unmailedLettersNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getUnmailedLettersNumber', response)
                })
              this.getPendingClaimsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.pendingClaimsNumber = data.total
                    self.headerInfo.pendingNodssClaimsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPendingClaimsNumber', response)
                })
              this.getUnmailedClaimsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.unmailedClaimsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getUnmailedClaimsNumber', response)
                })
              this.getRejectedClaimsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.rejectedClaimsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getRejectedClaimsNumber', response)
                })
              this.getPreauthNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.preauthNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPreauthNumber', response)
                })
              this.getPendingPreauthNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.pendingPreauthNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPendingPreauthNumber', response)
                })
              this.getRejectedPreauthNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.rejectedPreAuthNumber = data.total
                    self.headerInfo.alertsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getRejectedPreauthNumber', response)
                })
              this.getHSTNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.hstNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getHSTNumber', response)
                })
              this.getRequestedHSTNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.requestedHSTNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getRequestedHSTNumber', response)
                })
              this.getRejectedHSTNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.rejectedHSTNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getRejectedHSTNumber', response)
                })
              this.getPatientContactsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.patientContactsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPatientContactsNumber', response)
                })
              this.getPatientInsurancesNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.patientInsurancesNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPatientInsurancesNumber', response)
                })
              this.getPatientChangesNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.patientChangesNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPatientChangesNumber', response)
                })
              this.getPendingDuplicatesNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.pendingDuplicatesNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getPendingDuplicatesNumber', response)
                })
              this.getBouncesNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.emailBouncesNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getBouncesNumber', response)
                })
              this.getUsingPaymentReports()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.usePaymentReports = data.use_payment_reports
                  }
                }, function (response) {
                  this.handleErrors('getUsingPaymentReports', response)
                }).then(function () {
                  if (self.headerInfo.usePaymentReports) {
                    this.getPaymentReportsNumber()
                      .then(function (response) {
                        const data = response.data.data
                        if (data) {
                          self.headerInfo.paymentReportsNumber = data.total
                        }
                      }, function (response) {
                        this.handleErrors('getPaymentReportsNumber', response)
                      })
                  }
                })
              this.getUnsignedNotesNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.unsignedNotesNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getUnsignedNotesNumber', response)
                })
              this.getFaxAlertsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    self.headerInfo.faxAlertsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getFaxAlertsNumber', response)
                })
              this.getSupportTicketsNumber()
                .then(function (response) {
                  const data = response.data.data
                  if (data) {
                    this.supportTicketsNumber = data.total
                  }
                }, function (response) {
                  this.handleErrors('getSupportTicketsNumber', response)
                })
            }
          })
      }).then(function () {
        if (this.$route.query.pid) {
          this.getPatientByIdAndDocId(this.headerInfo.user.docid, this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data.length) {
                this.$set(self.headerInfo, 'medicare', (parseInt(data[0].p_m_ins_type) === 1))
                this.$set(self.headerInfo, 'premedCheck', data[0].premedcheck)
                this.$set(self.headerInfo, 'alertText', data[0].alert_text)
                this.$set(self.headerInfo, 'displayAlert', data[0].display_alert)
                if (self.headerInfo.premedCheck) {
                  self.headerInfo.title += 'Pre-medication: ' + data[0].premed + '\n'
                }
                this.$set(self.headerInfo, 'patientName', data[0].firstname + ' ' + data[0].lastname)
              }
            }, function (response) {
              this.handleErrors('getPatientByIdAndDocId', response)
            })
          this.getHealthHistoryByPatientId(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data.length) {
                this.alergen = data[0].allergenscheck
                if (this.alergen) {
                  self.headerInfo.title += 'Allergens: ' + data[0].other_allergens
                }
              }
            }, function (response) {
              this.handleErrors('getHealthHistoryByPatientId', response)
            })
        }
      }).then(function () {
        this.getTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.headerInfo.tasksNumber = data.length
            }
          }, function (response) {
            this.handleErrors('getTasks', response)
          })
        this.getOverdueTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.overdueTasks = data
              this.headerInfo.overdueTasks = data
            }
          }, function (response) {
            this.handleErrors('getOverdueTasks', response)
          })
        this.getTodayTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.todayTasks = data
              this.headerInfo.todayTasks = data
            }
          }, function (response) {
            this.handleErrors('getTodayTasks', response)
          })
        this.getTomorrowTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.tomorrowTasks = data
              this.headerInfo.tomorrowTasks = data
            }
          }, function (response) {
            this.handleErrors('getTomorrowTasks', response)
          })
        this.getThisWeekTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.headerInfo.thisWeekTasks = data
            }
          }, function (response) {
            this.handleErrors('getThisWeekTasks', response)
          })
        this.getNextWeekTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.headerInfo.nextWeekTasks = data
            }
          }, function (response) {
            this.handleErrors('getNextWeekTasks', response)
          })
        this.getLaterTasks()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.headerInfo.laterTasks = data
            }
          }, function (response) {
            this.handleErrors('getLaterTasks', response)
          })
      }).then(function () {
        this.getUserById(this.headerInfo.user.id)
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.$set(self.headerInfo.user, 'use_course', data.use_course)
            }
          }, function (response) {
            this.handleErrors('getUserById', response)
          })
        this.getCourseStaff()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.$set(self.headerInfo.courseStaff, 'use_course', data.use_course)
              this.$set(self.headerInfo.courseStaff, 'use_course_staff', data.use_course_staff)
            }
          }, function (response) {
            this.handleErrors('getCourseStaff', response)
          })
      }).then(function () {
        this.getCompanyLogo()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.getFileForDisplaying(data.logo)
                .then(function (response) {
                  const data = response.data.data
                  this.companyLogo = data.image
                }, function (response) {
                  this.handleErrors('getFileForDisplaying', response)
                })
            }
          }, function (response) {
            this.handleErrors('getCompanyLogo', response)
          })
      }).then(function () {
        if (this.$route.query.pid) {
          this.getPatientTasks(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.headerInfo.patientTaskNumber = data.length
              }
            }, function (response) {
              this.handleErrors('getPatientTasks', response)
            }).then(function () {
              if (this.headerInfo.patientTaskNumber > 0) {
                this.getPatientOverdueTasks(self.$route.query.pid)
                  .then(function (response) {
                    const data = response.data.data
                    if (data) {
                      self.headerInfo.overdueTasks = data
                    }
                  }, function (response) {
                    this.handleErrors('getPatientOverdueTasks', response)
                  })
                this.getPatientTodayTasks(self.$route.query.pid)
                  .then(function (response) {
                    const data = response.data.data
                    if (data) {
                      self.headerInfo.todayTasks = data
                    }
                  }, function (response) {
                    this.handleErrors('getPatientTodayTasks', response)
                  })
                this.getPatientTomorrowTasks(self.$route.query.pid)
                  .then(function (response) {
                    const data = response.data.data
                    if (data) {
                      self.headerInfo.tomorrowTasks = data
                    }
                  }, function (response) {
                    this.handleErrors('getPatientTomorrowTasks', response)
                  })
                this.getPatientFutureTasks(self.$route.query.pid)
                  .then(function (response) {
                    const data = response.data.data
                    if (data) {
                      this.futureTasks = data
                    }
                  }, function (response) {
                    this.handleErrors('getPatientFutureTasks', response)
                  })
              }
            })
        }
      }).then(function () {
        if (this.$route.query.pid) {
          this.getPatientsByParentId(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.childrenPatients = data
              }
            }, function (response) {
              this.handleErrors('getPatientsByParentId', response)
            })
          this.getCurrentPatientContacts(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.totalContacts = data.length
              }
            }, function (response) {
              this.handleErrors('getCurrentPatientContacts', response)
            })
          this.getCurrentPatientInsurances(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.totalInsurances = data.lenght
              }
            }, function (response) {
              this.handleErrors('getCurrentPatientInsurances', response)
            })
          this.getQuestionnaireStatuses(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                for (let field in data) {
                  if (data.hasOwnProperty(field)) {
                    this.questionnaireStatuses[field] = data[field]
                  }
                }
              }
            }, function (response) {
              this.handleErrors('getQuestionnaireStatuses', response)
            })
          this.getBouncedEmailsNumberForCurrentPatient(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.bouncedEmailsNumberForCurrentPatient = data.length
              }
            }, function (response) {
              this.handleErrors('getBouncedEmailsNumberForCurrentPatient', response)
            })
          this.getRejectedClaimsForCurrentPatient(this.$route.query.pid)
            .then(function (response) {
              const data = response.data.data
              if (data) {
                this.rejectedClaimsForCurrentPatient = data
              }
            }, function (response) {
              this.handleErrors('getRejectedClaimsForCurrentPatient', response)
            })
        }
      }).then(function () {
        this.getUncompletedHomeSleepTests()
          .then(function (response) {
            const data = response.data.data
            if (data) {
              this.uncompletedHomeSleepTests = data
            }
          }, function (response) {
            this.handleErrors('getUncompletedHomeSleepTests', response)
          })
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
  computed: {
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
          parseInt(this.headerInfo.courseStaff.use_course) === 1 && parseInt(this.headerInfo.courseStaff.use_course_staff) === 1
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
  methods: {
    onUpdateFromChild (headerInfo) {
      const keys = Object.keys(headerInfo)
      const self = this
      keys.forEach((el) => {
        self.headerInfo[el] = headerInfo[el]
      })
    },
    onGetHeaderInfo () {
      window.eventHub.$emit('update-header-info', this.headerInfo)
    },
    getCurrentUser: function () {
      return this.$http.post(process.env.API_PATH + 'users/current')
    },
    getUser: function (userId) {
      userId = userId || 0
      return this.$http.get(process.env.API_PATH + 'users/' + userId)
    },
    setLoginDetails: function (currentPage) {
      const data = {
        loginid: this.headerInfo.user.loginid || 0,
        userid: this.headerInfo.user.id || 0,
        cur_page: currentPage || ''
      }
      return this.$http.post(process.env.API_PATH + 'login-details', data)
    },
    getPendingLetters: function () {
      return this.$http.post(process.env.API_PATH + 'letters/pending')
    },
    getUnmailedLettersNumber: function () {
      return this.$http.post(process.env.API_PATH + 'letters/unmailed')
    },
    getPendingClaimsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurances/pending-claims')
    },
    getUnmailedClaimsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurances/unmailed-claims')
    },
    getRejectedClaimsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurances/rejected-claims')
    },
    getPreauthNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurance-preauth/completed')
    },
    getPendingPreauthNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurance-preauth/pending')
    },
    getRejectedPreauthNumber: function () {
      return this.$http.post(process.env.API_PATH + 'insurance-preauth/rejected')
    },
    getHSTNumber: function () {
      return this.$http.post(process.env.API_PATH + 'home-sleep-tests/completed')
    },
    getRequestedHSTNumber: function () {
      return this.$http.post(process.env.API_PATH + 'home-sleep-tests/requested')
    },
    getRejectedHSTNumber: function () {
      return this.$http.post(process.env.API_PATH + 'home-sleep-tests/rejected')
    },
    getPatientContactsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'patient-contacts/number')
    },
    getPatientInsurancesNumber: function () {
      return this.$http.post(process.env.API_PATH + 'patient-insurances/number')
    },
    getPatientChangesNumber: function () {
      return this.$http.post(process.env.API_PATH + 'patients/number')
    },
    getPendingDuplicatesNumber: function () {
      return this.$http.post(process.env.API_PATH + 'patients/duplicates')
    },
    getBouncesNumber: function () {
      return this.$http.post(process.env.API_PATH + 'patients/bounces')
    },
    getUsingPaymentReports: function () {
      return this.$http.post(process.env.API_PATH + 'users/payment-reports')
    },
    getPaymentReportsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'payment-reports/number')
    },
    getUnsignedNotesNumber: function () {
      return this.$http.post(process.env.API_PATH + 'notes/unsigned')
    },
    getFaxAlertsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'faxes/alerts')
    },
    getSupportTicketsNumber: function () {
      return this.$http.post(process.env.API_PATH + 'support-tickets/number')
    },
    getPatientByIdAndDocId: function (docId, patientId) {
      const data = {
        where: {
          docid: docId || 0,
          patientid: patientId || 0
        }
      }
      return this.$http.post(process.env.API_PATH + 'patients/with-filter', data)
    },
    getHealthHistoryByPatientId: function (patientId) {
      const data = {
        fields: ['other_allergens', 'allergenscheck'],
        where: { patientid: patientId || 0 }
      }
      return this.$http.post(process.env.API_PATH + 'health-histories/with-filter', data)
    },
    getTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/all')
    },
    getOverdueTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/overdue')
    },
    getTodayTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/today')
    },
    getTomorrowTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/tomorrow')
    },
    getThisWeekTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/this-week')
    },
    getNextWeekTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/next-week')
    },
    getLaterTasks: function () {
      return this.$http.post(process.env.API_PATH + 'tasks/later')
    },
    getPatientTasks: function (patientId) {
      patientId = patientId || 0
      return this.$http.post(process.env.API_PATH + 'tasks/all/pid/' + patientId)
    },
    getPatientOverdueTasks: function (patientId) {
      patientId = patientId || 0
      return this.$http.post(process.env.API_PATH + 'tasks/overdue/pid/' + patientId)
    },
    getPatientTodayTasks: function (patientId) {
      patientId = patientId || 0
      return this.$http.post(process.env.API_PATH + 'tasks/today/pid/' + patientId)
    },
    getPatientTomorrowTasks: function (patientId) {
      patientId = patientId || 0
      return this.$http.post(process.env.API_PATH + 'tasks/tomorrow/pid/' + patientId)
    },
    getPatientFutureTasks: function (patientId) {
      patientId = patientId || 0

      return this.$http.post(process.env.API_PATH + 'tasks/future/pid/' + patientId)
    },
    getUserById: function (userId) {
      userId = userId || 0

      return this.$http.get(process.env.API_PATH + 'users/' + userId)
    },
    getCourseStaff: function () {
      return this.$http.post(process.env.API_PATH + 'users/course-staff')
    },
    getCompanyLogo: function () {
      return this.$http.post(process.env.API_PATH + 'companies/company-logo')
    },
    getPatientsByParentId: function (parentPatientId) {
      const data = {
        where: { parent_patientid: parentPatientId || 0 }
      }

      return this.$http.post(process.env.API_PATH + 'patients/with-filter', data)
    },
    getCurrentPatientContacts: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return this.$http.post(process.env.API_PATH + 'patient-contacts/current', data)
    },
    getCurrentPatientInsurances: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return this.$http.post(process.env.API_PATH + 'patient-insurances/current', data)
    },
    getQuestionnaireStatuses: function (patientId) {
      const data = {
        fields: ['symptoms_status', 'treatments_status', 'history_status'],
        where: {
          patientid: patientId || 0
        }
      }

      return this.$http.post(process.env.API_PATH + 'patients/with-filter', data)
    },
    getBouncedEmailsNumberForCurrentPatient: function (patientId) {
      const data = {
        fields: ['patientid'],
        where: {
          email_bounce: 1,
          patientId: patientId || 0
        }
      }

      return this.$http.post(process.env.API_PATH + 'patients/with-filter', data)
    },
    getRejectedClaimsForCurrentPatient: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return this.$http.post(process.env.API_PATH + 'insurances/rejected', data)
    },
    getUncompletedHomeSleepTests: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return this.$http.post(process.env.API_PATH + 'home-sleep-tests/uncompleted', data)
    },
    getFileForDisplaying: function (filename) {
      filename = filename || ''

      return this.$http.get(process.env.API_PATH + 'display-file/' + filename)
    },
    showWarnings: function () {
      this.showAllWarnings = true
    },
    hideWarnings: function () {
      this.showAllWarnings = false
    },
    onMouseOverPatientTaskHeader: function (event) {
      event.target.parentElement.children['pat_task_list'].style.display = 'block'
    },
    onMouseLeavePatientTaskMenu: function (event) {
      event.target.children['pat_task_list'].style.display = 'none'
    }
  }
}
