
function submit_screener(){
  $.ajax({
    url: "script/submit_screener.php",
    type: "post",
    data: {
      docid: $('#docid').val(),
      userid: $('#userid').val(),
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(), 
      phone: $('#phone').val(),
      epworth_reading: $('#epworth_reading').val(),
      epworth_public: $('#epworth_public').val(),
      epworth_passenger: $('#epworth_passenger').val(),
      epworth_lying: $('#epworth_lying').val(),
      epworth_talking: $('#epworth_talking').val(),
      epworth_lunch: $('#epworth_lunch').val(),
      epworth_traffic: $('#epworth_traffic').val(),
      snore_1: $('#snore_1').val(),
      snore_2: $('#snore_2').val(),
      snore_3: $('#snore_3').val(),
      snore_4: $('#snore_4').val(),
      snore_5: $('#snore_5').val(),
      breathing: $("input[name=breathing]:checked").val(),
      driving: $("input[name=driving]:checked").val(),
      gasping: $("input[name=gasping]:checked").val(),
      sleepy: $("input[name=sleepy]:checked").val(),
      snore: $("input[name=snore]:checked").val(),
      weight_gain: $("input[name=weight_gain]:checked").val(),
      blood_pressure: $("input[name=blood_pressure]:checked").val(),
      jerk: $("input[name=jerk]:checked").val(),
      burning: $("input[name=burning]:checked").val(),
      headaches: $("input[name=headaches]:checked").val(),
      falling_asleep: $("input[name=falling_asleep]:checked").val(),
      staying_asleep: $("input[name=staying_asleep]:checked").val(),
      rx_cpap: $("input[name=rx_cpap]:checked").val(),
      rx_blood_pressure: $("input[name=rx_blood_pressure]").is(':checked')?2:0,
      rx_hypertension: $("input[name=rx_hypertension]").is(':checked')?1:0,
      rx_heart_disease: $("input[name=rx_heart_disease]").is(':checked')?1:0,
      rx_stroke: $("input[name=rx_stroke]").is(':checked')?3:0,
      rx_apnea: $("input[name=rx_apnea]").is(':checked')?4:0,
      rx_diabetes: $("input[name=rx_diabetes]").is(':checked')?1:0,
      rx_lung_disease: $("input[name=rx_lung_disease]").is(':checked')?1:0,
      rx_insomnia: $("input[name=rx_insomnia]").is(':checked')?1:0,
      rx_depression: $("input[name=rx_depression]").is(':checked')?1:0,
      rx_narcolepsy: $("input[name=rx_narcolepsy]").is(':checked')?1:0,
      rx_medication: $("input[name=rx_medication]").is(':checked')?1:0,
      rx_restless_leg: $("input[name=rx_restless_leg]").is(':checked')?1:0,
      rx_headaches: $("input[name=rx_headaches]").is(':checked')?1:0,
      rx_heartburn: $("input[name=rx_heartburn]").is(':checked')?1:0

    },
    success: function(data){
      var r = $.parseJSON(data);
      if(r.error){
      }else{
	//update view results div
	$('#r_first_name').text($('#first_name').val());
        $('#r_last_name').text($('#last_name').val());
        $('#r_phone').text($('#phone').val());
        $('#r_epworth_reading').text($('#epworth_reading').val());
        $('#r_epworth_public').text($('#epworth_public').val());
        $('#r_epworth_passenger').text($('#epworth_passenger').val());
        $('#r_epworth_lying').text($('#epworth_lying').val());
        $('#r_epworth_talking').text($('#epworth_talking').val());
        $('#r_epworth_lunch').text($('#epworth_lunch').val());
        $('#r_epworth_traffic').text($('#epworth_traffic').val());
        $('#r_breathing').text(($("input[name=breathing]:checked").val() > 0)?'Yes':'No');
        $('#r_driving').text(($("input[name=driving]:checked").val() > 0)?'Yes':'No');
        $('#r_gasping').text(($("input[name=gasping]:checked").val() > 0)?'Yes':'No');
        $('#r_sleepy').text(($("input[name=sleepy]:checked").val() > 0)?'Yes':'No');
        $('#r_snore').text(($("input[name=snore]:checked").val() > 0)?'Yes':'No');
        $('#r_weight_gain').text(($("input[name=weight_gain]:checked").val() > 0)?'Yes':'No');
        $('#r_blood_pressure').text(($("input[name=blood_pressure]:checked").val() > 0)?'Yes':'No');
        $('#r_jerk').text(($("input[name=jerk]:checked").val() > 0)?'Yes':'No');
        $('#r_burning').text(($("input[name=burning]:checked").val() > 0)?'Yes':'No');
        $('#r_headaches').text(($("input[name=headaches]:checked").val() > 0)?'Yes':'No');
        $('#r_falling_asleep').text(($("input[name=falling_asleep]:checked").val() > 0)?'Yes':'No');
        $('#r_staying_asleep').text(($("input[name=staying_asleep]:checked").val() > 0)?'Yes':'No');
        $('#r_rx_cpap').text(($("input[name=rx_cpap]:checked").val() > 0)?'Yes':'No');
        if($("input[name=rx_blood_pressure]").is(':checked')){
	  $('#r_diagnosed').append('<li>High blood pressure</li>');
	}
        if($("input[name=rx_heart_disease]").is(':checked')){
          $('#r_diagnosed').append('<li>Heart Disease</li>');
        }
        if($("input[name=rx_stroke]").is(':checked')){
          $('#r_diagnosed').append('<li>Stroke</li>');
        }
        if($("input[name=rx_apnea]").is(':checked')){
          $('#r_diagnosed').append('<li>Sleep Apnea</li>');
        }
        if($("input[name=rx_diabetes]").is(':checked')){
          $('#r_diagnosed').append('<li>Diabetes</li>');
        }
        if($("input[name=rx_lung_disease]").is(':checked')){
          $('#r_diagnosed').append('<li>Lung Disease</li>');
        }
        if($("input[name=rx_insomnia]").is(':checked')){
          $('#r_diagnosed').append('<li>Insomnia</li>');
        }
        if($("input[name=rx_depression]").is(':checked')){
          $('#r_diagnosed').append('<li>Depression</li>');
        }
        if($("input[name=rx_medication]").is(':checked')){
          $('#r_diagnosed').append('<li>Sleeping medication</li>');
        }
        if($("input[name=rx_restless_leg]").is(':checked')){
          $('#r_diagnosed').append('<li>Restless leg syndrome</li>');
        }
        if($("input[name=rx_headaches]").is(':checked')){
          $('#r_diagnosed').append('<li>Morning headaches</li>');
        }
        if($("input[name=rx_heartburn]").is(':checked')){
          $('#r_diagnosed').append('<li>Heartburn (Gastroesophageal Reflux)</li>');
        }

	$('#results_div div.check').each( function(){
  	  result = $(this).find('span').text();
	  if(result == 0 || result =='' || result== 'No'){
		$(this).hide();
	  }else if(result == 1){
                $(this).find('span').text('1 - Slight chance of dozing');
          }else if(result == 2){
                $(this).find('span').text('2 - Moderate chance of dozing');
          }else if(result == 3){
                $(this).find('span').text('3 - High chance of dozing');
          }
	});


	//get scores
	var ep = 0;
	ep += parseInt($('#epworth_reading').val(), 10);
        ep += parseInt($('#epworth_public').val(), 10);
        ep += parseInt($('#epworth_passenger').val(), 10);
        ep += parseInt($('#epworth_lying').val(), 10);
        ep += parseInt($('#epworth_talking').val(), 10);
        ep += parseInt($('#epworth_lunch').val(), 10);
        ep += parseInt($('#epworth_traffic').val(), 10);
        $('#r_ep_total').text(ep);
	var sect3 = 0;
	sect3 += parseInt($("input[name=rx_cpap]:checked").val(), 10);
	sect3 += $("input[name=rx_blood_pressure]").is(':checked')?2:0;
	sect3 += $("input[name=rx_hypertension]").is(':checked')?1:0;
	sect3 += $("input[name=rx_heart_disease]").is(':checked')?1:0;
	sect3 += $("input[name=rx_stroke]").is(':checked')?3:0;
        sect3 += $("input[name=rx_apnea]").is(':checked')?4:0;
        sect3 += $("input[name=rx_diabetes]").is(':checked')?1:0;
        sect3 += $("input[name=rx_lung_disease]").is(':checked')?1:0;
        sect3 += $("input[name=rx_insomnia]").is(':checked')?1:0;
        sect3 += $("input[name=rx_depression]").is(':checked')?1:0;
        sect3 += $("input[name=rx_narcolepsy]").is(':checked')?1:0;
        sect3 += $("input[name=rx_medication]").is(':checked')?1:0;
        sect3 += $("input[name=rx_restless_leg]").is(':checked')?1:0;
        sect3 += $("input[name=rx_headaches]").is(':checked')?1:0;
        sect3 += $("input[name=rx_heartburn]").is(':checked')?1:0;
	var survey = 0;
	if($("input[name=breathing]:checked").val())
		survey += parseInt($("input[name=breathing]:checked").val(), 10);
	if($("input[name=driving]:checked").val())
        	survey += parseInt($("input[name=driving]:checked").val(), 10);
        if($("input[name=gasping]:checked").val())                
		survey += parseInt($("input[name=gasping]:checked").val(), 10);
        if($("input[name=sleepy]:checked").val())                
                survey += parseInt($("input[name=sleepy]:checked").val(), 10);
        if($("input[name=snore]:checked").val())                
                survey += parseInt($("input[name=snore]:checked").val(), 10);
        if($("input[name=weight_gain]:checked").val()) 
                survey += parseInt($("input[name=weight_gain]:checked").val(), 10);
        if($("input[name=blood_pressure]:checked").val())                
                survey += parseInt($("input[name=blood_pressure]:checked").val(), 10);
        if($("input[name=jerk]:checked").val())                
                survey += parseInt($("input[name=jerk]:checked").val(), 10);
        if($("input[name=burning]:checked").val())                
                survey += parseInt($("input[name=burning]:checked").val(), 10);
        if($("input[name=headaches]:checked").val())                
                survey += parseInt($("input[name=headaches]:checked").val(), 10);
        if($("input[name=falling_asleep]:checked").val())                
                survey += parseInt($("input[name=falling_asleep]:checked").val(), 10);
        if($("input[name=staying_asleep]:checked").val())                
                survey += parseInt($("input[name=staying_asleep]:checked").val(), 10);
	an_tot = ep;
	$('.risk_desc').hide();
	                                                                        if(an_tot < 8)
                                                                        {
                                                                                an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a normal amount of sleepiness.';
										img = 'images/screener-low_risk.png';
                                                                        }
                                                                        
                                                                        if (an_tot >= 8 && an_tot < 10)
                                                                        {
                                                                                an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a average amount of sleepiness.';
                                                                                img = 'images/screener-moderate_risk.png';
                                                                        }
                                                                        
                                                                        if (an_tot >= 10 && an_tot < 16)
                                                                        {
                                                                                an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which may indicate excessive sleepiness depending on the situation. The patient may want to seek medical attention.';
                                                                                img = 'images/screener-high_risk.png';
                                                                        }
                                                                        
                                                                        if (an_tot >= 16 )
                                                                        {
                                                                                an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which indicates excessive sleepiness and medical attention should be sought.';
                                                                                img = 'images/screener-severe_risk.png';
                                                                        }
	var img = '';


        if(survey > 15 || ep > 18 || sect3 > 3){
                img = 'images/screener-severe_risk.png';
                $('#risk_severe').show();
	}else if(survey > 11 || ep > 14 || sect3 > 2){
                img = 'images/screener-high_risk.png';
                $('#risk_high').show();
	}else if(survey > 7 || ep > 9 || sect3 > 1){
                img = 'images/screener-moderate_risk.png';
                $('#risk_moderate').show();
	}else{
                img = 'images/screener-low_risk.png';
                $('#risk_low').show();
	}

	$('.pat_name').text($('#first_name').val());
	$('#risk_image').html('<img src="'+img+'" />');
	//$('#ep_score').text(an_text);
	//$('#snore_score').text(snore);
	//$('#survey_score').text(survey);
	next_sect('results');

      }
    },
    failure: function(data){
      alert('fail');
    }
  });	

}


