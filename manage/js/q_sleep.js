edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#q_sleepfrm').submit(function() {
		window.onbeforeunload = null;
	});

	cal_snore();
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function cal_analaysis(fa)
{
	var an_tot = 0;

	an_tot += parseInt($('#epworth_1').val());
	an_tot += parseInt($('#epworth_2').val());
	an_tot += parseInt($('#epworth_3').val());
	an_tot += parseInt($('#epworth_4').val());
	an_tot += parseInt($('#epworth_5').val());
	an_tot += parseInt($('#epworth_6').val());
	an_tot += parseInt($('#epworth_7').val());
	an_tot += parseInt($('#epworth_8').val());

	if(an_tot < 8) {
		an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a normal amount of sleepiness.';
	}
	if (an_tot >= 8 && an_tot < 10) {
		an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a average amount of sleepiness.';
	}
	if (an_tot >= 10 && an_tot < 16) {
		an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which may indicate excessive sleepiness depending on the situation. The patient may want to seek medical attention.';
	}
	if (an_tot >= 16 ) {
		an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which indicates excessive sleepiness and medical attention should be sought.';
	}

	document.q_sleepfrm.analysis.value = an_text;
}

function cal_snore()
{
	var fa = document.q_sleepfrm;
	var tot = parseInt(fa.snore_1.value) + parseInt(fa.snore_2.value) + parseInt(fa.snore_3.value) + parseInt(fa.snore_4.value) + parseInt(fa.snore_5.value); 
	fa.tot_score.value = tot;
}