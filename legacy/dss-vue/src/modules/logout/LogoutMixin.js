module.exports = {
    methods: {
        logout: function() {
            this.invalidateToken()
                .then(function(response) {
                    var vm = this;

                    swal({
                        title : '',
                        text  : 'Logout Successfully!',
                        type  : 'success'
                    }, function() {
                        window.storage.remove('token');
                        vm.$route.router.go('/manage/login');
                    });
                }, function(response) {
                    console.error('invalidateToken [status]: ', response.status);
                });
        },
        invalidateToken: function() {
            return this.$http.post(window.config.API_PATH + 'logout');
        }
    }
}