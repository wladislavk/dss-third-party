var memos = new Vue({
    el: '.memoManager',
    data: {
        memo_id     : 0,
        off_date    : '',
        memoText    : ''
    },
    methods: {
        editMemo: function(memo,e) {
            off_date = memo.off_date;
            memoText = memo.memo;
            memo_id  = memo.memo_id;
            console.log(memoText);
        },
        saveMemo: function(e) {
            console.log(e);
        },
        updateMemo: function(e) {

        },
        deleteMemo: function (e) {

        }
    },
    ready: function() {
        // GET request
        this.$http.get('/api/v1/memo', function (data, status, request) {
            this.$set('memos', data.data)
            console.log(data.data);
        }).error(function (data, status, request) {
            // handle error
        })
    }
})
