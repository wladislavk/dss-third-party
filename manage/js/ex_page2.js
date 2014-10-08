edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#ex_page2frm').submit(function() {
		window.onbeforeunload = null;
	});
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}