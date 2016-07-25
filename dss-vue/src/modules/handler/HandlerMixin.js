module.exports = {
    methods: {
        handleErrors: function(title, response) {
            // token expired
            if (response.status == 401) {
                window.storage.remove('token');
                this.$route.router.go('/manage/login');
            } else {
                // if dev environment
                if (true) {
                    console.error(title + ' [status]: ', response.status);
                } else {
                    // TODO if prod
                }
            }
        }
    }
}