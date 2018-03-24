$(".date_field").keydown(function(e)
    {
        var key = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
        return (key == 8 || key == 9 || key == 46 || key == 189 || key == 191 ||
                    (key >= 37 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
    }
);

$(".number_field").keydown(function(e)
    {
        var key = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, numbers and keypad numbers ONLY
        return (key == 8 || key == 9 || key == 46 || key == 110 || key == 190 ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
    }
);

form_changed = false;

$('input, select').bind('change', function()
    {
        form_changed = true; 
    }
);

function file_reject_claim()
{
  if ($('#p_m_ins_payer_id').val() == "") {
    alert('Insurance payer must be selected to electronically file claim.');
    return false;
  }

  c = confirm('You are about to resubmit a rejected claim. Please make sure you have corrected all errors, then click OK to resend the claim.');
  return c;
}

function file_claim()
{
  if ($('#p_m_ins_payer_id').val() == "") {
    alert('Insurance payer must be selected to electronically file claim.');
    return false;
  }

  c = confirm('You are about to electronically submit this claim, are you sure?');
  return c;
}

function change_form(electronic_form)
{
  if (form_changed) {
    if (confirm('Your changes to this claim will be lost if you change to electronic submission. Click \'Ok\' to proceed or \'Cancel\' to return to paper form.')) {
      window.location = electronic_form;
    } 
  } else {
    window.location = electronic_form;
  }

  return false;
}