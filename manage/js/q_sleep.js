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

	$('[id^=epworth_]').each(function(){
		var $this = $(this);

		if (!this.id.match(/epworth_\d+/)) {
			return;
		}

		an_tot += parseInt($this.val());
	});

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

	$('form[name=q_sleepfrm] [name=analysis]').val(an_text);
}

function cal_snore()
{
	var fa = $('[name=q_sleepfrm]');
	var tot = parseInt(fa.find('[name=snore_1]').val()) + parseInt(fa.find('[name=snore_2]').val()) +
		parseInt(fa.find('[name=snore_3]').val()) + parseInt(fa.find('[name=snore_4]').val()) +
		parseInt(fa.find('[name=snore_5]').val());
	fa.find('[name=tot_score]').val(tot);
}