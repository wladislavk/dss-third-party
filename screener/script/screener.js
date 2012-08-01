
function submit_screener(){
  $.ajax({
    url: "script/submit_screener.php",
    type: "post",
    data: {
      docid: $('#docid').val(),
      userid: $('#userid').val(),
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(), 
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
      rx_blood_pressure: $("input[name=rx_blood_pressure]").is(':checked')?1:0,
      rx_hypertension: $("input[name=rx_hypertension]").is(':checked')?1:0,
      rx_heart_disease: $("input[name=rx_heart_disease]").is(':checked')?1:0,
      rx_stroke: $("input[name=rx_stroke]").is(':checked')?1:0,
      rx_apnea: $("input[name=rx_apnea]").is(':checked')?1:0,
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
	var ep = 0;
	ep += parseInt($('#epworth_reading').val(), 10);
        ep += parseInt($('#epworth_public').val(), 10);
        ep += parseInt($('#epworth_passenger').val(), 10);
        ep += parseInt($('#epworth_lying').val(), 10);
        ep += parseInt($('#epworth_talking').val(), 10);
        ep += parseInt($('#epworth_lunch').val(), 10);
        ep += parseInt($('#epworth_traffic').val(), 10);
	var snore = 0;
        snore += parseInt($('#snore_1').val(), 10);
        snore += parseInt($('#snore_2').val(), 10);
        snore += parseInt($('#snore_3').val(), 10);
        snore += parseInt($('#snore_4').val(), 10);
        snore += parseInt($('#snore_5').val(), 10);
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
	if(survey<8){
		img = 'images/screener-low_risk.png';
		$('#risk_low').show();
	}else if(survey<12){
                img = 'images/screener-moderate_risk.png';
		$('#risk_moderate').show();
        }else if(survey<16){
                img = 'images/screener-high_risk.png';
		$('#risk_high').show();
        }else{
                img = 'images/screener-severe_risk.png';
		$('#risk_severe').show();
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
  if($('#first_name input').val() == ''){
    $('#first_name').addClass('error');
    error_text += "<label for=\"first_name\" generated=\"true\" class=\"error\" style=\"\"><strong>First Name</strong>: Please provide a first name</label>"
    return_val = false;
  }else{
    $('#first_name').removeClass('error');
  }


  if($('#last_name input').val() == ''){
    $('#last_name').addClass('error');
    error_text += "<label for=\"last_name\" generated=\"true\" class=\"error\" style=\"\"><strong>Last Name</strong>: Please provide a last name</label>"
    return_val = false;
  }else{
    $('#last_name').removeClass('error');
  }

  if(return_val){
  	next_sect(2);
  }else{
    $('#name_error_box').html(error_text).show();
  }
  return return_val;
}
function validate_epworth(){

  var return_val = true;
  var error_text = '';
  if($('#epworth_reading select').val() == ''){
    $('#epworth_reading').addClass('error');
    error_text += "<label for=\"epworth_reading\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting And Reading</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_reading').removeClass('error');
  }

  if($('#epworth_public select').val() == ''){
    $('#epworth_public').addClass('error');
    error_text += "<label for=\"epworth_public\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting inactive in a public place</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_public').removeClass('error');
  } 
        
  if($('#epworth_passenger select').val() == ''){
    $('#epworth_passenger').addClass('error');
    error_text += "<label for=\"epworth_passenger\" generated=\"true\" class=\"error\" style=\"\"><strong>As a passenger</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_passenger').removeClass('error');
  } 
        
  if($('#epworth_lying select').val() == ''){
    $('#epworth_lying').addClass('error');
    error_text += "<label for=\"epworth_lying\" generated=\"true\" class=\"error\" style=\"\"><strong>Lying down to rest</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_lying').removeClass('error');
  } 
        
  if($('#epworth_talking select').val() == ''){
    $('#epworth_talking').addClass('error');
    error_text += "<label for=\"epworth_talking\" generated=\"true\" class=\"error\" style=\"\"><strong>Sitting and talking</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_talking').removeClass('error');
  } 
        
  if($('#epworth_lunch select').val() == ''){
    $('#epworth_lunch').addClass('error');
    error_text += "<label for=\"epworth_lunch\" generated=\"true\" class=\"error\" style=\"\"><strong>After a lunch</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_lunch').removeClass('error');
  } 
        
  if($('#epworth_traffic select').val() == ''){
    $('#epworth_traffic').addClass('error');
    error_text += "<label for=\"epworth_traffic\" generated=\"true\" class=\"error\" style=\"\"><strong>Stopped in traffic</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_traffic').removeClass('error');
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
  if($('#breathing input:checked').val() == null){
    $('#breathing').addClass('error');
    error_text += "<label for=\"breathing\" generated=\"true\" class=\"error\" style=\"\"><strong>Stop breathing</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#breathing').removeClass('error');
  }

  if($('#driving input:checked').val() == null){
    $('#driving').addClass('error');
    error_text += "<label for=\"driving\" generated=\"true\" class=\"error\" style=\"\"><strong>Driving</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#driving').removeClass('error');
  }

  if($('#gasping input:checked').val() == null){
    $('#gasping').addClass('error');
    error_text += "<label for=\"gasping\" generated=\"true\" class=\"error\" style=\"\"><strong>Wake up gasping</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#gasping').removeClass('error');
  }

  if($('#sleepy input:checked').val() == null){
    $('#sleepy').addClass('error');
    error_text += "<label for=\"sleepy\" generated=\"true\" class=\"error\" style=\"\"><strong>Excessively sleepy</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#sleepy').removeClass('error');
  }

  if($('#weight_gain input:checked').val() == null){
    $('#weight_gain').addClass('error');
    error_text += "<label for=\"weight_gain\" generated=\"true\" class=\"error\" style=\"\"><strong>Weight gain</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#weight_gain').removeClass('error');
  }

  if($('#snore input:checked').val() == null){
    $('#snore').addClass('error');
    error_text += "<label for=\"snore\" generated=\"true\" class=\"error\" style=\"\"><strong>Snore</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#snore').removeClass('error');
  }

  if($('#blood_pressure input:checked').val() == null){
    $('#blood_pressure').addClass('error');
    error_text += "<label for=\"blood_pressure\" generated=\"true\" class=\"error\" style=\"\"><strong>High Blood Pressure</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#blood_pressure').removeClass('error');
  }

  if($('#jerk input:checked').val() == null){
    $('#jerk').addClass('error');
    error_text += "<label for=\"jerk\" generated=\"true\" class=\"error\" style=\"\"><strong>Jerk</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#jerk').removeClass('error');
  }

  if($('#burning input:checked').val() == null){
    $('#burning').addClass('error');
    error_text += "<label for=\"burning\" generated=\"true\" class=\"error\" style=\"\"><strong>Burning</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#burning').removeClass('error');
  }

  if($('#headaches input:checked').val() == null){
    $('#headaches').addClass('error');
    error_text += "<label for=\"headaches\" generated=\"true\" class=\"error\" style=\"\"><strong>Headaches</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#headaches').removeClass('error');
  }

  if($('#staying_asleep input:checked').val() == null){
    $('#staying_asleep').addClass('error');
    error_text += "<label for=\"staying_asleep\" generated=\"true\" class=\"error\" style=\"\"><strong>Staying asleep</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#staying_asleep').removeClass('error');
  }

  if($('#falling_asleep input:checked').val() == null){
    $('#falling_asleep').addClass('error');
    error_text += "<label for=\"falling_asleep\" generated=\"true\" class=\"error\" style=\"\"><strong>Falling asleep</strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#falling_asleep').removeClass('error');
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
