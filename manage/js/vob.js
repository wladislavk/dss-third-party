$(document).ready(function(){
  $('.vob_request').click( function(){
    pid = $(this).attr('data-pid');
    ut = $(this).attr('data-ut');
    if(ut=='2'){
      if(!confirm('A Verification of Benefits request will be submitted.  Upon completion of the VOB, you will be charged and invoiced.  Continue?')){
	  return false;
	}
    }
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

/*
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
*/

});
