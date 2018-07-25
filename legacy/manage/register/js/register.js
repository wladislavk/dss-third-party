//step-by-step wizard

 $.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg != value;
 }, "Value must not equal arg.");

 $.validator.addMethod("valueEquals", function(value, element, arg){
  var arg = $('#password').val();
  return arg == value;
 }, "Value must equal arg.");

 $.validator.addMethod("valueLength", function(value, element, arg){
  return parseInt(value.length, 10) >= parseInt(arg, 10);
 }, "Value must equal arg.");

 $.validator.addMethod("einOrSsn", function(value, element, arg){
  if(value != ''){
    ein = $('#ein').is(':checked');
    ssn = $('#ssn').is(':checked');
    if(!ssn && !ein ){
	return false;
    }
  }
  return true;
  
 }, "Please also select EIN or SSN");

lga_wizard = {
	init: function(){
		//wizard form submit
		$('#register_form').submit(function() {
			return false;
		});

		//set page width for steps
		pageW = $('#status').outerWidth();
		$('.page').css('width',pageW - 10);
		
		//initialize wizard
		var root = $("#register").fancyscrollable();
		var api = root.fancyscrollable();

		function next_sect(){

		  api.next();

		}
		                // adjust height after items have been scrolled
                api.onSeek(function(event, i) {
                          var page = root.find(".page").eq(api.getIndex());
                          $("#register").animate({ height : (page.height()+170) }, 300);
			  $("#main_section").animate({ height : (page.height()+250) }, 300);
			if(api.getIndex()==5){
			  //disable_registration();
			}
                });
		
                
                // adjust height after initialization
                var page = root.find(".page").eq(api.getIndex());
                $("#register").animate({ height : page.height() }, 300);

		api.onBeforeSeek(function(event, i) {
			if (api.getIndex() < i) {
				var page = root.find(".page").eq(api.getIndex());
				notValid = false;
				//class="validate" needs to be added to elements that needs to be validated
				page.find('.validate').each(function(){
					//assign validator to single element
					validator = $("#register_form").validate({
						highlight: function(element) {
							$(element).closest('div').addClass("error");
						},
						unhighlight: function(element) {
							$(element).closest('div').removeClass("error");
						},
                        rules: {
                            first_name: "required",
			    last_name: "required",
                            email: {
                                required: true,
                                email: true,
				remote: {
        				url: "includes/check_email.php",
        				type: "post",
					async: false,
        				data: {
          					email: function() {
            						return $("#email").val();
          					},
	  					id:  function() {
	    						return $("#userid").val();
	  					}
        				}
				}
                            },
                            phone: {
                                required: true
                            },
			    practice: "required",
                            address: "required",
			    city: "required",
			    state: "required",
                            zip: "required",
			    tax_id_or_ssn: {
				einOrSsn: true,
			    },
			    username: {
                                required: true,
				valueLength: "5",
                                remote: {
                                        url: "includes/check_username.php",
                                        type: "post",
                                        async: false,
                                        data: {
                                                email: function() {
                                                        return $("#username").val();
                                                },
                                                id:  function() {
                                                        return $("#userid").val();
                                                }
                                        }
                                }
                            },
			    password: {
				required: true,
                                valueLength: "8",
			    },
			    confirm_password: { 
				required: true,
				valueEquals: $("#password").val()
			    },
			    mailing_name: "required",
                            mailing_practice: "required",
			    mailing_phone: "required",
                            mailing_address: "required",
                            mailing_city: "required",
                            mailing_state: "required",
                            mailing_zip: "required"
                        },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
                        messages: {
                            first_name: "This field is required",
                            last_name: "This field is required",
			    email: {
				required: "This field is required",			
				remote: "Error: The email address you have entered is either invalid or already in use. Please enter a different email address.",
				email: "The field requires a valid email address"
				},
                            phone: "This field is required",
			    practice: "This field is required",
			    address: "This field is required",
                            city: "This field is required",
                            state: "This field is required",
                            zip: "This field is required",
			    tax_id_or_ssn: {
				einOrSsn: "Please also select EIN or SSN in next question"
			    },
			    username: {
                                required: "This field is required",
				valueLength: "Username must be at least 5 characters",
                                remote: "Error: The username you have entered is either invalid or already in use. Please enter a different username."
                                },
                            password: {
				required: "This field is required",
                                valueLength: "Password must be at least 8 characters"
			    	},
                            confirm_password: { 
				required: "This field is required",
				valueEquals: 'Must match password' 
				},
                            mailing_name: "This field is required",
                            mailing_practice: "This field is required",
			    mailing_phone: "This field is required",
                            mailing_address: "This field is required",
                            mailing_city: "This field is required",
                            mailing_state: "This field is required",
                            mailing_zip: "This field is required"
                        }
					}).element($(this));
				
					if(validator == false){	notValid = true	}
			})

				if(!notValid){
					if(api.getIndex()==3){
					  if($('#npi').val()=='' ||
						$('#medicare_npi').val()=='' ||
						$('#tax_id_or_ssn').val()==''){
						notValid = !confirm("Notice: You will not be able to generate or file insurance claims until these fields are completed. Click Cancel to complete them now, or OK to proceed and complete later."); 
					  } 
					}
				}

				if(notValid == true){ 
					var page = root.find(".page").eq(api.getIndex());
                        		$("#register").animate({ height : (page.height()) }, 300);
					return false; 
				}
			}
			
	                        var post = $('#register_form').serializeObject();
                	        $.post('helpers/register_submit.php', post, function(data) {
			if(api.getIndex()==5){
                                if($('#cc_id').val()==0){
                                  //api.next();
                                }else{
				  disable_registration();
                                  api.next();
                                }
                        }
                        	});
			$("#status li").removeClass("active").eq(i).addClass("active filed");
			$("#status li.active").prev("li").addClass("filed");
			window.scroll(0,0);
		});
                // if tab is pressed on the next button seek to next page
                root.find("a.next,button.next").keydown(function(e) {
                        if (e.keyCode == 9) {
                                // seeks to next tab by executing our validation routine
                                api.next();
                                e.preventDefault();
                        }
                });


                //disable enter key for wizard
                        //Bind this keypress function to all of the input tags
                        root.find("input").keypress(function (evt) {
                        //Deterime where our character code is coming from within the event
                                var charCode = evt.charCode || evt.keyCode;
                                if (charCode  == 13) { //Enter key's keycode
                                        return false;
                                }
                        });
        }

};

