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
                laterTasks               : []
            },
            user                       : {},
            docInfo                    : {},
            secondsPerDay              : 86400,
            oldestLetter               : 0,
            pendingPreauthNumber       : 0,
            supportTicketsNumber       : 0,
            title                      : '',
            premedCheck                : 0,
            medicare                   : 0,
            alertText                  : '',
            displayAlert               : false,
            alergen                    : 0,
            patientName                : '',
            patientTasks               : [],
            notificationsNumber        : 0,
            patientAllTasksNumber      : 0,
            isUserDoctor               : false,
            showOnlineCEAndSnoozleHelp : false,
            courseStaff: {
                use_course       : 0,
                use_course_staff : 0
            },
        }
    },
    created: function() {
        this.getCurrentUser() // get current user info
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    for (var field in data) {
                        this.user[field] = data[field];
                    }
                }
            }, function(response) {
                console.error('getCurrentUser [status]: ', response.status);
            }).then(function(response) {
                this.getUser(this.user.docid) //get doc info
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            for (var field in data) {
                                this.docInfo[field] = data[field];
                            }
                        }
                    }, function(response) {
                        console.error('getUser [status]: ', response.status);
                    }).then(function(response) {
                        if (this.docInfo.homepage != '1') {
                            // include_once 'includes/top2.htm';
                        } else {
                            if (this.user.loginid) {
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
                                    if (this.pendingLetters[0].generated_date == 0) {
                                        this.oldestLetter = 0
                                    } else {
                                        this.oldestLetter = Math.floor(
                                            (moment().valueOf() - this.pendingLetters[0].generated_date) / this.secondsPerDay
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
                if ($route.query.pid) {
                    this.getPatientByIdAndDocId(this.user.docid, $route.query.pid)
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

                    this.getHealthHistoryByPatientId($route.query.pid)
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
                this.getPatientTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.patientAllTasksNumber = data.length;
                        }
                    }, function(response) {
                        console.error('getPatientTasks [status]: ', response.status);
                    });

                this.getPatientOverdueTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.overdueTasks = data;
                        }
                    }, function(response) {
                        console.error('getPatientOverdueTasks [status]: ', response.status);
                    });

                this.getPatientTodayTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.todayTasks = data;
                        }
                    }, function(response) {
                        console.error('getPatientTodayTasks [status]: ', response.status);
                    });

                this.getPatientTomorrowTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.tomorrowTasks = data;
                        }
                    }, function(response) {
                        console.error('getPatientTomorrowTasks [status]: ', response.status);
                    });

                this.getPatientThisWeekTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.thisWeekTasks = data;
                        }
                    }, function(response) {
                        console.error('getPatientThisWeekTasks [status]: ', response.status);
                    });

                this.getPatientLaterTasks()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.laterTasks = data;
                        }
                    }, function(response) {
                        console.error('getPatientLaterTasks [status]: ', response.status);
                    });
            }).then(function(response) {
                this.getUserById(this.user.id)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.user['use_course'] = data.use_course;
                        }
                    }, function(response) {
                        console.error('getUserById [status]: ', response.status);
                    });

                this.getCourseStaff()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.courseStaff['use_course']       = data.use_course;
                            this.courseStaff['use_course_staff'] = data.use_course_staff;
                        }
                    }, function(response) {
                        console.error('getCourseStaff [status]: ', response.status);
                    });
            });
    },
    computed: {
        notificationsNumber: function() {
            var notificationsNumber = this.headerInfo.pendingLetters.lenght
                + this.headerInfo.preauthNumber
                + this.headerInfo.rejectedPreAuthNumber
                + this.headerInfo.patientContactsNumber
                + this.headerInfo.patientInsurancesNumber
                + this.headerInfo.patientChangesNumber
                + this.headerInfo.emailBouncesNumber
                + this.headerInfo.unsignedNotesNumber
                + this.headerInfo.pendingDuplicatesNumber;

            if (this.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE) {
                notificationsNumber += this.headerInfo.unmailedClaimsNumber
                    + this.headerInfo.pendingNodssClaimsNumber;
            } else {
                notificationsNumber += this.headerInfo.pendingClaimsNumber;
            }

            return notificationsNumber;
        },
        isUserDoctor: function() {
            return (this.user.docid === this.user.id);
        },
        showOnlineCEAndSnoozleHelp: function() {
            return (
                (this.isUserDoctor && this.user.use_course == 1) ||
                (
                    !this.isUserDoctor &&
                    this.courseStaff.use_course == 1 && this.courseStaff.use_course_staff == 1
                )
            );
        }
    },
    methods: function() {
        getCurrentUser: function() {
            return this.$http.post(window.config.API_PATH + 'users/current');
        },
        getUser: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        setLoginDetails: function(currentPage) {
            var data = {
                loginid  : this.user.loginid || 0,
                userid   : this.user.id || 0,
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
            return this.$http.post(window.config.API_PATH + 'insurances/pending');
        },
        getUnmailedClaimsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/unmailed');
        },
        getRejectedClaimsNumber: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/rejected');
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
            return this.$http.post(window.config.API_PATH + 'hst/completed');
        },
        getRequestedHSTNumber: function() {
            return this.$http.post(window.config.API_PATH + 'hst/requested');
        },
        getRejectedHSTNumber: function() {
            return this.$http.post(window.config.API_PATH + 'hst/rejected');
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
        getPatientTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/all');
        },
        getPatientOverdueTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/overdue');
        },
        getPatientTodayTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/today');
        },
        getPatientTomorrowTasks: function()
        {
            return this.$http.post(window.config.API_PATH + 'tasks/tomorrow');
        },
        getPatientThisWeekTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/this-week');
        },
        getPatientNextWeekTasks: fucntion() {
            return this.$http.post(window.config.API_PATH + 'tasks/next-week');
        },
        getPatientLaterTasks: function() {
            return this.$http.post(window.config.API_PATH + 'tasks/later');
        },
        getUserById: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        getCourseStaff: function()
        {
            return this.$http.post(window.config.API_PATH + 'users/course-staff');
        }
    }
};