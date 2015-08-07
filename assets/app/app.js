/**
 *
 * Brendan
 * Needs to be refactored...
 *
 */

var apiPath = 'http://apitest.ds3soft.net/api/v1/memo/';

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
        addMemo: function(e) {

            alert('k');
            this.fields.memo_id = 0;
            this.fields.off_date = '';
            this.fields.memoText = '';

        },
        editMemo: function(memo,e) {
            this.fields.off_date = memo.off_date;
            this.fields.memoText = memo.memo;
            this.fields.memo_id  = memo.memo_id;
        },
        saveMemo: function(e) {
            e.preventDefault();
            var off_date = $(".input-group.date").datepicker('getFormattedDate');
            off_date = off_date!=''?off_date:this.fields.off_date;
            postValues = {'memo': this.fields.memoText, 'off_date': off_date, 'last_update': moment().format("YYYY-MM-DD") };
            if(this.fields.memo_id != 0) {
                this.$http.put(apiPath + this.fields.memo_id,postValues,function(data,status,request) {
                    this.$set('memos', data.data);
                    alert('Memo updated.');
                    $('#responsive').modal('hide');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                })
            } else {
                this.$http.post(apiPath,postValues,function(data,status,request) {
                    this.$set('memos', data.data);
                    alert('Memo created.');
                    $('#responsive').modal('hide');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                })
            }
        },
        deleteMemo: function (memo,e) {
            if(confirm('Delete this Memo - Are you sure?'))
            {
                this.$http.delete(apiPath + memo.memo_id, function (data, status, request) {
                    this.$set('memos', data.data);
                    alert('Memo deleted.');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    alert(message);
                })
            }
        }
    },
    ready: function() {
        // GET request
        this.$http.get(apiPath, function (data, status, request) {
            this.$set('memos', data.data);
            console.log(data.data);
        }).error(function (data, status, request) {
            // handle error
        })
    }

})

function showModal()
{
    $("#responsive").modal({backdrop: true});
}

function hideModal()
{
    $("#responsive").modal('hide');
}

$(function(){

    $('.input-group.date').datepicker({
        format:'yyyy-mm-dd'
    }).on("changeDate", function(event) {
       // console.log($(".input-group.date").datepicker('getFormattedDate'));
    });

});