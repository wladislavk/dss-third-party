module.exports = {
    el: function() {
        return '#dashboard'
    },
    data: function() {
        return {
            // need to change logic for global values
            constants: window.constants,
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
                patientOverdueTasks      : [],
                patientTodayTasks        : [],
                patientTomorrowTasks     : [],
                patientThisWeekTasks     : [],
                patientNextWeekTasks     : [],
                patientLaterTasks        : [],
                user                     : {},
                docInfo                  : {},
                courseStaff: {
                    use_course       : 0,
                    use_course_staff : 0
                },
            },
            documentCategories: [],
            memos: [],
            notificationsNumber              : 0,
            isUserDoctor                     : false,
            showInvoices                     : false,
            showTransactionCode              : false,
            showEnrollments                  : false,
            showDSSFranchiseOperationsManual : false,
            showGetCE                        : false,
            showUnmailedLettersNumber        : false,
            showUnmailedClaims               : false
        }
    },
    watch: {
        'headerInfo.docInfo.homepage': 'redirectToIndex2',
        'headerInfo.user.id': function() {
            this.getManageStaffOfCurrentUser(this.headerInfo.user.id)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.headerInfo.user['manage_staff'] = data.manage_staff || 0
                    }
                }, function(response) {
                    console.error('getManageStaffOfCurrentUser [status]: ', response.status);
                });
        }
    },
    events: {
        'update-header-info': function(headerInfo) {
            this.headerInfo = headerInfo;
        }
    },
    created: function() {
        this.getDocumentCategories()
            .then(function(response) {
                var data = response.data.data;

                this.$set('documentCategories', data);
            }, function(response) {
                console.error('getDocumentCategories [status]: ', response.status);
            });

        this.getCurrentMemos()
            .then(function(response) {
                var data = response.data.data;

                this.$set('memos', data);
            }, function(response) {
                console.error('getCurrentMemos [status]: ', response.status);
            });
    },
    computed: {
        notificationsNumber: function() {
            return this.headerInfo.patientContactsNumber + this.headerInfo.patientInsurancesNumber + this.headerInfo.patientChangesNumber;
        },
        isUserDoctor: function() {
            return (this.headerInfo.user.docid === this.headerInfo.user.id);
        },
        showInvoices: function() {
            return (this.headerInfo.user.docid === this.headerInfo.user.id || this.docInfo.manage_staff == 1);
        },
        showTransactionCode: function() {
            return (this.headerInfo.user.id === this.headerInfo.user.docid || this.headerInfo.user.manage_staff == 1);
        },
        showEnrollments: function() {
            return (this.docInfo.use_eligible_api == 1);
        },
        showDSSFranchiseOperationsManual: function() {
            return (this.headerInfo.user.user_type == window.constants.DSS_USER_TYPE_FRANCHISEE);
        },
        showGetCE: function() {
            return (
                (this.isUserDoctor && this.docInfo.use_course == 1) ||
                (
                    !this.isUserDoctor &&
                    this.headerInfo.courseStaff.use_course == 1 && this.headerInfo.courseStaff.use_course_staff == 1
                )
            );
        },
        showUnmailedLettersNumber: function() {
            return (this.headerInfo.useLetters && this.headerInfo.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE);
        },
        showUnmailedClaims: function() {
            return (this.headerInfo.user.user_type == window.constants.DSS_USER_TYPE_SOFTWARE);
        }
    },
    methods: {
        redirectToIndex2: function() {
            if (this.docInfo.homepage != 1) {
                this.$route.router.go('/manage/index2');
            }
        },
        getManageStaffOfCurrentUser: function(userId) {
            userId = userId || 0;

            return this.$http.get(window.config.API_PATH + 'users/' + userId);
        },
        getDocumentCategories: function() {
            return this.$http.post(window.config.API_PATH + 'document-categories/active');
        },
        getCurrentMemos: function() {
            return this.$http.post(window.config.API_PATH + 'memos/current');
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