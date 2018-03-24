function reset_interval(){}

$(document).ready(function(){
    var seconds = 1000,
        minutes = 60*seconds,
        hours = 60*minutes,
        modalWait = 15*minutes,
        logoutWait = 1*hours,
        ticker = 1*seconds - 1,
        lastActivity = currentTime(),
        interval = 0,
        waitingForResponse = false,
        modalWindow = $('#warn_logout'),
        cancelButton = 'a:contains(logged)',
        timerDisplay = $('#logout_time_remaining');

    function currentTime () {
        return (new Date).getTime();
    }

    function formatTime (time) {
        var h = Math.floor(time/hours),
            m = Math.floor((time - h*hours)/minutes),
            s = Math.floor((time - h*hours - m*minutes)/seconds),
            time;

        function plural (n, text) {
            return n + ' ' + (n == 1 ? text : text + 's');
        }

        if (h) {
            time = plural(h, 'hour');

            if (m) {
                time += ', ' + plural(m, 'minute');
            }

            return time;
        }

        if (m) {
            time = plural(m, 'minute');

            if (m < 2 && s) {
                time += ', ' + plural(s, 'second');
            }

            return time;
        }

        return plural(s, 'second');
    }

    $(document).delegate('body', 'keydown mousemove', function(){
        if (modalWindow.is(':visible')) {
            return;
        }

        lastActivity = currentTime();
    });

    modalWindow.delegate(cancelButton, 'click', function(){
        modalWindow.hide();
        lastActivity = currentTime();
    });

    interval = setInterval(function(){
        var now = currentTime(),
            inactiveTime = now - lastActivity,
            timeBeforeModal = modalWait - inactiveTime,
            timeBeforeLogout = logoutWait - inactiveTime;

        timeBeforeModal = timeBeforeModal > 0 ? timeBeforeModal : 0;
        timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0;

        timerDisplay.text(formatTime(timeBeforeLogout));

        if (timeBeforeLogout <= 0) {
            if (waitingForResponse) {
                return;
            }

            waitingForResponse = true;

            $.post('/manage/includes/check_logout.php', function(json){
                var newLast = currentTime() + (json.reset_time || 0) - logoutWait;

                if (json.reset_time) {
                    lastActivity = newLast > lastActivity ? newLast : lastActivity;
                }
                else {
                    clearInterval(interval);
                    window.location = '/manage/logout.php';
                }

                waitingForResponse = false;
            }, 'json');
        }

        if (timeBeforeModal <= 0 && !modalWindow.is(':visible')) {
            modalWindow.show();
        }
    }, ticker);
});
