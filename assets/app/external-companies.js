Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var apiPath = apiRoot + 'api/v1/external-companies/';

var companies = new Vue({
    el: '#company-manager',
    data: {
        fields: {
            id: 0,
            name: '',
            short_name: '',
            api_key: '',
            valid_from: '',
            valid_to: '',
            url: '',
            description: '',
            status: 0,
            reason: ''
        }
    },
    methods: {
        newCompany: function () {
            this.fields.id = 0;
            this.fields.name = '';
            this.fields.short_name = '';
            this.fields.api_key = '';
            this.fields.valid_from = '';
            this.fields.valid_to = '';
            this.fields.url = '';
            this.fields.description = '';
            this.fields.status = 0;
            this.fields.reason = '';

            showModal();
        },
        editCompany: function (company, e) {
            this.fields.id = company.id;
            this.fields.name = company.name;
            this.fields.short_name = company.short_name;
            this.fields.api_key = company.api_key;
            this.fields.valid_from = company.valid_from;
            this.fields.valid_to = company.valid_to;
            this.fields.url = company.url;
            this.fields.description = company.description;
            this.fields.status = company.status;
            this.fields.reason = company.reason;

            showModal();
        },
        saveCompany: function (e) {
            e.preventDefault();
            this.showBusy('Saving changes please wait...');

            if (this.fields.id != 0) {
                this.$http.put(apiPath + this.fields.id, this.fields, function(data, status, request) {
                    this.$set('companies', data.data);
                    this.notifyAction('Company updated.');
                    hideModal();
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                });
            } else {
                this.$http.post(apiPath, this.fields, function(data, status, request) {
                    this.$set('companies', data.data);
                    this.notifyAction('Company created.');
                    hideModal();
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                });
            }

            $.unblockUI();
        },
        deleteCompany: function (company, e) {
            if (confirm('Delete this company - Are you sure?')) {
                this.showBusy('Deleting company please wait...');

                this.$http.delete(apiPath + company.id, function (data, status, request) {
                    this.$set('companies', data.data);
                    this.notifyAction('Company deleted.');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.notifyAction(message);
                });
            }

            $.unblockUI();
        },
        showBusy: function (message) {
            this.blockUI({
                message: message
            });
        },
        notifyAction: function (message) {
            this.blockUI({
                message: message,
                timeout: 2000
            });
        },
        blockUI: function (options) {
            var baseOptions = {
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    },
                    baseZ: 10000
                },
                extendedOptions = $.extend({}, baseOptions, options);

            $.blockUI(extendedOptions);
        }

    },
    ready: function() {
        // GET request
        this.$http.get(apiPath, function (data, status, request) {
            this.$set('companies', data.data);
        }).error(function (data, status, request) {
            // handle error
        });
    }

})

function showModal () {
    $("#responsive").modal({backdrop: true});
}

function hideModal () {
    $("#responsive").modal('hide');
}

$(function(){
    $('.input-group.date').datepicker({
        format:'yyyy-mm-dd'
    });
});
