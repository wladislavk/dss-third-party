$(document).ready(function(){
	$('.workphonemask').mask('(999) 999-9999? x99999');
	$.mask.definitions['~']='[x1-9]';
        $('.phonemask').mask('(999) 999-9999? ~99999');
	$('.ssnmask').mask('999-99-9999');
});
