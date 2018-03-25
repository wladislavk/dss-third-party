function show_new_followup () {
    $('#new_followup_but').hide();

    if ($('#followup_frame').length) {
        document.getElementById('followup_frame').contentWindow.show_new_followup();
    }
}
function show_new_but(){
	$('#new_followup_but').show();
}