edited = false;
$(document).ready(function()
{
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});
	$('#q_page1frm').submit(function() {
		window.onbeforeunload = null;
	});
	update_c_chb();
	showOtherBox();
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

var removed = [];

function update_c_chb()
{
	var selections = [];
	$('.complaint_chb').each( function(){
		if($(this).val()!='') {
			selections.push($(this).val());
		}
	})
	$('.complaint_chb').each( function(){
		$(' option', this).each( function(){
			if(in_array($(this).attr("value"), selections) && !($(this).attr("selected")) ){
				$(this).attr('disabled','disabled');
			} else {
				$(this).removeAttr('disabled');
			}
		});
    })
}

function in_array(needle, haystack)
{
	for (var key in haystack) {
		if(needle === haystack[key]) {
			return true;
		}
	}
	return false;
}

function chk_other_comp()
{
	if ($('#complaint_0').is(':checked')) {
		$('#other_complaints').show();
	} else {
		$('#other_complaints').hide();
	}			
}

function showOtherBox()
{
	sel = String($('#main_reason').val());
	if ($.inArray('other', sel.split(',')) != -1) {
		$('#main_reason_other_div').show();
	} else {
		$('#main_reason_other_div').hide();
	}
}