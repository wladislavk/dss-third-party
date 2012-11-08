//step-by-step wizard

 $.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg != value;
 }, "Value must not equal arg.");

 $.validator.addMethod("valueEquals", function(value, element, arg){
  var arg = $('#password').val();
  return arg == value;
 }, "Value must equal arg.");

lga_wizard = {
	init: function(){
		//wizard form submit
		$('#register_form').submit(function() {
			//var post = $(this).serializeObject();
			//$.post('helpers/register_submit.php', post, function(data) {
			//	$('#form_summary').html(data);
			//	//alert(data);
			//});
			return false;
		});

		//set page width for steps
		pageW = $('#status').outerWidth();
		$('.page').css('width',pageW - 10);
		
		//initialize wizard
		var root = $("#register").fancyscrollable();
		var api = root.fancyscrollable();

		                // adjust height after items have been scrolled
                api.onSeek(function(event, i) {
			if(api.getIndex()==5){
			  $("#register").animate({ height : 1400 }, 300);
			}else{
                          var page = root.find(".page").eq(api.getIndex());
                          $("#register").animate({ height : (page.height()) }, 300);
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
				/*
				if(api.getIndex()==0){
				  $.ajax({
					url: "includes/check_email.php",
                                        type: "post",
                                        data: {email: $("#email").val(), id: $("#userid").val()},
					async: false,
					success: function(data){
						if(data == 'false'){	
						  notValid = true;
						}
					},
					failure: function(data){
						//alert('fail');
					}
                                  });
					
				  if($("#email").val()!=$("#oldemail").val()){
					if(!confirm('You have changed your email from '+$("#oldemail").val()+' to '+$("#email").val()+'.  You will be sent an email reminder of this change.')){
						return false;
					}
				  }
				  
				}
				*/
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
                            name: "required",
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
                            address: "required",
			    city: "required",
			    state: "required",
                            zip: "required",
			    npi: "required",
			    medicare_npi: "required",
			    tax_id_or_ssn: "required",
			    username: {
                                required: true,
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
			    password: "required",
			    confirm_password: { 
				required: true,
				valueEquals: $("#password").val()
			    } 
                        },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
                        messages: {
                            name: "This field is required",
			    email: {
				required: "This field is required",			
				remote: "Error: The email address you have entered is either invalid or already in use. Please enter a different email address.",
				email: "The field requires a valid email address"
				},
                            phone: "This field is required",
			    address: "This field is required",
                            city: "This field is required",
                            state: "This field is required",
                            zip: "This field is required",
			    npi: "This field is required",
			    medicare_npi: "This field is required",
			    tax_id_or_ssn: "This field is required",
			    username: {
                                required: "This field is required",
                                remote: "Error: The username you have entered is either invalid or already in use. Please enter a different username."
                                },
                            password: "This field is required",
                            confirm_password: { 
				required: "This field is required",
				valueEquals: 'Must match password' 
				}
                        }
					}).element($(this));
				
					if(validator == false){	notValid = true	}
			})



				if(notValid == true){ 
					var page = root.find(".page").eq(api.getIndex());
                        		$("#register").animate({ height : (page.height()) }, 300);
					return false; 
				}
			}
			
	                        var post = $('#register_form').serializeObject();
				//alert(post);
                	        $.post('helpers/register_submit.php', post, function(data) {
					//var r = $.parseJSON(data);
					//alert(data);
                        	        //$('#form_summary').html(data);
                                	//alert(data);
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
