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
    compiled: function() {
        if (this.token) {
            this.$http.headers.common['Authorization'] = 'Bearer ' + this.token;

            this.setLoginDetails();
        }
    },
    methods: {
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

            this.getToken(this.credentials, this.getAccountStatus);
        },

        getToken: function(data, callback) {
            this.$http.post(config.API_ROOT + 'auth', data, function(data, status, request) {
                this.token = data.token;

                this.$http.headers.common['Authorization'] = 'Bearer ' + this.token;

                if (callback && typeof(callback) === "function") {
                    callback();
                }
            }).error(function (data, status, request) {
                if (status == 422) {
                    this.message = 'Wrong username or password';
                }
            })
        },
        setLoginDetails: function() {
            var data = {
                cur_page: window.location.pathname + window.location.search
            };

            this.$http.post(config.API_PATH + 'login-details', data, function(data, status, request) {
                console.log('setLoginDetails: ', status, data);
            }).error(function (data, status, request) {
                console.log('setLoginDetails [Error]: ', status, data);
            });
        },
        getAccountStatus: function() {
            this.$http.post(config.API_PATH + 'users/check', function(data, status, request) {
                data = data.data;

                if (data.type.toLowerCase() === 'suspended') {
                    this.message = 'This account has been suspended.';
                } else {
                    window.location.href = 'index.php';
                }
            }).error(function(data, status, request) {
                console.log('checkUserAuth [Error]: ', status, data);
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
