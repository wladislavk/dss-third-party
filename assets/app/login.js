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

            this.getToken(this.credentials, this.setSessionValues, {'pi': 3.14, 'e': 2.71});

            // this.getSessionValues({list: ['pi', 'e']});
        },
        getToken: function(data, callback, callbackData) {
            this.$http.post(apiRoot + 'auth', data, function(data, status, request) {
                if (status == 200) {
                    this.token = data.token;

                    // set header for JWT Authentification
                    // this.$http.headers.common['Authorization'] = 'Bearer ' + this.token;

                    if (callback && typeof(callback) === "function") {
                        if (callbackData) {
                            callback(callbackData);
                        } else {
                            callback();
                        }
                    }
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
                loginid: this.sessionValues.loginId || 0,
                userid: this.sessionValues.userId || 0,
                cur_page: currentPageFull
            };

            this.$http.post(apiRoot + 'api/v1/login-details', data, function(data, status, request) {
                console.log('setLoginDetails: ', status, data);
            }).error(function (data, status, request) {
                console.log('setLoginDetails [Error]: ', status, data);
            });
        },
        getSessionValues: function(data)
        {
            this.$http.post(apiRoot + 'session/get', data, function(data, status, request) {
                console.log('getSessionValues: ', status, data);

                if (data) {
                    for (var index in data) {
                        this.sessionValues.index = data.index;
                    }
                }
            }).error(function (data, status, request) {
                console.log('getSessionValues [Error]: ', status, data);
            });
        },
        setSessionValues: function(data)
        {
            this.$http.post(apiRoot + 'session/set', data, function(data, status, request) {
                console.log('setSessionValues: ', status, data);
            }).error(function (data, status, request) {
                console.log('setSessionValues [Error]: ', status, data);
            });
        }
    }
});