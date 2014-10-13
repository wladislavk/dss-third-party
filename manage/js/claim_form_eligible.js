$(document).ready(function(){
  form_changed = false;
  $('input, select').bind('change', function(){
    form_changed = true;
  });
});

function change_form(v2_form){
  if(form_changed) {
    if(confirm('Your changes to this claim will be lost if you change to paper submission. Click \'Ok\' to proceed or \'Cancel\' to return to electronic form.')) {
      window.location = "'" + v2_form + "'";
    }
  } else {
    window.location = "'" + v2_form + "'";
  }

  return false;
}