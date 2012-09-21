lo_timer = '';
timer_length = 60*60*1000;
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
                                    $.ajax({
                                        url: "includes/check_logout.php",
                                        type: "post",
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.reset_time){
							lo_timer=setInterval("auto_logout()",r.reset_time);
                                                }else{
							window.location = 'logout.php';
                                                }
                                        },
                                        failure: function(data){
                                               window.location = 'logout.php';
                                        }
                                  });
}

