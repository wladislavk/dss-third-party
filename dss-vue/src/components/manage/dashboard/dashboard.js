module.exports = {
    el: function() {
        return '#dashboard'
    },
    props: function() {
        return ['headerInfo']
    },
    data: function() {
        return {
            // need to change logic for global values
            constants: window.constants,
            // headerInfo: this.$parent.headerInfo,


            user: {},
            documentCategories: [],
            memos: [],
            docInfo: {
                homepage         : '',
                manage_staff     : '',
                use_course       : '',
                use_eligible_api : ''
            },
            courseStaff: {
                use_course       : 0,
                use_course_staff : 0
            },
            // from top
            patientContactsNumber    : 1,
            patientInsurancesNumber  : 3,
            patientChangesNumber     : 4,
            useLetters               : false,
            pendingLetters           : 5,
            unmailedLetters          : 3,
            preauthNumber            : 2,
            rejectedPreAuthNumber    : 6,
            hstNumber                : 4,
            rejectedHSTNumber        : 1,
            requestedHSTNumber       : 3,
            pendingNodssClaimsNumber : 2,
            unmailedClaimsNumber     : 3,
            rejectedClaimsNumber     : 4,
            pendingClaimsNumber      : 3,
            unsignedNotesNumber      : 3,
            alertsNumber             : 2,
            faxAlertsNumber          : 4,
            pendingDuplicatesNumber  : 2,
            emailBouncesNumber       : 3,
            usePaymentReports        : false,
            paymentReportsNumber     : 2,
            overdueTasks             : [],
            todayTasks               : [],
            tomorrowTasks            : [],
            thisWeekTasks            : [],
            nextWeekTasks            : [],
            laterTasks               : [],

            notificationsNumber              : 0,
            isUserDoctor                     : false,
            showInvoices                     : false,
            showTransactionCode              : false,
            showEnrollments                  : false,
            showDSSFranchiseOperationsManual : false,
            showGetCE                        : false,
            showUnmailedLetters              : false,
            showUnmailedClaims               : false,
        }
    },
    created: function() {
        /*
        1. getCurrentUser
            1.1 getDocInfoById
                1.1.1 redirectToIndex2
            1.2 getManageStaffOfCurrentUser
        2. getDocumentCategories
        3. getCourseStaff
        4. getCurrentMemos
        */

        console.info(this.headerInfo.user);

/*
        this.getCurrentUser()
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
                this.getDocInfoById(this.user.docid)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.docInfo['homepage']         = data.homepage || 0;
                            this.docInfo['manage_staff']     = data.manage_staff || 0;
                            this.docInfo['use_course']       = data.use_course || 0;
                            this.docInfo['use_eligible_api'] = data.use_eligible_api || 0;
                        }
                    }, function(response) {
                        console.error('getDocInfoById [status]: ', response.status);
                    }).then(this.redirectToIndex2);
                this.getManageStaffOfCurrentUser(this.user.id)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.user['manage_staff'] = data.manage_staff || 0
                        }
                    }, function(response) {
                        console.error('getManageStaffOfCurrentUser [status]: ', response.status);
                    });
            });

        this.getDocumentCategories()
            .then(function(response) {
                var data = response.data.data;

                this.$set('documentCategories', data);
            }, function(response) {
                console.error('getDocumentCategories [status]: ', response.status);
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

        this.getCurrentMemos()
            .then(function(response) {
                var data = response.data.data;

                this.$set('memos', data);
            }, function(response) {
                console.error('getCurrentMemos [status]: ', response.status);
            });
*/
    },
    computed: {
        notificationsNumber: function() {
            return this.patientContactsNumber + this.patientInsurancesNumber + this.patientChangesNumber;
        },
        isUserDoctor: function() {
            return (this.user.docid === this.user.id);
        },
        showInvoices: function() {
            return (this.user.docid === this.user.id || this.docInfo.manage_staff == 1);
        },
        showTransactionCode: function() {
            return (this.user.id === this.user.docid || this.user.manage_staff == 1);
        },
        showEnrollments: function() {
            return (this.docInfo.use_eligible_api == 1);
        },
        showDSSFranchiseOperationsManual: function() {
            return (this.user.user_type == window.constants.DSS_USER_TYPE_FRANCHISEE);
        },
        showGetCE: function() {
            return (
                (this.isUserDoctor && this.docInfo.use_course == 1) ||
                (
                    !this.isUserDoctor &&
                    this.courseStaff.use_course == 1 && this.courseStaff.use_course_staff == 1
                )
            );
        },
        showUnmailedLetters: function() {
            return (this.useLetters && this.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE);
        },
        showUnmailedClaims: function() {
            return (this.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE);
        }
    },
    methods: {
        getCurrentUser: function() {
            return this.$http.post(window.config.API_PATH + 'users/current');
        },
        getDocInfoById: function(docId) {
            docId = docId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + docId);
        },
        getManageStaffOfCurrentUser: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        getDocumentCategories: function() {
            return this.$http.post(window.config.API_PATH + 'document-categories/active');
        },
        getCourseStaff: function()
        {
            return this.$http.post(window.config.API_PATH + 'users/course-staff');
        },
        getCurrentMemos: function() {
            return this.$http.post(window.config.API_PATH + 'memos/current');
        },
        redirectToIndex2: function() {
            if (this.docInfo.homepage != 1) {
                window.location = 'index2.php';
            }
        },
        onClickExportMD: function() {
            swal({
                title            : '',
                text             : 'Enter your password',
                type             : 'input',
                showCancelButton : true,
                closeOnConfirm   : false,
                animation        : 'slide-from-top',
                inputPlaceholder : 'Enter password'
            }, function(inputValue){
                if (inputValue === "") {
                    swal.showInputError("You need to write the password!");
                    return false;
                }

                if (inputValue === "1234") {
                    swal.close();
                    window.location.href = 'export_md.php';
                } else if (inputValue.length > 0) {
                    swal("Oops...", "Wrong password!", "error");
                    return false;
                }
            });
        },
        onClickDataImport: function() {
            swal({
                title              : "",
                text               : "Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.",
                type               : "warning",
                showCancelButton   : true,
                confirmButtonColor : "#3CB371",
                confirmButtonText  : "Ok",
                cancelButtonText   : "Cancel",
                closeOnConfirm     : true,
                closeOnCancel      : true
            },
            function(isConfirm){
                if (isConfirm) {
                    window.location.href = 'data_import.php';
                }
            });
        }
    }
};