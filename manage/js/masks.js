$(document).ready(function(){
	$.mask.definitions['~']='[2-9]';
        $('.extphonemask').mask('(~99) 999-9999? ext99999');
        $('.phonemask').mask('(~99) 999-9999');
        $('.ssnmask').mask('999-99-9999');
	$('.ccmask').mask('?9999999999999999999');
        $('.cvcmask').mask('999');
	$('.mmmask').mask('99');
	$('.yyyymask').mask('9999');
        $('.zipmask').mask('99999');
});

  $(document).delegate('.dollar_input', 'keydown', function(event){

	  //Prevent multiple '.' from being entered.
        if ((event.keyCode == 110 || event.keyCode == 190) && $(this).val().indexOf('.')>=0){
		event.preventDefault();
	}
          // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39) ||

            (event.keyCode == 109 || event.keyCode == 110 || event.keyCode == 188 || event.keyCode == 189 || event.keyCode == 190)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
  });

