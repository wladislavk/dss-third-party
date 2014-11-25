$(document).ready(function() {
	var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']);
  var minutes = 1;
  var interval = 1000 * 60 * minutes; //interval is 60000ms, or 1 minute
  setInterval(save_draft, interval);
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
function pad_time(number){
  if (number < 10){
    number = "0"+number;
  }
  return number;
}

function save_draft(){
  var noteContent = $('#notes')[0].value;
  var procedureDate = $('#procedure_date')[0].value;
  var editorInitials = $('#editor_initials')[0].value;
  var post_data = { ed_initials: editorInitials, ed:<?=$_GET['ed']?>, notes: noteContent, procedure_date: procedureDate };
  $.post("create_draft_note.php",post_data, function(data){
    if (data.indexOf('logged_out')!= -1 || data.indexOf('login.php') != -1){
      alert("you have been logged out elsewhere. Redirecting to login page.");
      parent.window.location="login.php";
    }
    else if (data.indexOf('save_failed')!= -1)
    {
      alert("Auto-save failed. Make sure your note is backed up before saving or exiting this note.");
    }
    else
    {
      var d = new Date();
      $('#autosave_note').text("Last autosaved at: "+pad_time(d.getHours())+":"+pad_time(d.getMinutes())+":"+pad_time(d.getSeconds()));
    }
  });
}

