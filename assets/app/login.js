Vue.http.options.emulateJSON = true;

var login = new Vue({
    el: '#login_container',
    data: {
        message: '',
        token: '',
        credentials: {
            username: '',
            password: ''
        },
        sessionValues: {
            loginId: '',
            userId: ''
        }
    },
    methods: {
        submitForm: function(e) {
            e.preventDefault();

            if (this.credentials.username.trim() == '') {
                alert("Username is Required");
                this.$$.username.focus();

                return false;
            }

            if (this.credentials.password.trim() == '') {
                alert("Password is Required");
                this.$$.password.focus();

                return false;
            }

            var data = {
                username: this.credentials.username,
                password: this.credentials.password
            };

            this.getToken(this.credentials);
        },
        getToken: function(data) {
            this.$http.post(apiRoot + 'auth', data, function(data, status, request) {
                if (status == 200) {
                   this.token = data.token;

                   this.http.headers.common['Authorization'] = 'Bearer ' + this.token;
                }
            }).error(function (data, status, request) {
                if (status == 422) {
                    this.message = data.status;
                }
            })
        },
        setLoginDetails: function()
        {
            var currentPageFull = window.location.pathname + window.location.search;
            var data = {
                loginid: this.sessionValues.loginId,
                userid: this.sessionValues.userId,
                cur_page: currentPageFull
            };

            this.$http.post(apiRoot + 'api/v1/login-details', data, function(data, status, request) {
                console.log('setLoginDetails: ', status, data);
            }).error(function (data, status, request) {
                console.log('setLoginDetails [Error]: ', status, data);
            });
        },
        getSessionValues: function()
        {
            this.$http.post(apiRoot + '', data, function(data, status, request) {
                console.log('getSessionValues: ', status, data);
            }).error(function (data, status, request) {
                console.log('getSessionValues [Error]: ', status, data);
            });
        },
        setSessionValues: function()
        {
            this.$http.post(apiRoot + '', data, function(data, status, request) {
                console.log('setSessionValues: ', status, data);
            }).error(function (data, status, request) {
                console.log('setSessionValues [Error]: ', status, data);
            });
        }
    }
});