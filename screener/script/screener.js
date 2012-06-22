
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
      snore_5: $('#snore_5').val()
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
	
	$('#ep_score').text(ep);
	$('#snore_score').text(snore);
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
