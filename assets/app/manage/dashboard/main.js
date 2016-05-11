var config = require('../../modules/config.js');

Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var dashboard = new Vue({
    el: '#dashboard',
    data: {
        user: {},
        docInfo: {
            homepage         : '',
            manage_staff     : '',
            use_course       : '',
            use_eligible_api : ''
        },
        showInvoices: false,
        showTransactionCode: false,
        documentCategories: []
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
    },
    ready: function() {
        this.getDocumentCategories();
    },
    computed: {
        showInvoices: function() {
            return (this.user.docid === this.user.id || this.docInfo.manage_staff == 1);
        },
        showTransactionCode: function() {
            return (this.user.id === this.user.docid || this.user.manage_staff == 1);
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
        }
    }
});