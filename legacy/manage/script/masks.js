$(document).ready(function(){
	$.mask.definitions['%']='[0-9\.]';
        $('.datemask').mask('99/99/9999');
        $('.datealtmask').mask('99-99-99');
        $('.datealtfullmask').mask('99-99-9999');
	$('.datealtoptfullmask').mask('99-99-99?99');
	$('.singlenumber').mask('9');
	$('.numbermask').mask('?9999999999');
	$('.moneymask').mask('?%%%%%%%');
    $('.phonecodemask').mask('?999');
    $('.phonemask').mask('?9999999');
    $.mask.definitions['%']='[A-Za-z\.]';
    $('.statemask').mask('?%%');
});
