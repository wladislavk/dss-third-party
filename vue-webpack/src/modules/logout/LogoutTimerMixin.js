module.exports = {
  data () {
    return {
      lastActivity: this.currentTime(),
      modalWindow: null,
      seconds: 1000,
      minutes: 0,
      hours: 0,
      modalWait: 0,
      logoutWait: 0,
      ticker: 0,
      interval: 0,
      waitingForResponse: false,
      timerDisplay: null
    }
  },
  created () {
    window.addEventListener('keydown', this.catchUserMoving)
    window.addEventListener('mousemove', this.catchUserMoving)

    this.minutes = 60 * this.seconds
    this.hours = 60 * this.minutes
    this.modalWait = 15 * this.minutes
    this.logoutWait = 1 * this.hours
    this.ticker = 1 * this.seconds - 1
  },
  mounted () {
    this.modalWindow = window.$(this.$refs.warningLogout)
    this.timerDisplay = window.$(this.$refs.logoutTimer)
  },
  beforeDestroy () {
    window.removeEventListener('keydown', this.catchUserMoving)
    window.removeEventListener('mousemove', this.catchUserMoving)
  },
  methods: {
    setLogoutTimer () {
      this.interval = setInterval(this.displayTimer, this.ticker)
    },
    resetInterval () {
      this.modalWindow.hide()
      this.lastActivity = this.currentTime()
    },
    catchUserMoving () {
      if (this.modalWindow.is(':visible')) {
        return
      }

      this.lastActivity = this.currentTime()
    },
    displayTimer () {
      var now = this.currentTime()
      var inactiveTime = now - this.lastActivity
      var timeBeforeModal = this.modalWait - inactiveTime
      var timeBeforeLogout = this.logoutWait - inactiveTime

      timeBeforeModal = timeBeforeModal > 0 ? timeBeforeModal : 0
      timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0

      this.timerDisplay.text(this.formatTime(timeBeforeLogout))

      if (timeBeforeLogout <= 0) {
        if (this.waitingForResponse) {
          return
        }

        this.waitingForResponse = true

        this.checkLogout()
          .then(function (response) {
            var data = response.data

            var newLast = this.currentTime() + (data.resetTime || 0) - this.logoutWait

            if (data.resetTime) {
              this.lastActivity = newLast > this.lastActivity ? newLast : this.lastActivity
            } else {
              clearInterval(this.interval)
              this.logout()
            }

            this.waitingForResponse = false
          }, function (response) {
            this.handleErrors('checkLogout', response)
          })
      }

      if (timeBeforeModal <= 0 && !this.modalWindow.is(':visible')) {
        this.modalWindow.show()
      }
    },
    currentTime () {
      return (new Date()).getTime()
    },
    formatTime (time) {
      var h = Math.floor(time / this.hours)
      var m = Math.floor((time - h * this.hours) / this.minutes)
      var s = Math.floor((time - h * this.hours - m * this.minutes) / this.seconds)

      if (h) {
        time = this.plural(h, 'hour')

        if (m) {
          time += ', ' + this.plural(m, 'minute')
        }

        return time
      }

      if (m) {
        time = this.plural(m, 'minute')

        if (m < 2 && s) {
          time += ', ' + this.plural(s, 'second')
        }

        return time
      }

      return this.plural(s, 'second')
    },
    plural (n, text) {
      return n + ' ' + (n === 1 ? text : text + 's')
    },
    checkLogout () {
      return this.$http.post(process.env.API_PATH + 'users/check-logout')
    }
  }
}
