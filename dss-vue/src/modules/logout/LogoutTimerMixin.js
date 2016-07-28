module.exports = {
    data: function() {
        return {
            lastActivity       : this.currentTime(),
            modalWindow        : null,
            seconds            : 1000,
            minutes            : 0,
            hours              : 0,
            modalWait          : 0,
            logoutWait         : 0,
            ticker             : 0,
            interval           : 0,
            waitingForResponse : false,
            timerDisplay       : null
        }
    },
    created: function() {
        window.addEventListener('keydown', this.catchUserMoving);
        window.addEventListener('mousemove', this.catchUserMoving);

        this.minutes    = 60 * this.seconds;
        this.hours      = 60 * this.minutes;
        this.modalWait  = 15 * this.minutes;
        this.logoutWait = 1 * this.hours;
        this.ticker     = 1 * this.seconds - 1;
    },
    ready: function() {
        this.modalWindow  = $(this.$els.warningLogout);
        this.timerDisplay = $(this.$els.logoutTimer);
    },
    beforeDestroy: function() {
        window.removeEventListener('keydown', this.catchUserMoving);
        window.removeEventListener('mousemove', this.catchUserMoving);
    },
    methods: {
        setLogoutTimer: function() {
            this.interval = setInterval(this.displayTimer, this.ticker);
        },
        resetInterval: function() {
            this.modalWindow.hide();
            this.lastActivity = this.currentTime();
        },
        catchUserMoving: function() {
            if (this.modalWindow.is(':visible')) {
                return;
            }

            this.lastActivity = this.currentTime();
        },
        displayTimer: function() {
            var now              = this.currentTime(),
                inactiveTime     = now - this.lastActivity,
                timeBeforeModal  = this.modalWait - inactiveTime,
                timeBeforeLogout = this.logoutWait - inactiveTime;

            timeBeforeModal  = timeBeforeModal > 0 ? timeBeforeModal : 0;
            timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0;

            this.timerDisplay.text(this.formatTime(timeBeforeLogout));

            if (timeBeforeLogout <= 0) {
                if (this.waitingForResponse) {
                    return;
                }

                this.waitingForResponse = true;

                this.checkLogout()
                    .then(function(response) {
                        var data = response.data;

                        var newLast = this.currentTime() + (data.resetTime || 0) - this.logoutWait;

                        if (data.resetTime) {
                            this.lastActivity = newLast > this.lastActivity ? newLast : this.lastActivity;
                        } else {
                            clearInterval(this.interval);
                            this.logout();
                        }

                        this.waitingForResponse = false;
                    }, function(response) {
                        this.handleErrors('checkLogout', response);
                    });
            }

            if (timeBeforeModal <= 0 && !this.modalWindow.is(':visible')) {
                this.modalWindow.show();
            }
        },
        currentTime: function() {
            return (new Date).getTime();
        },
        formatTime: function(time) {
            var h = Math.floor(time / this.hours),
                m = Math.floor((time - h * this.hours) / this.minutes),
                s = Math.floor((time - h * this.hours - m * this.minutes) / this.seconds),
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