function next_sect(sect){
  if(sect==1){
	$('#restart_nav').show();
  }
  $('.sect').hide();
  $('#sect'+sect).show();
}


$(document).ready( function(){
  next_sect(0);
});


function validate_name(){
  var return_val = true;
  var error_text = '';
  if($('#first_name_div input').val() == ''){
    $('#first_name_div').addClass('error');
    error_text += "<label for=\"first_name\" generated=\"true\" class=\"error\" style=\"\"><strong>First Name</strong>: Please provide a first name</label>"
    return_val = false;
  }else{
    $('#first_name_div').removeClass('error');
  }


  if($('#last_name_div input').val() == ''){
    $('#last_name_div').addClass('error');
    error_text += "<label for=\"last_name\" generated=\"true\" class=\"error\" style=\"\"><strong>Last Name</strong>: Please provide a last name</label>"
    return_val = false;
  }else{
    $('#last_name_div').removeClass('error');
  }

  if($('#phone_div input').val() == ''){
    $('#phone_div').addClass('error');
    error_text += "<label for=\"phone\" generated=\"true\" class=\"error\" style=\"\"><strong>Phone number</strong>: Please provide a phone number</label>"
    return_val = false;
  }else{
    $('#phone_div').removeClass('error');
  }

  if(return_val){
        $('.assessment_name').text($('#first_name_div input').val()+" "+$('#last_name_div input').val());
  	next_sect(2);
  }else{
    $('#name_error_box').html(error_text).show();
  }
  return return_val;
}
function validate_epworth(){

  var return_val = true;
  var error_text = '';
  if($('#epworth_reading_div select').val() == ''){
    $('#epworth_reading_div').addClass('error');
    error_text += "<label for=\"epworth_reading\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting And Reading</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_reading_div').removeClass('error');
  }

  if($('#epworth_public_div select').val() == ''){
    $('#epworth_public_div').addClass('error');
    error_text += "<label for=\"epworth_public\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting inactive in a public place</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_public_div').removeClass('error');
  } 
        
  if($('#epworth_passenger_div select').val() == ''){
    $('#epworth_passenger_div').addClass('error');
    error_text += "<label for=\"epworth_passenger\" generated=\"true\" class=\"error\" style=\"\"><strong>As a passenger</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_passenger_div').removeClass('error');
  } 
        
  if($('#epworth_lying_div select').val() == ''){
    $('#epworth_lying_div').addClass('error');
    error_text += "<label for=\"epworth_lying\" generated=\"true\" class=\"error\" style=\"\"><strong>Lying down to rest</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_lying_div').removeClass('error');
  } 
        
  if($('#epworth_talking_div select').val() == ''){
    $('#epworth_talking_div').addClass('error');
    error_text += "<label for=\"epworth_talking\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting and talking</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_talking_div').removeClass('error');
  } 
        
  if($('#epworth_lunch_div select').val() == ''){
    $('#epworth_lunch_div').addClass('error');
    error_text += "<label for=\"epworth_lunch\" generated=\"true\" class=\"error\" style=\"\"><strong>After a lunch</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_lunch_div').removeClass('error');
  } 
        
  if($('#epworth_traffic_div select').val() == ''){
    $('#epworth_traffic_div').addClass('error');
    error_text += "<label for=\"epworth_traffic\" generated=\"true\" class=\"error\" style=\"\"><strong>Stopped in traffic</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_traffic_div').removeClass('error');
  }


  if(return_val){
        next_sect(3);
  }else{
    $('#epworth_error_box').html(error_text).show();
  }
  return return_val;
}

