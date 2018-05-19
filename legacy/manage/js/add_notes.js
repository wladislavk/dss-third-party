var localEd = getParameterByName('ed'),
    patientId = getParameterByName('pid');

$(document).ready(function() {
    var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']),
        minutes = 1,
        interval = 1000 * 60 * minutes, //interval is 60000ms, or 1 minute
        $noteFields = $('#notes, #subjective, #objective, #assessment, #plan'),
        $subjective = $('#subjective'),
        $objective = $('#objective'),
        $assessment = $('#assessment'),
        $plan = $('#plan');

    setInterval(save_draft, interval);

    $('select[name=title]').change(function(){
        var index = $(this).val(),
            description = '';

        try {
            index = parseInt(index);

            if (!customNotes[index]) {
                $noteFields.val('');
                return;
            }

            description = customNotes[index].description;
        } catch (e) {
            /* Fall through */
        }

        if (typeof description === 'string') {
            $noteFields.val(description);
            return;
        }

        $subjective.val(description.subjective);
        $objective.val(description.objective);
        $assessment.val(description.assessment);
        $plan.val(description.plan);
    });
});

function delete_note(patientid, notesid)
{
	if(confirm('Progress Note will be deleted, are you sure?')){
		parent.window.location = "dss_summ.php?pid=" + patientid + "&del_note=" + notesid;
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

  if ($('[name=is_soap]:not([disabled])').length) {
      noteContent = {
          subjective: $('#subjective').val(),
          objective: $('#objective').val(),
          assessment: $('#assessment').val(),
          plan: $('#plan').val()
      };
  }

  var post_data = { ed_initials: editorInitials, ed: localEd, notes: noteContent, procedure_date: procedureDate };
  $.post("create_draft_note.php?pid=" + encodeURIComponent(patientId), post_data, function(data){
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
      if (data.match(/\d+/)) {
        try {
          var newEd = parseInt(data);

          if (!isNaN(newEd)) {
            localEd = newEd;
            $('[name=ed]').val(localEd);
          }
        } catch (e) {}
      }
      var d = new Date();
      $('#autosave_note').text("Last autosaved at: "+pad_time(d.getHours())+":"+pad_time(d.getMinutes())+":"+pad_time(d.getSeconds()));
    }
  });
}

