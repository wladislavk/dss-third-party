edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#q_page3frm').submit(function() {
		window.onbeforeunload = null;
	});

	$('.extra').each(function(){
		var v = $(this).val();
		var n = $(this).attr('name');
		var c = $(this).attr('checked');
		if(v=="Yes"){
			if(c){
				$('#'+n+'_extra').css('display', 'inline');
			}else{
				$('#'+n+'_extra').css('display', 'none');
			}
		}
				
	});
});

$(function(){
	$('.extra').click(function(e){
		var v = e.target.value;
		var n = e.target.name;
		if(v=="Yes"){
			$('#'+n+'_extra').css('display', 'inline');
		}else{
	        $('#'+n+'_extra').css('display', 'none');
		}
	});
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function chk_allergens()
{
	fa = document.q_page3frm;
	chk_l = document.getElementsByName('allergens[]').length;

    if (!fa.no_allergens) {
        return;
    }

	if(fa.no_allergens.checked)
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('allergens[]')[i].disabled = true;
		}
		fa.other_allergens.disabled = true;
	}
	else
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('allergens[]')[i].disabled = false;
		}
		fa.other_allergens.disabled = false;
	}
}

function chk_medications()
{
	fa = document.q_page3frm;
	chk_l = document.getElementsByName('medications[]').length;

    if (!fa.no_medications) {
        return;
    }

	if(fa.no_medications.checked)
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('medications[]')[i].disabled = true;
		}
		fa.other_medications.disabled = true;
	}
	else
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('medications[]')[i].disabled = false;
		}
		fa.other_medications.disabled = false;
	}
}

function chk_history()
{
	fa = document.q_page3frm;
	chk_l = document.getElementsByName('history[]').length;

    if (!fa.no_history) {
        return;
    }

	if(fa.no_history.checked)
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('history[]')[i].disabled = true;
		}
		fa.other_history.disabled = true;
	}
	else
	{
		for(var i=0; i<chk_l; i++)
		{
			document.getElementsByName('history[]')[i].disabled = false;
		}
		fa.other_history.disabled = false;
	}
}

function chk_ortho()
{
	fa = document.q_page3frm;

    if (!fa.orthodontics || !fa.year_completed) {
        return;
    }

	if(fa.orthodontics[1].checked)
	{
		fa.year_completed.disabled = true;
	}
	else
	{
		fa.year_completed.disabled = false;
	}
}