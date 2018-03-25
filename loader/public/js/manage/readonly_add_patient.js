$(document).ready(function(){
	$('input').attr('readonly', 'readonly');
	$('select').attr('disabled', 'disabled');
	$('input:submit, input:button, button, a').hide();
});