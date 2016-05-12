var config    = require('../../modules/config.js');
var constants = require('../../modules/constants.js');

Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var dashboard = new Vue({
    el: '#dashboard',
    data: {
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
    },
    created: function() {
        /*
        1. getCurrentUser
        2.1 getDocInfoById
            2.1.1 redirectToIndex2
        2.2 getManageStaffOfCurrentUser
        3. getDocumentCategories
        */

        this.getCurrentUser();
        this.getDocumentCategories();
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
            return (this.user.user_type == constants.DSS_USER_TYPE_FRANCHISEE);
        },
        showGetCE: function() {
            return (
                (isUserDoctor && this.docInfo.use_course == 1) ||
                (
                    !isUserDoctor &&
                    this.courseStaff.use_course == 1 && this.courseStaff.use_course_staff == 1
                )
            );
        },
        showUnmailedLetters: function() {
            return (this.useLetters && this.user.user_type == constants.DSS_USER_TYPE_SOFTWARE);
        },
        showUnmailedClaims: function() {
            return (this.user.user_type == constants.DSS_USER_TYPE_SOFTWARE);
        }
    },
    methods: {
        getCurrentUser: function() {
            this.$http.post(config.API_PATH + 'users/current', function(data, status, request) {
                data = data.data;

                if (data) {
                    for (field in data) {
                        this.user[field] = data[field];
                    }
                }

                this.getDocInfoById(this.redirectToIndex2);
                this.getManageStaffOfCurrentUser();
            }).error(function(data, status, request) {
                console.log('getCurrentUser [Error]: ', status, data);
            });
        },
        getDocInfoById: function(callback) {
            this.$http.get(config.API_PATH + 'users/' + this.user.docid, function(data, status, request) {
                data = data.data;

                if (data) {
                    this.docInfo['homepage']         = data.homepage || 0;
                    this.docInfo['manage_staff']     = data.manage_staff || 0;
                    this.docInfo['use_course']       = data.use_course || 0;
                    this.docInfo['use_eligible_api'] = data.use_eligible_api || 0;
                }

                callback();
            }).error(function(data, status, request) {
                console.log('getDocInfoById [Error]: ', status, data);
            });
        },
        getManageStaffOfCurrentUser: function() {
            this.$http.get(config.API_PATH + 'users/' + this.user.id, function(data, status, request) {
                data = data.data;

                if (data) {
                    this.user['manage_staff'] = data.manage_staff || 0
                }
            }).error(function(data, status, request) {
                console.log('getManageStaffOfCurrentUser [Error]: ', status, data);
            });
        },
        redirectToIndex2: function() {
            if (this.docInfo.homepage != 1) {
                window.location = 'index2.php';
            }
        },
        getDocumentCategories: function() {
            this.$http.post(config.API_PATH + 'document-categories/active', function(data, status, request) {
                data = data.data;

                this.$set('documentCategories', data);
            }).error(function(data, status, request) {
                console.log('getDocumentCategories [Error]: ', status, data);
            });
        },
        getCourseStaff: function()
        {
            this.$http.post(config.API_PATH + 'users/course-staff', function(data, status, request) {
                data = data.data;

                if (data) {
                    this.courseStaff['use_course']       = data.use_course;
                    this.courseStaff['use_course_staff'] = data.use_course_staff;
                }
            }).error(function(data, status, request) {
                console.log('getCourseStaff [Error]: ', status, data);
            });
        },
        getCurrentMemos: function() {
            this.$http.post(config.API_PATH + 'memos/current', function(data, status, request) {
                data = data.data;

                this.$set('memos', data);
            }).error(function(data, status, request) {
                console.log('getCourseStaff [Error]: ', status, data);
            });
        }
    }
});