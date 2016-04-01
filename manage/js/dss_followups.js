function show_new_followup () {
    $('#sleepstudyadd').show();
}

function gotoQuestionnaire(){
  parent.window.location = 'q_page1.php?pid=' + getParameterByName('pid');
}

function update_ess(f, v){
  $('#'+f).val(v);
}
function update_ess_total(f, v){

  $('#ep_eadd_'+f).val(v);
  if (f=='new')
  {
    $('#submitaddfu').click();
  }
  else
  {
    $('#submitupdatefu_'+f).click();
  }
}

function update_tss(f, one, two, three, four, five, total){
  $('#thornton_'+f+'_1').val(one);
  $('#thornton_'+f+'_2').val(two);
  $('#thornton_'+f+'_3').val(three);
  $('#thornton_'+f+'_4').val(four);
  $('#thornton_'+f+'_5').val(five);
  $('#ep_tsadd_'+f).val(total);
  if (f=='new')
  {
    $('#submitaddfu').click();
  }
  else
  {
    $('#submitupdatefu_'+f).click();
  }
}

$(document).ready(function(){
	$('#sleepstudybaseline input, #sleepstudybaseline select').not('.no_questionnaire, :input[type=button], :input[type=submit], :input[type=reset]').click(function(){
		alert('Error: The baseline results are compiled from the patient\'s original Questionnaire. Click \"Edit Baseline\" to change these values in the patient\'s chart.');
	});
	$('#sleepstudybaseline input.no_questionnaire, #sleepstudybaseline select.no_questionnaire').not(':input[type=button], :input[type=submit], :input[type=reset]').click(function(){
		alert('This item is not captured on initial patient questionnaire, but is tracked in follow-up visits after you have delivered a device.');
	});
});