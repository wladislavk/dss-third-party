var clickedBut;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		window.onbeforeunload = confirmExit;
	});

	$('#patientfrm').submit(function() {
		window.onbeforeunload = null;
	});

	$('input,select').keypress(function() { return event.keyCode != 13; });

	$('#patientfrm :submit').click(function() { 
		clickedBut = $(this).attr("name");  
	})

	setup_autocomplete('referredby_name', 'referredby_hints', 'referred_by', 'referred_source', 'list_referrers.php', 'referrer', getParameterByName('pid'));
	setup_autocomplete('ins_payer_name', 'ins_payer_hints', 'p_m_eligible_payer', '', 'list_ins_payers.php', 'ins_payer');
	setup_autocomplete('docpcp_name', 'docpcp_hints', 'docpcp', '', 'list_contacts.php');
	setup_autocomplete('docent_name', 'docent_hints', 'docent', '', 'list_contacts.php');
	setup_autocomplete('docsleep_name', 'docsleep_hints', 'docsleep', '', 'list_contacts.php', 'contact', getParameterByName('pid'));
	setup_autocomplete('docdentist_name', 'docdentist_hints', 'docdentist', '', 'list_contacts.php', 'contact', getParameterByName('pid'));
	setup_autocomplete('docmdother_name', 'docmdother_hints', 'docmdother', '', 'list_contacts.php', 'contact', getParameterByName('pid'));
	setup_autocomplete('docmdother2_name', 'docmdother2_hints', 'docmdother2', '', 'list_contacts.php', 'contact', getParameterByName('pid'));
	setup_autocomplete('docmdother3_name', 'docmdother3_hints', 'docmdother3', '', 'list_contacts.php', 'contact', getParameterByName('pid'));
	
	updateNumber('p_m_ins_phone');
	updateNumber2('s_m_ins_phone');
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function validate_add_patient(fa){
	if(clickedBut == "sendPin"){
	    return  pinabc(fa);
	}

	p = patientabc(fa);
	var valid = true;
	$.ajax({
		url: "includes/check_email.php",
		type: "post",
		data: {email: fa.email.value, id: getParameterByName('pid')},
		async: false,
		success: function(data){
    		var r = $.parseJSON(data);
    		if (r.error) {
      			alert("Error: The email address you entered is already associated with another patient. Please enter a different email address.");
				valid = false; 
    		}
  		},
  		failure: function(data){
    		//alert('fail');
  		}
	});

	if(!valid){ return false; }
	var sendEmail = false;
	var emailConfirm = false;
	$.ajax({
		url: "includes/check_send.php",
		type: "post",
		data: {email: fa.email.value, id: getParameterByName('pid')},
		async: false,
		success: function(data){
    		var r = $.parseJSON(data);
    		if(r.success){                                                          
  				emailConfirm = true;
  				c = confirm("You have changed the patient's email address. The patient must be notified via email or he/she will not be able to access the Patient Portal. Send email notification and proceed?");
      			if(!c){ sendEmail = true; }
    		}
  		},
		failure: function(data){
		//alert('fail');
		}
	});

	if(sendEmail){ return false; }
	if(clickedBut == "sendReg" && !emailConfirm){
  		if(!regabc(fa)){ return false; }
	}else if(clickedBut == "sendRem" && !emailConfirm){
  		if(!remabc(fa)){ return false; }
	}

	if(p){
  		if(document.getElementById('s_m_dss_file_yes').checked){
   			i2 = validateDate('ins2_dob');
  		}else{
    		i2 = true;
  		}

  		if(document.getElementById('p_m_dss_file_yes').checked){
    		i = validateDate('ins_dob');
  		}else{
    		i = true;
  		}
  		/*d = validateDate('dob');*/
	}

	if(p){
  		result = true;
  		if( /*d &&*/ i && i2 && clickedBut != "sendReg" && clickedBut != "sendRem"){
			var result = true;
			info = required_info(fa);
			if (info.length == 0) {
				result = true;
			} else {
				m = 'Warning! Patient info is incomplete. Software functionality will be disabled for this patient until all required fields are entered. Are you sure you want to continue?\n\n';
				m += "Missing fields:";
				for(i=0;i<info.length;i++){
				  m += "\n"+info[i];
				}
				result = confirm(m);
			}
			if(!result){
	    		return result;
			}
  		}

	    if(trim(fa.p_m_partyfname.value) != "" || 
			trim(fa.p_m_partylname.value) != "" ||
			trim(fa.p_m_relation.value) != "" ||
			trim(fa.ins_dob.value) != "" ||
			trim(fa.p_m_ins_co.value) != "" ||
			trim(fa.p_m_party.value) != "" ||
			trim(fa.p_m_ins_grp.value) != "" ||
			trim(fa.p_m_ins_plan.value) != "" ||
			trim(fa.p_m_ins_type.value) != "Select Type"){
				if(document.getElementById('p_m_dss_file_yes').checked || document.getElementById('p_m_dss_file_no').checked){
			 		//ok
				}else{
					if($('#p_m_relation').val()!='' ||
						$('#p_m_partyfname').val()!='' ||
					    $('#p_m_partymname').val()!='' ||
					    $('#p_m_partylname').val()!='' ||
					    $('#ins_dob').val()!='' ||
					    $('#p_m_ins_co').val()!='' ||
					    $('#p_m_party').val()!='' ||
					    $('#p_m_ins_grp').val()!='' ||
					    $('#p_m_ins_plan').val()!='' ||
					    $('#p_m_ins_type').val()!=''){
	  						alert('Is DSS filing insurance?  Please select Yes or No.');
	  						return false;
	  				}
				}
		}

		if(document.getElementById('s_m_dss_file_yes').checked && !document.getElementById('p_m_dss_file_yes').checked){
			alert('DSS must file Primary Insurance in order to file Secondary Insurance.');
			return false;
		}

		if($('#s_m_ins_type').val() == 1){
			alert("Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.");
			return false;
		}

		return result;

		//workaround for settimeout being called in conditionals even if not true
		var err = '';
		if(!d) {
			err = "dob" 
		}else if(!i) {
			err = "ins_dob"
		}else if(!i2) {
			err = "ins2_dob"
		}

		if(err != ''){
			el = document.getElementById(err);
			setTimeout("el.focus()", 0);
		}
	}

	return false;
}

