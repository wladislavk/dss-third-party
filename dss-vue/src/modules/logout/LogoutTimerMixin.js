module.exports = {
    data: function() {
        return {
            lastActivity: this.currentTime(),
        }
    },
    methods: {
        setLogoutTimer: function() {
            var seconds            = 1000,
                minutes            = 60 * seconds,
                hours              = 60 * minutes,
                modalWait          = 15 * minutes,
                logoutWait         = 1 * hours,
                ticker             = 1 * seconds - 1,
                interval           = 0,
                waitingForResponse = false,
                modalWindow        = $('#warn_logout'),
                cancelButton       = 'a:contains(logged)',
                timerDisplay       = $('#logout_time_remaining');

            $(document).delegate('body', 'keydown mousemove', function(){
                if (modalWindow.is(':visible')) {
                    return;
                }

                console.log(this.lastActivity);

                this.lastActivity = this.currentTime();
            });

            modalWindow.delegate(cancelButton, 'click', function(){
                modalWindow.hide();

                this.lastActivity = this.currentTime();
            });

            interval = setInterval(function(){
                var now              = this.currentTime(),
                    inactiveTime     = now - this.lastActivity,
                    timeBeforeModal  = modalWait - inactiveTime,
                    timeBeforeLogout = logoutWait - inactiveTime;

                timeBeforeModal  = timeBeforeModal > 0 ? timeBeforeModal : 0;
                timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0;

                timerDisplay.text(this.formatTime(timeBeforeLogout));

                if (timeBeforeLogout <= 0) {
                    if (waitingForResponse) {
                        return;
                    }

                    waitingForResponse = true;

                    this.checkLogout()
                        .then(function(response) {
                            var data = response.data;

                            var newLast = this.currentTime() + (data.resetTime || 0) - logoutWait;

                            if (data.resetTime) {
                                this.lastActivity = newLast > this.lastActivity ? newLast : this.lastActivity;
                            } else {
                                clearInterval(interval);
                                this.logout();
                            }

                            waitingForResponse = false;
                        }, function(response) {
                            this.handleErrors('checkLogout', response);
                        });
                }

                if (timeBeforeModal <= 0 && !modalWindow.is(':visible')) {
                    modalWindow.show();
                }
            }, ticker);
        },
        resetInterval: function() {
            this.lastActivity = this.currentTime();
        },
        currentTime: function() {
            return (new Date).getTime();
        },
        formatTime: function(time) {
            var h = Math.floor(time / hours),
                m = Math.floor((time - h * hours) / minutes),
                s = Math.floor((time - h * hours - m * minutes) / seconds),
                time;

                if (h) {
                    time = this.plural(h, 'hour');

                    if (m) {
                        time += ', ' + this.plural(m, 'minute');
                    }

                    return time;
                }

                if (m) {
                    time = this.plural(m, 'minute');

                    if (m < 2 && s) {
                        time += ', ' + this.plural(s, 'second');
                    }

                    return time;
                }

                return this.plural(s, 'second');
        },
        plural: function(n, text) {
            return n + ' ' + (n == 1 ? text : text + 's');
        },
        checkLogout: function() {
            return this.$http.post(window.config.API_PATH + 'users/check-logout');
        }
    }
}