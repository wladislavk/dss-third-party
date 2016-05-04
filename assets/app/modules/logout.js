// TODO: the functions for work with the session should be moved to separate module

module.exports = {
    get data () {
        return {
            sessionValues: {
                loginid: 0
            }
        }
    },
    excute: function() {
        /*
         The execution order:

         1. getSessionValues - get the loginid from the session
         2. setLogoutDate
         3. flushSession - remove all data from the session
         4. Redirect to login.php
        */

        this.getSessionValues(
            {list: ['loginid']},
            [
                {
                    title: this.setLogoutDate,
                    parameter: this.flushSession
                }
            ]
        );
    },
    setLogoutDate: function(callback) {
        var data = {
            logout_date: moment().format("YYYY-MM-DD HH:mm:ss")
        };

        Vue.http.put(config.API_PATH + 'logins/' + this.data.sessionValues.loginid, data, function(data, status, request) {
            callback();

            swal('Logout Successfully!', 'success');
            window.location.href = 'login.php';
        }).error(function(data, status, request) {
            console.log('setLogoutDate [Error]: ', status, data);
        });
    },
    getSessionValues: function(data, callbacks) {
        Vue.http.post(config.API_ROOT + 'session/get', data, function(data, status, request) {
            console.log('getSessionValues: ', status, data);

            if (data) {
                for (var index in data) {
                    this.data.sessionValues.index = data.index;
                }
            }

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
    flushSession: function() {
        Vue.http.get(config.API_ROOT + 'session/flush', function(data, status, request) {
            console.log('flushSession: ', status, data);
        }).error(function(data, status, request) {
            console.log('flushSession [Error]: ', status, data);
        });
    }
}