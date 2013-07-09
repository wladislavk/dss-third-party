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
						  if(r.code == "e0486_user"){
							alert("Error! You have not set a fee for the E0486 Dental Device insurance code in your software, and therefore benefits cannot be verified. Please set your E0486 amount by visiting Admin->Transaction Code and contact Support if you have any questions.\n\nError! You have not entered a valid NPI or TaxID number in your software, and therefore benefits cannot be verified. Please set these by visiting Admin->Profile and contact Support if you have any questions.");
						  }else if(r.code == "user"){
                                                        alert("Error! You have not entered a valid NPI or TaxID number in your software, and therefore benefits cannot be verified. Please set these by visiting Admin->Profile and contact Support if you have any questions.");

						  }else if(r.code == "e0486"){
                                                        alert("Error! You have not set a fee for the E0486 Dental Device insurance code in your software, and therefore benefits cannot be verified. Please set your E0486 amount by visiting Admin->Transaction Code and contact Support if you have any questions.");

						  }
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