function validate_sect3(){
  var return_val = true;
  var error_text = '';
  if($('#breathing_div input:checked').val() == null){
    $('#breathing_div').addClass('error');
    error_text += "<label for=\"breathing\" generated=\"true\" class=\"error\" style=\"\"><strong>Stop breathing</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#breathing_div').removeClass('error');
  }

  if($('#driving_div input:checked').val() == null){
    $('#driving_div').addClass('error');
    error_text += "<label for=\"driving\" generated=\"true\" class=\"error\" style=\"\"><strong>Driving</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#driving_div').removeClass('error');
  }

  if($('#gasping_div input:checked').val() == null){
    $('#gasping_div').addClass('error');
    error_text += "<label for=\"gasping\" generated=\"true\" class=\"error\" style=\"\"><strong>Wake up gasping</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#gasping_div').removeClass('error');
  }

  if($('#sleepy_div input:checked').val() == null){
    $('#sleepy_div').addClass('error');
    error_text += "<label for=\"sleepy\" generated=\"true\" class=\"error\" style=\"\"><strong>Excessively sleepy</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#sleepy_div').removeClass('error');
  }

  if($('#weight_gain_div input:checked').val() == null){
    $('#weight_gain_div').addClass('error');
    error_text += "<label for=\"weight_gain\" generated=\"true\" class=\"error\" style=\"\"><strong>Weight gain</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#weight_gain_div').removeClass('error');
  }

  if($('#snore_div input:checked').val() == null){
    $('#snore_div').addClass('error');
    error_text += "<label for=\"snore\" generated=\"true\" class=\"error\" style=\"\"><strong>Snore</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#snore_div').removeClass('error');
  }

  if($('#blood_pressure_div input:checked').val() == null){
    $('#blood_pressure_div').addClass('error');
    error_text += "<label for=\"blood_pressure\" generated=\"true\" class=\"error\" style=\"\"><strong>High Blood Pressure</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#blood_pressure_div').removeClass('error');
  }

  if($('#jerk_div input:checked').val() == null){
    $('#jerk_div').addClass('error');
    error_text += "<label for=\"jerk\" generated=\"true\" class=\"error\" style=\"\"><strong>Jerk</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#jerk_div').removeClass('error');
  }

  if($('#burning_div input:checked').val() == null){
    $('#burning_div').addClass('error');
    error_text += "<label for=\"burning\" generated=\"true\" class=\"error\" style=\"\"><strong>Burning</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#burning_div').removeClass('error');
  }

  if($('#headaches_div input:checked').val() == null){
    $('#headaches_div').addClass('error');
    error_text += "<label for=\"headaches\" generated=\"true\" class=\"error\" style=\"\"><strong>Headaches</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#headaches_div').removeClass('error');
  }

  if($('#staying_asleep_div input:checked').val() == null){
    $('#staying_asleep_div').addClass('error');
    error_text += "<label for=\"staying_asleep\" generated=\"true\" class=\"error\" style=\"\"><strong>Staying asleep</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#staying_asleep_div').removeClass('error');
  }

  if($('#falling_asleep_div input:checked').val() == null){
    $('#falling_asleep_div').addClass('error');
    error_text += "<label for=\"falling_asleep\" generated=\"true\" class=\"error\" style=\"\"><strong>Falling asleep</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#falling_asleep_div').removeClass('error');
  }

  if(return_val){
        next_sect(4);
  }else{
    $('#sect3_error_box').html(error_text).show();
  }
  return return_val;

  if($("input[name=weight_gain]:checked").val() == null ||
      $("input[name=breathing]:checked").val() == null ||
      $("input[name=driving]:checked").val() == null ||
      $("input[name=gasping]:checked").val() == null ||
      $("input[name=sleepy]:checked").val() == null ||
      $("input[name=snore]:checked").val() == null ||
      $("input[name=weight_gain]:checked").val() == null ||
      $("input[name=blood_pressure]:checked").val() == null ||
      $("input[name=jerk]:checked").val() == null ||
      $("input[name=burning]:checked").val() == null ||
      $("input[name=headaches]:checked").val() == null ||
      $("input[name=falling_asleep]:checked").val() == null ||
      $("input[name=staying_asleep]:checked").val() == null
){
    alert('All questions much be answered.');
    return false;
  }

  next_sect(4);
}

$(document).ready(function(){
				//regular dialog
				$("a[rel='fancyReg']").fancybox({
					'transitionIn'	: 'elastic',
					'width'				: 300,
					'height'			: 150,
					'autoDimensions'	: false,
					'overlayOpacity'	: '0',
					'hideOnOverlayClick': false
				});
});
