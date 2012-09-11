//step-by-step wizard

 $.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg != value;
 }, "Value must not equal arg.");

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
		api.onBeforeSeek(function(event, i) {
			if (api.getIndex() < i) {
				var page = root.find(".page").eq(api.getIndex());
				notValid = false;
				//class="validate" needs to be added to elements that needs to be validated
				if(api.getIndex()==0){
				  $.ajax({
					url: "includes/check_email.php",
                                        type: "post",
                                        data: {email: $("#email").val(), id: $("#patientid").val()},
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
                            firstname: "required",
			    lastname: "required",
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
	    						return $("#patientid").val();
	  					}
        				}
				}
                            },
                            cell_phone: {
                                required: true
                            },
                            add1: "required",
			    city: "required",
			    state: "required",
                            zip: "required",
                            dob_month: { valueNotEquals: '' },
                            dob_day: { valueNotEquals: '' },
                            dob_year: { valueNotEquals: '' },
			    gender: { valueNotEquals: '' },
			    marital_status: { valueNotEquals: '' },
			    ssn: "required",
			    preferredcontact: "required",
			    p_m_relation: "required",
                            p_m_partyfname: "required",
                            p_m_partylname: "required",
                            ins_dob_month: { valueNotEquals: '' },
                            ins_dob_day: { valueNotEquals: '' },
                            ins_dob_year: { valueNotEquals: '' },
			    p_m_ins_medicare: "required",
                            p_m_ins_company: "required",
			    p_m_ins_address1: "required",
			    p_m_ins_city: "required",
			    p_m_ins_state: "required",
			    p_m_ins_zip: "required",
			    p_m_ins_phone: "required",
                            p_m_ins_id: "required",
                            p_m_ins_grp: "required",
                            p_m_ins_plan: "required",
			    has_p_m_ins: "required",
			    has_s_m_ins: "required",
                            s_m_relation: "required",
                            s_m_partyfname: "required",
                            s_m_partylname: "required",
                            ins2_dob_month: { valueNotEquals: '' },
                            ins2_dob_day: { valueNotEquals: '' },
                            ins2_dob_year: { valueNotEquals: '' },
                            s_m_ins_company: "required",
                            s_m_ins_address1: "required",
                            s_m_ins_city: "required",
                            s_m_ins_state: "required",
                            s_m_ins_zip: "required",
                            s_m_ins_phone: "required",
                            s_m_ins_id: "required",
                            s_m_ins_grp: "required",
                            s_m_ins_plan: "required"
                        },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
                        messages: {
                            firstname: "This field is required",
			    lastname: "This field is required",
			    email: {
				required: "This field is required",			
				remote: "Error: The email address you have entered is either invalid or already in use. Please enter a different email address.",
				email: "The field requires a valid email address"
				},
                            cell_phone: "Cell phone required for security verification.",
			    add1: "This field is required",
                            city: "This field is required",
                            state: "This field is required",
                            zip: "This field is required",
                            dob_month: { valueNotEquals: 'Please enter month' },
                            dob_day: { valueNotEquals: 'Please enter day' },
                            dob_year: { valueNotEquals: 'Please enter year' },
                            gender: { valueNotEquals: 'Please select gender' },
			    marital_status: { valueNotEquals: 'Please select marital status' },
                            ssn: "This field is required",
                            preferredcontact: "This field is required",
                            p_m_relation: "This field is required",
                            p_m_partyfname: "This field is required",
                            p_m_partylname: "This field is required",
                            ins_dob_month: { valueNotEquals: 'This field is required' },
                            ins_dob_day: { valueNotEquals: 'This field is required' },
                            ins_dob_year: { valueNotEquals: 'This field is required' },
                            p_m_ins_company: "This field is required",
                            p_m_ins_address1: "This field is required",
                            p_m_ins_city: "This field is required",
                            p_m_ins_state: "This field is required",
                            p_m_ins_zip: "This field is required",
                            p_m_ins_phone: "This field is required",
                            p_m_ins_id: "This field is required",
                            p_m_ins_grp: "This field is required",
                            p_m_ins_plan: "This field is required",
                            s_m_relation: "This field is required",
                            s_m_partyfname: "This field is required",
                            s_m_partylname: "This field is required",
                            ins2_dob_month: { valueNotEquals: 'This field is required' },
                            ins2_dob_day: { valueNotEquals: 'This field is required' },
                            ins2_dob_year: { valueNotEquals: 'This field is required' },
                            s_m_ins_company: "This field is required",
                            s_m_ins_address1: "This field is required",
                            s_m_ins_city: "This field is required",
                            s_m_ins_state: "This field is required",
                            s_m_ins_zip: "This field is required",
                            s_m_ins_phone: "This field is required",
                            s_m_ins_id: "This field is required",
                            s_m_ins_grp: "This field is required",
                            s_m_ins_plan: "This field is required"
                        }
					}).element($(this));
				
					if(validator == false){	notValid = true	}
			})



                                if(api.getIndex()==1){
                                  if($('#dob_day').val()=='' || $('#dob_month').val()=='' || $('#dob_year').val()==''){
                                        $('#dob_div').addClass("error");
                                  }else{
                                        $('#dob_div').removeClass("error");
                                  }
                                }else if(api.getIndex()==2){
                                  if($('#ins_dob_day').val()=='' || $('#ins_dob_month').val()=='' || $('#ins_dob_year').val()==''){
                                        $('#ins_dob_div').addClass("error");
                                  }else{
                                        $('#ins_dob_div').removeClass("error");
                                  }
                                }else if(api.getIndex()==3){
                                  if($('#ins2_dob_day').val()=='' || $('#ins2_dob_month').val()=='' || $('#ins2_dob_year').val()==''){
                                        $('#ins2_dob_div').addClass("error");
                                  }else{
                                        $('#ins2_dob_div').removeClass("error");
                                  }
                                }



				if(notValid == true){ return false; }
			}
			
	                        var post = $('#register_form').serializeObject();
				//alert(post);
                	        $.post('helpers/register_submit.php', post, function(data) {
					var r = $.parseJSON(data);
					//alert(data);
					if(r.p_m_patient_insuranceid){
					  $('#p_m_patient_insuranceid').val(r.p_m_patient_insuranceid);
					}else if(r.s_m_patient_insuranceid){
                                          $('#s_m_patient_insuranceid').val(r.s_m_patient_insuranceid);
                                        }
					if(r.pc_1_patient_contactid){
					  $('#pc_1_patient_contactid').val(r.pc_1_patient_contactid);
					}
                                        if(r.pc_2_patient_contactid){
                                          $('#pc_2_patient_contactid').val(r.pc_2_patient_contactid);
                                        }
                                        if(r.pc_3_patient_contactid){
                                          $('#pc_3_patient_contactid').val(r.pc_3_patient_contactid);
                                        }
                                        if(r.pc_4_patient_contactid){
                                          $('#pc_4_patient_contactid').val(r.pc_4_patient_contactid);
                                        }
                                        if(r.pc_5_patient_contactid){
                                          $('#pc_5_patient_contactid').val(r.pc_5_patient_contactid);
                                        }
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

	        root.find("a.next2,button.next2").click(function(e) {
                                api.move(2);
                });	
                root.find("a.prev2,button.prev2").click(function(e) {
                                api.move(-2);
                });
                root.find("a.next3,button.next3").click(function(e) {
                                api.move(3);
                });
                root.find("a.prev3,button.prev3").click(function(e) {
                                api.move(-3);
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


function updateNext(v, i){
  if(i==1){
	ins2 = $('input:radio[name=has_s_m_ins]:checked').val();
	if(v=="Yes"){
	  $('#ins1Next1').show();
          $('#ins1Next3').hide();
	  if(ins2=="Yes"){
            $('#insPrev1').show();
	    $('#insPrev2').hide();
            $('#insPrev3').hide();
	  }else{
	    $('#insPrev1').hide();
            $('#insPrev2').show();
            $('#insPrev3').hide();	
	  }
	}else{
          $('#ins1Next1').hide();
          $('#ins1Next3').show();
          $('#insPrev1').hide();
          $('#insPrev2').hide();
          $('#insPrev3').show();
	}
  }else if(i==2){
        if(v=="Yes"){
          $('#ins2Next1').show();
          $('#ins2Next2').hide();
          $('#insPrev1').show();
          $('#insPrev2').hide();
          $('#insPrev3').hide();
        }else{
          $('#ins2Next1').hide();
          $('#ins2Next2').show();
          $('#insPrev1').hide();
          $('#insPrev2').show();
          $('#insPrev3').hide();
        }
  }
}

/*
  if(v=='No'){
        $('#insNext').hide();
        $('#insNext2').show();
        $('#insPrev').hide();
        $('#insPrev2').show();
  }else{
        $('#insNext').show();
        $('#insNext2').hide();
        $('#insPrev').show();
        $('#insPrev2').hide();
  }
*/

$( document ).ready( function() { 

      $( "input[name='p_m_ins_type']" ).bind( "click", updateDescription )
      
  });

  function updateDescription()
  {
      if( $( this ).val() == "1" ){
  	$('#p_m_ins_description').html('Please complete the information below for the PRIMARY INSURED PARTY listed on your MEDICARE insurance card.');
      }else{
  	$('#p_m_ins_description').html('Please complete the information below for the PRIMARY INSURED PARTY listed on your insurance card.');
      }
}


