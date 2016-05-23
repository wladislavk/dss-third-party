module.exports = {
    data: function() {
        return {
            headerInfo: {
                usePaymentReports    : false,
                paymentReportsNumber : 0
            },
            user: {},
            docInfo: {},
            pendingLetters: [],
            unmailedLetters: []
            secondsPerDay: 86400,
            oldestLetter: 0,
            preauthNumber: 0
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
                                        this.pendingLetters = data;
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

                            this.getUnmailedLetters()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        this.unmailedLetters = data;
                                    }
                                }, function(response) {
                                    console.error('getUnmailedLetters [status]: ', response.status);
                                });

                            this.getPendingClaims()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPendingClaims [status]: ', response.status);
                                });

                            this.getUnmailedClaims()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getUnmailedClaims [status]: ', response.status);
                                });

                            this.getRejectedClaims()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getRejectedClaims [status]: ', response.status);
                                });

                            this.getPreauthNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPreauthNumber [status]: ', response.status);
                                });

                            this.getPendingPreauthNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPendingPreauthNumber [status]: ', response.status);
                                });

                            this.getRejectedPreauthNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getRejectedPreauthNumber [status]: ', response.status);
                                });

                            this.getHSTNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getHSTNumber [status]: ', response.status);
                                });

                            this.getRequestedHSTNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getRequestedHSTNumber [status]: ', response.status);
                                });

                            this.getRejectedHSTNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getRejectedHSTNumber [status]: ', response.status);
                                });

                            this.getPatientContactsNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPatientContactsNumber [status]: ', response.status);
                                });

                            this.getPatientInsurancesNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPatientInsurancesNumber [status]: ', response.status);
                                });

                            this.getPatientChangesNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPatientChangesNumber [status]: ', response.status);
                                });

                            this.getPendingDuplicatesNUmber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getPendingDuplicatesNUmber [status]: ', response.status);
                                });

                            this.getBouncesNumber()
                                .then(function(response) {
                                    // if success
                                }, function(response) {
                                    console.error('getBouncesNumber [status]: ', response.status);
                                });

                            this.getUsingPaymentReports()
                                .then(function(response) {
                                    // if success
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
                        }
                    });
            });
    },
    computed: {},
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
        getUnmailedLetters: function() {
            return this.$http.post(window.config.API_PATH + 'letters/unmailed');
        },
        getPendingClaims: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/pending');
        },
        getUnmailedClaims: function() {
            return this.$http.post(window.config.API_PATH + 'insurances/unmailed');
        },
        getRejectedClaims: function() {
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
        getPendingDuplicatesNUmber: function() {
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
        }
    }
};