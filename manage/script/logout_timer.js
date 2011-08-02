lo_timer = '';
function set_interval()
{
lo_timer=setInterval("auto_logout()",1800000);
}
function reset_interval()
{
clearInterval(lo_timer);
lo_timer=setInterval("auto_logout()",1800000);
}
function auto_logout()
{
window.location = 'logout.php';

}

