
$(function() {
  //$('input, select, textarea').each(function() { console.log($(this).attr('name')); });
  $("input[name='has_out_of_network_benefits']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#has_out_of_network_benefits_yes').css('display', 'block');
      $('#has_out_of_network_benefits_no').css('display', 'none');
    } else {
      $('#has_out_of_network_benefits_yes').css('display', 'none');
      $('#has_out_of_network_benefits_no').css('display', 'block');
    }
  });
  $("input[name='has_out_of_network_benefits']:checked").click();

  $("input[name='has_in_network_benefits']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#has_in_network_benefits_yes').css('display', 'block');
      $('#has_in_network_benefits_no').css('display', 'none');
    } else {
      $('#has_in_network_benefits_yes').css('display', 'none');
      $('#has_in_network_benefits_no').css('display', 'block');
    }
  });
  $("input[name='has_in_network_benefits']:checked").click();
  
  $("input[name='is_hmo']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#is_hmo_yes').css('display', 'block');
      $('#is_hmo_no').css('display', 'none');
    } else {
      $('#is_hmo_yes').css('display', 'none');
      $('#is_hmo_no').css('display', 'block');
    }
  });
  $("input[name='is_hmo']:checked").click();

  $("input[name='hmo_needs_auth']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#hmo_needs_auth_yes').css('display', 'block');
    } else {
      $('#hmo_needs_auth_yes').css('display', 'none');
    }
  });
  $("input[name='hmo_needs_auth']:checked").click();

  $("input[name='is_pre_auth_required']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#is_pre_auth_required_yes').css('display', 'block');
    } else {
      $('#is_pre_auth_required_yes').css('display', 'none');
    }
  });
  $("input[name='is_pre_auth_required']:checked").click();
  $("input[name='in_is_pre_auth_required']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#in_is_pre_auth_required_yes').css('display', 'block');
    } else {
      $('#in_is_pre_auth_required_yes').css('display', 'none');
    }
  });
  $("input[name='in_is_pre_auth_required']:checked").click();
  
  $("#ins_cal_year_end").bind("focus blur click", function() {
	if($(this).val()!=''){
	myDate = new Date($(this).val());
	myDate.setDate(myDate.getDate()+1);
    $("#deductible_reset_date").val(parseInt(myDate.getMonth()+1,10)+"/"+myDate.getDate()+"/"+myDate.getFullYear());
    $("#in_deductible_reset_date").val(parseInt(myDate.getMonth()+1,10)+"/"+myDate.getDate()+"/"+myDate.getFullYear());
	}else{
	  $("#deductible_reset_date").val('');
	  $("#in_deductible_reset_date").val('');
	}
  });
  $("#ins_cal_year_end").blur();
 
  $("#ins_cal_year").bind("click", function() {
        if($("#ins_cal_year_end").val()!=''){
        myDate = new Date($("#ins_cal_year_end").val());
        myDate.setDate(myDate.getDate()+1);
    $("#deductible_reset_date").val(parseInt(myDate.getMonth()+1,10)+"/"+myDate.getDate()+"/"+myDate.getFullYear());
    $("#in_deductible_reset_date").val(parseInt(myDate.getMonth()+1,10)+"/"+myDate.getDate()+"/"+myDate.getFullYear());
        }else{
          $("#deductible_reset_date").val('');
          $("#in_deductible_reset_date").val('');
        }

  });


 
  function calc_amount_left_to_meet() {
    var deductible = $('#patient_deductible').val();
    var amountMet  = $('#patient_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    var leftToMeet = deductible - amountMet;
    if (leftToMeet < 0) { leftToMeet = 0; }
    $('#patient_amount_left_to_meet').val(leftToMeet.toFixed(2));
    var deductible = $('#in_patient_deductible').val();
    var amountMet  = $('#in_patient_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    var leftToMeet = deductible - amountMet;
    if (leftToMeet < 0) { leftToMeet = 0; }
    $('#in_patient_amount_left_to_meet').val(leftToMeet.toFixed(2));
  }

  function calc_amount_left_to_meet_family() {
    var deductible = $('#family_deductible').val();
    var amountMet  = $('#family_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    var leftToMeet = deductible - amountMet;
    if (leftToMeet < 0) { leftToMeet = 0; }
    $('#family_amount_left_to_meet').val(leftToMeet.toFixed(2));
    var deductible = $('#in_family_deductible').val();
    var amountMet  = $('#in_family_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    var leftToMeet = deductible - amountMet;
    if (leftToMeet < 0) { leftToMeet = 0; }
    $('#in_family_amount_left_to_meet').val(leftToMeet.toFixed(2));
  }

  
  $("#patient_deductible, #patient_amount_met, #in_patient_deductible, #in_patient_amount_met").bind("focus blur click", function() {
    calc_amount_left_to_meet();
    calc_expected_payments();
  });

  $("input[name='deductible_from'], input[name='in_deductible_from']").bind("focus blur click", function() {
    calc_expected_payments();
  });

  $("#family_deductible, #family_amount_met, #in_family_deductible, #in_family_amount_met").bind("focus blur click", function() {
    calc_amount_left_to_meet_family();
    calc_expected_payments();
  });


  function calc_expected_payments() {


    // OUT OF NETWORK BENEFITS
    var debug = true;
    if (debug) { console.log('calc_expected_payments'); }
    var deductibleFrom = $("input[name='deductible_from']:checked").val(); 
    var deviceAmount = $('#trxn_code_amount2').val();
    if(deductibleFrom == '1'){
      var amountLeftToMeet = $('#patient_amount_left_to_meet').val();
    }else{
      var amountLeftToMeet = $('#family_amount_left_to_meet').val();
    }
    var hasOutOfNetwork = $("input[name='has_out_of_network_benefits']:checked").val();
    var isHmo = $("input[name='is_hmo']:checked").val();
    var outOfPocketMet = $("input[name='out_of_pocket_met']:checked").val();
    var benefits = $("input[name='network_benefits']:checked").val();
    var percentagePaid = 0;

    if (debug) { 
      console.log('amountLeftToMeet: ' + amountLeftToMeet);
      console.log('hasOutOfNetwork: ' + hasOutOfNetwork);
      console.log('isHmo: ' + isHmo);
      console.log('outOfPocketMet: ' + outOfPocketMet);
    }
    //if (benefits == 1){ //out of network    
      if (hasOutOfNetwork == 1) {
        // percentage from out_of_network_percentage
        percentagePaid = $('#out_of_network_percentage').val();
      //} else if (isHmo == 0) {
        // percentage from in_network_percentage
        //percentagePaid = $('#in_network_percentage').val();
      } else {
        // no percentage, set to 0
        percentagePaid = 0;
      }
    /*}else{ //in-network
      if(hasOutOfNetwork == 1){
        percentagePaid = 0;
      }else{
        percentagePaid = $('#in_network_percentage').val();
      }
    }*/
    if (debug) { console.log('percentagePaid: ' + percentagePaid); }

    if (isNaN(deviceAmount))     { deviceAmount = 0; }
    if (isNaN(percentagePaid))   { percentagePaid = 0; }
    if (isNaN(amountLeftToMeet)) { amountLeftToMeet = 0; }
    
    if (outOfPocketMet == 1) {
      $('#expected_insurance_payment').val(deviceAmount);
      $('#expected_patient_payment').val('0.00');
      if (debug) { 
        console.log('expected_insurance_payment: ' + deviceAmount);
        console.log('expected_patient_payment: ' + 0.00);
      }
    } else {
      var expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid/100);
      if (expectedInsurancePayment < 0) { expectedInsurancePayment = 0; }

      var expectedPatientPayment = deviceAmount - expectedInsurancePayment;
      if (expectedPatientPayment < 0) { expectedPatientPayment = 0; }

      if (debug) { 
        console.log('expectedInsurancePayment: ' + expectedInsurancePayment.toFixed(2));
        console.log('expectedPatientPayment: ' + expectedPatientPayment.toFixed(2));
      }
      $('#expected_insurance_payment').val(expectedInsurancePayment.toFixed(2));
      $('#expected_patient_payment').val(expectedPatientPayment.toFixed(2));
    }
    
    if (debug) { console.log('-----------------------'); }


    //IN NETWORK BENEFITS
    if (debug) { console.log('calc_expected_payments'); }
    var deductibleFrom = $("input[name='in_deductible_from']:checked").val(); 
    var deviceAmount = $('#in_trxn_code_amount2').val();
    if(deductibleFrom == '1'){
      var amountLeftToMeet = $('#in_patient_amount_left_to_meet').val();
    }else{
      var amountLeftToMeet = $('#in_family_amount_left_to_meet').val();
    }
    var hasInNetwork = $("input[name='has_in_network_benefits']:checked").val();
    var isHmo = $("input[name='is_hmo']:checked").val();
    var outOfPocketMet = $("input[name='in_out_of_pocket_met']:checked").val();
    var benefits = $("input[name='network_benefits']:checked").val();
    var percentagePaid = 0;

    if (debug) { 
      console.log('amountLeftToMeet: ' + amountLeftToMeet);
      console.log('hasOutOfNetwork: ' + hasOutOfNetwork);
      console.log('isHmo: ' + isHmo);
      console.log('outOfPocketMet: ' + outOfPocketMet);
    }
      if (hasInNetwork == 1) {
        // percentage from out_of_network_percentage
        percentagePaid = $('#in_network_percentage').val();
      } else {
        // no percentage, set to 0
        percentagePaid = 0;
      }
    if (debug) { console.log('percentagePaid: ' + percentagePaid); }

    if (isNaN(deviceAmount))     { deviceAmount = 0; }
    if (isNaN(percentagePaid))   { percentagePaid = 0; }
    if (isNaN(amountLeftToMeet)) { amountLeftToMeet = 0; }
    
    if (outOfPocketMet == 1) {
      $('#in_expected_insurance_payment').val(deviceAmount);
      $('#in_expected_patient_payment').val('0.00');
      if (debug) { 
        console.log('in_expected_insurance_payment: ' + deviceAmount);
        console.log('in_expected_patient_payment: ' + 0.00);
      }
    } else {
      var expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid/100);
      if (expectedInsurancePayment < 0) { expectedInsurancePayment = 0; }

      var expectedPatientPayment = deviceAmount - expectedInsurancePayment;
      if (expectedPatientPayment < 0) { expectedPatientPayment = 0; }

      if (debug) { 
        console.log('expectedInsurancePayment: ' + expectedInsurancePayment.toFixed(2));
        console.log('expectedPatientPayment: ' + expectedPatientPayment.toFixed(2));
      }
      $('#in_expected_insurance_payment').val(expectedInsurancePayment.toFixed(2));
      $('#in_expected_patient_payment').val(expectedPatientPayment.toFixed(2));
    }
    
    if (debug) { console.log('-----------------------'); }
	

  }
  
  // Fields that should be clear on focus if value is 0
  $('#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met, #in_patient_deductible, #in_patient_amount_met, #in_family_deductible, #in_family_amount_met').bind('focus', function() {
    var value = $(this).val();
    if (isNaN(value) || (value == 0)) {
      $(this).val('');
    }
  });
  
  // Fields that should display two decimal places on blur
  $('#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met, #in_patient_deductible, #in_patient_amount_met, #in_family_deductible, #in_family_amount_met').bind('blur', function() {
    var value = parseFloat($(this).val());
    if (!isNaN(value)) {
      $(this).val(value.toFixed(2));
    }
  });
  
  // Fields that should trigger calculations
  $('#out_of_network_percentage, #in_network_percentage, #patient_deductible, #patient_amount_met').bind("mouseup keyup", function() {
    calc_expected_payments();
  });
  $("[name='has_out_of_network_benefits'], [name='has_in_network_benefits'], [name='network_benefits'], [name='is_hmo'], [name='out_of_pocket_met']").bind('change', function() {
    calc_expected_payments();
  });
  
  // Fields where the user shouldn't be able to gain focus
  $('#patient_amount_left_to_meet, #family_amount_left_to_meet, #in_patient_amount_left_to_meet, #in_family_amount_left_to_meet, #deductible_reset_date, #expected_insurance_payment, #expected_patient_payment').bind('focus', function() {
    $(this).blur();
  });
  
  // Disable/enable fields related to this trxn code being covered by insurance
  $("input[name='trxn_code_covered']").bind('click', function() {
    if ($(this).val() == "1") {
      // enable all the "covered" fields
      $('.covered').each(function() {
        $(this).removeAttr('disabled');
        $(this).css('background-color', '');
      });
      
      // show all the "covered-row" elements
      $('.covered-row').show();

      // update expected payments
      calc_expected_payments();
      
    } else {
      // hide all the "covered-row" elements
      $('.covered-row').hide();

      // manually set expected payments
      var deviceAmount = $('#trxn_code_amount2').val();
      $('#expected_insurance_payment').val('0.00');
      $('#expected_patient_payment').val(deviceAmount);
      
      // disable all the "covered" fields
      $('.covered').each(function() {
        $(this).attr('disabled', 'true');
        $(this).css('background-color', '#cccccc');
      });
    }
  });
  $("input[name='trxn_code_covered']:checked").click();

});
