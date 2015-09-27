/**
 *
 * Very rudimentary Proof of Concept. Most of this code should and could be refactored...
 * Brendan
 *
 */


var memos = new Vue({

    el: '.memoManager',
    data: {
        fields: {
            memo_id: 0,
            off_date: '',
            memoText: ''
        },
        postValues: []
    },
    methods: {
        addMemo: function(e) {
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
            postValues = {'memo': this.fields.memoText, 'off_date': this.fields.off_date, 'last_update': moment().format("YYYY-MM-DD") };
            if(this.fields.memo_id != 0) {
                this.$http.put('/api/v1/memo/' + this.fields.memo_id,postValues,function(data,status,request) {
                    this.$set('memos', data.data);
                    alert('Memo updated.')
                    $('#responsive').modal('hide');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                    console.log(message);
                })
            } else {
                this.$http.post('/api/v1/memo',postValues,function(data,status,request) {
                    this.$set('memos', data.data);
                    alert('Memo created.')
                    $('#responsive').modal('hide');
                }).error(function (data, status, request) {
                    var message = JSON.parse(data.message);
                    this.$set('errors', message);
                    console.log(message);
                })
            }
        },
        deleteMemo: function (e) {

        }
    },
    ready: function() {
        // GET request
        this.$http.get('/api/v1/memo', function (data, status, request) {
            this.$set('memos', data.data);
        }).error(function (data, status, request) {
            // handle error
        })
    }

})
