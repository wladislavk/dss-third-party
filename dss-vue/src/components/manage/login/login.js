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

            this.$route.router.go('/manage/index');
        }
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
                            console.error('getAccountStatus [status]: ', response.status);
                        });
                }, function(response) {
                    if (response.status == 422) {
                        this.message = 'Wrong username or password';
                    } else {
                        console.error('getToken [status]: ', response.status);
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