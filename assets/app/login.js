Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

var login = new Vue({
    el: '#login_container',
    data: {
        message: '',
        credentials: {
            username: '',
            password: ''
        }
    },
    filters: {
        username: function(val) {
            if (val.trim() == '') {
                alert("Username is Required");
                this.$$.username.focus();
            }
        },
        password: function(val) {
            if (val.trim() == '') {
                alert("Password is Required");
                this.$$.password.focus();
            }
        },
    },
    methods: {
        submitForm: function(e) {
            e.preventDefault();

            this.message = this.credentials.username;
        },
        getToken: function(data) {
            this.$http.post(apiRoot + '/auth', data).then(function (response) {
                console.log(response);
            }, function (response) {
                console.log(response);
            });
        }
    }
});