
/**
 *
 * Brendan
 *
 */

//var enrollmentApiPath = 'http://apitest.ds3soft.net/api/v1/enrollments/';
var enrollmentApiPath = 'http://api.ds3soft.local/api/v1/enrollments/';
var divDocId = document.getElementById("dom-docid");
var docId = divDocId.textContent;
var divApiKey = document.getElementById("dom-default-api-key");
var defaultApiKey = divApiKey.textContent;

var enrollmentStatuses = {
    DSS_ENROLLMENT_SUBMITTED    : 0,
    DSS_ENROLLMENT_ACCEPTED     : 1,
    DSS_ENROLLMENT_REJECTED     : 2,
    DSS_ENROLLMENT_PDF_RECEIVED : 3,
    DSS_ENROLLMENT_PDF_SENT     : 4
};

var enrollmentLabels = [];
enrollmentLabels[enrollmentStatuses.DSS_ENROLLMENT_SUBMITTED] = 'Submitted';
enrollmentLabels[enrollmentStatuses.DSS_ENROLLMENT_ACCEPTED] = 'Accepted';
enrollmentLabels[enrollmentStatuses.DSS_ENROLLMENT_REJECTED] = 'Rejected';
enrollmentLabels[enrollmentStatuses.DSS_ENROLLMENT_PDF_RECEIVED] = 'PDF Received';
enrollmentLabels[enrollmentStatuses.DSS_ENROLLMENT_PDF_SENT] = 'PDF Sent';

var enrollments = new Vue({
    el: '#enrollmentManager',
        data: {
            enrollments:[],
            apikey:[],
        fields: {

        }
    },

    ready: function() {

        this.fetchEnrollments();
        this.fetchApiKey();

    },
    methods: {

        fetchEnrollments:function() {
            this.$http.get(enrollmentApiPath + 'list/' + docId, function (data, status, request) {
                this.$set('enrollments', data.data);
                //console.log(data.data);
            }).error(function (data, status, request) {
                // handle error
            });
        },

        fetchApiKey:function() {
            this.$http.get(enrollmentApiPath + 'apikey/' + docId, function (data, status, request) {
                if(data != null) {
                    this.$set('apikey', data.eligible_api_key);
                }
                else {
                    this.$set('apikey', defaultApiKey);
                }
                //console.log(this.apikey);
            }).error(function (data, status, request) {
                // handle error
            });
        },

        enrollmentStatusLabel: function(status) {
            return enrollmentLabels[status];
        },

    },

});
