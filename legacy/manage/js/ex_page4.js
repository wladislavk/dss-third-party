edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#ex_page4frm').submit(function() {
		window.onbeforeunload = null;
	});
});

function reloadPerio(t)
{
	window.frames.perio_iframe.updateTeeth(t);
}

function toggle_perio()
{
	if($('#perio_chart').css('display') == 'block'){
	  document.getElementById('perio_iframe').contentWindow.submit_form();
	}
	$('#perio_chart').toggle('slow');
}

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}