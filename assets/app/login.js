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
        }
    },
    methods: {
        // global method
        submitForm: function(e) {
            e.preventDefault();

            // username is a required field
            if (this.credentials.username.trim() == '') {
                alert("Username is Required");
                this.$$.username.focus();

                return false;
            }

            // password is a required field
            if (this.credentials.password.trim() == '') {
                alert("Password is Required");
                this.$$.password.focus();

                return false;
            }

            // get an api token
            this.getToken(this.credentials);

            // get loginId from the session
            this.getSessionValues({list: ['loginid']});

            // if user was not logged in set login details
            if (!this.loginId) {
                this.setLoginDetails();
            }

            // check username and password, check user status, set session values, user logining
            this.checkUserAuth(this.credentials);
        },

        // parts of full logic (global method)
        getToken: function(data, callback, callbackData) {
            this.$http.post(apiRoot + 'auth', data, function(data, status, request) {
                this.token = data.token;

                // set header for JWT Authentification
                this.$http.headers.common['Authorization'] = 'Bearer ' + this.token;

                if (callback && typeof(callback) === "function") {
                    if (callbackData) {
                        callback(callbackData);
                    } else {
                        callback();
                    }
                }
            }).error(function (data, status, request) {
                if (status == 422) {
                    this.message = data.status;
                }
            })
        },
        setLoginDetails: function() {
            var currentPageFull = window.location.pathname + window.location.search;
            var data = {
                loginid: this.sessionValues.loginid || 0,
                userid: this.sessionValues.userid || 0,
                cur_page: currentPageFull
            };

            this.$http.post(apiRoot + 'api/v1/login-details', data, function(data, status, request) {
                console.log('setLoginDetails: ', status, data);
            }).error(function (data, status, request) {
                console.log('setLoginDetails [Error]: ', status, data);
            });
        },
        checkUserAuth: function(data) {
            this.$http.post(apiRoot + 'api/v1/users/check', data, function(data, status, request) {
                // if username and password are correct
                if (data) {
                    if (data.status == 3) {
                        this.message = 'This account has been suspended.';
                    } else {
                        var dataForSession = {
                            'userid'      : data.userid || 0,
                            'username'    : data.username || 0,
                            'name'        : data.first_name + ' ' + data.last_name,
                            'user_access' : data.user_access || 0,
                            'companyid'   : data.companyid || 0,
                            'api_token'   : this.token
                        };

                        if (data.docid != 0) {
                            dataForSession.docid = data.docid;

                            // get user type
                            this.$http.post(apiRoot + 'api/v1/users/' + data.docid + '/type', function(data, status, request) {
                                dataForSession.user_type = data.user_type;
                            }).error(function(data, status, request) {
                                console.log('Get user type [Error]: ', status, data);
                            });
                        } else {
                            dataForSession.docid     = data.userid;
                            dataForSession.user_type = data.user_type;
                        }

                        var loginData = {
                            docid  : dataForSession.docid,
                            userid : dataForSession.userid
                        };

                        // pass loginId to the session - user will be log in
                        this.$http.post(apiRoot + 'api/v1/logins', loginData, function(data, status, request) {
                            // pass login id from successfull request to the session
                            dataForSession.loginid = data.data.loginid;
                        }).error(function(data, status, request) {
                            console.log('Log in [Error]: ', status, data);
                        });

                        this.setSessionValues(dataForSession);

                        // redirect to FO dashboard
                        window.location.href = 'index.php';
                    }
                } else {
                    this.message = 'Wrong username or password';
                }
            }).error(function(data, status, request) {
                console.log('checkUserAuth [Error]: ', status, data);
            });
        },

        // helpers for work with the session
        getSessionValues: function(data) {
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
        setSessionValues: function(data) {
            this.$http.post(apiRoot + 'session/set', data, function(data, status, request) {
                console.log('setSessionValues: ', status, data);
            }).error(function (data, status, request) {
                console.log('setSessionValues [Error]: ', status, data);
            });
        }
    }
});