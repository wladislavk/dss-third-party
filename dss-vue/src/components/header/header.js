module.exports = {
    data: function() {
        return {
            headerInfo: {
                unmailedLettersNumber    : 0,
                pendingClaimsNumber      : 0,
                pendingNodssClaimsNumber : 0,
                unmailedClaimsNumber     : 0,
                rejectedClaimsNumber     : 0,
                preauthNumber            : 0,
                rejectedPreAuthNumber    : 0,
                alertsNumber             : 0,
                hstNumber                : 0,
                requestedHSTNumber       : 0,
                rejectedHSTNumber        : 0,
                patientContactsNumber    : 0,
                patientInsurancesNumber  : 0,
                patientChangesNumber     : 0,
                pendingDuplicatesNumber  : 0,
                emailBouncesNumber       : 0,
                paymentReportsNumber     : 0,
                unsignedNotesNumber      : 0,
                faxAlertsNumber          : 0,
                usePaymentReports        : false,
                useLetters               : false,
                pendingLetters           : [],
                overdueTasks             : [],
                todayTasks               : [],
                tomorrowTasks            : [],
                thisWeekTasks            : [],
                nextWeekTasks            : [],
                laterTasks               : [],
                user                     : {},
                docInfo                  : {},
                courseStaff              : {
                    use_course       : 0,
                    use_course_staff : 0
                },
            },
            secondsPerDay                        : 86400,
            oldestLetter                         : 0,
            pendingPreauthNumber                 : 0,
            supportTicketsNumber                 : 0,
            title                                : '',
            premedCheck                          : 0,
            medicare                             : 0,
            alertText                            : '',
            displayAlert                         : false,
            alergen                              : 0,
            patientName                          : '',
            patientTasks                         : [],
            notificationsNumber                  : 0,
            tasksNumber                          : 0,
            patientTaskNumber                    : 0,
            isUserDoctor                         : false,
            showOnlineCEAndSnoozleHelp           : false,
            companyLogo                          : '',
            overdueTasks                         : [],
            todayTasks                           : [],
            tomorrowTasks                        : [],
            futureTasks                          : [],
            childrenPatients                     : [],
            totalContacts                        : 0,
            totalInsurances                      : 0,
            showWarningAboutPatientChanges       : false,
            questionnaireStatuses                : [],
            showWarningAboutQuestionnaireChanges : false,
            bouncedEmailsNumberForCurrentPatient : 0,
            showWarningAboutBouncedEmails        : false,
            rejectedClaimsForCurrentPatient      : [],
            uncompletedHomeSleepTests            : [],
            showAllWarnings                      : false
        }
    },
    created: function() {
        this.getCurrentUser() // get current user info
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    for (var field in data) {
                        this.$set('headerInfo.user.' + field, data[field]);
                    }
                }
            }, function(response) {
                console.error('getCurrentUser [status]: ', response.status);
                // token is expired
                if (response.status == 401) {
                    this.$route.router.go('/manage/login');
                }
            }).then(function(response) {
                this.getUser(this.headerInfo.user.docid) //get doc info
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            for (var field in data) {
                                this.$set('headerInfo.docInfo.' + field, data[field]);
                            }
                        }
                    }, function(response) {
                        console.error('getUser [status]: ', response.status);
                    }).then(function(response) {
                        if (this.headerInfo.docInfo.homepage != '1') {
                            // include_once 'includes/top2.htm';
                        } else {
                            if (this.headerInfo.user.loginid) {
                                var currentPage = this.$route.query;

                                this.setLoginDetails(currentPage)
                                    .then(function(response) {
                                        // if success
                                    }, function(response) {
                                        console.error('setLoginDetails [status]: ', response.status);
                                    });
                            }

                            this.getPendingLetters()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.pendingLetters = data;
                                    }
                                }, function(response) {
                                    console.error('getPendingLetters [status]: ', response.status);
                                }).then(function(response) {
                                    if (this.headerInfo.pendingLetters[0].generated_date == 0) {
                                        this.oldestLetter = 0
                                    } else {
                                        // need check if correct 
                                        this.oldestLetter = Math.floor(
                                            (moment().valueOf() - this.headerInfo.pendingLetters[0].generated_date) / this.secondsPerDay
                                        );
                                    }
                                });

                            this.getUnmailedLettersNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.unmailedLettersNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getUnmailedLettersNumber [status]: ', response.status);
                                });

                            this.getPendingClaimsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.pendingClaimsNumber      = data.total;
                                        this.headerInfo.pendingNodssClaimsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPendingClaimsNumber [status]: ', response.status);
                                });

                            this.getUnmailedClaimsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.unmailedClaimsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getUnmailedClaimsNumber [status]: ', response.status);
                                });

                            this.getRejectedClaimsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.rejectedClaimsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getRejectedClaimsNumber [status]: ', response.status);
                                });

                            this.getPreauthNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.preauthNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPreauthNumber [status]: ', response.status);
                                });

                            this.getPendingPreauthNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.pendingPreauthNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPendingPreauthNumber [status]: ', response.status);
                                });

                            this.getRejectedPreauthNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.rejectedPreAuthNumber = data.total;
                                        this.headerInfo.alertsNumber          = data.total;
                                    }
                                }, function(response) {
                                    console.error('getRejectedPreauthNumber [status]: ', response.status);
                                });
                            
                            this.getHSTNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.hstNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getHSTNumber [status]: ', response.status);
                                });

                            this.getRequestedHSTNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.requestedHSTNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getRequestedHSTNumber [status]: ', response.status);
                                });

                            this.getRejectedHSTNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.rejectedHSTNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getRejectedHSTNumber [status]: ', response.status);
                                });

                            this.getPatientContactsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.patientContactsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPatientContactsNumber [status]: ', response.status);
                                });

                            this.getPatientInsurancesNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.patientInsurancesNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPatientInsurancesNumber [status]: ', response.status);
                                });

                            this.getPatientChangesNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.patientChangesNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPatientChangesNumber [status]: ', response.status);
                                });

                            this.getPendingDuplicatesNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.pendingDuplicatesNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getPendingDuplicatesNumber [status]: ', response.status);
                                });

                            this.getBouncesNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.emailBouncesNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getBouncesNumber [status]: ', response.status);
                                });

                            this.getUsingPaymentReports()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.usePaymentReports = data.use_payment_reports;
                                    }
                                }, function(response) {
                                    console.error('getUsingPaymentReports [status]: ', response.status);
                                }).then(function(response) {
                                    if (this.headerInfo.usePaymentReports) {
                                        this.getPaymentReportsNumber()
                                            .then(function(response) {
                                                var data = response.data.data;

                                                if (data) {
                                                    this.headerInfo.paymentReportsNumber = data.total;
                                                }
                                            }, function(response) {
                                                console.error('getPaymentReportsNumber [status]: ', response.status);
                                            });
                                    }
                                });

                            this.getUnsignedNotesNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.unsignedNotesNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getUnsignedNotesNumber [status]: ', response.status);
                                });

                            this.getFaxAlertsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.headerInfo.faxAlertsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getFaxAlertsNumber [status]: ', response.status);
                                });

                            this.getSupportTicketsNumber()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.supportTicketsNumber = data.total;
                                    }
                                }, function(response) {
                                    console.error('getSupportTicketsNumber [status]: ', response.status);
                                });
                        }
                    });
            }).then(function(response) {
                if (this.$route.query.pid) {
                    this.getPatientByIdAndDocId(this.headerInfo.user.docid, this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.premedCheck  = data[0].premedcheck;
                                this.medicare     = (data[0].p_m_ins_type == 1);
                                this.alertText    = data[0].alert_text;
                                this.displayAlert = data[0].display_alert;

                                if (this.premedCheck) {
                                    this.title += 'Pre-medication: ' + data[0].premed + '\n';
                                }

                                this.patientName = data[0].firstname +  ' ' + data[0].lastname;
                            }
                        }, function(response) {
                            console.error('getPatientByIdAndDocId [status]: ', response.status);
                        });

                    this.getHealthHistoryByPatientId(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.alergen = data[0].allergenscheck;

                                if (this.alergen) {
                                    this.title += 'Allergens: ' + data[0].other_allergens;
                                }
                            }
                        }, function(response) {
                            console.error('getHealthHistoryByPatientId [status]: ', response.status);
                        });
                }
            }).then(function(response) {
                this.getTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.tasksNumber = data.length;
                        }
                    }, function(response) {
                        console.error('getTasks [status]: ', response.status);
                    });

                this.getOverdueTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.overdueTasks            = data;
                            this.headerInfo.overdueTasks = data;
                        }
                    }, function(response) {
                        console.error('getOverdueTasks [status]: ', response.status);
                    });

                this.getTodayTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.todayTasks            = data;
                            this.headerInfo.todayTasks = data;
                        }
                    }, function(response) {
                        console.error('getTodayTasks [status]: ', response.status);
                    });

                this.getTomorrowTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.tomorrowTasks            = data;
                            this.headerInfo.tomorrowTasks = data;
                        }
                    }, function(response) {
                        console.error('getTomorrowTasks [status]: ', response.status);
                    });

                this.getThisWeekTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.headerInfo.thisWeekTasks = data;
                        }
                    }, function(response) {
                        console.error('getThisWeekTasks [status]: ', response.status);
                    });

                this.getNextWeekTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.headerInfo.nextWeekTasks = data;
                        }
                    }, function(response) {
                        console.error('getNextWeekTasks [status]: ', response.status);
                    });

                this.getLaterTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.headerInfo.laterTasks = data;
                        }
                    }, function(response) {
                        console.error('getLaterTasks [status]: ', response.status);
                    });
            }).then(function(response) {
                this.getUserById(this.headerInfo.user.id)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.$set('headerInfo.user.use_course', data.use_course);
                        }
                    }, function(response) {
                        console.error('getUserById [status]: ', response.status);
                    });

                this.getCourseStaff()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.$set('headerInfo.courseStaff.use_course', data.use_course);
                            this.$set('headerInfo.courseStaff.use_course_staff', data.use_course_staff);
                        }
                    }, function(response) {
                        console.error('getCourseStaff [status]: ', response.status);
                    });
            }).then(function(response) {
                this.getCompanyLogo()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.$set('companyLogo', data.logo);
                        }
                    }, function(response) {
                        console.error('getCompanyLogo [status]: ', response.status);
                    });
            }).then(function(response) {
                if (this.$route.query.pid) {
                    this.getPatientTasks(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.patientTaskNumber = data.length;
                            }
                        }, function(response) {
                            console.error('getPatientTasks [status]: ', response.status);
                        }).then(function(response) {
                            if (this.patientTaskNumber > 0) {
                                this.getPatientOverdueTasks(this.$route.query.pid)
                                    .then(function(response) {
                                        var data = response.data.data;

                                        if (data) {
                                            this.headerInfo.overdueTasks = data;
                                        }
                                    }, function(response) {
                                        console.error('getPatientOverdueTasks [status]: ', response.status);
                                    });

                                this.getPatientTodayTasks(this.$route.query.pid)
                                    .then(function(response) {
                                        var data = response.data.data;

                                        if (data) {
                                            this.headerInfo.todayTasks = data;
                                        }
                                    }, function(response) {
                                        console.error('getPatientTodayTasks [status]: ', response.status);
                                    });

                                this.getPatientTomorrowTasks(this.$route.query.pid)
                                    .then(function(response) {
                                        var data = response.data.data;

                                        if (data) {
                                            this.headerInfo.tomorrowTasks = data;
                                        }
                                    }, function(response) {
                                        console.error('getPatientTomorrowTasks [status]: ', response.status);
                                    });

                                this.getPatientFutureTasks(this.$route.query.pid)
                                    .then(function(response) {
                                        var data = response.data.data;

                                        if (data) {
                                            this.futureTasks = data;
                                        }
                                    }, function(response) {
                                        console.error('getPatientFutureTasks [status]: ', response.status);
                                    });
                            }
                        });
                }
            }).then(function(response) {
                if (this.$route.query.pid) {
                    this.getPatientsByParentId(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.childrenPatients = data;
                            }
                        }, function(response) {
                            console.error('getPatientsByParentId [status]: ', response.status);
                        });

                    this.getCurrentPatientContacts(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.totalContacts = data.length;
                            }
                        }, function(response) {
                            console.error('getCurrentPatientContacts [status]: ', response.status);
                        });

                    this.getCurrentPatientInsurances(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.totalInsurances = data.lenght;
                            }
                        }, function(response) {
                            console.error('getCurrentPatientInsurances [status]: ', response.status);
                        });

                    this.getQuestionnaireStatuses(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                for (var field in data) {
                                    this.questionnaireStatuses[field] = data[field];
                                }
                            }
                        }, function(response) {
                            console.error('getQuestionnaireStatuses [status]: ', response.status);
                        })

                    this.getBouncedEmailsNumberForCurrentPatient(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.bouncedEmailsNumberForCurrentPatient = data.length;
                            }
                        }, function(response) {
                            console.error('getBouncedEmailsNumberForCurrentPatient [status]: ', response.status);
                        });

                    this.getRejectedClaimsForCurrentPatient(this.$route.query.pid)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                this.$set('rejectedClaimsForCurrentPatient', data);
                            }
                        }, function(response) {
                            console.error('getRejectedClaimsForCurrentPatient [status]: ', response.status);
                        });
                }
            }).then(function(response) {
                this.getUncompletedHomeSleepTests()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.$set('uncompletedHomeSleepTests', data);
                        }
                    }, function(response) {
                        console.error('getUncompletedHomeSleepTests [status]: ', response.status);
                    });
            });
    },
    watch: {
        'headerInfo': {
            handler: function() {
                this.$broadcast('update-header-info', this.headerInfo);
            },
            deep: true
        },
        'headerInfo.docInfo.use_letters': function() {
            this.headerInfo.useLetters = (this.headerInfo.docInfo.use_letters == 1);
        }
    },
    computed: {
        notificationsNumber: function() {
            var notificationsNumber = +this.headerInfo.pendingLetters.length +
                +this.headerInfo.preauthNumber +
                +this.headerInfo.rejectedPreAuthNumber +
                +this.headerInfo.patientContactsNumber +
                +this.headerInfo.patientInsurancesNumber +
                +this.headerInfo.patientChangesNumber +
                +this.headerInfo.emailBouncesNumber +
                +this.headerInfo.unsignedNotesNumber +
                +this.headerInfo.pendingDuplicatesNumber;

            if (this.headerInfo.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE) {
                notificationsNumber += +this.headerInfo.unmailedClaimsNumber
                    + +this.headerInfo.pendingNodssClaimsNumber;
            } else {
                notificationsNumber += +this.headerInfo.pendingClaimsNumber;
            }

            return notificationsNumber;
        },
        isUserDoctor: function() {
            return (this.headerInfo.user.docid === this.headerInfo.user.id);
        },
        showOnlineCEAndSnoozleHelp: function() {
            return (
                (this.isUserDoctor && this.headerInfo.user.use_course == 1) ||
                (
                    !this.isUserDoctor &&
                    this.headerInfo.courseStaff.use_course == 1 && this.headerInfo.courseStaff.use_course_staff == 1
                )
            );
        },
        showWarningAboutPatientChanges: function() {
            return ((this.childrenPatients.length + this.totalContacts + this.totalInsurances) > 0);
        },
        showWarningAboutQuestionnaireChanges: function() {
            return (this.questionnaireStatuses.symptoms_status == 2
                || this.questionnaireStatuses.treatments_status == 2
                || this.questionnaireStatuses.history_status == 2
            );
        },
        showWarningAboutBouncedEmails: function() {
            return this.bouncedEmailsNumberForCurrentPatient;
        }
    },
    methods: {
        getCurrentUser: function() {
            return this.$http.post(window.config.API_PATH + 'users/current');
        },
        getUser: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        setLoginDetails: function(currentPage) {
            var data = {
                loginid  : this.headerInfo.user.loginid || 0,
                userid   : this.headerInfo.user.id || 0,
                cur_page : currentPage || ""
            };

            return this.$http.post(window.config.API_PATH + 'login-details', data);
        },
        getPendingLetters: function() {
            return this.$http.post(window.config.API_PATH + 'letters/pending');
        },
        getUnmailedLettersNumber: function() {
            return this.$http.post(window.config.API_PATH + 'letters/unmailed');
        },
        getPendingClaimsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/pending-claims');
        },
        getUnmailedClaimsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/unmailed-claims');
        },
        getRejectedClaimsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/rejected-claims');
        },
        getPreauthNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurance-preauth/completed');
        },
        getPendingPreauthNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurance-preauth/pending');
        },
        getRejectedPreauthNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurance-preauth/rejected');
        },
        getHSTNumber: function() {
            return this.$http.post(window.config.API_PATH + 'home-sleep-tests/completed');
        },
        getRequestedHSTNumber: function() {
            return this.$http.post(window.config.API_PATH + 'home-sleep-tests/requested');
        },
        getRejectedHSTNumber: function() {
            return this.$http.post(window.config.API_PATH + 'home-sleep-tests/rejected');
        },
        getPatientContactsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'patient-contacts/number');
        },
        getPatientInsurancesNumber: function() {
            return this.$http.post(window.config.API_PATH + 'patient-insurances/number');
        },
        getPatientChangesNumber: function() {
            return this.$http.post(window.config.API_PATH + 'patients/number');
        },
        getPendingDuplicatesNumber: function() {
            return this.$http.post(window.config.API_PATH + 'patients/duplicates');
        },
        getBouncesNumber: function() {
            return this.$http.post(window.config.API_PATH + 'patients/bounces');
        },
        getUsingPaymentReports: function() {
            return this.$http.post(window.config.API_PATH + 'users/payment-reports');
        },
        getPaymentReportsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'payment-reports/number');
        },
        getUnsignedNotesNumber: function() {
            return this.$http.post(window.config.API_PATH + 'notes/unsigned');
        },
        getFaxAlertsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'faxes/alerts');
        },
        getSupportTicketsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'support-tickets/number');
        },
        getPatientByIdAndDocId: function(docId, patientId) {
            var data = {
                where: {
                    docid     : docId || 0,
                    patientid : patientId || 0
                }
            };

            return this.$http.post(window.config.API_PATH + 'patients/with-filter', data);
        },
        getHealthHistoryByPatientId: function(patientId) {
            var data = {
                fields : ['other_allergens', 'allergenscheck'],
                where  : { patientid : patientId || 0 }
            };

            return this.$http.post(window.config.API_PATH + 'health-histories/with-filter', data);
        },
        getTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/all');
        },
        getOverdueTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/overdue');
        },
        getTodayTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/today');
        },
        getTomorrowTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/tomorrow');
        },
        getThisWeekTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/this-week');
        },
        getNextWeekTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/next-week');
        },
        getLaterTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/later');
        },
        getPatientTasks: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'tasks/all/pid/' + patientId);
        },
        getPatientOverdueTasks: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'tasks/overdue/pid/' + patientId);
        },
        getPatientTodayTasks: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'tasks/today/pid/' + patientId);
        },
        getPatientTomorrowTasks: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'tasks/tomorrow/pid/' + patientId);
        },
        getPatientFutureTasks: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'tasks/future/pid/' + patientId);
        },
        getUserById: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        getCourseStaff: function() {
            return this.$http.post(window.config.API_PATH + 'users/course-staff');
        },
        getCompanyLogo: function() {
            return this.$http.post(window.config.API_PATH + 'companies/company-logo');
        },
        getPatientsByParentId: function(parentPatientId) {
            var data = {
                where  : { parent_patientid : parentPatientId || 0 }
            };

            return this.$http.post(window.config.API_PATH + 'patients/with-filter', data);
        },
        getCurrentPatientContacts: function(patientId) {
            var data = {
                patientId: patientId || 0
            }

            return this.$http.post(window.config.API_PATH + 'patient-contacts/current', data);
        },
        getCurrentPatientInsurances: function(patientId) {
            var data = {
                patientId: patientId || 0
            }

            return this.$http.post(window.config.API_PATH + 'patient-insurances/current', data);
        },
        getQuestionnaireStatuses: function(patientId) {
            var data = {
                fields: ['symptoms_status', 'treatments_status', 'history_status'],
                where: {
                    patientid : patientId || 0
                }
            };

            return this.$http.post(window.config.API_PATH + 'patients/with-filter', data);
        },
        getBouncedEmailsNumberForCurrentPatient: function(patientId) {
            var data = {
                fields: ['patientid'],
                where: {
                    patientId : patientId || 0
                }
            };

            return this.$http.post(window.config.API_PATH + 'patients/with-filter', data);
        },
        getRejectedClaimsForCurrentPatient: function(patientId) {
            var data = {
                patientId: patientId || 0
            }

            return this.$http.post(window.config.API_PATH + 'insurances/rejected', data);
        },
        getUncompletedHomeSleepTests: function(patientId) {
            var data = {
                patientId: patientId || 0
            }

            return this.$http.post(window.config.API_PATH + 'home-sleep-tests/uncompleted', data);
        },
        showWarnings: function() {
            this.$set('showAllWarnings', true);
        },
        hideWarnings: function() {
            this.$set('showAllWarnings', false);
        },
        updateTaskToActive: function(id) {
            id = id || 0;

            var data = {
                status: 1
            };

            return this.$http.put(window.config.API_PATH + 'tasks/' + id, data);
        },
        deleteTask: function(id) {
            id = id || 0;

            return this.$http.delete(window.config.API_PATH + 'tasks/' + id);
        },
        onClickTaskStatus: function(event) {
            var id = event.target.value || 0;

            this.updateTaskToActive(id)
                .then(function(response) {
                    switch (event.target.parentElement.parentElement.id) {
                        case 'task_od_list':
                            this.overdueTasks.$remove(this.searchItemById(this.overdueTasks, id));
                            break;
                        case 'task_tod_list':
                            this.todayTasks.$remove(this.searchItemById(this.todayTasks, id));
                            break;
                        case 'task_tom_list':
                            this.tomorrowTasks.$remove(this.searchItemById(this.tomorrowTasks, id));
                            break;
                        case 'task_tw_list':
                            this.thisWeekTasks.$remove(this.searchItemById(this.thisWeekTasks, id));
                            break;
                        case 'task_nw_list':
                            this.nextWeekTasks.$remove(this.searchItemById(this.nextWeekTasks, id));
                            break;
                        case 'task_lat_list':
                            this.laterTasks.$remove(this.searchItemById(this.laterTasks, id));
                            break;
                        default:
                            break;
                    }

                    this.$set('tasksNumber', --this.tasksNumber);
                }, function(response) {
                    console.error('updateTaskToActive [status]: ', response.status);
                });
        },
        onMouseEnterTaskItem: function(event) {
            // get id from .task_status element
            var id = event.target.children[1].value || 0;

            event.target.children['task_extra_' + id].style.display = 'block';
        },
        onMouseLeaveTaskItem: function(event) {
            // get id from .task_status element
            var id = event.target.children[1].value || 0;

            event.target.children['task_extra_' + id].style.display = 'none';
        },
        onMouseOverPatientTaskHeader: function(event) {
            event.target.parentElement.children['pat_task_list'].style.display = 'block';
        },
        onMouseLeavePatientTaskMenu: function(event) {
            event.target.children['pat_task_list'].style.display = 'none';
        },
        onClickDeleteTask: function(id, event) {
            event.preventDefault();

            if (confirm('Are you sure you want to delete this task?')) {
                id = id || 0;

                this.deleteTask(id)
                    .then(function(response) {
                        switch (event.target.parentElement.parentElement.parentElement.id) {
                            case 'task_od_list':
                                this.overdueTasks.$remove(this.searchItemById(this.overdueTasks, id));
                                break;
                            case 'task_tod_list':
                                this.todayTasks.$remove(this.searchItemById(this.todayTasks, id));
                                break;
                            case 'task_tom_list':
                                this.tomorrowTasks.$remove(this.searchItemById(this.tomorrowTasks, id));
                                break;
                            case 'task_tw_list':
                                this.thisWeekTasks.$remove(this.searchItemById(this.thisWeekTasks, id));
                                break;
                            case 'task_nw_list':
                                this.nextWeekTasks.$remove(this.searchItemById(this.nextWeekTasks, id));
                                break;
                            case 'task_lat_list':
                                this.laterTasks.$remove(this.searchItemById(this.laterTasks, id));
                                break;
                            default:
                                break;
                        }

                        this.$set('tasksNumber', --this.tasksNumber);
                    }, function(response) {
                        console.error('deleteTask [status]: ', response.status);
                    });
            }
        },
        searchItemById: function(data, id) {
            id = id || 0;
            var removeId = -1;

            data.forEach(function(task, index) {
                if (task.id == id) {
                    removeId = index;
                }
            });

            if (removeId >= 0) {
                return data[removeId];
            } else {
                return null;
            }
        }
    }
};