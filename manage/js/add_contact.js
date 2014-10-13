$('#google_link').click(function(){ 
	$('#google_link').attr('href', 'http://google.com/search?q='+$('#firstname').val()+'+'+$('#lastname').val()+'+'+$('#company').val()+'+'+$('#add1').val()+'+'+$('#city').val()+'+'+$('#state').val()+'+'+$('#zip').val());
});

var cal1 = new calendar2(document.getElementById('ins_dob'));
var cal2 = new calendar2(document.getElementById('ins2_dob'));
var cal3 = new calendar2(document.getElementById('dob'));