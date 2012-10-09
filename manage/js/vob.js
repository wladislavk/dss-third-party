$(document).ready(function(){
  $('.vob_request').click( function(){
    pid = $(this).attr('data-pid');
                                    $.ajax({
                                        url: "includes/vob_request_preauth.php",
                                        type: "post",
                                        data: {pid: pid},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
							alert('VOB submitted');
							window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                alert('fail');
                                        }
                                  });

  });


  $('#rx_item').click( function(){
    $('#rx_file').click();
  });

  $('#rx_file').change( function(){
    $('#rx_form').submit(); 
  });

  $('#lomn_item').click( function(){
    $('#lomn_file').click();
  });

  $('#lomn_file').change( function(){
    $('#lomn_form').submit();
  });


});
