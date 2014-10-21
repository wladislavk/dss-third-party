$(document).ready(function() {
	var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']);
});

function change_desc(fa, desc_str)
{
    if(fa != '') {
        var desc_arr = desc_str.split('##');
        document.getElementById("notes").value = desc_arr[fa].replace(/\%n\%/g,'\r\n').replace(/&amp;/g,'&');
    } else {
        document.getElementById("notes").value = "";
    }
}

function delete_note(patientid, notesid)
{
	if(confirm('Progress Note will be deleted, are you sure?')){
		if (patientid != '') {
			var	inputValue = patientid;
		} else {
			var inputValue = notesid;
		}
		parent.window.location = "dss_summ.php?pid=" + patientid + "&del_note=" + inputValue;
	}
}

function staff_sign(name)
{
	if(confirm("Your account does not have sufficient privileges to SIGN progress notes. The users in your office who can legally SIGN this progress note are: " + name + ". Please ask one of these authorized users to enter their credentials below - by doing so they will legally SIGN this progress note. If you do not wish to SIGN this progress note, simply click \"Save and Keep UNSIGNED\"")){
		$('#submit_buttons').hide();
		$('#cred_div').show();
	}
}