
/**
 *
 * Brendan
 *
 */

var enrollmentApiPath = apiRoot + 'api/v1/enrollments/';

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
            fields: {
                transaction_type:null
            },
            enrollments:[],
            apikey:[],
            selectedEnrollmentType:null,
            errors: null
    },

    ready: function() {

        this.fetchEnrollments();
        this.fetchApiKey();

    },
    methods: {

        fetchEnrollments:function()
        {

            this.showBusy("<h1>Fetching enrollments please wait...</h1>");

            this.$http.get(enrollmentApiPath + 'list/' + docId, function (data, status, request) {
                this.$set('enrollments', data.data);
                //console.log(data.data);
                $.unblockUI();
            }).error(function (data, status, request) {
                // handle error
                $.unblockUI();
            });

        },

        fetchApiKey:function()
        {
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

        fetchEnrrollmentType : function()
        {
            this.$http.get(enrollmentApiPath + 'type/' + docId, function (data, status, request) {
                if(data != null) {
                    this.$set('selectedEnrollmentType', data.transaction_type);
                }
                else {
                    this.$set('selectedEnrollmentType', []);
                }
                $('#selected_transaction_type').val(this.selectedEnrollmentType);
                console.log(this.selectedEnrollmentType);
            }).error(function (data, status, request) {
                // handle error
            });
        },

        createEnrollment: function (e) {

            e.preventDefault();

            this.fetchEnrrollmentType();
            var payer_id = $('#payer_id').val().split("-")[0];
            var provider = JSON.parse( $('#provider_select').val() );

            var postValues = {
                user_id:$('#user_id').val(),
                transaction_type_id:$('#transaction_type').val(),
                selected_transaction_type:$('#selected_transaction_type').val(),
                payer_id:payer_id,
                facility_name:$('#facility_name').val(),
                provider_name:provider.provider_name,
                tax_id:$('#tax_id').val(),
                address:$('#address').val(),
                city:$('#city').val(),
                state:$('#state').val(),
                zip:$('#zip').val(),
                first_name:$('#first_name').val(),
                last_name:$('#last_name').val(),
                contact_number:$('#contact_number').val(),
                email:$('#email').val(),
                npi:provider.npi,
                ptan:provider.medicare_ptan
            };

            //console.log(postValues);

            this.showBusy("<h1>Creating enrollment please wait...</h1>");

            this.$http.post(enrollmentApiPath + 'create',postValues,function(data,status,request) {
                this.fetchEnrollments();
                alert('Enrollment successfully created.');
                $.colorbox.close();
            }).error(function (data, status, request) {
                var message = data;
                $.unblockUI();
                this.$set('errors', message);
            })


        },

        setEnrollmentType : function()
        {

        },

        enrollmentStatusLabel: function(status) {
            return enrollmentLabels[status];
        },

        showBusy: function(message) {
            $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }, message: message, baseZ:10000 });
        },

        showHideResponse: function(id)
        {
            //$('#' + id).toggle();
            $.colorbox({width: "40%",
                inline: true,
                href: '#' + id
            });
        },

        uploadEnrollment: function()
        {
            alert('ddd');
            //loadPopup('upload_enrollment.php' + reference_id);
        },

    },

});

$(document).ready(function() {

    $('.addButton').colorbox({inline:true, width:"40%", closeButton: true,
        onClosed:function(){ location.reload(); }
    });

});
