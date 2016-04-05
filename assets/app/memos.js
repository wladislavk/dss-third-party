/**
 *
 * Brendan
 * Needs to be refactored...
 *
 */
Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var apiPath = apiRoot + 'api/v1/memo/';

var memos = new Vue({
    el: '#memoManager',
    data: {
        fields: {
            memo_id: 0,
            off_date: '',
            memoText: ''
        }
    },
    methods: {
        newMemo: function () {
            this.fields.memo_id = 0;
            this.fields.off_date = '';
            this.fields.memoText = '';

            showModal();
        },
        editMemo: function (memo, e) {
            this.fields.off_date = memo.off_date;
            this.fields.memoText = memo.memo;
            this.fields.memo_id  = memo.memo_id;

            showModal();
        },
        saveMemo: function (e) {
            e.preventDefault();
            this.showBusy('Saving Memo please wait...');

            var off_date = $(".input-group.date").datepicker('getFormattedDate');
            off_date = off_date != '' ? off_date : this.fields.off_date;

            postValues = {
                memo: this.fields.memoText,
                off_date: off_date,
                last_update: moment().format("YYYY-MM-DD")
            };

            if (this.fields.memo_id != 0) {
                this.$http.put(apiPath + this.fields.memo_id, postValues, function(data, status, request) {
                    this.$set('memos', data.data);
                    this.notifyAction('Memo updated.');
                    hideModal();
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                });
            } else {
                this.$http.post(apiPath,postValues,function(data, status, request) {
                    this.$set('memos', data.data);
                    this.notifyAction('Memo created.');
                    hideModal();
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                });
            }

            $.unblockUI();
        },
        deleteMemo: function (memo, e) {
            if (confirm('Delete this Memo - Are you sure?')) {
                this.showBusy('Deleting Memo please wait...');

                this.$http.delete(apiPath + memo.memo_id, function (data, status, request) {
                    this.$set('memos', data.data);
                    this.notifyAction('Memo deleted.');
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
            this.$set('memos', data.data);
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
