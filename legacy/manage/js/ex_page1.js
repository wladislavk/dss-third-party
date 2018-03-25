edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#ex_page1frm').submit(function() {
		window.onbeforeunload = null;
	});
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function cal_bmi()
{
    fa = document.ex_page1frm;
    if(fa.feet.value != 0 && fa.inches.value != -1 && fa.weight.value != 0)
    {
        var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);           
        var inc_sqr = parseInt(inc) * parseInt(inc);
        var wei = parseInt(fa.weight.value) * 703;
        var bmi = parseInt(wei) / parseInt(inc_sqr);
        
        fa.bmi.value = bmi.toFixed(1);
    }
    else
    {
        fa.bmi.value = '';
    }
}