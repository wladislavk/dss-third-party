
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
      rx_tongue: $("input[name=rx_tongue]").is(':checked')?1:0,
      rx_reflux: $("input[name=rx_reflux]").is(':checked')?1:0,
      rx_hypertension: $("input[name=rx_hypertension]").is(':checked')?1:0,
      rx_jaw: $("input[name=rx_jaw]").is(':checked')?1:0,
      rx_tonsils: $("input[name=rx_tonsils]").is(':checked')?1:0,
      rx_heart: $("input[name=rx_heart]").is(':checked')?1:0,
      rx_pallet: $("input[name=rx_pallet]").is(':checked')?1:0,
      rx_metabolic: $("input[name=rx_metabolic]").is(':checked')?1:0,
      rx_stroke: $("input[name=rx_stroke]").is(':checked')?1:0,
      rx_bruxism: $("input[name=rx_bruxism]").is(':checked')?1:0,
      rx_diabetes: $("input[name=rx_diabetes]").is(':checked')?1:0,
      rx_obesity: $("input[name=rx_obesity]").is(':checked')?1:0
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
	survey += parseInt($("input[name=breathing]:checked").val(), 10);
        survey += parseInt($("input[name=driving]:checked").val(), 10);
        survey += parseInt($("input[name=gasping]:checked").val(), 10);
        survey += parseInt($("input[name=sleepy]:checked").val(), 10);
        survey += parseInt($("input[name=snore]:checked").val(), 10);
        survey += parseInt($("input[name=weight_gain]:checked").val(), 10);
        survey += parseInt($("input[name=blood_pressure]:checked").val(), 10);
        survey += parseInt($("input[name=jerk]:checked").val(), 10);
        survey += parseInt($("input[name=burning]:checked").val(), 10);
        survey += parseInt($("input[name=headaches]:checked").val(), 10);
        survey += parseInt($("input[name=falling_asleep]:checked").val(), 10);
        survey += parseInt($("input[name=staying_asleep]:checked").val(), 10);

	$('#ep_score').text(ep);
	$('#snore_score').text(snore);
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
  $('.sect').hide();
  $('#sect'+sect).show();
}


$(document).ready( function(){
  next_sect(1);
});
