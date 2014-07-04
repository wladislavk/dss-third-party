$(document).ready(function(){
    var seconds = 1000,
    minutes = 60*seconds,
    hours = 60*minutes,
    modalWait = 15*minutes,
    logoutWait = 3*hours,
    ticker = 1*seconds,
    lastActivity = currentTime(),
    interval = 0
    waitingForResponse = false;
    
    function currentTime () {
        return (new Date).getTime();
    }
    
    function formatTime (time) {
        var h = Math.floor(time/hours),
        m = Math.floor((time - h*hours)/minutes),
        s = Math.floor((time - h*hours - m*minutes)/seconds);
        
        function plural (n, text) {
            return n + ' ' + (n == 1 ? text : text + 's');
        }
        
        if (h) {
            return plural(h,'hour');
        }
        
        if (m) {
            return plural(m,'minute');
        }
        
        return plural(s,'second');
    }
    
    $(document).on('keydown mousemove',function(){
        lastActivity = currentTime();
    });
    
    $('#go-to-sleep').on('hide.bs.modal',function(){
        lastActivity = currentTime();
    });
    
    interval = setInterval(function(){
        var now = currentTime(),
        inactiveTime = now - lastActivity,
        timeBeforeModal = modalWait - inactiveTime,
        timeBeforeLogout = logoutWait - inactiveTime;
        
        timeBeforeModal = timeBeforeModal > 0 ? timeBeforeModal : 0;
        timeBeforeLogout = timeBeforeLogout > 0 ? timeBeforeLogout : 0;
        
        $('#sleep-time').text(formatTime(timeBeforeLogout));
        
        if (timeBeforeLogout <= 0) {
            if (waitingForResponse) {
                return;
            }
            
            waitingForResponse = true;
            
            $.post('/manage/admin/includes/check_logout.php',function(json){
                var newLast = currentTime() + (json.reset_time || 0) - logoutWait;
                
                if (json.reset_time) {
                    lastActivity = newLast > lastActivity ? newLast : lastActivity;
                }
                else {
                    clearInterval(interval);
                    window.location = '/manage/admin/logout.php';
                }
                
                waitingForResponse = false;
            },'json');
        }
        
        if (timeBeforeModal <= 0) {
            $('#go-to-sleep').modal('show');
        }
    },ticker);
});
