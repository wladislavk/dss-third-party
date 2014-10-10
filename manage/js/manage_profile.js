$('input[name="use_service_npi"]').click(function(){
  check_service();
});

function check_service()
{
  if($('input[name="use_service_npi"]:checked').val()==1){
    $('.service_info').show();
  }else{
    $('.service_info').hide();
  }
}

function set_num_nine(){
  $('#letter_header').attr("checked", true);
  $('#indent_address').attr("checked", true);
  $('#header_space').attr("checked", true);
}

function set_ls(){
  $('#letter_header').attr("checked", false);
  $('#indent_address').attr("checked", false);
  $('#header_space').attr("checked", false);
}

function set_rls(){
  $('#letter_header').attr("checked", true);
  $('#indent_address').attr("checked", false);
  $('#header_space').attr("checked", false);
}

function check_dups(f)
{
	$.ajax({
        url: "includes/check_dups.php",
        type: "post",
        data: {id: f.userid.value, email: f.email.value, username: f.username.value},
		async: false,
        success: function(data){
			var r = $.parseJSON(data);
			if(r.error){
				if(r.username){
		  			alert('Username already taken. Please choose a new username.');
		  			returnval = false;
				} else if(r.email) {
                  alert('Email already taken. Please choose a new email.');
                  returnval = false;
                }
          	} else {
            	returnval = true;
          	}
        }
    });

    return returnval;
}

function check_profile(f, check_profile_value)
{
    if (check_profile_value) {
	    alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
	    return false;
	}

    if(!mailinglocationabc(f)){
		return false;
    } else {
		return check_dups(f);
    }
}

check_service();