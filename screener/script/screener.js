
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
	}else if(survey<12){
                img = 'images/screener-moderate_risk.png';
        }else if(survey<16){
                img = 'images/screener-high_risk.png';
        }else{
                img = 'images/screener-severe_risk.png';
        }

	$('#result_body').text($('#first_name').val() + ', thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate:');
	$('#risk_image').html('<img src="'+img+'" />');
	$('#ep_score').text(an_text);
	//$('#snore_score').text(snore);
	$('#survey_score').text(survey);
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
