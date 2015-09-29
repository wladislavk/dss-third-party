
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
            fields: {
                transaction_type:null
            },
            payer_id: '',
            enrollments:[],
            apikey:[],
            selectedEnrollmentType:null,
            errors: null
    },

    ready: function() {

        $('.addButton').colorbox({inline:true, width:"40%", closeButton: true, title:'<strong>Field with * are required: Note required fields change based on Insurance Co selection.</strong>',
            onClosed:function(){ location.reload(); }
        });

        $('#payer_id').change(function() {
            $("[id*=_required]").css('display', 'none');
            var payer_id = $('#payer_id').val().split("-")[0];
            $.get( enrollmentApiPath + 'requiredfields/' + payer_id, function( response ) {
                $.each( response.data , function( key, value) {
                    $('#' + value + '_required').toggle();
                    console.log(value);
                });
            });
        });

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
                swal("Success", "Enrollment successfully created.!", "success");
                $.colorbox.close();
            }).error(function (data, status, request) {
                $.unblockUI();
                var message = JSON.stringify(data);
                //this.$set('errors', message);
                this.handleErrors(data);
            })

        },

        setEnrollmentType : function()
        {
            var t = $('#transaction_type').val();
            $('#ins_payer_name').val('');
            if(t == '1'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer', '','','','','','coverage');
            }else if(t == '2'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/payment/status.json', 'ins_payer');
            }else if(t == '4'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/era.json', 'ins_payer', '','','','','','payment reports');
            }else if(t == '5'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', '', 'ins_payer');
            }else if(t == '6'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/dental.json', 'ins_payer');
            }else if(t == '7'){
                setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/institutional.json', 'ins_payer', '','','','','','professional claims');
            }
        },

        providerOnChangeHandler : function(me)
        {
            var json = $("#provider_select").val();
            var r = $.parseJSON(json);
            if(r.signature=="0"){
                alert("Error - No e-signature on file for "+r.provider_name+".  In order to submit electronic enrollments this user must add an e-signature on his/her ‘Profile’ page.");
                $('#provider_select option:first-child').attr("selected", "selected");
                exit;
            }
            $('#facility_name').val(r.facility_name);
            $('#provider_name').val(r.provider_name);
            $('#tax_id').val(r.tax_id);
            $('#address').val(r.address);
            $('#city').val(r.city);
            $('#state').val(r.state);
            $('#zip').val(r.zip);
            $('#npi').val(r.npi);
            $('#ptan').val(r.medicare_ptan);
            $('#first_name').val(r.first_name);
            $('#last_name').val(r.last_name);
            $('#contact_number').val(r.contact_number);
            $('#email').val(r.email);
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

        handleErrors: function(response)
        {
            var errors = typeof response.errors != 'undefined' ? JSON.parse(response.errors) : response;
            var errorString = '<ul>';
            $.each( errors, function( key, value) {
                errorString += '<li>' + value + '</li>';
            });
            errorString += '</ul>';
            //$.colorbox({width:"25%",html:errorString});
            swal({ title: "Error!",   text: errorString,   type: "error",   confirmButtonText: "Ok", html:true });
        },

    },

});

$(document).ready(function() {

});
