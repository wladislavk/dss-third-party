module.exports = {
    excute: function() {
        this.logout();
    },
    logout: function() {
        Vue.http.post(config.API_PATH + 'logout', function(data, status, request) {
            swal('Logout Successfully!', 'success');

            window.location.href = 'login.php';
        }).error(function(data, status, request) {
            console.log('setLogoutDate [Error]: ', status, data);
        });
    }
}