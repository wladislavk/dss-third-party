module.exports = {
    methods: {
        logout: function() {
            this.invalidateToken()
                .then(function(response) {
                    alert('Logout Successfully!');

                    window.storage.remove('token');
                    this.$route.router.go('/manage/login');
                }, function(response) {
                    console.error('invalidateToken [Error]: ', status, data);
                });
        },
        invalidateToken: function() {
            return this.$http.post(window.config.API_PATH + 'logout');
        }
    }
}