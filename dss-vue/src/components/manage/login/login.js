var handlerMixin      = require('../../../modules/handler/HandlerMixin.js');
var scriptLoaderMixin = require('../../../modules/loader/ScriptLoaderMixin.js');

module.exports = {
    data: function() {
        return {
            message: '',
            credentials: {
                username: '',
                password: ''
            }
        }
    },
    mixins: [handlerMixin, scriptLoaderMixin],
    compiled: function() {
        if (window.storage.get('token')) {
            var data = {
                cur_page: this.$route.path
            };

            this.setLoginDetails(data);

            this.$route.router.go('/manage/index');
        }
        /*
        this.loadScriptFrom(
            'https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf',
            '#siteseal',
            'verifySeal'
        );
        */
        alert('compiled');
    },
    methods: {
        submitForm: function() {
            // username is a required field
            if (this.credentials.username.trim() == '') {
                alert("Username is Required");
                this.$els.username.focus();

                return false;
            }

            // password is a required field
            if (this.credentials.password.trim() == '') {
                alert("Password is Required");
                this.$els.password.focus();

                return false;
            }

            this.getToken(this.credentials)
                .then(function(response) {
                    var data = response.data;

                    if (data.token) {
                        window.storage.save('token', data.token);
                    }

                    this.getAccountStatus()
                        .then(function(response) {
                            var data = response.data.data;

                            if (data.type.toLowerCase() === 'suspended') {
                                this.message = 'This account has been suspended.';
                            } else {
                                this.$route.router.go('/manage/index');
                            }
                        }, function(response) {
                            this.handleErrors('getAccountStatus', response);
                        });
                }, function(response) {
                    if (response.status == 422) {
                        this.message = 'Wrong username or password';
                    } else {
                        this.handleErrors('getToken', response);
                    }
                });
        },

        getToken: function(data) {
            return this.$http.post(config.API_ROOT + 'auth', data);
        },
        setLoginDetails: function(data) {
            return this.$http.post(config.API_PATH + 'login-details', data);
        },
        getAccountStatus: function() {
            return this.$http.post(config.API_PATH + 'users/check', {}, {
                headers: {
                    Authorization: 'Bearer ' + window.storage.get('token')
                }
            });
        }
    }
}