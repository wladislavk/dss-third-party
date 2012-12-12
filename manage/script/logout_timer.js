lo_timer = '';
w_timer = '';
timer_length = 60*60*1000;
w_timer_length = 15*60*1000; 
startTimeMS = 0;
function set_interval()
{
startTimeMS = (new Date()).getTime();
lo_timer=setInterval("auto_logout()",timer_length);
w_timer=setInterval("warn_logout()",w_timer_length);
}

function update_logout_timer(){
  t = timer_length - ( (new Date()).getTime() - startTimeMS );
  m = Math.floor(t/60000);
  $('#logout_time_remaining').text(m+" minutes");
}

setInterval("update_logout_timer()", 30000);

function reset_interval()
{
clearInterval(lo_timer);
clearInterval(w_timer);
lo_timer=setInterval("auto_logout()",timer_length);
w_timer=setInterval("warn_logout()",w_timer_length);
$('#warn_logout').hide();
}

function warn_logout(){
  $('#warn_logout').show();
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

