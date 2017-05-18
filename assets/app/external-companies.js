Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var apiPath = apiRoot + 'api/v1/external-companies/';

var companies = new Vue({
    el: '#company-manager',
    data: {
        fields: {
            id: 0,
            software: '',
            name: '',
            short_name: '',
            api_key: '',
            valid_from: '',
            valid_to: '',
            url: '',
            description: '',
            status: 0,
            reason: ''
        },
        editKey: null,
        companies: {}
    },
    methods: {
        newCompany: function () {
            this.fields.id = 0;
            this.fields.software = '';
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
        editCompany: function (company, $index) {
            this.editKey = $index;

            this.fields.id = company.id;
            this.fields.software = company.software;
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

            if (this.fields.id) {
                this.$http.put(apiPath + this.fields.id, this.fields, function(data, status, request) {
                    this.notifyAction('Company updated.');
                    hideModal();

                    if (this.editKey) {
                        this.$set(['companies[', this.editKey, ']'].join(''), this.fields);
                    }

                    this.editKey = null;

                }).error(function (data, status, request) {
                    try {
                        var message = JSON.parse(data.message);
                        this.$set('errors', message);
                    } catch (e) { /* No error messages */ }
                });
            } else {
                this.editKey = null;

                this.$http.post(apiPath, this.fields, function(data, status, request) {
                    this.notifyAction('Company created.');
                    hideModal();
                    this.onReady();
                }).error(function (data, status, request) {
                    try {
                        var message = JSON.parse(data.message);
                        this.$set('errors', message);
                    } catch (e) { /* No error messages */ }
                });
            }

            $.unblockUI();
        },
        deleteCompany: function (company, e) {
            if (!confirm('Delete this company - Are you sure?')) {
                return;
            }

            this.showBusy('Deleting company please wait...');

            this.$http.delete(apiPath + company.id, function (data, status, request) {
                this.notifyAction('Company deleted.');
                this.onReady();
            }).error(function (data, status, request) {
                try {
                    var message = JSON.parse(data.message);
                    this.notifyAction(message);
                } catch (e) { /* No error messages */ }
            });

            $.unblockUI();
        },
        generateApiKey: function (fields) {
            function guid () {
                function s4 () {
                    return Math.floor((1 + Math.random()) * 0x10000)
                        .toString(16)
                        .substring(1);
                }

                return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                    s4() + '-' + s4() + s4() + s4();
            }
            fields.api_key = guid();
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
        },

        onReady: function() {
            // GET request
            this.$http.get(apiPath, function (data, status, request) {
                this.$set('companies', data.data);
            }).error(function (data, status, request) {
                // handle error
            });
        }
    },
    ready: function() {
        this.onReady();
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