$(document).ready(function(){
$('#billing_mailing').click(function(){
  if($(this).is(':checked')){
    $('#mailing_name').val($('#first_name').val()+" "+$('#last_name').val());
    $('#mailing_practice').val($('#practice').val());
    $('#mailing_phone').val($('#phone').val());
    $('#mailing_address').val($('#address').val());
    $('#mailing_city').val($('#city').val());
    $('#mailing_state').val($('#state').val());
    $('#mailing_state_chzn .chzn-single span').text($('#state option:selected').text());
    $('#mailing_zip').val($('#zip').val());    
  }
  
});
});

function disable_registration(){

                                  $.ajax({
                                        url: "includes/disable_registration.php",
                                        type: "post",
                                        data: {id: $("#userid").val()},
                                        async: false,
                                        success: function(data){
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

}

$(document).ready(function(){
    lga_wizard.init();
    $(".chzn-select").chosen({no_results_text: "No results matched"});
});

$('.service_info').hide();

function show_service_info()
{
    $('.service_info').show();
    $("#register").animate({ height : 600 }, 300);
    $("#main_section").animate({ height : 680 }, 300);
}

function cancel(n)
{
    $('#pc_' + n + '_input_div').hide();
    $('#pc_' + n + '_person').show();
    $('#pc_' + n + '_input_div input').val('');
}

function createPassword () {
    var e = $('#email').val(),
        c = $('#code').val(),
        p1 = $('#password1').val(),
        p2 = $('#password2').val(),
        agreement = $('#agreement').is(':checked');

    if (p1.length < 8) {
        $('#first2_error').html("Password must be at least 8 characters in length.").show('slow');
    } else if (!agreement) {
        $('#first2_error').html("User Agreement must be accepted.").show('slow');
    } else if (p1 == p2) {
        $.ajax({
            url: 'includes/setup_user.php',
            type: 'post',
            data: { email: e, code: c, p: p1 },
            success: function(data){
                var r = $.parseJSON(data);

                if (r.success) {
                    window.location = "register.php";
                } else {
                    if (r.error == "code") {
                        $('#sent_text').html("Incorrect text message code!").show('slow');
                    } else {
                        $('#sent_text').html("Error.").show('slow');
                    }
                }
            },
            error: function(){
                $('#sent_text').html("There was an error retrieving the response from the server. Please notify the system admin and try again later.").show('slow');
            }
        });
    } else {
        $('#sent_text').html("Passwords don't match!").show('slow');
    }

}

function setValidClass (selector, valid) {
    if (valid === 'reset') {
        $(selector)
            .removeClass('pass_valid')
            .removeClass('pass_invalid');
        return;
    }

    if (valid) {
        $(selector)
            .addClass('pass_valid')
            .removeClass('pass_invalid');
        return;
    }

    $(selector)
        .addClass('pass_invalid')
        .removeClass('pass_valid');
}

function checkPass () {
    var p1 = $('#password1').val() || '',
        p2 = $('#password2').val() || '';

    setValidClass('#password1', p1.length < 8);

    if (p1 != '' || p2 != '') {
        setValidClass('#password2', p1 == p2);
    } else {
        setValidClass('#password2', 'reset');
    }
}

function stripeResponseHandler(status, response)
{
    //console.log(response);
    if (response.error) {
        // Show the errors on the form
        alert(response.error.message);
        $('#loader').hide();
        $('#payment_proceed').show();
    } else {
        var address = $('#address').val()+" "+$('#city').val()+" "+ $('#state').val()+" "+$('#zip').val();
        var token = response.id;
        $.ajax({
            url: "includes/update_token.php",
            type: "get",
            data: {id: $("#userid").val(), name: $('#name').val(), address: address, email: $("#email").val(), token: token},
            success: function(data){
                $('#loader').hide();      
                $('#payment_proceed').show();
            },
            failure: function(data){
                alert('f - '+data);
                $('#loader').hide();
                $('#payment_proceed').show();
            }
        });
    }
    
    $('#loader').hide();
    $('#payment_proceed').show();
}

function add_cc()
{
    if($('.card-number').val()=='' || $('.card-cvc').val()=='' || $('.card-expiry-month').val().length!=2 || $('.card-expiry-year').val().length!=4 || $('.card-name').val()=='' || $('.card-zip').val().length!=5){
        alert('Please enter valid information for all fields');
        return false;
    }
    
    $('#loader').show();
    var address = $('#address').val()+" "+$('#city').val()+" "+ $('#state').val()+" "+$('#zip').val();
    $('#payment_proceed').hide();
    $.ajax({
        url: "includes/update_token.php",
        type: "post",
        data: {id: $("#userid").val(), 
                name: $('#name').val(), 
                address: address, 
                email: $("#email").val(),
                cnumber: $('.card-number').val(),
                cname: $('.card-name').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                cvc: $('.card-cvc').val(),
                zip: $('.card-zip').val(),
                // The following two files do NOT seem to be available in reg/register.php
                companyid: $('[name=companyid]').val(),
                company: $('[name=companyname]').val()
              },
        success: function(data){
            var r = $.parseJSON(data);
            if(r.error){
                $('#loader').hide();      
                $('#payment_proceed').show();
                alert(r.error.message);
            } else {
                $('.card-number').val('');
                $('.card-cvc').val('');
                $('.card-expiry-month').val('');
                $('.card-expiry-year').val('');
                $('a.next').click();
            }
        },
        failure: function(data){
             $('#loader').hide();
             $('#payment_proceed').show();
        }
    });

    // Prevent the form from submitting with the default action
    return false;
}