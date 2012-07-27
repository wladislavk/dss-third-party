lo_timer = '';
timer_length = 3*60*60*1000; //3 hours
function set_interval()
{
lo_timer=setInterval("auto_logout()",timer_length);
}
function reset_interval()
{
clearInterval(lo_timer);
lo_timer=setInterval("auto_logout()",timer_length);
}
function auto_logout()
{
window.location = 'logout.php';
}
