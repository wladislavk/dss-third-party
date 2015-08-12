
function update_needed(v, f){
    if(v=='yes'){
        f.elements["scheddate"].style.visibility='visible';
        showWhere(f);
        autoselect(v,f);
    }else{
        f.elements["scheddate"].style.visibility='hidden';
        hideWhere(f);
        autoselect(v,f);
    }
}

function showWhere(f){
    f.elements["place"].style.display="block";
}

function hideWhere(f){
    f.elements["place"].style.display='none';
}

function autoselect(selectedOption, f) {
    if(selectedOption=="no") {
        f.elements["completed"][0].checked=true;        } else {
        f.elements["completed"][1].checked=true;
    }
}

function delete_confirm(){
  if(confirm("Are you sure you want to delete this study?")){
    window.onbeforeunload=false;
    return true;
  }

  return false;
} 

function show_new_study(){
  $('#new_sleep_study_form').show();
}
function updatePlace(f){
  if(f.sleeptesttype.value == "HST"){
    f.place.style.display = "none";
    f.home.style.display = "block";
  }else{
    f.place.style.display = "block";
    f.home.style.display = "none";
  }
}

function update_home(f){
  if(f.sleeptesttype.value == "HST Baseline" || f.sleeptesttype.value == "HST Titration"){
    f.place.value = 0;
  }
}

function addstudylab(v, s){
  if(v == 'add'){
    loadPopup('add_sleeplab.php?r=flowsheet&s='+s);
  }
}

$(document).ready(function(){
	var pid = getParameterByName('pid');
	setup_autocomplete('diagnosising_doc', 'diagnosising_doc_hints', 'diagnosising_npi', '', 'list_contacts_npi.php', 'contact', pid);
	var input_id_starts = 'diagnosising_doc_';
	$('input[id^="' + input_id_starts + '"]').each(function() {
		var id_element = $(this).attr('id');
			number_id = id_element.substr(input_id_starts.length);
		setup_autocomplete('diagnosising_doc_' + number_id, 'diagnosising_doc_' + number_id + '_hints', 'diagnosising_npi_' + number_id, '', 'list_contacts_npi.php', 'contact', pid);
	});
	update_home(document.getElementById('new_sleep_study_form'));
	var cal1 = new calendar2(document.getElementById('date'));

    $('form.sleep-study-form').submit(function(){
        var $this = $(this),
            submit = true;

        if ($this.find('[type=file]').val()) {
            return true;
        }

        submit = confirm('Note: You did not attach a sleep study image to the sleep test. Proceed without image?');

        if (!submit) {
            $this.find('img.loading').hide();
        }

        return submit;
    });
});