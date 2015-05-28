<?php namespace Ds3\Libraries\Legacy; ?><script type="text/javascript">
var screenerid='';
function submit_screener(){
  $('#sect4_next').hide();
  $('#sect4_next_dis').show();

    function onFailure () {
        $('#sect4_next').show();
        $('#sect4_next_dis').hide();
        alert('There was an error communicating with the server, please try again in a few minutes');
    }

  $.ajax({
    url: "script/submit_screener.php",
    type: "post",
    data: {
      docid: $('#docid').val(),
      userid: $('#userid').val(),
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(), 
      phone: $('#phone').val(),
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>
      epworth_<?= $ea['epworthid']; ?>: $('#epworth_<?=$ea['epworthid'];?>').val(),
<?php } ?>
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
          onFailure();
      }else{
 	screenerid=r.screenerid;
	//update view results div
	$('#r_first_name').text($('#first_name').val());
        $('#r_last_name').text($('#last_name').val());
        $('#r_phone').text($('#phone').val());
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>

        $('#r_epworth_<?= $ea['epworthid'];?>').text($('#epworth_<?=$ea['epworthid'];?>').val());
<?php } ?>
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
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>
	ep += parseInt($('#epworth_<?= $ea['epworthid']; ?>').val(), 10);
<?php } ?>
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
        $('#risk_image_doc').html('<img src="'+img+'" />');
	//$('#ep_score').text(an_text);
	//$('#snore_score').text(snore);
	//$('#survey_score').text(survey);

	//update hst div
	$('#hst_first_name').val($('#first_name').val());
        $('#hst_last_name').val($('#last_name').val());
        $('#hst_phone').val($('#phone').val());

	next_sect('results');

      }
    },
    error: onFailure
  });	

}


function next_sect(sect){
  if(sect==2){
	$('#restart_nav').show();
  }
  $('.sect').hide();
  $('#sect'+sect).show();
}


$(document).ready( function(){
  next_sect(0);
});


function validate_name(){
  $('#sect1_next').hide();
    $('#sect1_next_dis').show();
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
  if(!return_val){
    $('#sect1_next').show();
    $('#sect1_next_dis').hide();
  }
  return return_val;
}
function validate_epworth(){

    $('#sect2_next').hide();
    $('#sect2_next_dis').show();
 var return_val = true;
  var error_text = '';
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>
  if($('#epworth_<?=$ea['epworthid']; ?>_div select').val() == ''){
    $('#epworth_<?= $ea['epworthid']; ?>_div').addClass('error');
    error_text += "<label for=\"epworth_<?=$ea['epworthid'];?>\" generated=\"true\" class=\"error\" style=\"\"><strong><?=$ea['epworth']; ?></strong>: Please provide an answer</label>"
    return_val = false;
  }else{
    $('#epworth_<?= $ea['epworthid']; ?>_div').removeClass('error');
  }
<?php } ?>
  if(return_val){
        next_sect(3);
  }else{
    $('#sect2_next').show();
    $('#sect2_next_dis').hide();
    $('#epworth_error_box').html(error_text).show();
  }
  return return_val;
}

function validate_sect3(){
    $('#sect3_next').hide();
    $('#sect3_next_dis').show();
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
    $('#sect3_next').show();
    $('#sect3_next_dis').hide();
    $('#sect3_error_box').html(error_text).show();
  }
  return return_val;

}

function show_hst(){
  next_sect('hst');
}

function show_doctor(){
  next_sect('doctor');
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


function submit_hst(){
  if($('#hst_first_name').val()=='' || $('#hst_last_name').val() == '' || $('#hst_dob').val()=='' || $('#hst_phone').val()=='' || $('#hst_email').val() == '' ||$('input[name=hst_company_id]:checked').length == 0){
    alert('All fields are required.');
  }else{
  var $button = $('#secthst #sect4_next');

  function onFailure () {
    $button.removeClass('disabled');
    alert('There was a problem communicating with the server, please try again in a few minutes');
  }

  $button.addClass('disabled').show();
  $.ajax({
    url: "script/submit_hst.php",
    type: "post",
    data: {
      screenerid: screenerid,
      docid: $('#docid').val(),
      userid: $('#userid').val(),
      companyid: $('input[name=hst_company_id]:checked').val(),
      patient_first_name: $('#hst_first_name').val(),
      patient_last_name: $('#hst_last_name').val(),
      patient_cell_phone: $('#hst_phone').val(),
      patient_email: $('#hst_email').val(),
      patient_dob: $('#hst_dob').val(),
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>
      epworth_<?= $ea['epworthid']; ?>: $('#epworth_<?=$ea['epworthid'];?>').val(),
<?php } ?>
      snore_1: $('#snore_1').val(),
      snore_2: $('#snore_2').val(),
      snore_3: $('#snore_3').val(),
      snore_4: $('#snore_4').val(),
      snore_5: $('#snore_5').val()
    },
    success: function(data){
      var r = $.parseJSON(data);
      if(r.error){
        onFailure();
      }else{
	alert('HST submitted for approval and is in your Pending HST queue.');
	window.location = 'index.php';
      }
    },
    error: onFailure
   });
  }
}

</script>
