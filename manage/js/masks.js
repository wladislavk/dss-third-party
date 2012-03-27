$(document).ready(function(){
	$.mask.definitions['~']='[2-9]';
        $('.extphonemask').mask('(~99) 999-9999? ext99999');
        $('.phonemask').mask('(~99) 999-9999');
        $('.ssnmask').mask('999-99-9999');
});
