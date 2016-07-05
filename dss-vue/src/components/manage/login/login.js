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
    compiled: function()
    {
        if (window.storage.get('token')) {
            var data = {
                cur_page: this.$route.path
            };

            this.setLoginDetails(data);
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

            this.getToken(this.credentials)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.token) {
                        window.storage.save('token', data.token);
                    }

                    console.log(response);
                }, function(response) {
                    if (true) {
                        // todo this.message = 'Wrong username or password'; if status == 422
                    } else {
                        console.error('getToken [status]: ', response.status);
                    }
                }).then(function(response) {
                    this.getAccountStatus()
                        .then(function(response) {
                            var data = response.data.data;

                            if (data.type.toLowerCase() === 'suspended') {
                                this.message = 'This account has been suspended.';
                            } else {
                                this.$route.router.go('/manage/index');
                            }
                        }, function(response) {
                            console.error('getAccountStatus [status]: ', response.status);
                        });
                });
        },

        getToken: function(data) {
            return this.$http.post(config.API_ROOT + 'auth', data);
        },
        setLoginDetails: function(data) {
            return this.$http.post(config.API_PATH + 'login-details', data);
        },
        getAccountStatus: function() {
            return this.$http.post(config.API_PATH + 'users/check');
        }
    }
}