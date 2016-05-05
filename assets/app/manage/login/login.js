(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var config = require('../../modules/config.js');

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

            /*
             The execution order:

             1. Check if we have not api token (user not logged in) -> getToken.
             2. getSessionValues - get loginId and userId from the session
             3. setLoginDetails
             4. checkUserAuth - check username and password, check user status, set session values, user logining
             5. get user type
             6. set login info
             7. setSessionValues
             8. Redirect to index.php
            */

            if (this.token) {
                // get loginid and userid from the session
                this.getSessionValues({list: ['loginid', 'userid']}, [
                    this.setLoginDetails,
                    {
                        title: this.checkUserAuth,
                        parameter: this.credentials
                    }
                ]);
            } else {
                // get an api token, callback - get loginid and userid from the session
                this.getToken(this.credentials, this.getSessionValues);
            }
        },

        // global methods
        getToken: function(data, callback) {
            this.$http.post(config.API_ROOT + 'auth', data, function(data, status, request) {
                this.token = data.token;

                // set header for JWT Authentification
                this.$http.headers.common['Authorization'] = 'Bearer ' + this.token;

                if (callback && typeof(callback) === "function") {
                    callback(
                        {list: ['loginid', 'userid']}, // parameters for the getSessionValues function
                        // callbacks - the setLoginDetails and the checkUserAuth functions.
                        // the second function also need a parameter - credentials
                        [
                            this.setLoginDetails,
                            {
                                title: this.checkUserAuth,
                                parameter: this.credentials
                            }
                        ]
                    );
                }
            }).error(function (data, status, request) {
                if (status == 422) {
                    this.message = data.status;
                }
            })
        },
        setLoginDetails: function() {
            // if user was not logged in -> set login details
            if (!this.loginid) {
                var currentPageFull = window.location.pathname + window.location.search;
                var data = {
                    loginid: this.sessionValues.loginid || 0,
                    userid: this.sessionValues.userid || 0,
                    cur_page: currentPageFull
                };

                this.$http.post(config.API_PATH + 'login-details', data, function(data, status, request) {
                    console.log('setLoginDetails: ', status, data);
                }).error(function (data, status, request) {
                    console.log('setLoginDetails [Error]: ', status, data);
                });
            }
        },
        checkUserAuth: function(data) {
            // check username and password, check user status, set session values, user logining
            this.$http.post(config.API_PATH + 'users/check', data, function(data, status, request) {
                // if username and password are correct
                data = data.data;

                if (data) {
                    if (data.status == 3) {
                        this.message = 'This account has been suspended.';
                    } else {
                        var dataForSession = {
                            'userid'      : data.userid || 0,
                            'username'    : data.username || 0,
                            'name'        : (data.first_name || '') + ' ' + (data.last_name || ''),
                            'user_access' : data.user_access || 0,
                            'companyid'   : data.companyid || 0,
                            'api_token'   : this.token
                        };

                        if (data.docid > 0) {
                            dataForSession.docid = data.docid;

                            // get user type
                            this.$http.get(config.API_PATH + 'users/' + data.docid + '/type', function(data, status, request) {
                                dataForSession.user_type = data.user_type;
                            }).error(function(data, status, request) {
                                console.log('Get user type [Error]: ', status, data);
                            });
                        } else {
                            dataForSession.docid     = data.userid;
                            dataForSession.user_type = data.user_type;
                        }

                        var loginData = {
                            docid      : dataForSession.docid || 0,
                            userid     : dataForSession.userid || 0,
                            login_date : moment().format("YYYY-MM-DD HH:mm:ss")
                        };

                        // pass loginId to the session - user will be log in
                        this.$http.post(config.API_PATH + 'logins', loginData, function(data, status, request) {
                            // pass login id from successfull request to the session
                            dataForSession.loginid = data.data.loginid;

                            this.setSessionValues(dataForSession);
                        }).error(function(data, status, request) {
                            console.log('Log in [Error]: ', status, data);
                        });

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
        getSessionValues: function(data, callbacks) {
            this.$http.post(config.API_ROOT + 'session/get', data, function(data, status, request) {
                console.log('getSessionValues: ', status, data);

                if (data) {
                    for (var index in data) {
                        this.sessionValues.index = data.index;
                    }
                }

                // check callbacks. It contains: the first callback - the setLoginDetails function
                // the second callback - object (title - checkUserAuth, parameter - credentials)
                callbacks.forEach(function(callback) {
                    if (callback) {
                        if (typeof(callback) === "function") {
                            callback();
                        } else if (typeof(callback) === "object") {
                            if (typeof(callback.title) === "function") {
                                callback.title(callback.parameter);
                            }
                        }
                    }
                });
            }).error(function (data, status, request) {
                console.log('getSessionValues [Error]: ', status, data);
            });
        },
        setSessionValues: function(data) {
            this.$http.post(config.API_ROOT + 'session/set', data, function(data, status, request) {
                console.log('setSessionValues: ', status, data);
            }).error(function (data, status, request) {
                console.log('setSessionValues [Error]: ', status, data);
            });
        }
    }
});
},{"../../modules/config.js":2}],2:[function(require,module,exports){
module.exports = {
    API_ROOT: 'http://api.ds3.loc/',
    get API_PATH () {
        return this.API_ROOT + 'api/v1/';
    }
}
},{}]},{},[1]);
