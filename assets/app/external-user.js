Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var userId = $('[name=ed]').val();
var apiPath = apiRoot + 'api/v1/external-user/';

var user = new Vue({
    el: '#add-user-form',
    data: {
        fields: {
            id: 0,
            user_id: userId,
            api_key: '',
            valid_from: '',
            valid_to: ''
        },
        enabled: null
    },
    methods: {
        saveUser: function (e) {
            e.preventDefault();

            if (typeof userabc_warn !== 'undefined' && !userabc_warn(this.$el)) {
                return;
            }

            var method = this.fields.id ? 'put' : 'post';
            var id = this.fields.id ? userId : '';

            this.$http[method](apiPath + id, this.fields, function() {
                this.$el.submit();
            }).error(function () {
                this.$el.submit();
            });
        },
        deleteUser: function (e) {
            e.preventDefault();

            if (!confirm('Do Your Really want to Delete?.')) {
                return;
            }

            this.$http.delete(apiPath + userId, function () {
                this.enabled = false;

                if (e.target && e.target.href) {
                    window.location = e.target.href;
                }
            }).error(function () {
                if (e.target && e.target.href) {
                    window.location = e.target.href;
                }
            });
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
        onReady: function() {
            this.enabled = this.id && this.fields.user_id;

            this.$http.get(apiPath + userId, function (data) {
                this.$set('fields', data.data);
                this.enabled = this.id && this.fields.user_id;
            });
        }
    },
    ready: function() {
        this.onReady();
    }
});

$(function(){
    $('.input-group.date').datepicker({
        format:'yyyy-mm-dd'
    });
});