function remove_notification(id){
  	$.ajax({
		url: 'includes/notifications_remove.php',
	    type: 'post',
	    data: 'id=' + id,
	    success: function( data ) {
        	var r = $.parseJSON(data);
        	if(r.success){
           		$('#not_'+id).hide('slow');
        	}else{
				//alert('Error');
        	}
    	}
  	});
}

function cal_bmi()
{
    fa = document.patientfrm;
    if(fa.feet.value != 0 && fa.inches.value != -1 && fa.weight.value != 0) {
        var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);
        //alert(inc);
        
        var inc_sqr = parseInt(inc) * parseInt(inc);
        var wei = parseInt(fa.weight.value) * 703;
        var bmi = parseInt(wei) / parseInt(inc_sqr);
        
        //alert("BMI " + bmi.toFixed(2));
        fa.bmi.value = bmi.toFixed(1);
    } else {
        fa.bmi.value = '';
    }
}

function show_referredby(t, rs){
	if(t == 'person'){
		document.getElementById('referred_notes').style.display="none";
		document.getElementById('referred_person').style.display="block";
	}else{
		document.getElementById('referred_notes').style.display="block";
		document.getElementById('referred_person').style.display="none";
	}
    
    $('#referred_source').val(rs);
}

function updateNumber(f){
    var selectBox = document.getElementById("p_m_ins_co");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById(f).innerHTML = insurance_nums[selectedValue];
}

function clearInfo(){
	$('.s_m_ins_div input[type="text"]').val('');
	$('.s_m_ins_div select option[value=]').attr('selected', 'selected');
	$('.s_m_ins_div input[type="radio"]').removeAttr("checked");
}

function updateNumber2(f){
	var selectBox = document.getElementById("s_m_ins_co");
	var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	document.getElementById(f).innerHTML = insurance_nums[selectedValue];
}

function add_md(){		      
    if($('#docmdother2_tr').css('display') == 'none'){
    	$('#docmdother2_tr').css('display', 'table-row');
    }else if($('#docmdother3_tr').css('display') == 'none'){
    	$('#docmdother3_tr').css('display', 'table-row');
    }    

    if($('#docmdother2_tr').css('display') != 'none' && $('#docmdother3_tr').css('display') != 'none'){
		$('#add_new_md').hide();
    }
}

function cancel_md(md){
    $('#' + md).val('');
    $('#' + md + '_name').val('');
    $('#' + md + '_tr').hide();
}

function updatePPAlert(){
  	if($('#status').val()==2){
		$('#ppAlert').show();
  	}else{
		$('#ppAlert').hide();
  	}
}